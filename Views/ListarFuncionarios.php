<html>
<?php include "Head.php"; ?>

<!DOCTYPE html>

<?php
$v_params = $this->getParams();
$v_funcionario = $v_params['v_funcionarios'];
?>

<html lang="en">

<body>
    <?php include "menu.php"; ?>
    <h1 align="center">Listar Funcionarios</h1>
    <div align="center">
        <table width="80%" border="1">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Nome
                </th>
                <th>
                    Sobrenome
                </th>
                <th>
                    Data
                </th>
                <th>
                    Salario
                </th>
                <th>
                    Mensagem
                </th>
                <th colspan="3">
                    Ações
                </th>
            </tr>
            <?php
            foreach ($v_funcionario as $funcionario) {
            ?>
                <tr>
                    <td>
                        <?php echo $funcionario->getId() ?>
                    </td>
                    <td>
                        <?php echo $funcionario->getNome() ?>
                    </td>
                    <td>
                        <?php echo $funcionario->getSobrenome() ?>
                    </td>
                    <td>
                        <?php echo $funcionario->getDataNascimento() ?>
                    </td>
                    <td>
                        <?php echo $funcionario->getSalario() ?>
                    </td>
                    <td align="center">
                    <?php echo $funcionario->verificarAniversario($funcionario->getDataNascimento()) ?>
                    </td>
                    <td align="center">
                        <a href='ViewController.php?controle=Funcionario&acao=cadastraFuncionario&id=<?php echo $funcionario->getId() ?>'>Editar</a>
                    </td>
                    <td align="center">
                        <a href='ViewController.php?controle=Funcionario&acao=apagarFuncionario&id=<?php echo $funcionario->getId() ?>'>Apagar</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
        <br />
        <a href='ViewController.php?controle=Funcionario&acao=novoFuncionario'>NOVO FUNCIONARIO</a>
    </div>
</body>

</html>