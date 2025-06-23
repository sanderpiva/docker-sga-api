<?php

        
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once __DIR__ . '/../models/Matricula_model.php';


class Matricula_controller {
    private $matriculaModel;
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
        $this->matriculaModel = new MatriculaModel($this->conexao);
        
    }

    /**
     * Exibe uma lista de todas as matrículas.
     */
    public function list() {
        $matriculas = $this->matriculaModel->getAllMatriculas();
        include __DIR__ . '/../views/matricula/List.php';
    }

    /**
     * Exibe o formulário para criação de uma nova matrícula.
     */
    public function showCreateForm() {
        $alunos = $this->matriculaModel->getAllAlunos();
        $disciplinas = $this->matriculaModel->getAllDisciplinas();
        $professores = $this->matriculaModel->getAllProfessores();

        $professorsLookup = [];
        foreach ($professores as $professor) {
            $professorsLookup[$professor['id_professor']] = $professor['nome'];
        }
        
        $matricula = null; 
        include __DIR__ . '/../views/matricula/Create_edit.php';
    }

    /**
     * Exibe o formulário para edição de uma matrícula existente.
     * @param int $alunoId O ID do aluno.
     * @param int $disciplinaId O ID da disciplina.
     */
    public function showEditForm($alunoId, $disciplinaId) {
        if ($alunoId && $disciplinaId) {
            $matricula = $this->matriculaModel->getMatriculaByIds($alunoId, $disciplinaId);
            if ($matricula) {
                $alunos = $this->matriculaModel->getAllAlunos();
                $disciplinas = $this->matriculaModel->getAllDisciplinas();
                $professores = $this->matriculaModel->getAllProfessores();

                $professorsLookup = [];
                foreach ($professores as $professor) {
                    $professorsLookup[$professor['id_professor']] = $professor['nome'];
                }
                
                include __DIR__ . '/../views/matricula/Create_edit.php';
            } else {
                redirect('index.php?controller=matricula&action=list&error=' . urlencode("Matrícula não encontrada para edição."));
            }
        } else {
            redirect('index.php?controller=matricula&action=list&error=' . urlencode("IDs de aluno ou disciplina não especificados para edição."));
        }
    }
    
    /**
     * Função 'create' adaptada para roteamento.
     * Se for POST, chama handleCreatePost. Se for GET, exibe o formulário.
     * @param mixed $param Pode ser os dados POST ou null.
     */
    public function create($param = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleCreatePost($param);
        } else {
            $this->showCreateForm();
        }
    }

    /**
     * MÉTODO RESTAURADO: Este método serve como um ponto de entrada para o roteador.
     * Ele chama 'handleUpdatePost' para executar a lógica real de atualização.
     * @param array $postData Os dados recebidos via POST do formulário.
     */
    public function update($postData) {
        // Simplesmente chama a função que contém a lógica real de atualização.
        // O index.php espera por este método.
        error_log("DEBUG: update - Método update chamado. Redirecionando para handleUpdatePost.");
        $this->handleUpdatePost($postData);
    }

    /**
     * Lida com a requisição POST para ATUALIZAR uma matrícula existente.
     * Contém a lógica completa de atualização.
     * @param array $postData Os dados recebidos via POST do formulário.
     */
    public function handleUpdatePost($postData) {
        error_log("DEBUG: handleUpdatePost - Início. PostData: " . print_r($postData, true));

        $originalAlunoId = filter_var($postData['original_aluno_id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        $originalDisciplinaId = filter_var($postData['original_disciplina_id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        $novoAlunoId = filter_var($postData['aluno_id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        $novaDisciplinaId = filter_var($postData['disciplina_id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
        
        error_log("DEBUG: handleUpdatePost - IDs filtrados: Original Aluno=$originalAlunoId, Original Disciplina=$originalDisciplinaId, Novo Aluno=$novoAlunoId, Nova Disciplina=$novaDisciplinaId");

        if (!$originalAlunoId || !$originalDisciplinaId || !$novoAlunoId || !$novaDisciplinaId) {
            error_log("DEBUG: handleUpdatePost - Dados de atualização inválidos ou incompletos. Redirecionando.");
            redirect('index.php?controller=matricula&action=list&error=' . urlencode("Dados de atualização inválidos ou incompletos."));
            return;
        }

        error_log("DEBUG: handleUpdatePost - Verificando se a matrícula já existe para a nova combinação.");
        if ($this->matriculaModel->matriculaExists($novoAlunoId, $novaDisciplinaId, $originalAlunoId, $originalDisciplinaId)) {
            error_log("DEBUG: handleUpdatePost - Matrícula para nova combinação já existe. Redirecionando.");
            redirect('index.php?controller=matricula&action=showEditForm&aluno_id=' . urlencode($originalAlunoId) . '&disciplina_id=' . urlencode($originalDisciplinaId) . '&error=' . urlencode("Não foi possível atualizar a matrícula. Esta combinação Aluno/Disciplina já existe."));
            return;
        }
        error_log("DEBUG: handleUpdatePost - Matrícula para nova combinação não existe. Prosseguindo com a atualização.");

        if ($this->matriculaModel->updateMatricula($originalAlunoId, $originalDisciplinaId, $novoAlunoId, $novaDisciplinaId)) {
            error_log("DEBUG: handleUpdatePost - Matrícula atualizada com sucesso. Redirecionando.");
            redirect('index.php?controller=matricula&action=list&message=' . urlencode("Matrícula atualizada com sucesso!"));
        } else {
            error_log("DEBUG: handleUpdatePost - Erro ao atualizar matrícula no modelo. Redirecionando.");
            redirect('index.php?controller=matricula&action=showEditForm&aluno_id=' . urlencode($originalAlunoId) . '&disciplina_id=' . urlencode($originalDisciplinaId) . '&error=' . urlencode("Erro ao atualizar a matrícula. Nenhuma alteração realizada ou dados inválidos."));
        }
    }

    /**
     * Lida com a requisição de exclusão de uma matrícula.
     * Esta função é mantida exatamente como você solicitou.
     * @param int $id O ID do aluno da matrícula a ser excluída.
     */
    public function delete($id) {
        error_log("DEBUG: delete - Início. ID: " . $id);
        if (isset($id)) {
            $this->matriculaModel->deleteMatricula($id);
            error_log("DEBUG: delete - Matrícula deletada. Redirecionando.");
            redirect('index.php?controller=matricula&action=list');
        } else {
            error_log("DEBUG: delete - ID da matrícula não especificado para exclusão. Redirecionando.");
            displayErrorPage("ID da matrícula não especificado para exclusão.", 'index.php?controller=matricula&action=list');
        }
    }

    /**
     * Lida com a submissão POST para criar uma nova matrícula.
     * Esta função é mantida exatamente como você solicitou.
     * @param array $postData Os dados POST.
     */
    public function handleCreatePost($postData) {
        error_log("DEBUG: handleCreatePost - Início. PostData: " . print_r($postData, true));
        if (isset($postData['aluno_id']) && isset($postData['disciplina_id'])) {
            if ($this->matriculaModel->createMatricula($postData['aluno_id'], $postData['disciplina_id'])) {
                error_log("DEBUG: handleCreatePost - Matrícula criada com sucesso. Redirecionando.");
                redirect('index.php?controller=matricula&action=list');
            } else {
                error_log("DEBUG: handleCreatePost - Erro ao criar matrícula no modelo. Redirecionando.");
                displayErrorPage("Dados incompletos para criar matrícula.", 'index.php?controller=matricula&action=showCreateForm');
            }
        } else {
            error_log("DEBUG: handleCreatePost - Dados incompletos para criar matrícula. Redirecionando.");
            displayErrorPage("Dados incompletos para criar matrícula.", 'index.php?controller=matricula&action=showCreateForm');
        }
    }
    
    /**
     * Ação padrão para requisições inválidas.
     */
    public function defaultAction() {
        error_log("DEBUG: defaultAction - Ação inválida detectada. Redirecionando para a lista.");
        redirect('index.php?controller=matricula&action=list&error=' . urlencode("Ação inválida para Matrícula."));
    }
}
