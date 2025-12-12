<?php
require_once __DIR__ . '/../Config/conexao.php'; // caminho relativo correto
header('Content-Type: application/json; charset=utf-8');

// Define locale para português
setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');

// Filtro por situação
$situacao = isset($_GET['situacao']) ? trim($_GET['situacao']) : 'todos';
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

// Construir query
$sql = "SELECT id_item, nome, descricao, situacao, cor_predominante, foto, data_encontrado, horario_aproximado, pergunta_especifica, nome_de_quem_achou FROM itens WHERE 1=1";

if ($situacao !== 'todos') {
    $situacao = mysqli_real_escape_string($conn, $situacao);
    $sql .= " AND situacao = '$situacao'";
}

if (!empty($busca)) {
    $busca = mysqli_real_escape_string($conn, $busca);
    $sql .= " AND (nome LIKE '%$busca%' OR descricao LIKE '%$busca%')";
}

$sql .= " ORDER BY data_encontrado DESC, id_item DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar itens: ' . mysqli_error($conn)]);
    exit;
}

// Mapeamento de meses para português
$meses = [
    'January' => 'janeiro',
    'February' => 'fevereiro',
    'March' => 'março',
    'April' => 'abril',
    'May' => 'maio',
    'June' => 'junho',
    'July' => 'julho',
    'August' => 'agosto',
    'September' => 'setembro',
    'October' => 'outubro',
    'November' => 'novembro',
    'December' => 'dezembro'
];

$itens = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Calcular "guardado há X dias"
    if (!empty($row['data_encontrado'])) {
        $dataEncontrado = new DateTime($row['data_encontrado']);
        $hoje = new DateTime('now');
        $diasDiferenca = $hoje->diff($dataEncontrado)->days;
        $guardadoHa = $diasDiferenca == 0 ? 'Hoje' : ($diasDiferenca == 1 ? '1 dia' : "$diasDiferenca dias");
    } else {
        $guardadoHa = 'Desconhecido';
    }

    // Formatar data em português
    $dataFormatada = 'Data não informada';
    if (!empty($row['data_encontrado'])) {
        $timestamp = strtotime($row['data_encontrado']);
        $dia = date('d', $timestamp);
        $mes_en = date('F', $timestamp);
        $mes_pt = $meses[$mes_en] ?? $mes_en;
        $dataFormatada = "$dia de $mes_pt";
    }

    $itens[] = [
        'id' => intval($row['id_item']),
        'nome' => htmlspecialchars($row['nome'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'descricao' => htmlspecialchars($row['descricao'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'situacao' => htmlspecialchars($row['situacao'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'cor' => htmlspecialchars($row['cor_predominante'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'foto' => $row['foto'] ? htmlspecialchars($row['foto'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'img/placeholder.png',
        'dataFormatada' => $dataFormatada,
        'guardadoHa' => $guardadoHa,
        'achador' => htmlspecialchars($row['nome_de_quem_achou'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
    ];
}

echo json_encode([
    'sucesso' => true,
    'total' => count($itens),
    'itens' => $itens
], JSON_UNESCAPED_UNICODE);

mysqli_close($conn);
?>
