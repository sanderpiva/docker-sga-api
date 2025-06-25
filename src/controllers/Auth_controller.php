<?php

require_once __DIR__ . '/../models/Auth_model.php';

class Auth_controller {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function showLoginForm() {

        //$clima = $this->authModel->getWeather();  //openweathermap
        $clima = $this->authModel->getWeather("Machado,MG");
        
        require_once __DIR__ . '/../views/auth/Login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $senhaDigitada = $_POST['senha'] ?? '';

            if (empty($login) || empty($senhaDigitada)) {
                displayErrorPage("Por favor, preencha todos os campos de login e senha.", 'index.php?controller=auth&action=showLoginForm');
            }

            $user = $this->authModel->authenticate($login, $senhaDigitada);

            if ($user) {
                $_SESSION['logado'] = true;
                $_SESSION['tipo_usuario'] = $user['type'];
                $_SESSION['id_usuario'] = $user['data']['id_' . $user['type']];
                $_SESSION['nome_usuario'] = $user['data']['nome'];
                $_SESSION['email_usuario'] = $user['data']['email'];

                if ($user['type'] === 'aluno') {
                    $_SESSION['nome_turma'] = $user['data']['nomeTurma'] ?? 'N/A';
                    redirect('index.php?controller=dashboard&action=showAlunoDashboard');
                } else { 
                    
                    redirect('index.php?controller=dashboard&action=showProfessorDashboard');
                }
            } else {
                displayErrorPage("Login ou senha inválidos. Por favor, tente novamente.", 'index.php?controller=auth&action=showLoginForm');
            }
        } else {
            redirect('index.php?controller=auth&action=showLoginForm');
        }
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();   
        session_destroy(); 
        displayErrorPage("Você foi desconectado com sucesso!", 'index.php?controller=auth&action=showLoginForm');
    }

    public function showProfessorRegisterForm() {
        $isUpdating = false; 
        $professorData = []; 
        $errors = "";        
        require_once __DIR__ . '/../views/auth/register_professor.php';
    }

    public function showEditForm($id) {
        if (isset($id)) {
            $professor = $this->professorModel->getProfessorById($id);
            if ($professor) {
                include __DIR__ . '/../views/auth/Register_professor.php';
            } else {
                displayErrorPage("Professor não encontrado para edição.", 'index.php?controller=professor&action=list');
            }
        } else {
            displayErrorPage("ID do professor não especificado para edição.", 'index.php?controller=professor&action=list');
        }
    }

    public function registerProfessor() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->authModel->validateProfessorData($_POST);

            if (!empty($errors)) {
                $isUpdating = false;
                $professorData = $_POST; 
                require_once __DIR__ . '/../views/auth/register_professor.php';
                return; 
            }

            if ($this->authModel->registerProfessor($_POST)) {
                echo "<p>Professor cadastrado com sucesso!</p>";
                echo '<button onclick="window.location.href=\'index.php?controller=auth&action=showLoginForm\'">Voltar para o Login</button>';
                exit(); 
            } else {
                displayErrorPage("Erro ao cadastrar professor. Por favor, tente novamente.", 'index.php?controller=auth&action=showLoginForm');
            }
        } else {
            redirect('index.php?controller=auth&action=showProfessorRegisterForm');
        }
    }

    public function showAlunoRegisterForm() {
        $turmas = $this->authModel->getTurmas(); // Recupera as turmas do banco de dados
        require_once __DIR__ . '/../views/auth/register_aluno.php';
    }

    public function registerAluno() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->authModel->validateAlunoData($_POST);
            
            if (!empty($errors)) {
                $isUpdating = false;
                $alunoData = $_POST; 
                $turmas = $this->authModel->getTurmas(); 

                require_once __DIR__ . '/../views/auth/register_aluno.php';
                return; 
            }

            if ($this->authModel->registerAluno($_POST)) {
                echo "<p>Aluno cadastrado com sucesso!</p>";
                echo '<button onclick="window.location.href=\'index.php?controller=auth&action=showLoginForm\'">Voltar para o Login</button>';
                exit(); 
            } else {
                displayErrorPage("Erro ao cadastrar aluno. Por favor, tente novamente.", 'index.php?controller=auth&action=showLoginForm');
            }
        } else {
            redirect('index.php?controller=auth&action=showAlunoRegisterForm');
        }
  
    }
}
?>
