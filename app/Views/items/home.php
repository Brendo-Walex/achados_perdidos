<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achados e Perdidos | Achou?achei.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #0f4d1f; /* verde escuro */
            color: white;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #013409ff;
        }

        .logo-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-title h1 {
            font-size: 28px;
            color: white;
        }

        .logo-title img {
            max-height: 50px;
        }

        .tagline {
            font-size: 14px;
            color: #a5e7a5;
            font-style: italic;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        .button-group a {
            background-color: #08a000;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 10px;
            transition: 0.3s;
        }

        .button-group a:hover {
            background-color: #02c944;
        }

        .catalogo {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .link-item {
            text-decoration: none;
        }

        .item {
            background-color: #08a000;
            border-radius: 12px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 2px solid #ccc; /* padrão borda clara */
        }

        .item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
        }

        .item img {
            max-width: 100%;
            border-radius: 8px;
        }

        .item h3 {
            text-align: center;
            font-size: 1.1rem;
            color: #fff;
        }

        .item p {
            text-align: center;
            color: #e0e0e0;
            font-size: 0.9rem;
        }

        .status-achado {
            border-color: #4cd964; /* verde claro */
        }

        .status-perdido {
            border-color: #ff6b6b; /* vermelho suave */
        }

        p {
            color: #fff;
            text-align: center;
        }

    </style>
</head>
<body>

<header>
    <div class="logo-title">
        <h1><img src="img/logo.png" alt="Logo Achou?achei.com"></h1>
        <div>
            <h1>Achou?achei.com</h1>
            <p class="tagline">"Porque perder algo é fácil, mas recuperar também pode ser"</p>
        </div>
    </div>

    <nav>
        <ul>
            <li><a href="#">Sobre</a></li>
            <li><a href="#">Contato</a></li>
            <li><a href="#">Ajuda</a></li>
        </ul>
    </nav>

    <div class="button-group">
        <a id="login-btn" href="index.php?pagina=login">Entrar</a>
        <!-- Botão de criar conta removido -->
    </div>
</header>

<section class="catalogo">

<?php 
if (isset($result) && $result->num_rows > 0):
    while ($item = $result->fetch_assoc()): 
        $descricao_curta = $item['descricao_curta'] 
            ? $item['descricao_curta'] 
            : (strlen($item['descricao']) > 80 ? substr($item['descricao'], 0, 80) . '...' : $item['descricao']);

        $foto = !empty($item['foto']) ? 'uploads/' . $item['foto'] : 'img/sem_foto.png';
        $titulo = $item['nome'] . " - " . $item['cor_predominante'];
        $statusClass = strtolower($item['situacao']) === 'achado' ? 'status-achado' : 'status-perdido';
?>

    <a class="link-item" href="index.php?pagina=ver_item&id=<?= $item['id_item'] ?>" title="Ver detalhes">
        <div class="item <?= $statusClass ?>">
            <h3><?= htmlspecialchars($titulo) ?></h3>
            <img src="<?= htmlspecialchars($foto) ?>" alt="Imagem de <?= htmlspecialchars($titulo) ?>">
            <p><?= htmlspecialchars($descricao_curta) ?></p>
        </div>
    </a>

<?php 
    endwhile; 
else:
?>
    <p>Nenhum item encontrado.</p>
<?php endif; ?>

</section>

</body>
</html>