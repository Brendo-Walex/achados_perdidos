<?php
session_start();

// Verifica se o usuário NÃO está logado. Se não estiver, redireciona para o login.
if (!isset($_SESSION['usuario_login'])) {
    header("Location: tela_login.php");
    exit;
}

$nome_usuario = htmlspecialchars($_SESSION['usuario_login']);

// Inclua aqui seu arquivo de conexão, se necessário para a listagem
// include "conexao.php"; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Meus Itens - Achou?achei.com</title>
    <link rel="stylesheet" href="css/tela_listagem_de_itens.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo-area">
            <img src="img/logo.png" alt="logo">
            <div>
                <h1>Achou?achei.com</h1>
                <p class="tagline">"Porque perder algo é fácil, mas recuperar também pode ser"</p>
            </div>
        </div>

        <div class="user-status">
            <span class="user-info">👋 Olá, **<?= $nome_usuario ?>**</span>
            <a href="logout.php" class="btn-logout">Sair</a>
        </div>
        <nav class="main-nav">
            <button onclick="irParateladelistasitens()">+ Cadastrar Item</button>
            <button onclick="irParateladesolicitacoes()">👁 Ver Solicitações</button>
            <button onclick="irParateladedevolucao()">↩ Ver Devolução</button>
        </nav>
    </header>
    
    <main class="conteudo">
        <section class="busca-area">
            <div class="busca-esquerda">
                <div class="select">
                    <select id="filtrosituacao"> 
                        <option value="todos">Todos</option>
                        <option value="achados">Achados</option>
                        <option value="perdidos">Perdidos</option>
                    </select>
                </div>
                <input id="campoBusca" type="search" placeholder="Pesquise um item aqui" />
            </div>
            <button id="btnBuscar" class="btn-busca">🔎</button>
        </section>

        <p class="resultado-info">3 itens encontrados em IFTO Campus - Colinas</p>

        <section id="gradeItens" class="grade">
            <p style="grid-column:1/-1;text-align:center;color:#666">Carregando itens...</p>
        </section>

    </main>
    <script src="js/listar_itens.js"></script>
</body>
</html>