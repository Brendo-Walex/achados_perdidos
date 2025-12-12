<?php
$servidor = "db"; // nome do serviço do MySQL
$usuario  = "root";
$senha    = "root_password_segura"; 
$banco    = "achados_e_perdidos"; // nome correto do banco criado

$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conn) {
    die("Erro ao conectar: " . mysqli_connect_error());
}
?>
