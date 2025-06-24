<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once __DIR__ . '/../models/Professor_model.php'; 

class Professor_controller
{
    private $professorModel;
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
        $this->professorModel = new ProfessorModel($this->conexao);
    }

    public function list() {
        $professores = $this->professorModel->getAllProfessores(); 
        include __DIR__ . '/../views/professor/List.php';
    }

    public function showDashboard() {
        echo "<h1>Bem-vindo ao Dashboard do Professor</h1>";
        require_once __DIR__ . '/../views/professor/Dashboard_login.php';
    }

    public function showServicesPage() {
        require_once __DIR__ . '/../views/professor/Dashboard_servicos.php';
    }

    public function showResultsPage() {
        echo "<h1>Página de Resultados dos Alunos</h1>";
        require_once __DIR__ . '/../views/professor/Dashboard_resultados.php';
    }

    public function handleSelection() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo_assunto = $_POST['tipo_assunto'] ?? '';

            if ($tipo_assunto === 'servicos') {
                header("Location: index.php?controller=professor&action=showServicesPage");
                exit();
            } elseif ($tipo_assunto === 'resultados') {
                header("Location: index.php?controller=professor&action=showResultsPage");
                exit();
            }elseif ($tipo_assunto === 'grafico') {
                header("Location: index.php?controller=grafico&action=viewProvasPorProfessorEDisciplina");
                exit();
            } else {
                $error = "Selecione uma opção válida.";
                require_once __DIR__ . '/../views/professor/Dashboard_login.php';
            }
        } else {
            $error = "Requisição inválida.";
            require_once __DIR__ . '/../views/professor/Dashboard_login.php';
        }
    }

    // Método para exibir o formulário de edição pré-preenchido
    public function showEditForm($id) {
        if (isset($id)) {
            $professorData = $this->professorModel->getProfessorById($id); // Alterado para $professorData para melhor clareza na view
            if ($professorData) {
                include __DIR__ . '/../views/auth/register_professor.php'; 
            } else {
                displayErrorPage("Professor não encontrado para edição.", 'index.php?controller=professor&action=list');
            }
        } else {
            displayErrorPage("ID do professor não especificado para edição.", 'index.php?controller=professor&action=list');
        }
    }

    // NOVO MÉTODO: Para processar a submissão do formulário de atualização
    public function updateProfessor() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_professor'])) {
            // Coletar e sanitizar dados
            $id_professor = htmlspecialchars($_POST['id_professor']);
            $registroProfessor = htmlspecialchars($_POST['registroProfessor'] ?? '');
            $nomeProfessor = htmlspecialchars($_POST['nomeProfessor'] ?? '');
            $emailProfessor = htmlspecialchars($_POST['emailProfessor'] ?? '');
            $enderecoProfessor = htmlspecialchars($_POST['enderecoProfessor'] ?? '');
            $telefoneProfessor = htmlspecialchars($_POST['telefoneProfessor'] ?? '');
            $novaSenha = $_POST['novaSenha'] ?? null; 

            $errors = []; 

            if (empty($registroProfessor)) {
                $errors[] = "O registro do professor é obrigatório.";
            }
            if (empty($nomeProfessor)) {
                $errors[] = "O nome do professor é obrigatório.";
            }
            if (!filter_var($emailProfessor, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Formato de e-mail inválido.";
            }
            
            if (empty($errors)) {
                $dadosParaAtualizar = [
                    'id_professor' => $id_professor,
                    'registroProfessor' => $registroProfessor,
                    'nome' => $nomeProfessor,
                    'email' => $emailProfessor,
                    'endereco' => $enderecoProfessor,
                    'telefone' => $telefoneProfessor,
                ];

                if (!empty($novaSenha)) {
                    $dadosParaAtualizar['novaSenha'] = $novaSenha; // Inclui a nova senha se fornecida
                }

                if ($this->professorModel->updateProfessor($dadosParaAtualizar)) { 
                    redirect('index.php?controller=professor&action=list'); // Redireciona para a lista
                } else {
                    $errors[] = "Erro ao atualizar professor no banco de dados. Tente novamente.";
                    $professorData = $_POST; 
                    include __DIR__ . '/../views/auth/register_professor.php'; // Usa a view de formulário novamente
                }
            } else {
                $professorData = $_POST; 
                include __DIR__ . '/../views/auth/register_professor.php'; // Usa a view de formulário novamente
            }

        } else {
            displayErrorPage("Requisição inválida para atualização de professor.", 'index.php?controller=professor&action=list');
        }
    }


    public function delete($id) {
        if (isset($id)) {
            $this->professorModel->deleteProfessor($id);
            redirect('index.php?controller=professor&action=list');
        } else {
            displayErrorPage("ID do professor não especificado para exclusão.", 'index.php?controller=professor&action=list');
        }
    }

}