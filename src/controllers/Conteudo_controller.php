<?php


error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../models/Conteudo_model.php';
require_once __DIR__ . '/../models/Disciplina_model.php';

if (!function_exists('displayErrorPage')) {
    function displayErrorPage($message, $redirectUrl) {
        echo "<h1>Erro: " . htmlspecialchars($message) . "</h1>";
        echo "<p><a href='" . htmlspecialchars($redirectUrl) . "'>Voltar</a></p>";
        exit;
    }
}
if (!function_exists('redirect')) {
    function redirect($url) {
        header("Location: " . $url);
        exit;
    }
}

class Conteudo_controller {
    private $conteudoModel;
    private $disciplinaModel;
    private $professorModel; 

    public function __construct($conexao) {
        $this->conteudoModel = new ConteudoModel($conexao);
        $this->disciplinaModel = new DisciplinaModel($conexao);
        $this->professorModel = new ProfessorModel($conexao);
    }

    public function list() {
        $conteudos = $this->conteudoModel->getAllConteudos();
        include __DIR__ . '/../views/conteudo/List.php';
    }

    public function showCreateForm() {
        $conteudoData = null; // Para formulário vazio
        
        $disciplinas = $this->disciplinaModel->getAllDisciplinas(); // Precisará retornar Professor_id_professor
        $professores = $this->professorModel->getAllProfessores();

        $professorsLookup = []; // Constroi o lookup para a view
        foreach ($professores as $professor) {
            $professorsLookup[$professor['id_professor']] = $professor['nome'];
        }

        $conteudoData = null; // Garante que $conteudoData está vazio para não entrar no $isUpdating
        $errors = [];

        include __DIR__ . '/../views/conteudo/Create_edit.php';
    
    }

    /**
     * Exibe o formulário de edição de conteúdo.
     * @param int $id ID do conteúdo a ser editado.
     */
    
    public function showEditForm($id) {
        if (!$id) {
                displayErrorPage("ID do conteúdo não especificado.", 'index.php?controller=conteudo&action=list');
                return;
        }

        $conteudoData = $this->conteudoModel->getConteudoById($id);
        if (!$conteudoData) {
            displayErrorPage("Conteúdo não encontrado.", 'index.php?controller=conteudo&action=list');
            return;
        }

        $errors = []; 

        $disciplinas = $this->disciplinaModel->getAllDisciplinas();

        $professores = $this->professorModel->getAllProfessores();

        $professorsLookup = [];
        foreach ($professores as $professor) {
            $professorsLookup[$professor['id_professor']] = $professor['nome'];
        }

        $nomeDisciplinaAtual = $conteudoData['nomeDisciplina'] ?? 'Nome da Disciplina Desconhecido';
        //var_dump($conteudoData);

        include __DIR__ . '/../views/conteudo/Create_edit.php';
        
    }

    /**
     * Lida com a requisição POST para criar um novo conteúdo.
     */

    public function create($id) {
        if (isset($id)) {
            $conteudo = $this->conteudoModel->getConteudoById($id);
            if ($conteudo) {
                include __DIR__ . '/../views/conteudo/Create_edit.php';
            } else {
                displayErrorPage("Conteudo não encontrado para edição.", 'index.php?controller=conteudo&action=list');
            }
        } else {
            displayErrorPage("ID da conteudo não especificado para edição.", 'index.php?controller=conteudo&action=list');
        }
    }


    public function handleCreatePost($postData) {
        $errors = $this->validateConteudoData($postData);
        if (!empty($errors)) {
            $conteudoData = $postData; 
            $disciplinas = $this->disciplinaModel->getAllDisciplinas();
            include __DIR__ . '/../views/conteudo/Create_edit.php';
            return;
        }

        if ($this->conteudoModel->createConteudo($postData)) {
            redirect('index.php?controller=conteudo&action=list&message=' . urlencode("Conteúdo criado com sucesso!"));
        } else {
            displayErrorPage("Erro ao criar conteúdo.", 'index.php?controller=conteudo&action=showCreateForm');
        }
    }

    public function update($id) {
        if (isset($id)) {
            $conteudo = $this->conteudoModel->getConteudoById($id);
            if ($conteudo) {
                include __DIR__ . '/../views/conteudo/Create_edit.php';
            } else {
                displayErrorPage("Conteudo não encontrada para edição.", 'index.php?controller=conteudo&action=list');
            }
        } else {
            displayErrorPage("ID da conteudo não especificado para edição.", 'index.php?controller=conteudo&action=list');
        }
    }

    /**
     * Lida com a requisição POST para atualizar um conteúdo existente.
     */
    public function handleUpdatePost($postData) {
        if (empty($postData['id_conteudo'])) {
            displayErrorPage("ID do conteúdo não fornecido.", 'index.php?controller=conteudo&action=list');
            return;
        }
        $errors = $this->validateConteudoData($postData);
        if (!empty($errors)) {
            $conteudoData = $postData; 
            $disciplinas = $this->disciplinaModel->getAllDisciplinas();
            include __DIR__ . '/../views/conteudo/Create_edit.php';
            return;
        }

        if ($this->conteudoModel->updateConteudo($postData)) {
            redirect('index.php?controller=conteudo&action=list&message=' . urlencode("Conteúdo atualizado com sucesso!"));
        } else {
            displayErrorPage("Erro ao atualizar conteúdo.", 'index.php?controller=conteudo&action=showEditForm&id=' . $postData['id_conteudo']);
        }
    }

    /**
     * Lida com a requisição para deletar um conteúdo.
     */
    public function delete($id) {
        if (!isset($id) || !is_numeric($id)) {
            displayErrorPage("ID do conteúdo não especificado.", 'index.php?controller=conteudo&action=list');
            return;
        }

        try {
            if ($this->conteudoModel->deleteConteudo($id)) {
                redirect('index.php?controller=conteudo&action=list&message=' . urlencode("Conteúdo excluído com sucesso!"));
            } else {
                displayErrorPage("Erro ao excluir conteúdo.", 'index.php?controller=conteudo&action=list');
            }
        } catch (PDOException $e) {
            displayErrorPage("Erro de banco de dados ao excluir conteúdo: " . $e->getMessage(), 'index.php?controller=conteudo&action=list');
        }
    }

    /**
     * Valida os dados do formulário de conteúdo.
     * @param array $data Dados do formulário.
     * @return array Array de erros.
     */
    private function validateConteudoData($data) {
        $errors = [];
        if (empty($data['codigoConteudo']) || strlen($data['codigoConteudo']) < 5 || strlen($data['codigoConteudo']) > 20) {
            $errors[] = "Erro: campo 'Código do Conteúdo' deve ter entre 5 e 20 caracteres.";
        }
        if (empty($data['titulo']) || strlen($data['titulo']) < 5 || strlen($data['titulo']) > 40) {
            $errors[] = "Erro: campo 'Titulo de Conteúdo' deve ter entre 5 e 40 caracteres.";
        }
        if (empty($data['descricao']) || strlen($data['descricao']) < 30 || strlen($data['descricao']) > 300) {
            $errors[] = "Erro: campo 'Descrição do Conteúdo' deve ter entre 30 e 300 caracteres.";
        }
        if (empty($data['data_postagem'])) {
            $errors[] = "A data de postagem é obrigatória.";
        }
        if (empty($data['professor']) || strlen($data['professor']) < 5 || strlen($data['professor']) > 20) {
             $errors[] = "Erro: campo 'Professor' deve ter entre 5 e 20 caracteres.";
        }
        if (empty($data['id_disciplina'])) { 
            $errors[] = "A disciplina é obrigatória.";
        }
        if (empty($data['tipo_conteudo']) || strlen($data['tipo_conteudo']) < 5 || strlen($data['tipo_conteudo']) > 20) {
            $errors[] = "Erro: campo 'Tipo de Conteúdo' deve ter entre 5 e 20 caracteres.";
        }
        return $errors;
    }
}