<?php
session_start();
include "conexao.php";

// Verifica se os dados vieram do formulário
if (!isset($_POST['login']) || !isset($_POST['senha'])) {
    echo "<script>alert('Preencha os campos!'); window.location='tela_login.html';</script>";
    exit;
}

$login = $_POST['login'];
$senha = $_POST['senha'];

// Consulta o usuário
$sql = "SELECT * FROM usuarios WHERE login = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $login);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verifica se encontrou o login
if (mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

    // Confere a senha hasheada
    if (password_verify($senha, $user['senha'])) {

        $_SESSION['usuario_id'] = $user['id_usuario'];
        $_SESSION['usuario_login'] = $user['login'];

        header("Location: tela_listagem_de_itens.html");
        exit;

    } else {
        echo "<script>alert('Senha incorreta!'); window.location='tela_login.html';</script>";
    }

} else {
    echo "<script>alert('Usuário não encontrado!'); window.location='tela_login.html';</script>";
}
?>
