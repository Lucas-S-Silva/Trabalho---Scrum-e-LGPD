<?php

session_start();

include("conexao.php");

$usuario_id = $_SESSION['usuario_id'];

$evento = "LOGOUT";

$ip = $_SERVER['REMOTE_ADDR'];

$sqlLog = "INSERT INTO logs_autenticacao
           (usuario_id, evento, ip, data_hora)
           VALUES
           ($usuario_id, '$evento', '$ip', NOW())";

$conexao->query($sqlLog);

session_destroy();

header("Location: login.php");
exit;

?>