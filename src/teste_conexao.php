<?php
require_once 'conexao.php';

echo "<h2>Teste de Conexão</h2>";

// Teste 1: Conexão
if ($conn) {
    echo "<p style='color:green'>✓ Conexão com banco de dados OK</p>";
} else {
    echo "<p style='color:red'>✗ Erro na conexão: " . mysqli_connect_error() . "</p>";
    exit;
}

// Teste 2: Tabela itens existe
$result = mysqli_query($conn, "SHOW TABLES LIKE 'itens'");
if (mysqli_num_rows($result) > 0) {
    echo "<p style='color:green'>✓ Tabela 'itens' existe</p>";
} else {
    echo "<p style='color:red'>✗ Tabela 'itens' não encontrada</p>";
}

// Teste 3: Contar registros
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM itens");
$row = mysqli_fetch_assoc($result);
$total = $row['total'];
echo "<p>Total de itens no banco: <strong>$total</strong></p>";

// Teste 4: Listar itens
echo "<h3>Itens cadastrados:</h3>";
$result = mysqli_query($conn, "SELECT id_item, nome, situacao, data_encontrado FROM itens LIMIT 10");
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>ID</th><th>Nome</th><th>Situação</th><th>Data</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id_item'] . "</td>";
        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($row['situacao']) . "</td>";
        echo "<td>" . $row['data_encontrado'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:orange'>Nenhum item encontrado na tabela.</p>";
}

// Teste 5: Testar API JSON
echo "<h3>Teste de API JSON:</h3>";
echo "<pre>";
header('Content-Type: application/json; charset=utf-8');
$result = mysqli_query($conn, "SELECT id_item, nome, situacao FROM itens LIMIT 3");
$itens = [];
while ($row = mysqli_fetch_assoc($result)) {
    $itens[] = $row;
}
echo json_encode(['sucesso' => true, 'total' => count($itens), 'itens' => $itens], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "</pre>";

mysqli_close($conn);
?>
