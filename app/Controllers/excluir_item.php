<?php
// ATENÇÃO: session_start() já iniciado no index.php

// Verificação de segurança
if (!isset($_SESSION['usuario_login'])) {
    header("Location: index.php?pagina=login");
    exit;
}

require_once __DIR__ . '/../Models/ItemModel.php';

$itemModel = new ItemModel();

// Pega o ID enviado pela URL
$id_item = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_item <= 0) {
    $_SESSION['erro_msg'] = 'ID inválido!';
    header("Location: index.php?pagina=dashboard");
    exit;
}

// Verifica se o item existe
$item = $itemModel->getItemPorId($id_item);
if (!$item) {
    $_SESSION['erro_msg'] = 'Item não encontrado!';
    header("Location: index.php?pagina=dashboard");
    exit;
}

// Remove a imagem da pasta uploads
if (!empty($item['foto']) && file_exists(__DIR__ . '/../../uploads/' . $item['foto'])) {
    unlink(__DIR__ . '/../../uploads/' . $item['foto']);
}

// Exclui o item do banco
if ($itemModel->excluirItem($id_item)) {
    $_SESSION['sucesso_msg'] = 'Item excluído com sucesso!';
} else {
    $_SESSION['erro_msg'] = 'Erro ao excluir item!';
}

header("Location: index.php?pagina=dashboard");
exit;
