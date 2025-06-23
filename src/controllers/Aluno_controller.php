<?php


require_once __DIR__ . '/../models/Aluno_model.php'; // Adicione esta linha!
require_once __DIR__ . '/../models/DinamicActions_model.php'; // Adicione esta linha!
require_once __DIR__ . '/../models/Turma_model.php'; // Adicione esta linha!

class Aluno_controller
{
    private $turmaModel; 
    private $alunoModel;
    private $dinamicActions; 
    private $conexao; 

    /**
     * Construtor da classe Turma_controller.
     * Recebe a conexão com o banco de dados para passar ao modelo.
     * @param object $conexao Objeto de conexão com o banco de dados.
     */
    public function __construct($conexao) {
        $this->conexao = $conexao; 
        $this->alunoModel = new AlunoModel($this->conexao); 
        $this->dinamicActions = new DinamicActionsModel($this->conexao); 
        $this->turmaModel = new TurmaModel($this->conexao); 
    }

    public function list() {
        $alunos = $this->alunoModel->getAllAlunos(); 
        include __DIR__ . '/../views/aluno/List.php';
    }


    public function showDashboard()
    {
        echo "<h1>Bem-vindo ao Dashboard do Aluno</h1>";
        require_once __DIR__ . '/../views/aluno/Dashboard_login.php';
    }

    public function showStaticServicesPage()
    {
        /*
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }*/

        require_once __DIR__ . '/../views/aluno/Dashboard_algebrando.php'; // ATENÇÃO: Verifique este caminho
    }

    
    public function showEditForm($id) {
        if (isset($id) && !empty($id)) {
            $alunoData = $this->alunoModel->getAlunoById($id); 
            $turmas = $this->turmaModel->getAllTurmas(); // Supondo que você tenha um TurmaModel ou um método para buscar turmas

        if ($alunoData) {
            $alunoData = $alunoData; // Não é necessário, mas ilustra que a var está no escopo
            $turmas = $turmas;
            
            include __DIR__ . '/../views/auth/Register_aluno.php';
        } else {
            displayErrorPage("Aluno não encontrado para edição.", 'index.php?controller=aluno&action=list');
        }
    } else {
        $turmas = $this->turmaModel->getAllTurmas(); 
        include __DIR__ . '/../views/auth/Register_aluno.php';
    }
   }



    public function handleSelection()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo_atividade = $_POST['tipo_atividade'] ?? '';

            if ($tipo_atividade === 'dinamica') {
                
                header("Location: index.php?controller=aluno&action=showDynamicServicesPage");
                exit();
            } elseif ($tipo_atividade === 'estatica') {
                header("Location: index.php?controller=aluno&action=showStaticServicesPage");
                exit();
            } else {
                $error = "Selecione uma opção válida.";
                require_once __DIR__ . '/../views/aluno/Dashboard_login.php';
            }
        } else {
            $error = "Requisição inválida."; // Mensagem mais apropriada para GET em um handler POST
            require_once __DIR__ . '/../views/aluno/Dashboard_login.php';
        }
    }

     public function delete($id) {
        if (isset($id)) {
            $this->alunoModel->deleteAluno($id);
            redirect('index.php?controller=aluno&action=list');
        } else {
            displayErrorPage("ID do aluno não especificado para exclusão.", 'index.php?controller=aluno&action=list');
        }
    }

    //Matemática Estática: Algebrando
    // 🔥 Novo método para acessar PA.php
    public function viewPA() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        $_SESSION['pa_status'] = 1;
        
        require_once __DIR__ . '/../views/aluno/matematica-estatica/pa.php';
    }

    // 🔥 Novo método para acessar PG.php
    public function viewPG() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        $_SESSION['pg_status'] = 1;
        
        require_once __DIR__ . '/../views/aluno/matematica-estatica/pg.php';

    }
    // 🔥 Novo método para acessar Porcentagem.php
    public function viewPorcentagem() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        $_SESSION['porcentagem_status'] = 1;
        
        require_once __DIR__ . '/../views/aluno/matematica-estatica/Porcentagem.php';
    }
    // 🔥 Novo método para acessar Proporcao.php
    public function viewProporcao() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        $_SESSION['proporcao_status'] = 1;
        
        require_once __DIR__ . '/../views/aluno/matematica-estatica/Proporcao.php';
    }

    // 🔥 Novo método para acessar Prova.php
    public function viewProva() {
       if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }

        // Zera as variáveis de progresso das atividades
         unset($_SESSION['pa_status'], $_SESSION['pg_status'], $_SESSION['porcentagem_status'], $_SESSION['proporcao_status']);

        require_once __DIR__ . '/../views/aluno/matematica-estatica/prova.php';

    }
    //FIM Matemática Estática: Algebrando

    // Método para processar a submissão do formulário de atualização
    public function updateAluno() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_aluno'])) {
            // Coletar e sanitizar dados
            $id_aluno = htmlspecialchars($_POST['id_aluno']);
            $matricula = htmlspecialchars($_POST['matricula'] ?? '');
            $nome = htmlspecialchars($_POST['nome'] ?? '');
            $cpf = htmlspecialchars($_POST['cpf'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $data_nascimento = htmlspecialchars($_POST['data_nascimento'] ?? '');
            $endereco = htmlspecialchars($_POST['endereco'] ?? '');
            $cidade = htmlspecialchars($_POST['cidade'] ?? '');
            $telefone = htmlspecialchars($_POST['telefone'] ?? '');
            $turma_id_turma = htmlspecialchars($_POST['Turma_id_turma'] ?? '');
            $novaSenha = $_POST['novaSenha'] ?? null; // A senha pode ser opcional na atualização

            $errors = []; // Array para armazenar erros de validação

            if (empty($matricula)) {
                $errors[] = "A matrícula é obrigatória.";
            }
            if (empty($nome)) {
                $errors[] = "O nome do aluno é obrigatório.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Formato de e-mail inválido.";
            }
            
            if (empty($errors)) {
                $dadosParaAtualizar = [
                    'id_aluno' => $id_aluno,
                    'matricula' => $matricula,
                    'nome' => $nome,
                    'cpf' => $cpf,
                    'email' => $email,
                    'data_nascimento' => $data_nascimento,
                    'endereco' => $endereco,
                    'cidade' => $cidade,
                    'telefone' => $telefone,
                    'Turma_id_turma' => $turma_id_turma,
                ];

                if (!empty($novaSenha)) {
                    $dadosParaAtualizar['novaSenha'] = $novaSenha; // Inclui a nova senha se fornecida
                }

                error_log("DEBUG ALUNO CONTROLLER: Dados para atualizar: " . print_r($dadosParaAtualizar, true));

                if ($this->alunoModel->updateAluno($dadosParaAtualizar)) {
                    error_log("DEBUG ALUNO CONTROLLER: Aluno atualizado com sucesso (ID: " . $id_aluno . ")");
                    redirect('index.php?controller=aluno&action=list'); // Redireciona para a lista
                } else {
                    error_log("DEBUG ALUNO CONTROLLER: Falha ao atualizar aluno (ID: " . $id_aluno . ")");
                    $errors[] = "Erro ao atualizar aluno no banco de dados. Tente novamente.";
                    $alunoData = $_POST; // Preserva os dados digitados
                    include __DIR__ . '/../views/auth/Register_aluno.php'; // Usa a view de formulário novamente
                }
            } else {
                error_log("DEBUG ALUNO CONTROLLER: Erros de validação: " . print_r($errors, true));
                $alunoData = $_POST; // Preserva os dados digitados
                include __DIR__ . '/../views/auth/Register_aluno.php'; // Usa a view de formulário novamente
            }

        } else {
            error_log("DEBUG ALUNO CONTROLLER: Requisição inválida para updateAluno.");
            displayErrorPage("Requisição inválida para atualização de aluno.", 'index.php?controller=aluno&action=list');
        }
    }

     public function showDynamicOptions() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'aluno') {
            header("Location: index.php?controller=auth&action=showLoginForm");
            exit();
        }
        $erro_form = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['turma_selecionada']) && !empty($_POST['turma_selecionada']) &&
                isset($_POST['disciplina_selecionada']) && !empty($_POST['disciplina_selecionada'])) {
                $_SESSION['turma_selecionada'] = $_POST['turma_selecionada'];
                $_SESSION['disciplina_selecionada'] = $_POST['disciplina_selecionada'];
                header('Location: index.php?controller=aluno&action=showDynamicServicesPage');
                exit();
            } else {
                $erro_form = "Por favor, selecione tanto a Turma quanto a Disciplina.";
            }
        }
        $turmas = $this->alunoModel->getAllTurmas();
        $disciplinas = $this->alunoModel->getAllDisciplinas();
        require_once __DIR__ . '/../views/aluno/Dinamic_selection.php';
    }

    public function showDynamicServicesPage()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'aluno') {
            header("Location: index.php?controller=auth&action=showLoginForm");
            exit();
        }

        $turma_selecionada = $_SESSION['turma_selecionada'] ?? null;
        $disciplina_selecionada = $_SESSION['disciplina_selecionada'] ?? null;

        if (!$turma_selecionada || !$disciplina_selecionada) {
            $_SESSION['erro_selecao'] = "Por favor, selecione a turma e a disciplina para ver os conteúdos.";
            header('Location: index.php?controller=aluno&action=showDynamicOptions');
            //exit();
        }

        $conteudos = $this->dinamicActions->getConteudosPorTurmaEDisciplina($turma_selecionada, $disciplina_selecionada);

        
        $erro_conexao = null; 

        require_once __DIR__ . '/../views/aluno/dashboard_dinamico.php';
    }

    public function detalheConteudoDinamico() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'aluno') {
            header("Location: index.php?controller=auth&action=showLoginForm");
            exit(); 
        }

        $id_conteudo = $_GET['id'] ?? null; 

        $conteudo = false; 
        $erro = null; 
        $imagem_associada = null; 

        if (!$id_conteudo || !is_numeric($id_conteudo)) {
            $erro = "ID de conteúdo inválido ou não fornecido.";
        } else {
            $conteudo = $this->dinamicActions->getConteudoById((int)$id_conteudo);

            if (!$conteudo) {
                $erro = "Conteúdo não encontrado para o ID fornecido.";
            }
        }
        
        
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'aluno' . DIRECTORY_SEPARATOR . 'detalhe_conteudo.php';
    }

    //EXERCICIOS DINAMICOS: TESTE
    // NOVO MÉTODO: Para o exercício de Progressão Aritmética (PA)
    public function exercicioPA() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'aluno') {
            header("Location: index.php?controller=auth&action=showLoginForm");
            exit();
        }

        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'aluno' . DIRECTORY_SEPARATOR . 'exercicio_pa.php';
    }
    
}
?>
