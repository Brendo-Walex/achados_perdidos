<?php
// ATENÇÃO: Removemos o session_start() daqui pois o index.php já fez isso.

// Verifica se o formulário foi enviado
if (!isset($_POST['login']) || !isset($_POST['senha'])) {
    echo "<script>alert('Preencha os campos!'); window.location='index.php?pagina=login';</script>";
    exit;
}

$login = $_POST['login'];
$senha = $_POST['senha'];

// Consulta o usuário
$sql = "SELECT * FROM usuarios WHERE login = ?";
// A variável $conn vem do index.php que incluiu este arquivo
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $login);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verifica se encontrou o login
if (mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

    // Confere a senha hasheada
    if (password_verify($senha, $user['senha'])) {

        $_SESSION['usuario_id'] = $user['id_usuario'];
        $_SESSION['usuario_login'] = $user['login'];


        header("Location: index.php?pagina=cadastro_item");
        exit;

    } else {
        echo "<script>alert('Senha incorreta!'); window.location='index.php?pagina=login';</script>";
    }

} else {
    echo "<script>alert('Usuário não encontrado!'); window.location='index.php?pagina=login';</script>";
}
?>