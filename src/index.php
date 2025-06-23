<?php


require_once __DIR__ . '/config/conexao.php'; // Este arquivo define conectarBD()

// <--- ALTERADO: CHAMA A FUNÇÃO conectarBD() E ATRIBUI À VARIÁVEL $conexao
$conexao = conectarBD();

// <--- NOVO: VERIFICA SE A CONEXÃO FOI ESTABELECIDA. SE NÃO, EXIBE ERRO E ENCERRA.
if ($conexao === null) {
    // Você pode usar uma função de displayErrorPage aqui, se tiver uma globalmente disponível
    // Por exemplo, se você tem 'displayErrorPage' definida em algum lugar ou pode defini-la aqui.
    // displayErrorPage("Falha ao conectar ao banco de dados. Por favor, tente novamente mais tarde.", "index.php");
    echo "<h1>Erro Crítico: Não foi possível conectar ao banco de dados.</h1>";
    echo "<p>Por favor, verifique as configurações do banco de dados e se o serviço está ativo.</p>";
    error_log("Erro Crítico: Conexão com o banco de dados falhou em index.php.");
    exit(); // Encerra a execução do script
}

//ate aqui manteve
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/conexao.php';

require_once __DIR__ . '/controllers/Auth_controller.php';
require_once __DIR__ . '/controllers/Dashboard_controller.php';
require_once __DIR__ . '/controllers/Professor_controller.php';
require_once __DIR__ . '/controllers/Aluno_controller.php';
require_once __DIR__ . '/controllers/Turma_controller.php';
require_once __DIR__ . '/controllers/Disciplina_controller.php';
require_once __DIR__ . '/controllers/Matricula_controller.php';
require_once __DIR__ . '/controllers/Professor_controller.php';
require_once __DIR__ . '/controllers/Prova_controller.php';
require_once __DIR__ . '/controllers/Questoes_controller.php';
require_once __DIR__ . '/controllers/Respostas_controller.php';
require_once __DIR__ . '/controllers/Conteudo_controller.php';

/**
 * Redireciona o navegador para uma nova URL.
 * @param string $url A URL completa ou relativa para redirecionar.
 */
function redirect($url) {
    header("Location: " . $url);
    exit(); // É crucial parar a execução após um redirecionamento
}

/**
 * Exibe uma página de erro formatada com uma mensagem e um link para retornar.
 * @param string $message A mensagem de erro a ser exibida.
 * @param string $homeUrl A URL para o botão "Voltar para a Home" ou outra página.
 */
function displayErrorPage($message, $homeUrl = 'index.php?controller=auth&action=showLoginForm') {
    global $errorMessage, $homeUrlForButton;
    $errorMessage = $message;
    $homeUrlForButton = $homeUrl;
    require __DIR__ . '/views/auth/error.php'; // Caminho para sua view de erro
    exit(); // É crucial parar a execução após exibir a página de erro
}

/**
 * Verifica se o usuário está autenticado e, opcionalmente, se é de um tipo específico.
 * Se as condições não forem atendidas, redireciona ou exibe uma página de erro.
 * @param string|null $userType O tipo de usuário esperado ('professor' ou 'aluno'). Se null, apenas verifica se está logado.
 */
function requireAuth($userType = null) {
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        redirect('index.php?controller=auth&action=showLoginForm'); // Redireciona para o login
    }

    if ($userType && $_SESSION['tipo_usuario'] !== $userType) {
        displayErrorPage("Acesso negado. Você não tem permissão para acessar esta página.", 'index.php?controller=auth&action=showLoginForm');
    }
}


$controllerParam = $_GET['controller'] ?? 'auth';
$actionParam = $_GET['action'] ?? 'showLoginForm';

$controllerClassName = ucfirst($controllerParam) . '_controller';

if (!class_exists($controllerClassName)) {
    displayErrorPage("Controller '$controllerClassName' não encontrado no sistema.", 'index.php?controller=auth&action=showLoginForm');
}

$controller = null; // Inicializa a variável do controlador

if (
    $controllerClassName === 'Turma_controller' ||
    $controllerClassName === 'Professor_controller' || // Adicione se Professor_controller precisa de $conexao
    $controllerClassName === 'Aluno_controller' ||     // Adicione se Aluno_controller precisa de $conexao
    $controllerClassName === 'Conteudo_controller' ||    // Adicione se Conteudo_controller precisa de $conexao
    $controllerClassName === 'Disciplina_controller' ||
    $controllerClassName === 'Matricula_controller' ||
    $controllerClassName === 'Prova_controller' ||
    $controllerClassName === 'Questoes_controller' ||
    $controllerClassName === 'Respostas_controller' 
    
) {
    $controller = new $controllerClassName($conexao); // Passa a conexão aqui!
} else {
    $controller = new $controllerClassName();
}

$methodToCall = $actionParam;

if (method_exists($controller, $methodToCall)) {
    switch ($methodToCall) {
        //case 'showEditForm': // Ação para exibir formulário de edição (GET)
        case 'showEditForm':
            if ($controllerClassName === 'Matricula_controller') {
            // Para matrícula, precisa de dois parâmetros
            $controller->$methodToCall($_GET['aluno_id'] ?? null, $_GET['disciplina_id'] ?? null);
            } else {
            // Para outras tabelas, só o ID
            $controller->$methodToCall($_GET['id'] ?? null);
            }
            break;
        case 'delete':  // Ação para excluir (GET) deleteTurma
            $controller->$methodToCall($_GET['id'] ?? null); // Passa o ID se for edição ou exclusão
            break;
        
        case 'create': // Ação 'create' via GET para exibir o formulário de criação
            // Para casos onde 'action=create' (GET) mostra o formulário, e 'action=create' (POST) processa
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (method_exists($controller, 'handleCreatePost')) {
                    $controller->handleCreatePost($_POST);
                } else {
                    displayErrorPage("Ação POST para 'create' não implementada no controller '$controllerClassName'.", 'index.php?controller=' . $controllerParam . '&action=list');
                }
            } else {
                $controller->showCreateForm(); // Assumimos que o método GET de criação é 'showCreateForm'
            }
            break;

        case 'update': // Ação 'update' via POST para processar atualização
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (method_exists($controller, 'handleUpdatePost')) {
                    $controller->handleUpdatePost($_POST);
                } else {
                    displayErrorPage("Ação POST para 'update' não implementada no controller '$controllerClassName'.", 'index.php?controller=' . $controllerParam . '&action=list');
                }
            } else {
                displayErrorPage("Ação 'update' só pode ser acessada via POST.", 'index.php?controller=' . $controllerParam . '&action=list');
            }
            break;
            
        case 'login': // Ação 'login' no Auth_controller
        case 'registerProfessor': // Ação 'registerProfessor' no Auth_controller
        case 'registerAluno': // Ação 'registerAluno' no Auth_controller
            $controller->$methodToCall();
            break;

        default:
            $controller->$methodToCall();
            break;
    }
} else {
    if (method_exists($controller, 'defaultAction')) {
        $controller->defaultAction();
    } else {
        displayErrorPage("Ação '$actionParam' não encontrada no controller '$controllerClassName'.", 'index.php?controller=auth&action=showLoginForm');
    }
}

?>



