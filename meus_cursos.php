<?php

session_start();

include("conexao.php");

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if(isset($_POST['avancar'])){

    $inscricao_id = $_POST['inscricao_id'];

    $sqlProgresso = "SELECT progresso
                     FROM inscricoes
                     WHERE id = $inscricao_id";

    $resultadoProgresso = $conexao->query($sqlProgresso);

    $inscricao = $resultadoProgresso->fetch_assoc();

    $novoProgresso = $inscricao['progresso'] + 25;

    if($novoProgresso > 100){
        $novoProgresso = 100;
    }

    $sqlAtualiza = "UPDATE inscricoes
                    SET progresso = $novoProgresso
                    WHERE id = $inscricao_id";

    $conexao->query($sqlAtualiza);

}

$sql = "SELECT i.id, c.nome, c.descricao, i.progresso
        FROM inscricoes i
        INNER JOIN cursos c ON c.id = i.curso_id
        WHERE i.usuario_id = $usuario_id";

$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Cursos</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-login">

    <div class="card-login">

        <h1 class="titulo">Meus Cursos</h1>

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

            <p>
                Progresso: <?php echo $curso['progresso']; ?>%
            </p>
            <form method="POST">

                <input
                    type="hidden"
                    name="inscricao_id"
                    value="<?php echo $curso['id']; ?>"
                >

                <button type="submit" name="avancar">
                    Avançar Progresso
                </button>

            </form>

        </div>
        <?php
        }
        ?>
        <br>
            <div class="login-link">
                <a href="cursos.php" class="btn-cadastro">
                    Voltar para Cursos
                </a>

            </div>
        </div>

    </div>

        </body>
        </html>