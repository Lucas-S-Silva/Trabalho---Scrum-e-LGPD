<?php

include("conexao.php");

$mensagem = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $consentimento_marketing = isset($_POST['consentimento_marketing']) ? 1 : 0;

        $sql = "INSERT INTO usuarios
        (nome, email, senha, consentimento_marketing)
        VALUES
        ('$nome', '$email', '$senha', $consentimento_marketing)";

    if($conexao->query($sql) === TRUE){
        $mensagem = "Cadastro realizado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar!";
    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container-login">

    <div class="card-login">

        <h1 class="titulo">Cadastro</h1>

        <?php
        if($mensagem != ""){
            echo "<p class='sucesso'>$mensagem</p>";
        }
        ?>

        <form action="" method="POST">

            <input 
                type="text" 
                name="nome" 
                placeholder="Digite seu nome" 
                required
            >

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

            <label>
                <input
                    type="checkbox"
                    name="consentimento_marketing"
                    value="1"
                >
                Desejo receber ofertas e novidades por e-mail.
            </label>

            <br><br>

            <button type="submit">
                Cadastrar
            </button>

        </form>

        <p class="login-link">
            Já possui conta?
            <a href="login.php">Fazer login</a>
        </p>

    </div>

</div>

</body>
</html>