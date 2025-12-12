<?php
// ATENÇÃO: session_start() removido pois o index.php já inicia.

// Verificação de Segurança: Se não estiver logado, manda pro login
if (!isset($_SESSION['usuario_login'])) {
    header("Location: index.php?pagina=login");
    exit;
}


$nome_usuario = htmlspecialchars($_SESSION['usuario_login']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Meus Itens - Achou?achei.com</title>
  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* ======================================= */
/* Estilos Gerais (Manter no topo)         */
/* ======================================= */
@import url(header.css);
@import url(Responsivo.css);

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    /* Use uma fonte mais moderna como Poppins, se não estiver na importação */
    font-family: 'Poppins', Arial, sans-serif; 
}

body {
    background-color: #a6eba6; /* Cor de fundo mais clara e suave */
    color: #333;
    padding: 0; /* Remova o padding do body se for usar um cabeçalho fixo */
}

/* ======================================= */
/* HEADER (Topo) - NOVO LAYOUT             */
/* ======================================= */

header {
    background-color: #a6eba6;
    border-bottom: 5px solid #024f0f;
    padding: 10px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap; /* Permite que os elementos se quebrem em telas menores */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.logo-area {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-area img {
    max-width: 60px; /* Logo menor */
    position: static;
}

.logo-area h1 {
    font-size: 1.8rem; /* Tamanho ajustado */
    font-weight: 700;
    background: linear-gradient(to right, #024f0f, #2bc36b);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin: 0;
    letter-spacing: 1px;
}

.logo-area .tagline {
    font-size: 0.8rem;
    color: #6c757d;
    font-style: italic;
    margin-top: 0;
}

/* NOVO: Estilização do Status do Usuário */
.user-status {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-left: auto; /* Empurra o status para a direita */
}

.user-info {
    font-size: 1rem;
    color: #024f0f;
    font-weight: 600;
}

.btn-logout {
    background-color: #dc3545; /* Vermelho para destaque de logout/perigo */
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s;
    text-decoration: none; /* Garante que 'a' pareça um botão */
}

.btn-logout:hover {
    background-color: #c82333;
}

/* Menu de Navegação Principal */
nav.main-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    /* Alinha a navegação abaixo do logo em telas grandes se o espaço for limitado */
    width: 100%; 
    justify-content: flex-start;
    padding-top: 10px;
    border-top: 1px solid #eee;
    margin-top: 10px;
}

nav.main-nav button {
    color: white;
    background-color: #2bc36b; /* Verde claro para botões de ação */
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.2s;
}

nav.main-nav button:hover {
    background-color: #198754; 
    transform: translateY(-1px);
}

/* ======================================= */
/* MAIN (Conteúdo)             */
/* ======================================= */

main.conteudo {
    background-color: #065c06ff; /* Fundo branco para a área de conteúdo */
    padding: 20px;
    border-radius: 8px;
    max-width: 1200px;
    margin: 20px auto;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}

/* Ajuste a busca-area para o novo design */
.busca-area {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f1f1f1; /* Fundo claro para a barra de busca */
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 20px;
    max-width: 100%; /* Ajuste para preencher o main */
}

.btn-busca {
    background: #024f0f; /* Verde escuro para o botão de busca */
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 700;
    max-width: 20%;
}

.resultado-info {
    color: #024f0f;
    font-weight: 600;
    margin-bottom: 15px;
    padding-left: 5px;
}

/* Ajustes na Grade (Lista) */
.grade {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); /* Mais adaptável */
    gap: 20px;
}

.cartao {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #00ff4cff; /* Fundo leve para o cartão */
    border: 1px solid #b7f2c9;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.cartao-esquerda img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
}
    </style>
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
            <a href="index.php?pagina=logout" class="btn-logout">Sair</a>
        </div>
        
        <nav class="main-nav">
            <a href="index.php?pagina=cadastro_item" class="btn-nav">+ Cadastrar Item</a>
            <a href="index.php?pagina=solicitacoes" class="btn-nav">👁 Ver Solicitações</a>
            <a href="index.php?pagina=devolucoes" class="btn-nav">↩ Ver Devolução</a>
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

        <p class="resultado-info">Itens do sistema</p>

        <section id="gradeItens" class="grade">
            <p style="grid-column:1/-1;text-align:center;color:#666">Carregando itens via JS...</p>
        </section>

    </main>
    <script src="js/listar_itens.js"></script>
</body>
</html>