<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formulario de devolução</title>
  <link rel="stylesheet" href="css/tela_formulario_de_devolucao.css" />
</head>
<body>
  <header>
 <img src="img/logo.png" alt="logo">
    <div>
    <h1>Achou?achei.com</h1>
    <br>
    <p class="tagline">"Porque perder algo é fácil, mas recuperar também pode ser"</p>
    </div>
    <nav>
        <button onclick="irParateladelistasitens()">+ Cadastrar Item</button>
        <button onclick="irParateladelistasitens()">☰ Lista Itens</button>
        <button onclick="irParateladesolicitacoes()">👁 Ver Solicitações</button>
        <button onclick="irParateladedevolucao()">↩ Ver Devolução</button>

    </nav>
  </header>
  <main>
    <section class="formulario-container">
      <div class="item-encontrado">
        <img src="img/carteira_marrom.webp" alt="Carteira" />
        <div>
          <h2>Carteira</h2>
          <p>Encontrado em <strong>IFTO Campus - Colinas</strong></p>
          <p>No dia <strong>25 de Setembro</strong></p>
        </div>
      </div>

      <form>
        <h3>Preencha o formulário de devolução</h3>
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required />

        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf" required />

        
        <label for="email">Informe o seu E-mail</label>
        <input type="email" id="email" name="email" required />
          
        <label for="telefone">Número de Telefone</label>
        <input type="tel" id="telefone" name="telefone" required />

        <button type="submit">Salvar</button>
      </form>
   </section>
  </main>

  <script>
    // Função de exemplo para navegação
    function navegarPara(pagina) {
        window.location.href = pagina;
    }

    // Definição das funções referenciadas no HTML
    function irParateladelistasitens() {
      navegarPara("tela_listagem_de_itens.php"); // Mude para o nome correto do arquivo
    }

    function irParateladesolicitacoes() {
      navegarPara("tela_solicitacoes.php"); // Mude para o nome correto do arquivo
    }

    function irParateladedevolucao() {
      navegarPara("tela_devolucao.php"); // Mude para o nome correto do arquivo
    }
  </script>
</body>
</html>