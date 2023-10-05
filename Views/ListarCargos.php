<html>
    <?php include "head.php"; ?>

<!DOCTYPE html>

<?php
    $v_params = $this->getParams();
    $v_cargos = $v_params['v_cargos'];
?>

<html lang="en">

    <?php include "head.php"; ?>
<body>
    <?php include "menu.php"; ?>

    <h1 align="center" >Listar Cargos</h1>
    <div align="center">
        <table width="80%" border="1">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Descricao
                </th>
               
                <th colspan="3">
                    Ações
                </th>
            </tr>
            <?php
            foreach($v_cargos AS $cargo)
            {
                ?>
                <tr>
                    <td>
                        <?php echo $cargo->getId()?>
                    </td>
                    <td>
                        <?php echo $cargo->getDescricao()?>
                    </td>
                    <td align="center">
                        <a href='ViewController.php?controle=Cargo&acao=cadastraCargo&id=<?php echo $cargo->getId()?>'>Editar</a>
                    </td>
                    <td align="center">
                        <a href='ViewController.php?controle=Cargo&acao=apagarCargo&id=<?php echo $cargo->getId()?>'>Apagar</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br />
        <a href='ViewController.php?controle=Cargo&acao=CadastraCargo'>NOVO CARGO</a>
    </div>
</body>
</html>