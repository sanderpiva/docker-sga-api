<?php


error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../models/Prova_model.php';
require_once __DIR__ . '/../models/Disciplina_model.php'; 
require_once __DIR__ . '/../models/Professor_model.php';  

class Prova_controller {
    private $provaModel;
    private $disciplinaModel;
    private $professorModel;
    
    public function __construct($conexao) {
        $this->provaModel = new ProvaModel($conexao);
        $this->disciplinaModel = new DisciplinaModel($conexao); 
        $this->professorModel = new ProfessorModel($conexao);   
    }

    public function list() {
    
        $provas = $this->provaModel->getAllProvas();
        include __DIR__ . '/../views/prova/List.php';
    }

    public function showCreateForm() {
    
        $provaData = null;
        $errors = [];
        $disciplinas = $this->disciplinaModel->getAllDisciplinas();
        $professores = $this->professorModel->getAllProfessores();
        include __DIR__ . '/../views/prova/Create_edit.php';
    }

    public function showEditForm($id) {
        if (!$id) {
            displayErrorPage("ID da prova não especificado.", 'index.php?controller=prova&action=list');
            return;
        }
        $provaData = $this->provaModel->getProvaById($id);
        if (!$provaData) {
            displayErrorPage("Prova não encontrada.", 'index.php?controller=prova&action=list');
            return;
        }
        $errors = [];
        $disciplinas = $this->disciplinaModel->getAllDisciplinas();
        $professores = $this->professorModel->getAllProfessores();
        
        include __DIR__ . '/../views/prova/Create_edit.php';
    }

    public function create($id) {
        if (isset($id)) {
            $prova = $this->provaModel->getProvaById($id);
            if ($prova) {
                include __DIR__ . '/../views/prova/Create_edit.php';
            } else {
                displayErrorPage("Prova não encontrada para edição.", 'index.php?controller=prova&action=list');
            }
        } else {
            displayErrorPage("ID da prova não especificado para edição.", 'index.php?controller=prova&action=list');
        }
    }

    public function handleCreatePost($postData) {
        $errors = $this->validateProvaData($postData);
        if (!empty($errors)) {
             $provaData = $postData;
            $disciplinas = $this->disciplinaModel->getAllDisciplinas();
            $professores = $this->professorModel->getAllProfessores();
            include __DIR__ . '/../views/prova/Create_edit.php';
            return;
        }
        if ($this->provaModel->createProva($postData)) {
            redirect('index.php?controller=prova&action=list&message=' . urlencode("Prova criada com sucesso!"));
        } else {
            displayErrorPage("Erro ao criar prova.", 'index.php?controller=prova&action=showCreateForm');
        }
    }

    public function handleUpdatePost($postData) {
        if (empty($postData['id_prova'])) {
            displayErrorPage("ID da prova não fornecido.", 'index.php?controller=prova&action=list');
            return;
        }
        $errors = $this->validateProvaData($postData);
        if (!empty($errors)) {
            $provaData = $postData;
            $disciplinas = $this->disciplinaModel->getAllDisciplinas();
            $professores = $this->professorModel->getAllProfessores();
            include __DIR__ . '/../views/prova/Create_edit.php';
            return;
        }
        if ($this->provaModel->updateProva($postData)) {
            redirect('index.php?controller=prova&action=list&message=' . urlencode("Prova atualizada com sucesso!"));
        } else {
            displayErrorPage("Erro ao atualizar prova.", 'index.php?controller=prova&action=showEditForm&id=' . $postData['id_prova']);
        }
    }

    public function delete($id) {
        
        if (!isset($id) || !is_numeric($id)) {
            displayErrorPage("ID da prova não especificado.", 'index.php?controller=prova&action=list');
            return;
        }

        try {
            if ($this->provaModel->deleteProva($id)) {
            redirect('index.php?controller=prova&action=list&message=' . urlencode("Prova excluída com sucesso!"));
            } else {
            displayErrorPage("Erro ao excluir prova.", 'index.php?controller=prova&action=list');
            }
        } catch (PDOException $e) {
            displayErrorPage("Erro de banco de dados ao excluir questão: " . $e->getMessage(), 'index.php?controller=prova&action=list');
        }
    }


    private function validateProvaData($data) {
        $erros = "";
        

        if (
            empty($_POST["codigoProva"]) ||
            empty($_POST["tipo_prova"]) ||
            empty($_POST["disciplina"]) ||
            empty($_POST["conteudo"]) ||
            empty($_POST["data_prova"]) ||
            empty($_POST["nome_professor"]) ||
            empty($_POST["id_disciplina"]) ||
            empty($_POST["id_professor"]) 
            
        ) {
            $erros .= "Todos os campos devem ser preenchidos.<br>";
        }

        if (strlen($_POST["codigoProva"]) < 3 || strlen($_POST["codigoProva"]) > 20) {
            $erros .= "Erro: campo 'Código da Prova' deve ter entre 3 e 20 caracteres.<br>";
        }

        if (strlen($_POST["tipo_prova"]) < 3 || strlen($_POST["tipo_prova"]) > 30) {
            $erros .= "Erro: campo 'Tipo de Prova' deve ter entre 3 e 30 caracteres.<br>";
        }

        if (strlen($_POST["disciplina"]) < 3 || strlen($_POST["disciplina"]) > 20) {
            $erros .= "Erro: campo 'Disciplina' deve ter entre 3 e 20 caracteres.<br>";
        }

        if (strlen($_POST["conteudo"]) < 30 || strlen($_POST["conteudo"]) > 300) {
            $erros .= "Erro: campo 'Conteúdo da Prova' deve ter entre 30 e 300 caracteres.<br>";
        }


        if (strlen($_POST["nome_professor"]) < 5 || strlen($_POST["nome_professor"]) > 20) {
            $erros .= "Erro: campo 'Professor' deve ter entre 5 e 20 caracteres.<br>";
        }


    }

    public function update($id) {
        
        if (isset($id)) {
            $prova = $this->provaModel->getProvaById($id);
            if ($prova) {
                include __DIR__ . '/../views/prova/Create_edit.php';
            } else {
                displayErrorPage("Prova não encontrada para edição.", 'index.php?controller=prova&action=list');
            }
        } else {
            displayErrorPage("ID da prova não especificado para edição.", 'index.php?controller=prova&action=list');
        }
    }  
}
?>
