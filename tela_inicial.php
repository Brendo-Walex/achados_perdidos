<?php
include "conexao.php";

// Buscar itens no banco
$sql = "SELECT * FROM itens ORDER BY id_item DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Achados e Perdidos</title>
  <link rel="stylesheet" href="css/tela_inicial.css">
</head>
<body>

<header>
    <h1><img src="img/logo.png" alt="logo"></h1>

    <div>
      <h1>Achou?achei.com</h1>
      <p class="tagline">"Porque perder algo é fácil, mas recuperar também pode ser"</p>
    </div>

    <nav>
      <ul>
        <li><a href="#">Sobre</a></li>
        <li><a href="#">Contato</a></li>
        <li><a href="#">Ajuda</a></li>
      </ul>
    </nav>

    <a id="login-btn" href="tela_login.html">Entrar</a>
</header>

<section class="catalogo">

<?php while ($item = $result->fetch_assoc()): ?>

  <?php
    // Descrição curta
    $descricao_curta = $item['descricao_curta'] 
        ? $item['descricao_curta'] 
        : substr($item['descricao'], 0, 60) . '...';

    // Foto
    $foto = $item['foto'] ? $item['foto'] : 'img/sem_foto.png';

    // Título com nome + cor
    $titulo = $item['nome'] . " - " . $item['cor_predominante'];

    // Status: achado OU perdido
    $statusClass = strtolower($item['situacao']) === 'achado'
        ? 'status-achado'
        : 'status-perdido';
  ?>

  <a class="link-item" href="reivindicar.php?id_item=<?= $item['id_item'] ?>">
    <div class="item <?= $statusClass ?>">
      
      <h3><?= htmlspecialchars($titulo) ?></h3>

      <img src="<?= $foto ?>" alt="<?= htmlspecialchars($titulo) ?>">

      <p><?= htmlspecialchars($descricao_curta) ?></p>
      
    </div>
  </a>

<?php endwhile; ?>

</section>

</body>
</html>
