<?php

session_start();

include("conexao.php");

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM cursos";

$resultado = $conexao->query($sql);

$mensagem = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $usuario_id = $_SESSION['usuario_id'];
    $curso_id = $_POST['curso_id'];

    $verifica = "SELECT * FROM inscricoes
             WHERE usuario_id = $usuario_id
             AND curso_id = $curso_id";

    $resultadoVerifica = $conexao->query($verifica);

    if($resultadoVerifica->num_rows == 0){
        $sqlInscricao = "INSERT INTO inscricoes
                        (usuario_id, curso_id, progresso)
                        VALUES
                        ($usuario_id, $curso_id, 0)";
        if($conexao->query($sqlInscricao)){
            $mensagem = "Inscrição realizada com sucesso!";
        }
    }
    else{
        $mensagem = "Você já está inscrito neste curso!";
    }

}

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
        <?php
        if($mensagem != ""){
            echo "<p class='sucesso'>$mensagem</p>";
        }
        ?>

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

                    <form method="POST">
                        <input
                            type="hidden"
                            name="curso_id"
                            value="<?php echo $curso['id']; ?>"
                        >

                        <button type="submit">
                            Inscrever-se
                        </button>

                    </form>

                </div>

            <?php
            }
            ?>

        </div>

        <br>

        <div class="login-link">
            <a href="meus_cursos.php" class="btn-cadastro">
                Meus Cursos
            </a>
        </div>

        <br>

        <div class="login-link">
            <a href="perfil.php" class="btn-cadastro">
                Editar Perfil
            </a>
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