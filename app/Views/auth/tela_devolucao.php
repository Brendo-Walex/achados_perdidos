<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Devolução de Item - Achou?achei.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/tela_formulario_de_devolucao.css" />
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
            <a href="tela_listagem_de_itens.php" class="btn btn-home">🏠 Início</a>
        </div>
        
        <nav class="main-nav">
            <button class="btn btn-action" onclick="irParateladelistasitens()">+ Cadastrar Item</button>
            <button class="btn btn-action" onclick="irParateladelistasitens()">☰ Lista Itens</button>
            <button class="btn btn-action" onclick="irParateladesolicitacoes()">👁 Solicitações</button>
            <button class="btn btn-action current" onclick="irParateladedevolucao()">↩ Devoluções</button>
        </nav>
    </header>
    
    <main>
        <section class="formulario-container">
            
            <div class="item-card">
                <div class="item-card-image">
                    <img src="img/carteira_marrom.webp" alt="Carteira" />
                </div>
                <div class="item-card-info">
                    <h2>Detalhes do Item</h2>
                    <h3>Carteira de Couro Marrom</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Local Encontrado: <strong>IFTO Campus - Colinas</strong></p>
                    <p><i class="fas fa-calendar-alt"></i> Data: <strong>25 de Setembro</strong></p>
                    <hr>
                    <p class="nota-importante"><i class="fas fa-exclamation-triangle"></i> Preencha o formulário para iniciar a **validação da posse** do item.</p>
                </div>
            </div>

            <form class="devolucao-form">
                <h3 class="form-title"><i class="fas fa-user-check"></i> Dados do Solicitante</h3>
                
                <div class="form-group input-icon">
                    <label for="nome">Nome Completo</label>
                    <i class="fas fa-user icon"></i>
                    <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required />
                </div>

                <div class="form-group input-icon">
                    <label for="cpf">CPF</label>
                    <i class="fas fa-id-card icon"></i>
                    <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00 (Máscara via JS)" required />
                </div>

                <div class="form-group input-icon">
                    <label for="email">E-mail</label>
                    <i class="fas fa-envelope icon"></i>
                    <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" required />
                </div>
                    
                <div class="form-group input-icon">
                    <label for="telefone">Número de Telefone</label>
                    <i class="fas fa-phone icon"></i>
                    <input type="tel" id="telefone" name="telefone" placeholder="(00) 90000-0000 (Máscara via JS)" required />
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Enviar Solicitação</button>
                <p class="nota-seguranca">Garantimos a proteção de seus dados. Apenas para validação e contato.</p>
            </form>
        </section>
    </main>
    <script>
        function navegarPara(pagina) { window.location.href = pagina; }
        function irParateladelistasitens() { navegarPara("tela_listagem_de_itens.php"); }
        function irParateladesolicitacoes() { navegarPara("tela_solicitacoes.php"); }
        function irParateladedevolucao() { navegarPara("tela_devolucao.php"); }
        
        // Exemplo: Adicionar máscara básica (você usaria uma biblioteca real como JQuery Mask, mas este é o conceito)
        document.getElementById('cpf').addEventListener('input', function (e) {
            var value = e.target.value.replace(/\D/g, '');
            if (value.length > 3) value = value.substring(0, 3) + '.' + value.substring(3);
            if (value.length > 7) value = value.substring(0, 7) + '.' + value.substring(7);
            if (value.length > 11) value = value.substring(0, 11) + '-' + value.substring(11, 13);
            e.target.value = value;
        });
    </script>
</body>
</html>