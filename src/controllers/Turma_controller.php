<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once __DIR__ . '/../models/Turma_model.php';

class Turma_controller {
    private $turmaModel;
    private $conexao; // Propriedade para armazenar a conexão

    /**
     * Construtor da classe Turma_controller.
     * Recebe a conexão com o banco de dados para passar ao modelo.
     * @param object $conexao Objeto de conexão com o banco de dados.
     */
    public function __construct($conexao) {
        $this->conexao = $conexao; // Armazena a conexão
        $this->turmaModel = new TurmaModel($this->conexao);
    }

    public function list() { // <--- **MUDANÇA AQUI: de listTurmas() para list()**
        $turmas = $this->turmaModel->getAllTurmas();
        include __DIR__ . '/../views/turma/List.php';
    }

    public function showCreateForm() {
        $turma = null; 
        include __DIR__ . '/../views/turma/Create_edit.php';
    }

    /**
     * Exibe o formulário para editar uma turma existente.
     * Corresponde à ação 'edit' (GET).
     * @param int $id ID da turma a ser editada.
     */
    public function showEditForm($id) {
        if (isset($id)) {
            $turma = $this->turmaModel->getTurmaById($id);
            if ($turma) {
                include __DIR__ . '/../views/turma/Create_edit.php';
            } else {
                displayErrorPage("Turma não encontrada para edição.", 'index.php?controller=turma&action=list');
            }
        } else {
            displayErrorPage("ID da turma não especificado para edição.", 'index.php?controller=turma&action=list');
        }
    }

    public function update($id) {
        if (isset($id)) {
            $turma = $this->turmaModel->getTurmaById($id);
            if ($turma) {
                include __DIR__ . '/../views/turma/Create_edit.php';
            } else {
                displayErrorPage("Turma não encontrada para edição.", 'index.php?controller=turma&action=list');
            }
        } else {
            displayErrorPage("ID da turma não especificado para edição.", 'index.php?controller=turma&action=list');
        }
    }

    public function create($id) {
        if (isset($id)) {
            $turma = $this->turmaModel->getTurmaById($id);
            if ($turma) {
                include __DIR__ . '/../views/turma/Create_edit.php';
            } else {
                displayErrorPage("Turma não encontrada para edição.", 'index.php?controller=turma&action=list');
            }
        } else {
            displayErrorPage("ID da turma não especificado para edição.", 'index.php?controller=turma&action=list');
        }
    }

    /**
     * Exclui uma turma.
     * Corresponde à ação 'delete' (GET).
     * @param int $id ID da turma a ser excluída.deleteTurma
     */
    public function delete($id) {
        if (isset($id)) {
            $this->turmaModel->deleteTurma($id);
            redirect('index.php?controller=turma&action=list');
        } else {
            displayErrorPage("ID da turma não especificado para exclusão.", 'index.php?controller=turma&action=list');
        }
    }

    /**
     * Processa a submissão do formulário para criar uma nova turma.
     * Corresponde à ação 'create' (POST).
     * @param array $postData Dados do formulário via POST.
     */
    public function handleCreatePost($postData) {
        if (isset($postData['codigoTurma']) && isset($postData['nomeTurma'])) {
            $this->turmaModel->createTurma($postData['codigoTurma'], $postData['nomeTurma']);
            redirect('index.php?controller=turma&action=list');
        } else {
            displayErrorPage("Dados incompletos para criar turma.", 'index.php?controller=turma&action=showCreateForm');
        }
    }

    /**
     * Processa a submissão do formulário para atualizar uma turma existente.
     * Corresponde à ação 'update' (POST).
     * @param array $postData Dados do formulário via POST.
     */
    public function handleUpdatePost($postData) {
        if (isset($postData['id_turma']) && isset($postData['codigoTurma']) && isset($postData['nomeTurma'])) {
            $this->turmaModel->updateTurma($postData['id_turma'], $postData['codigoTurma'], $postData['nomeTurma']);
            redirect('index.php?controller=turma&action=list');
        } else {
            displayErrorPage("Dados incompletos para atualizar turma.", 'index.php?controller=turma&action=list');
        }
    }

    /**
     * Método padrão para lidar com ações inválidas.
     */
    public function defaultAction() {
        displayErrorPage("Ação inválida para Turma.", 'index.php?controller=turma&action=list');
    }
}
?>