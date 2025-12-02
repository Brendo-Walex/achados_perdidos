<?php
require_once 'conexao.php';

// Função simples para limpar entrada
function clean($conn, $value) {
    return trim(mysqli_real_escape_string($conn, $value));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tela_cadastro_de_item.html');
    exit;
}

$nome = isset($_POST['nome']) ? clean($conn, $_POST['nome']) : '';
$descricao = isset($_POST['descricao']) ? clean($conn, $_POST['descricao']) : '';
$cor = isset($_POST['cor']) ? clean($conn, $_POST['cor']) : '';
$situacao = isset($_POST['situacao']) ? clean($conn, $_POST['situacao']) : '';
$data = isset($_POST['data']) && $_POST['data'] !== '' ? $_POST['data'] : null;
$hora = isset($_POST['hora']) && $_POST['hora'] !== '' ? $_POST['hora'] : null;
$pergunta = isset($_POST['pergunta']) ? clean($conn, $_POST['pergunta']) : '';
$achador = isset($_POST['achador']) ? clean($conn, $_POST['achador']) : '';

// Tratamento do upload (opcional)
$foto_path = null;
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['imagem'];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('Erro no upload da imagem. Código: ' . $file['error']);
    }

    // Validar tipo e tamanho
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowed)) {
        die('Tipo de imagem não permitido. Use JPG, PNG, GIF ou WEBP.');
    }

    $maxBytes = 5 * 1024 * 1024; // 5 MB
    if ($file['size'] > $maxBytes) {
        die('Imagem muito grande. Máx 5MB.');
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $target = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $safeName;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        die('Falha ao mover o arquivo enviado.');
    }

    // Salva caminho relativo
    $foto_path = 'uploads/' . $safeName;
}

// Validar campos obrigatórios
if (empty($nome)) {
    die('Erro: Nome do item é obrigatório.');
}

// Inserir no banco usando prepared statement
$sql = "INSERT INTO itens (nome, descricao, situacao, cor_predominante, foto, data_encontrado, horario_aproximado, pergunta_especifica, nome_de_quem_achou) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die('Erro na preparação da query: ' . mysqli_error($conn));
}

// Bind com os tipos corretos
mysqli_stmt_bind_param($stmt, 'sssssssss', $nome, $descricao, $situacao, $cor, $foto_path, $data, $hora, $pergunta, $achador);

$exec = mysqli_stmt_execute($stmt);
if (!$exec) {
    die('Erro ao inserir item: ' . mysqli_stmt_error($stmt));
}

$itemId = mysqli_insert_id($conn);
mysqli_stmt_close($stmt);

// Mostra mensagem de sucesso com dados do item e redireciona para a listagem (com flag)
// Preparar valores para exibição/URL
$displayNome = htmlspecialchars($nome, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$displayFoto = $foto_path ? htmlspecialchars($foto_path, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : null;
$urlNome = rawurlencode($nome);
$redirectUrl = "tela_listagem_de_itens.html?success=1&nome={$urlNome}";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Item cadastrado</title>
        <meta http-equiv="refresh" content="3;url=<?php echo $redirectUrl; ?>">
        <style>
                body{font-family:Arial,Helvetica,sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#f6f6f6}
                .card{background:#fff;padding:24px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.08);text-align:center;max-width:420px}
                .preview{max-width:180px;max-height:180px;object-fit:cover;border-radius:6px;margin:12px 0}
                a{color:#007bff;text-decoration:none}
        </style>
</head>
<body>
    <div class="card">
        <h1>Item cadastrado com sucesso!</h1>
        <p><strong><?php echo $displayNome; ?></strong></p>
        <?php if ($displayFoto): ?>
            <img src="<?php echo $displayFoto; ?>" alt="Foto do item" class="preview">
        <?php endif; ?>
        <p>Você será redirecionado em alguns segundos.</p>
        <p><a href="<?php echo $redirectUrl; ?>">Ir agora para a lista de itens</a> • <a href="tela_cadastro_de_item.html">Cadastrar outro item</a></p>
    </div>
</body>
</html>
<?php
exit;
?>
