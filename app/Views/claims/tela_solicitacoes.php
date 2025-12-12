<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Gerenciar Solicitações de Itens</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/tela_solicitacoes.css" />
</head>
<body>
    <header>
        <div class="header-content-top">
            <div class="logo-area">
                <img src="img/logo.png" alt="Logo Achou?achei.com">
                <div>
                    <h1>Achou?achei.com</h1>
                    <p class="tagline">"Porque perder algo é fácil, mas recuperar também pode ser"</p>
                </div>
            </div>
            <div class="user-status">
                <span class="user-info">Olá, Administrador</span>
                <a href="logout.php" class="btn btn-logout">Sair</a>
            </div>
        </div>

        <nav class="main-nav">
            <button class="btn btn-action" onclick="irParateladelistasitens()">+ Cadastrar Item</button>
            <button class="btn btn-action" onclick="irParateladelistasitens()">☰ Lista Itens</button>
            <button class="btn btn-action current" onclick="irParateladesolicitacoes()">👁 Solicitações</button>
            <button class="btn btn-action" onclick="irParateladedevolucao()">↩ Ver Devolução</button>
        </nav>
    </header>

    <main class="conteudo">
        <div id="notification" style="display:none;position:fixed;top:16px;right:16px;background:#e6ffed;border:1px solid #b7f2c9;padding:12px 16px;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.06);z-index:999">
            <strong id="notif-title">Sucesso</strong>
            <div id="notif-message" style="margin-top:6px"></div>
        </div>

        <section class="busca-area">
            <div class="busca-esquerda">
                <div class="select">
                    <select id="filtrosituacao" class="select-filtro">
                        <option value="Pendentes">Pendentes (Padrão)</option>
                        <option value="Aprovadas">Aprovadas</option>
                        <option value="Reprovadas">Reprovadas</option>
                        <option value="Todos">Todos</option>
                    </select>
                </div>
                <input id="campoBusca" type="search" placeholder="Pesquisar solicitante, item ou CPF..." class="input-busca" />
            </div>
            <button id="btnBuscar" class="btn btn-busca">🔎 Buscar</button>
        </section>

        <p class="resultado-info">3 Solicitações Pendentes em IFTO Campus - Colinas</p>

        <section class="lista" id="listaSolicitacoes">
            
            <article class="cartao-solicitacao" data-id="123" data-status="Pendentes">
                <div class="item-visual">
                    <div class="status-tag">PENDENTE</div>
                    <img src="img/carteira_marrom.webp" alt="Carteira Marrom" />
                    <div class="item-info">
                        <h3>Carteira Marrom</h3>
                        <p>Encontrado em: <strong>25/09/2025</strong></p>
                    </div>
                </div>

                <div class="solicitacao-detalhes">
                    <h4>Informações do Solicitante</h4>
                    <div class="solicitante-dados">
                        <p>👤 <strong>Nome:</strong> Jose de Sousa</p>
                        <p>📧 <strong>Email:</strong> jose2018@gmail.com</p>
                        <p>📞 <strong>Celular:</strong> (63) 99200-0000</p>
                        <p>🆔 <strong>CPF/Doc:</strong> 123.456.789-00</p>
                    </div>
                    
                    <h4 class="pergunta-titulo">Perguntas de Validação</h4>
                    <div class="validacao-area">
                        <p class="pergunta">"Quais documentos estavam dentro da carteira?"</p>
                        <p class="resposta">CNH, RG, CPF e a Carteira de estudante.</p>
                        </div>
                </div>

                <div class="solicitacao-acoes">
                    <button class="btn btn-aprovado" onclick="aprovarSolicitacao(123)">✅ Aprovar (Devolver)</button>
                    <button class="btn btn-rejeitado" onclick="reprovarSolicitacao(123)">❌ Reprovar (Rejeitar)</button>
                    <button class="btn btn-secundario" onclick="verAnexo(123)">📎 Ver Anexo/Prova</button>
                    <button class="btn btn-secundario" onclick="enviarEmail(123)">📧 Contatar Solicitante</button>
                </div>
            </article>

            <p class="loading-message" style="grid-column:1/-1;text-align:center;color:#666">Carregando solicitações...</p>

        </section>
    </main>
    
    <script>
        function navegarPara(pagina) {
            window.location.href = pagina;
        }
        function irParateladelistasitens() { navegarPara("tela_listagem_de_itens.php"); }
        function irParateladesolicitacoes() { navegarPara("tela_solicitacoes.php"); }
        function irParateladedevolucao() { navegarPara("tela_devolucao.php"); }

        // NOVAS FUNÇÕES DE AÇÃO PARA O JS
        function aprovarSolicitacao(id) {
            if (confirm("Tem certeza que deseja APROVAR esta solicitação?")) {
                // Lógica AJAX para enviar o ID para o servidor (PHP) e atualizar o status no banco de dados
                console.log("Aprovando solicitação ID: " + id);
                // Exibir notificação de sucesso
            }
        }
        function reprovarSolicitacao(id) {
             if (confirm("Tem certeza que deseja REPROVAR esta solicitação? Ela será marcada como rejeitada.")) {
                // Lógica AJAX para enviar o ID para o servidor (PHP) e atualizar o status
                console.log("Reprovando solicitação ID: " + id);
                // Exibir notificação de rejeição
            }
        }
        function verAnexo(id) {
            alert("Abrir modal ou nova aba com o anexo da solicitação ID: " + id);
        }
        function enviarEmail(id) {
            alert("Abrir interface para contatar o solicitante da solicitação ID: " + id);
        }
    </script>
    <script src="js/listar_solicitacoes.js"></script>
</body>
</html>