<?php
session_unset(); 
session_destroy();

// Redireciona o usuário para a tela de login ou inicial
header("Location: index.php?pagina=home");
exit;
?>