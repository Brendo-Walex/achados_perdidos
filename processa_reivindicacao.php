<?php
include "conexao.php";

$id_item = $_POST['id_item'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$data_nascimento = $_POST['data_nascimento'];
$descricao_detalhada = $_POST['descricao_detalhada'];
$resposta_pergunta = $_POST['resposta_pergunta'];

$arquivo_anexo = "";

// Upload
if (!empty($_FILES['arquivo_anexo']['name'])) {
    $pasta = "uploads/";
    $nomeArquivo = time() . "_" . $_FILES['arquivo_anexo']['name'];
    $caminhoCompleto = $pasta . $nomeArquivo;

    if (move_uploaded_file($_FILES['arquivo_anexo']['tmp_name'], $caminhoCompleto)) {
        $arquivo_anexo = $nomeArquivo;
    }
}

$sql = "INSERT INTO solicitacoes 
        (id_item, nome_solicitante, email, telefone, cpf, data_nascimento, descricao_detalhada, resposta_pergunta, arquivo_anexo)
        VALUES 
        ('$id_item', '$nome', '$email', '$telefone', '$cpf', '$data_nascimento', '$descricao_detalhada', '$resposta_pergunta', '$arquivo_anexo')";

if ($conn->query($sql)) {
    echo "<script>alert('Solicitação enviada com sucesso!'); window.location='tela_inicial.php';</script>";
} else {
    echo "Erro: " . $conn->error;
}
?>
