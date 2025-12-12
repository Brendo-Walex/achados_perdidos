<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Achou?achei.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #0f4d1f;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .container .msg {
            margin-bottom: 15px;
            font-weight: 500;
            color: red;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            text-align: left;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }

        input[type="text"], input[type="password"] {
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #4A90E2;
            outline: none;
            box-shadow: 0 0 5px rgba(74,144,226,0.5);
        }

        button {
            background: #08a000ff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #02c944ff;
        }

        .link {
            margin-top: 15px;
            font-size: 14px;
        }

        .link a {
            color: #4A90E2;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Login</h2>

    <?php 
    if (isset($_SESSION['erro_login'])): 
    ?>
        <p class="msg"><?= $_SESSION['erro_login']; ?></p>
        <?php unset($_SESSION['erro_login']); ?>
    <?php endif; ?>

    <form action="index.php?pagina=processa_login" method="POST">

        <label for="login">Usuário</label>
        <input type="text" id="login" name="login" placeholder="Digite seu usuário" required>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

        <button type="submit">Entrar</button>

        <p class="link">
            Não tem conta? <a href="index.php?pagina=cadastro_usuario">Criar Conta</a>
        </p>
    </form>

</div>

</body>
</html>
