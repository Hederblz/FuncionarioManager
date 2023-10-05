<!DOCTYPE html>

<?php
$menssagem = $_GET["menssagem"];
?>
<html lang="en">

<?php include "views/head.php"; ?>

<body>
    <?php include "views/menu.php"; ?>

    <h1 align="center">ERRO</h1>
    <div align="center">
        <h3><?php echo $menssagem ?></h3>
    </div>
</body>

</html>