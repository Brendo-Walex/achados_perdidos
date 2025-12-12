<?php
// Controller permanece com o mesmo nome para não quebrar nada
require_once __DIR__ . '/../Config/conexao.php'; // Cria $conn
require_once __DIR__ . '/../Models/Item.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ------------------------------
    // 1️⃣ Receber dados do formulário
    // ------------------------------
    $nome       = trim($_POST['nome'] ?? '');
    $descricao  = trim($_POST['descricao'] ?? '');
    $cor        = $_POST['cor'] ?? '';
    $situacao   = $_POST['situacao'] ?? '';
    $data       = $_POST['data'] ?? null;
    $hora       = $_POST['hora'] ?? null;
    $pergunta   = trim($_POST['pergunta'] ?? '');
    $achador    = trim($_POST['achador'] ?? '');

    $descricao_curta = mb_substr($descricao, 0, 50);

    if (empty($nome) || empty($situacao) || empty($cor)) {
        die("<script>alert('Preencha os campos obrigatórios: Nome, Situação e Cor.'); window.history.back();</script>");
    }

    // ------------------------------
    // 2️⃣ Tratamento da imagem
    // ------------------------------
    if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] !== 0) {
        die("<script>alert('Imagem obrigatória.'); window.history.back();</script>");
    }

    $arquivo = $_FILES['imagem'];
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $nome_imagem = uniqid() . '.' . $extensao;
    $caminho = __DIR__ . '/../../public/uploads/' . $nome_imagem;

    if (!in_array($extensao, ['jpg','jpeg','png'])) {
        die("<script>alert('Apenas imagens JPG ou PNG são permitidas.'); window.history.back();</script>");
    }

    if ($arquivo['size'] > 5 * 1024 * 1024) {
        die("<script>alert('A imagem deve ter no máximo 5MB.'); window.history.back();</script>");
    }

    if (!is_dir(__DIR__ . '/../../public/uploads')) {
        mkdir(__DIR__ . '/../../public/uploads', 0755, true);
    }

    if (!move_uploaded_file($arquivo['tmp_name'], $caminho)) {
        die("<script>alert('Erro ao enviar a imagem.'); window.history.back();</script>");
    }

    // ------------------------------
    // 3️⃣ Cadastrar item usando o Model
    // ------------------------------
    try {
        $itemModel = new Item($conn);
        $itemModel->cadastrar(
            $nome,
            $descricao,
            $descricao_curta,
            $situacao,
            $cor,
            $nome_imagem,
            $data,
            $hora,
            $pergunta,
            $achador
        );

        echo "<script>alert('Item cadastrado com sucesso!'); window.location.href='index.php?pagina=dashboard';</script>";

    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }

    mysqli_close($conn);

} else {
    die("Acesso inválido.");
}
