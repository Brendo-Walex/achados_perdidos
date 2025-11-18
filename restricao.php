<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    // Usuário não está logado
    header("Location: tela_login.html");
    exit;
}
?>
