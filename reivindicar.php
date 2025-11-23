<?php
include "conexao.php";

// Verificar se veio id
if (!isset($_GET['id_item'])) {
    die("Item não informado!");
}

$id = intval($_GET['id_item']);

// Buscar item no banco
$sql = "SELECT * FROM itens WHERE id_item = $id LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Item não encontrado!");
}

$item = $result->fetch_assoc();

// Foto (fallback se não tiver)
$foto = $item['foto'] ? $item['foto'] : "img/sem_foto.png";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Reivindicar Item</title>

    <!-- Seu CSS -->
    <link rel="stylesheet" href="css/tela_formulario_para_reividicar.css">
</head>

<body>

<header>
    <img src="img/logo.png" alt="logo">
    <div>
        <h1>Achou?achei.com</h1>
        <p class="tagline">"Porque perder algo é fácil, mas recuperar também pode ser"</p>
    </div>
</header>

<main>
    <section class="formulario-container">

        <!-- FOTO DO ITEM -->
        <div class="item-encontrado">
            <img src="<?= $foto ?>" alt="Foto do item">
            <div>
                <h2><?= htmlspecialchars($item['nome']) ?></h2>

                <?php if (!empty($item['descricao'])): ?>
                    <p><?= nl2br(htmlspecialchars($item['descricao'])) ?></p>
                <?php endif; ?>

                <?php if (!empty($item['data_encontrado'])): ?>
                    <p>Encontrado em <strong><?= htmlspecialchars($item['data_encontrado']) ?></strong></p>
                <?php endif; ?>
            </div>
        </div>

        <h3>Orientações para Reivindicar o Item</h3>
        <p class="descricao">
            Precisamos que você descreva detalhes para comprovar que é o dono.  
            Forneça qualquer informação que seja relevante.
        </p>

        <form action="processa_reivindicacao.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id_item" value="<?= $item['id_item'] ?>">

            <label for="descricao_detalhada">Descrição detalhada</label>
            <textarea id="descricao_detalhada" name="descricao_detalhada" rows="4" required></textarea>

            <?php if (!empty($item['pergunta_especifica'])): ?>
                <label for="resposta_pergunta">Pergunta: <strong><?= htmlspecialchars($item['pergunta_especifica']) ?></strong></label>
                <input type="text" id="resposta_pergunta" name="resposta_pergunta" required>
            <?php endif; ?>

            <label for="arquivo">Adicione um arquivo (foto, comprovante etc.)</label>
            <input type="file" id="arquivo" name="arquivo_anexo" accept="image/*">

            <label for="nome">Seu nome</label>
            <input type="text" id="nome" name="nome" required>

            <div class="duplo">
                <div>
                    <label for="email">Seu e-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div>
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" required>
                </div>
            </div>

            <div class="duplo">
                <div>
                    <label for="nascimento">Data de nascimento</label>
                    <input type="date" id="nascimento" name="data_nascimento" required>
                </div>

                <div>
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" required>
                </div>
            </div>

            <button type="submit">Enviar</button>
        </form>

    </section>
</main>

</body>
</html>
