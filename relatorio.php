<?php

    use Dompdf\Dompdf;

    require_once 'dompdf/autoload.inc.php';
    require_once 'Lib/Banco.php';

    //include('Lib/Banco.php');

    
    
    
    $sql_query = "SELECT * FROM tbFuncionario";

    $link = $this->conecta_mysql();
        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

    if($data->num_rows > 0){
       $html = "<table border ='1'>";
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
        $html .= 'Nenhum dado registrado';
    }
    
    print $html
    
    //$dompdf = new Dompdf();
    //$dompdf->loadHtml($html);
    //$dompdf->setPaper('A4', 'portrait');
    //$dompdf->render();
    //$dompdf->stream();

?>