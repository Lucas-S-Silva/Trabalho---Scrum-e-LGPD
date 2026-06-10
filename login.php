<?php

session_start();

include("conexao.php");

$mensagem = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";

    $resultado = $conexao->query($sql);

    if($resultado->num_rows > 0){

        $usuario = $resultado->fetch_assoc();

        if(password_verify($senha, $usuario['senha'])){

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['nome'];

            $usuario_id = $usuario['id'];
            $evento = "LOGIN";
            $ip = $_SERVER['REMOTE_ADDR'];

            $sqlLog = "INSERT INTO logs_autenticacao
                    (usuario_id, evento, ip, data_hora)
                    VALUES
                    ($usuario_id, '$evento', '$ip', NOW())";

            $conexao->query($sqlLog);

            header("Location: cursos.php");
            exit;

        } else {

            $mensagem = "Senha incorreta!";

        }

    } else {

        $mensagem = "Usuário não encontrado!";

    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-login">

    <div class="card-login">

        <h2 class="titulo">Login</h2>

        <?php
        if($mensagem != ""){
            echo "<p class='erro'>$mensagem</p>";
        }
        ?>

        <form action="" method="POST">

            <input 
                type="email" 
                name="email"
                placeholder="Digite seu e-mail"
                required
            >

            <input 
                type="password" 
                name="senha"
                placeholder="Digite sua senha"
                required
            >

            <br><br>

            <button type="submit">
                Entrar
            </button>

        </form>

        <div class="login-link">
            <a href="cadastro.php" class="btn-cadastro">
                Criar conta
            </a>
        </div>

    </div>

</div>

</body>
</html>