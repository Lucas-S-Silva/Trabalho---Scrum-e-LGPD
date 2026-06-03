<?php

session_start();

include("conexao.php");

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT nome, email
        FROM usuarios
        WHERE id = $usuario_id";

$resultado = $conexao->query($sql);

$usuario = $resultado->fetch_assoc();
$mensagem = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sqlEmail = "SELECT id
             FROM usuarios
             WHERE email = '$email'
             AND id != $usuario_id";

    $resultadoEmail = $conexao->query($sqlEmail);

    if($resultadoEmail->num_rows > 0){
    $mensagem = "Este e-mail já está sendo utilizado.";
    }
    else{
        $sqlUpdate = "UPDATE usuarios
              SET nome = '$nome',
                  email = '$email'
              WHERE id = $usuario_id";
              if($conexao->query($sqlUpdate)){
                $_SESSION['usuario'] = $nome;
                $mensagem = "Dados atualizados com sucesso!";
                $usuario['nome'] = $nome;
                $usuario['email'] = $email;
            }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-login">

    <div class="card-login">

        <h1 class="titulo">Editar Perfil</h1>
        <?php
        if($mensagem != ""){
            echo "<p class='sucesso'>$mensagem</p>";
        }
        ?>

        <form method="POST">

            <input
                type="text"
                name="nome"
                value="<?php echo $usuario['nome']; ?>"
                required
            >

            <input
                type="email"
                name="email"
                value="<?php echo $usuario['email']; ?>"
                required
            >

            <button type="submit">
                Salvar Alterações
            </button>

        </form>

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