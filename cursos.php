<?php

session_start();

include("conexao.php");

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM cursos";

$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cursos</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-login">

    <div class="card-login">

        <h1 class="titulo">Cursos Disponíveis</h1>

        <p>
            Bem-vindo,
            <?php echo $_SESSION['usuario']; ?>!
        </p>

        <br>

        <div class="lista-cursos">

            <?php
            while($curso = $resultado->fetch_assoc()){
            ?>

                <div class="curso">

                    <h3>
                        <?php echo $curso['nome']; ?>
                    </h3>

                    <p>
                        <?php echo $curso['descricao']; ?>
                    </p>

                </div>

            <?php
            }
            ?>

        </div>

        <br>

        <div class="login-link">

            <a href="logout.php" class="btn-cadastro">
                Sair
            </a>

        </div>

    </div>

</div>

</body>
</html>