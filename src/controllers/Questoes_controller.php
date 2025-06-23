<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once __DIR__ . '/../models/Questoes_model.php';

class Questoes_controller {
    private $questoesModel;
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
        $this->questoesModel = new QuestoesModel($this->conexao);

    }

    public function list() {
        //handleLogout(); // Handle logout request if present
        $questoes = $this->questoesModel->getAllQuestoes();
        include __DIR__ . '/../views/questoes/List.php';
    }

    public function showCreateForm() {
        
        $questaoProvaData = null; 
        $professores = $this->questoesModel->getAllProfessores();
        $disciplinas = $this->questoesModel->getAllDisciplinas();
        $provas = $this->questoesModel->getAllProvas();
        $errors = []; 

        $professorsLookup = [];
        foreach ($professores as $professor) {
            $professorsLookup[$professor['id_professor']] = $professor['nome'];
        }

        include __DIR__ . '/../views/questoes/Create_edit.php';
    }

    public function showEditForm($id) {
        
        if (!isset($id) || !is_numeric($id)) {
            displayErrorPage("ID da questão da prova não especificado ou inválido para edição.", 'index.php?controller=questoes&action=list');
            return;
        }

        $questaoProvaData = $this->questoesModel->getQuestaoById($id);
        if (!$questaoProvaData) {
            displayErrorPage("Questão da prova não encontrada para edição.", 'index.php?controller=questoes&action=list');
            return;
        }

        $professores = $this->questoesModel->getAllProfessores();
        $disciplinas = $this->questoesModel->getAllDisciplinas();
        $provas = $this->questoesModel->getAllProvas();
        $errors = []; 

        $professorsLookup = [];
        foreach ($professores as $professor) {
            $professorsLookup[$professor['id_professor']] = $professor['nome'];
        }

        $nomeDisciplinaAtual = '';
        foreach ($disciplinas as $disciplina) {
            if ($disciplina['id_disciplina'] == ($questaoProvaData['Prova_Disciplina_id_disciplina'] ?? null)) {
                $nomeDisciplinaAtual = $disciplina['nome'];
                break;
            }
        }
        $nomeProfessorAtual = '';
        foreach ($professores as $professor) {
            if ($professor['id_professor'] == ($questaoProvaData['Prova_Disciplina_Professor_id_professor'] ?? null)) {
                $nomeProfessorAtual = $professor['nome'];
                break;
            }
        }
        $nomeProvaAtual = '';
        foreach ($provas as $prova) {
            if ($prova['id_prova'] == ($questaoProvaData['Prova_id_prova'] ?? null)) {
                $nomeProvaAtual = $prova['codigoProva'];
                break;
            }
        }

        include __DIR__ . '/../views/questoes/Create_edit.php';
    }

    public function update($id) {
        if (isset($id)) {
            $questoes = $this->questoesModel->getQuestoesById($id);
            if ($questoes) {
                include __DIR__ . '/../views/questoes/Create_edit.php';
            } else {
                displayErrorPage("Questão não encontrada para edição.", 'index.php?controller=questoes&action=list');
            }
        } else {
            displayErrorPage("ID da questão não especificado para edição.", 'index.php?controller=questoes&action=list');
        }
    }

    public function handleUpdatePost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            displayErrorPage("Requisição inválida.", 'index.php?controller=questoes&action=list');
            return;
        }

        $postData = $_POST;
        $errors = $this->validateQuestaoProvaData($postData);

        if (!empty($errors)) {
            $questaoProvaData = $postData; // Pass submitted data back to form for sticky fields
            $professores = $this->questoesModel->getAllProfessores();
            $disciplinas = $this->questoesModel->getAllDisciplinas();
            $provas = $this->questoesModel->getAllProvas();

            $professorsLookup = [];
            foreach ($professores as $professor) {
                $professorsLookup[$professor['id_professor']] = $professor['nome'];
            }

            $nomeDisciplinaAtual = '';
            foreach ($disciplinas as $disciplina) {
                if ($disciplina['id_disciplina'] == ($questaoProvaData['id_disciplina'] ?? null)) {
                    $nomeDisciplinaAtual = $disciplina['nome'];
                    break;
                }
            }
            $nomeProfessorAtual = '';
            foreach ($professores as $professor) {
                if ($professor['id_professor'] == ($questaoProvaData['id_professor'] ?? null)) {
                    $nomeProfessorAtual = $professor['nome'];
                    break;
                }
            }
            $nomeProvaAtual = '';
            foreach ($provas as $prova) {
                if ($prova['id_prova'] == ($questaoProvaData['id_prova'] ?? null)) {
                    $nomeProvaAtual = $prova['codigoProva'];
                    break;
                }
            }

            include __DIR__ . '/../views/questoes/Create_edit.php';
            return;
        }

        try {
            if (isset($postData['id_questao']) && !empty($postData['id_questao'])) {
                if ($this->questoesModel->updateQuestao($postData)) {
                    redirect('index.php?controller=questoes&action=list&message=' . urlencode("Questão atualizada com sucesso!"));
                } else {
                    displayErrorPage("Erro ao atualizar questão.", 'index.php?controller=questoes&action=showEditForm&id=' . $postData['id_questao']);
                }
            } else {
                if ($this->questoesModel->insertQuestao($postData)) {
                    redirect('index.php?controller=questoes&action=list&message=' . urlencode("Questão cadastrada com sucesso!"));
                } else {
                    displayErrorPage("Erro ao cadastrar questão.", 'index.php?controller=questoes&action=showCreateForm');
                }
            }
        } catch (PDOException $e) {
        
            displayErrorPage("Erro de banco de dados: " . $e->getMessage(), 'index.php?controller=questoes&action=list');
        }
    }

    public function delete($id) {
        
        if (!isset($id) || !is_numeric($id)) {
            displayErrorPage("ID da questão da prova não especificado ou inválido para exclusão.", 'index.php?controller=questoes&action=list');
            return;
        }

        try {
            if ($this->questoesModel->deleteQuestao($id)) {
                redirect('index.php?controller=questoes&action=list&message=' . urlencode("Questão excluída com sucesso!"));
            } else {
                displayErrorPage("Erro ao excluir questão.", 'index.php?controller=questoes&action=list');
            }
        } catch (PDOException $e) {
            displayErrorPage("Erro de banco de dados ao excluir questão: " . $e->getMessage(), 'index.php?controller=questoes&action=list');
        }
    }

    public function defaultAction() {
        displayErrorPage("Ação inválida para Questões de Prova.", 'index.php?controller=questoes&action=list');
    }

    private function validateQuestaoProvaData($data) {
        $errors = [];

        if (
            empty($_POST["codigoQuestaoProva"]) ||
            empty($_POST["descricao_questao"]) ||
            empty($_POST["tipo_prova"])||
            empty($_POST["id_disciplina"]) ||
            empty($_POST["id_prova"]) ||
            empty($_POST["id_professor"])
        ) {
            $erros .= "Todos os campos devem ser preenchidos.<br>";
        }

        if (strlen($_POST["codigoQuestaoProva"]) < 3 || strlen($_POST["codigoQuestaoProva"]) > 20) {
            $erros .= "Erro: campo 'Código da Questão' deve ter entre 3 e 20 caracteres.<br>";
        }

        if (strlen($_POST["descricao_questao"]) < 10 || strlen($_POST["descricao_questao"]) > 300) {
            $erros .= "Erro: campo 'Descrição da Questão' deve ter entre 10 e 300 caracteres.<br>";
        }

        if (strlen($_POST["tipo_prova"]) < 5 || strlen($_POST["tipo_prova"]) > 20) {
            $erros .= "Erro: campo 'Tipo de Prova' deve ter entre 5 e 20 caracteres.<br>";
        }

        return $errors;
    }

    public function create($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Processa os dados do formulário e cria uma nova questão
          $this->handleCreatePost($_POST);
        } else {
            // Exibe o formulário de criação/edição
            if ($id) {
                $questao = $this->questoesModel->getQuestoesById($id);
                if ($questao) {
                    include __DIR__ . '/../views/questoes/Create_edit.php';
                } else {
                    displayErrorPage("Questão não encontrada para edição.", 'index.php?controller=questoes&action=list');
                }
            } else {
                displayErrorPage("ID da questão não especificado para edição.", 'index.php?controller=questoes&action=list');
            }
        }
    }

    public function handleCreatePost($postData) {
    
        $codigoQuestao = filter_var($postData['codigoQuestaoProva'] ?? null, FILTER_SANITIZE_STRING);
        $descricao = filter_var($postData['descricao_questao'] ?? null, FILTER_SANITIZE_STRING);
        $tipoProva = filter_var($postData['tipo_prova'] ?? null, FILTER_SANITIZE_STRING);
        $provaId = filter_var($postData['id_prova'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        $disciplinaId = filter_var($postData['id_disciplina'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        $professorId = filter_var($postData['id_professor'] ?? null, FILTER_SANITIZE_NUMBER_INT);

        if (!$codigoQuestao || !$descricao || !$tipoProva || !$provaId || !$disciplinaId || !$professorId) {
            displayErrorPage("Dados incompletos para criar questão.", 'index.php?controller=questoes&action=showCreateForm');
        }

        $data = [
            'codigoQuestaoProva' => $codigoQuestao,
            'descricao_questao' => $descricao,
            'tipo_prova' => $tipoProva,
            'id_prova' => $provaId,
            'id_disciplina' => $disciplinaId,
            'id_professor' => $professorId
        ];
        
    
        if ($this->questoesModel->insertQuestao($data)) {
            redirect('index.php?controller=questoes&action=list&message=' . urlencode("Questão criada com sucesso!"));
        } else {
            displayErrorPage("Erro ao criar questão. Tente novamente.", 'index.php?controller=questoes&action=showCreateForm');
        }
    }
}