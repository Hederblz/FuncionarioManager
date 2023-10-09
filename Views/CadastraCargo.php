<!DOCTYPE html>

<?php
$v_params = $this->getParams();
$CargoModel = $v_params["CargoModel"];
?>
<html lang="en">

<?php include "Head.php"; ?>

<body>
    <?php include "menu.php"; ?>

    <h1 align="center">Cadastra Cargo</h1>
    <div align="center">
        <form method='POST'>
            <table width="300" border="1">
                <tr>
                    <th>
                        Descricao
                    </th>

                    <th colspan="2">
                        Ações
                    </th>
                </tr>
                <tr>
                    <td>
                        <input type='text' name='descricao' value='<?php echo $CargoModel->getDescricao(); ?>'>
                    </td>

                    <td align="center">
                        <a href='ViewController.php?controle=Cargo&acao=listarCargos'>Cancelar</a>
                    </td>
                    <td align="center">
                        <input type='hidden' name='controle' value='Cargo'>
                        <input type='hidden' name='acao' value='cadastraCargo'>
                        <input type='hidden' name='id' value='<?php echo $CargoModel->getId(); ?>'>
                        <button type='submit'>Salvar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>