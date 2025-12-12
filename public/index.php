<?php
// 1. Inicia Sessão e Conexão Globalmente
session_start();

// Garante que o PHP mostre erros durante o desenvolvimento (opcional)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../app/Config/conexao.php';

// 2. Roteador
$pagina = $_GET['pagina'] ?? 'home';

switch ($pagina) {

    // =================================================================
    // ÁREA 1: VIEWS (Telas que o usuário vê)
    // =================================================================
    
    case 'home':
        // Tela Inicial Pública
        $sql = "SELECT * FROM itens ORDER BY id_item DESC";
        $result = $conn->query($sql);
        require_once __DIR__ . '/../app/Views/items/home.php';
        break;

    case 'login':
        // Tela de Login
        require_once __DIR__ . '/../app/Views/auth/login.php';
        break;

    case 'cadastro_usuario':
        // Tela de Cadastro de Usuário
        require_once __DIR__ . '/../app/Views/auth/cadastro.php';
        break;

    case 'dashboard':
        // Painel do Usuário (Meus Itens) - Protegido
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?pagina=login');
            exit;
        }
        // Sugestão: Renomeie 'tela_listagem_de_itens.php' para 'listagem.php'
        require_once __DIR__ . '/../app/Views/items/listagem.php';
        break;

    case 'cadastro_item':
        // Formulário de Novo Item - Protegido
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?pagina=login');
            exit;
        }
        require_once __DIR__ . '/../app/Views/items/cadastro.php';
        break;
    
    case 'ver_item':
        // Tela de Detalhes/Reivindicar (Pública ou Privada)
        $id_item = $_GET['id'] ?? 0;
        require_once __DIR__ . '/../app/Views/items/reivindicar.php';
        break;

    case 'solicitacoes':
        // Tela de Gestão de Solicitações (Admin/User)
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?pagina=login');
            exit;
        }
        require_once __DIR__ . '/../app/Views/claims/tela_solicitacoes.php';
        break;

    case 'devolucoes':
        // Tela de Devoluções
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?pagina=login');
            exit;
        }
        require_once __DIR__ . '/../app/Views/claims/tela_devolucao.php';
        break;

    case 'api_listar_itens':
        require_once __DIR__ . '/../app/Models/listar_itens.php';
        break;
    
    case 'excluir_item':
        require_once __DIR__ . '/../app/Controllers/excluir_item.php';
        break;

    // =================================================================
    // ÁREA 2: CONTROLLERS (Processamento de formulários/Lógica)
    // =================================================================
    
    case 'processa_login':
        require_once __DIR__ . '/../app/Controllers/logar.php';
        break;

    case 'logout':
        require_once __DIR__ . '/../app/Controllers/logout.php';
        break;

    case 'processa_cadastro_usuario':
        require_once __DIR__ . '/../app/Controllers/cadastrar_usuario.php';
        break;

    case 'processa_cadastro_item':
        require_once __DIR__ . '/../app/Controllers/cadastrar_item.php';
        break;
    
    case 'processa_reivindicacao':
        require_once __DIR__ . '/../app/Controllers/processa_reivindicacao.php';
        break;

    // =================================================================
    // ÁREA 3: API (Retorna JSON para o JavaScript)
    // =================================================================
    
    case 'api_solicitacoes':
        // Se você tiver o arquivo listar_solicitacoes.php retornando JSON:
        require_once __DIR__ . '/../app/Models/listar_solicitacoes.php';
        break;

    default:
        // Página de erro 404
        http_response_code(404);
        echo "<div style='text-align:center; padding:50px;'>";
        echo "<h1>Erro 404</h1>";
        echo "<p>Ops! A página <strong>'$pagina'</strong> não foi encontrada.</p>";
        echo "<a href='index.php'>Voltar para o início</a>";
        echo "</div>";
        break;
}
?>