<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "my_database";

try {
    // Conexão usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

    // Configura o modo de erro do PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conectado com sucesso!";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
