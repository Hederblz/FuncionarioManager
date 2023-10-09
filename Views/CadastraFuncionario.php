<!DOCTYPE html>
<?php include "Head.php"; ?>
<?php
$v_params = $this->getParams();
$funcionario = $v_params["funcionario"];
if ($funcionario->getId() != null) {
    $codCargo = $v_params["cargo"];
}
$v_cargos = $v_params["v_cargos"];
?>

<html lang="en">

<body>
    <?php include "menu.php"; ?>

    <h1 align="center">Cadastra Funcionario</h1>
    <div align="center">
        <form action="ViewController.php" method='POST'>
            <table width="300" border="1">
                <tr>
                    <th>
                        Nome
                    </th>
                    <th>
                        Sobrenome
                    </th>
                    <th>
                        Data de Nascimento
                    </th>
                    <th>
                        Salario
                    </th>
                    <th>
                        Cargo
                    </th>
                    <th colspan="2">
                        Ações
                    </th>
                </tr>
                <tr>
                    <td>
                        <input type='text' name='nome' value='<?php echo $funcionario->getNome(); ?>' required>
                    </td>
                    <td>
                        <input type='text' name='sobrenome' value='<?php echo $funcionario->getSobrenome(); ?>' required>
                    </td>
                    <td>
                    <input type="date" name="dataNascimento" value="<?php echo $funcionario->getDataNascimento(); ?>" required>
                    </td>
                    <td>
                    <input type="text" name="salario" value="<?php echo $funcionario->getSalario(); ?>"
                    pattern="^\d+(\.\d{1,2})?$" step="0.01" required min="0" max="9999999.99">
                    </td>
                    <td>
                        <select name="cargo">
                            <?php
                            if ($funcionario->getId() !== null) {
                            ?>
                                <option value="<?php echo $codCargo->getId() ?>"> <?php echo $codCargo->getDescricao(); ?></option>
                            <?php
                            }
                            ?>

                            <?php
                            foreach ($v_cargos as $cargo) {
                                if ($cargo->getId() !== $funcionario->getCodCargo()) {
                            ?>
                                    <option value="<?php echo $cargo->getId() ?>"><?php echo $cargo->getDescricao(); ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td align="center">
                        <a href='ViewController.php?controle=Funcionario&acao=listarFuncionarios'>Cancelar</a>
                    </td>
                    <td align="center">
                        <input type='hidden' name='controle' value='Funcionario'>
                        <input type='hidden' name='acao' value='cadastraFuncionario'>
                        <input type='hidden' name='id' value='<?php echo $funcionario->getId(); ?>'>
                        <button type='submit'>Salvar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>