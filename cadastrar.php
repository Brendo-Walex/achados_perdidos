<?php
include "conexao.php";

$login = $_POST['login'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (login, senha) VALUES ('$login', '$senha')";
mysqli_query($conn, $sql);

echo "Usuário cadastrado com sucesso!";
?>
