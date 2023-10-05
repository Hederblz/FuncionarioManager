<?php

require_once 'Models/CargoModel.php';

class CargoController extends Banco{
    
    public function loadById($id){
        $sql_query = "SELECT * FROM `tbCargo` WHERE `tbCargo`.`idTbCargo` = $id;";
        $CargoModel = new CargoModel();
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $cargo = $data->fetch_object();
        $CargoModel->setId($cargo->idTbCargo);
        $CargoModel->setDescricao($cargo->Descricao);

        return $CargoModel;
    }

    public function listarCargosAction(){
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

        $View = new View('views/listarCargos.php');
        $View->setParams(array('v_cargos' => $v_cargos));
        $View->showContents();
    }

    public function save($CargoModel){
        $descricao = $CargoModel->getDescricao();
        $id = $CargoModel->getId();
        $link = $this->conecta_mysql();

        if (is_null($id))
            $sql_query = "INSERT INTO `tbCargo`
                        (
                            `Descricao`
                        )
                        VALUES
                        (
                            '$descricao'
                        );";
        else
            $sql_query = "UPDATE
                            `tbCargo`
                        SET
                            `Descricao` = '$descricao'
                        WHERE
                        `idTbCargo` = $id";
        try {
            mysqli_query($link, $sql_query);
            return true;
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }
    }

    public function cadastraCargoAction(){
        $CargoModel = new CargoModel();

        if (isset($_REQUEST['id'])) {
            if ($_REQUEST['id'])
                $CargoModel = $this->loadById($_REQUEST['id']);
        }

        if (count($_POST) > 0) {
            $CargoModel->setDescricao($_POST['descricao']);

            if ($this->save($CargoModel)) {
                Application::redirect('ViewController.php?controle=Cargo&acao=listarCargos');
            }
        }

        $View = new View('views/cadastraCargo.php');
        $View->setParams(array('CargoModel' => $CargoModel));
        $View->showContents();
    }

    public function apagarCargoAction(){
        if ($_GET['id']) {
            $CargoModel = new CargoModel();
            $CargoModel = $this->loadById($_GET['id']);
            $id = $CargoModel->getId();
            $link = $this->conecta_mysql();

            if (!is_null($id)) {

                $sql_query = "DELETE FROM `tbCargo` WHERE `tbCargo`.`idTbCargo` = $id";
                try {
                    mysqli_query($link, $sql_query);
                } catch (mysqli_sql_exception $e) {
                    if ($e->getCode() === 1451) {
                        $menssagem = "O cargo \"" . $CargoModel->getDescricao() .
                            "\" não pode ser excluida porque ele está atribuido a algum funcionario";
                        Application::redirect("ErroPage.php?menssagem=" . $menssagem);
                        die();
                    } else {
                        $menssagem = "Houve um erro contate o administrador do sistema";
                        Application::redirect("ErroPage.php?menssagem=" . $menssagem);
                        die();
                    }
                }
            }
            Application::redirect('ViewController.php?controle=Cargo&acao=listarCargos');
        }
    }

}