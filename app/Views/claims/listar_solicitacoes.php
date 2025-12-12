<?php
require_once 'conexao.php';
header('Content-Type: application/json; charset=utf-8');

// Filtro por situação do item
$situacao = isset($_GET['situacao']) ? trim($_GET['situacao']) : 'todos';
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

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

// Construir query com JOIN para trazer dados do item
$sql = "SELECT 
    s.id_solicitacao, 
    s.id_item, 
    s.nome_solicitante, 
    s.email, 
    s.telefone, 
    s.cpf, 
    s.data_nascimento, 
    s.descricao_detalhada, 
    s.resposta_pergunta, 
    s.arquivo_anexo, 
    s.data_solicitacao,
    i.nome as nome_item,
    i.foto as foto_item,
    i.situacao,
    i.data_encontrado,
    i.pergunta_especifica
FROM solicitacoes s
JOIN itens i ON s.id_item = i.id_item
WHERE 1=1";

if ($situacao !== 'todos') {
    $situacao = mysqli_real_escape_string($conn, $situacao);
    $sql .= " AND i.situacao = '$situacao'";
}

if (!empty($busca)) {
    $busca = mysqli_real_escape_string($conn, $busca);
    $sql .= " AND (i.nome LIKE '%$busca%' OR s.nome_solicitante LIKE '%$busca%')";
}

$sql .= " ORDER BY s.data_solicitacao DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar solicitações: ' . mysqli_error($conn)]);
    exit;
}

$solicitacoes = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Formatar data de nascimento
    $dataNascimento = 'Não informada';
    if (!empty($row['data_nascimento'])) {
        $dataNasc = DateTime::createFromFormat('Y-m-d', $row['data_nascimento']);
        if ($dataNasc) {
            $dataNascimento = $dataNasc->format('d/m/Y');
        }
    }

    // Formatar data do item em português
    $dataFormatada = 'Data não informada';
    if (!empty($row['data_encontrado'])) {
        $timestamp = strtotime($row['data_encontrado']);
        $dia = date('d', $timestamp);
        $mes_en = date('F', $timestamp);
        $mes_pt = $meses[$mes_en] ?? $mes_en;
        $dataFormatada = "$dia de $mes_pt";
    }

    $solicitacoes[] = [
        'id' => intval($row['id_solicitacao']),
        'idItem' => intval($row['id_item']),
        'nomeItem' => htmlspecialchars($row['nome_item'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'fotoItem' => $row['foto_item'] ? htmlspecialchars($row['foto_item'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : 'img/placeholder.png',
        'situacao' => htmlspecialchars($row['situacao'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'dataSolicitacao' => !empty($row['data_solicitacao']) ? date('d/m/Y H:i', strtotime($row['data_solicitacao'])) : 'Desconhecida',
        'dataItem' => $dataFormatada,
        'nomeSolicitante' => htmlspecialchars($row['nome_solicitante'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'email' => htmlspecialchars($row['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'telefone' => htmlspecialchars($row['telefone'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'cpf' => htmlspecialchars($row['cpf'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'dataNascimento' => $dataNascimento,
        'descricao' => htmlspecialchars($row['descricao_detalhada'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
        'perguntaItem' => $row['pergunta_especifica'] ? htmlspecialchars($row['pergunta_especifica'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : '',
        'respostaSolicitante' => $row['resposta_pergunta'] ? htmlspecialchars($row['resposta_pergunta'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : '',
        'anexo' => $row['arquivo_anexo'] ? htmlspecialchars($row['arquivo_anexo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : null
    ];
}

echo json_encode([
    'sucesso' => true,
    'total' => count($solicitacoes),
    'solicitacoes' => $solicitacoes
], JSON_UNESCAPED_UNICODE);

mysqli_close($conn);
?>
