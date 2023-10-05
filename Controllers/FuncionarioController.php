<?php


use Dompdf\Dompdf;

require_once 'Models/FuncionarioModel.php';
require_once 'Models/CargoModel.php';
require_once 'CargoController.php';
require_once 'dompdf/autoload.inc.php';



class FuncionarioController extends Banco{

    public function loadById($id){
        $sql_query = "SELECT * FROM `tbFuncionario` WHERE `tbFuncionario`.`idtbFuncionario`  = $id";
        $FuncionarioModel = new FuncionarioModel();
        $link = $this->conecta_mysql();

        try{
            $data = mysqli_query($link, $sql_query);
        }catch(mysqli_sql_exception $e){
            die($e->getMessage());
        }
        $Funcionario = $data->fetch_object();

        $CargoController = new CargoController();
        $CargoModel = new CargoModel();
        $CargoModel = $CargoController->loadByID($Funcionario->CodTbCargo);

        $FuncionarioModel->setId($Funcionario->idtbFuncionario);
        $FuncionarioModel->setNome($Funcionario->Nome);
        $FuncionarioModel->setSobrenome($Funcionario->Sobrenome);
        $FuncionarioModel->setDataNascimento($Funcionario->DataNascimento);
        $FuncionarioModel->setSalario($Funcionario->Salario);
        $FuncionarioModel->setCodCargo($CargoModel->getId());

        return $FuncionarioModel;
    }

    public function listarFuncionariosAction(){
        $sql_query = "SELECT * FROM `tbFuncionario` ORDER BY `tbFuncionario`.`nome` ASC;";

        $link = $this->conecta_mysql();
        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $v_funcionarios = array();
        while($funcionario_data = $data->fetch_object()){
            $funcionario_model = new FuncionarioModel();
            $funcionario_model->setId($funcionario_data->idtbFuncionario);
            $funcionario_model->setNome($funcionario_data->Nome);
            $funcionario_model->setSobrenome($funcionario_data->Sobrenome);
            $funcionario_model->setDataNascimento($funcionario_data->DataNascimento);
            $funcionario_model->setSalario($funcionario_data->Salario);
            array_push($v_funcionarios, $funcionario_model);
        }

        $View = new View('views/listarFuncionarios.php');
        $View->setParams(array('v_funcionarios' => $v_funcionarios));
        $View->showContents();
    }

    public function cadastraFuncionarioAction(){
        $FuncionarioModel = new FuncionarioModel();
        $CargoController = new CargoController();
        $cargoFuncionario = new CargoModel();
        $v_cargos = array();
        $link = $this->conecta_mysql();

        if(isset($_REQUEST['id'])){
            if($_REQUEST['id']){
                $FuncionarioModel = $this->loadById($_REQUEST['id']);
                $cargoFuncionario = $CargoController->loadById($FuncionarioModel->getCodCargo());
            }
        }
        if(count($_POST) > 0){
            $FuncionarioModel->setNome($_POST['nome']);
            $FuncionarioModel->setSobrenome($_POST['sobrenome']);
            $FuncionarioModel->setDataNascimento($_POST['dataNascimento']);
            $FuncionarioModel->setSalario($_POST['salario']);
            $FuncionarioModel->setCodCargo($_POST['cargo']);

            if($this->save($FuncionarioModel)){
                Application::redirect('ViewController.php?controle=Funcionario&acao=listarFuncionarios');
            }
        }

        $sql_query = "SELECT * FROM `tbCargo` ORDER BY `tbCargo`.`Descricao` ASC;";

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        while($cargo = $data->fetch_object()){
            $CargoModel = new CargoModel();
            $CargoModel->setId($cargo->idTbCargo);
            $CargoModel->setDescricao($cargo->Descricao);
            array_push($v_cargos, $CargoModel);
        }

        $View = new View('views/cadastraFuncionario.php');
        $View->setParams(array(
            'funcionario' => $FuncionarioModel,
            'v_cargos' => $v_cargos,
            'cargo'=> $cargoFuncionario
        ));

        $View->showContents();
    }

    public function novoFuncionarioAction(){
        $sql_query = "SELECT * FROM `tbCargo` ORDER BY `tbCargo`.`Descricao` ASC;";
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $v_cargos = array();
        while ($cargo = $data->fetch_object()) {
            $CargoModel = new CargoModel();
            $CargoModel->setId($cargo->idTbCargo);
            $CargoModel->setDescricao($cargo->Descricao);
            array_push($v_cargos, $CargoModel);
        }

        if ($v_cargos[0] === null) {
            $menssagem = "Antes de cadastrar um funcionario, cadastre antes um cargo";
            Application::redirect("ErroPage.php?menssagem=" . $menssagem);
            die();
        }
        $FuncionarioModel = new FuncionarioModel();

        $View = new View('views/cadastraFuncionario.php');
        $View->setParams(array('funcionario' => $FuncionarioModel, 'v_cargos' => $v_cargos));
        $View->showContents();
    }

    public function save($FuncionarioModel){
        $link = $this->conecta_mysql();
        $id = $FuncionarioModel->getId();
        $nome = $FuncionarioModel->getNome();
        $sobrenome = $FuncionarioModel->getSobrenome();
        $dataNascimento = $FuncionarioModel->getDataNascimento();
        $salario = $FuncionarioModel->getSalario();
        $CodCargo = $FuncionarioModel->getCodCargo();

        if (is_null($id))
            $sql_query = "INSERT INTO `tbFuncionario` 
            (
                `Nome`, 
                `Sobrenome`,
                `DataNascimento`,
                `Salario`, 
                `CodTbCargo`
            ) 
            VALUES ('$nome', '$sobrenome', '$dataNascimento', '$salario', '$CodCargo')";
        else{
            $sql_query = "UPDATE
                            `tbFuncionario`
                        SET
                            `Nome` = '$nome',
                            `Sobrenome` = '$sobrenome',
                            `DataNascimento` = '$dataNascimento',
                            `Salario` = '$salario',
                            `CodTbCargo` = $CodCargo
                        WHERE `idtbFuncionario` = $id";
        }
        try {
            mysqli_query($link, $sql_query);
            return true;
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }
    }

    public function apagarFuncionarioAction(){
        if ($_GET['id']) {
            $FuncionarioModel = new FuncionarioModel();
            $FuncionarioModel = $this->loadById($_GET['id']);
            $id = $FuncionarioModel->getId();
            $link = $this->conecta_mysql();
            if (!is_null($id)) {
                $sql_query = "DELETE FROM `tbFuncionario` WHERE `tbFuncionario`.`idtbFuncionario` = $id";
                try {
                    mysqli_query($link, $sql_query);
                } catch (mysqli_sql_exception $e) {
                    die($e->getMessage());
                }
            }
            Application::redirect('ViewController.php?controle=Funcionario&acao=listarFuncionarios');
        }
    }

    public function imprimirFuncionarioAction(){
        $sql_query = "SELECT * FROM tbFuncionario";

        $link = $this->conecta_mysql();
            try {
                $data = mysqli_query($link, $sql_query);
            } catch (mysqli_sql_exception $e) {
                die($e->getMessage());
            }
    
        if($data->num_rows > 0){
           $html = "<table width=80% border=1>";
                    $html .= "<tr>";
                    $html .= "<th>";
                    $html .= "ID";
                        $html .= "</th>";
                    $html .= "<th>";
                    $html .= "Nome";
                        $html .= "</th>";
                    $html .= "<th>";
                    $html .= "Sobrenome";
                        $html .= "</th>";
                    $html .= "<th>";
                    $html .= "Data";
                        $html .= "</th>";
                    $html .= "<th>";
                    $html .= "Salario";
                        $html .= "</th>";
                    $html .= "</tr>";
            while($funcionario_data = $data->fetch_object()){
                $html .= "<tr>";
                $html .= "<td>".$funcionario_data->idtbFuncionario."</td>";
                $html .= "<td>".$funcionario_data->Nome."</td>";
                $html .= "<td>".$funcionario_data->Sobrenome."</td>";
                $html .= "<td>".$funcionario_data->DataNascimento."</td>";
                $html .= "<td>".$funcionario_data->Salario."</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";
        }else{
            $menssagem = "Nenhum funcionario registrado";
            Application::redirect("ErroPage.php?menssagem=" . $menssagem);
            die();
        }
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    
    }

}
