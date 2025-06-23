<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once __DIR__ . '/../models/Respostas_model.php';


class Respostas_controller {
    private $respostaModel;
    private $conexao;
    private $questoesModel;
    private $provaModel;
    private $disciplinaModel;
    private $professorModel;
    private $alunoModel;

    public function __construct($conexao) {
        $this->conexao = $conexao;
        $this->respostaModel = new RespostaModel($this->conexao);
        $this->questoesModel = new QuestoesModel($conexao); 
        $this->provaModel = new ProvaModel($conexao);       
        $this->disciplinaModel = new DisciplinaModel($conexao); 
        $this->professorModel = new ProfessorModel($conexao);   
        $this->alunoModel = new AlunoModel($conexao); 

        
    }

    
    public function list() {
        $respostas = $this->respostaModel->getAllRespostasDetailed();
        include __DIR__ . '/../views/respostas/List.php';
    }


    public function create($id) {
        if (isset($id)) {
            $resposta = $this->respostaModel->getRespostaById($id);
            if ($prova) {
                include __DIR__ . '/../views/resposta/Create_edit.php';
            } else {
                displayErrorPage("Resposta não encontrada para edição.", 'index.php?controller=resposta&action=list');
            }
        } else {
            displayErrorPage("ID da resposta não especificado para edição.", 'index.php?controller=resposta&action=list');
        }
    }


    public function showCreateForm() {
        $respostaData = null; 
        $professores = $this->respostaModel->getAllProfessores();
        $disciplinas = $this->respostaModel->getAllDisciplinas();
        $provas = $this->respostaModel->getAllProvas();
        $questoes = $this->respostaModel->getAllQuestoes();
        $alunos = $this->respostaModel->getAllAlunos();

        $professorsLookup = [];
        foreach ($professores as $professor) {
            $professorsLookup[$professor['id_professor']] = $professor['nome'];
        }

        $errors = []; 
        include __DIR__ . '/../views/respostas/Create_edit.php';
    }

    public function showEditForm($id) {
        if (!isset($id)) {
            displayErrorPage("ID da resposta não especificado para edição.", 'index.php?controller=respostas&action=list');
            return;
        }

        $respostaData = $this->respostaModel->getRespostaById($id);

        if (!$respostaData) {
            displayErrorPage("Resposta não encontrada para edição.", 'index.php?controller=respostas&action=list');
            return;
        }

        $professores = $this->professorModel->getAllProfessores(); // Use o modelo de Professor
        $disciplinas = $this->disciplinaModel->getAllDisciplinas(); // Use o modelo de Disciplina
        $provas = $this->provaModel->getAllProvas();             // Use o modelo de Prova
        $questoes = $this->questoesModel->getAllQuestoes();       // Use o modelo de Questoes
        $alunos = $this->alunoModel->getAllAlunos();             // Use o modelo de Aluno

        $professorsLookup = [];
        foreach ($professores as $professor) {
            $professorsLookup[$professor['id_professor']] = $professor['nome'];
        }

        $descricaoQuestaoAtual = $respostaData['descricao_questao_completa'] ?? 'N/A';
        $codigoProvaAtual = $respostaData['codigo_prova_completa'] ?? 'N/A';
        $nomeDisciplinaAtual = $respostaData['nome_disciplina_completa'] ?? 'N/A';
        $nomeProfessorAtual = $respostaData['nome_professor_completa'] ?? 'N/A';
        $nomeAlunoAtual = $respostaData['nome_aluno_completa'] ?? 'N/A';

        $errors = []; // Initialize errors for the view (se houver erros de validação na submissão anterior)

        include __DIR__ . '/../views/respostas/Create_edit.php';
    }

    public function handleCreatePost($postData) {
        $errors = $this->validateRespostaData($postData);

        if (!empty($errors)) {
            $respostaData = $postData; 
            $professores = $this->respostaModel->getAllProfessores();
            $disciplinas = $this->respostaModel->getAllDisciplinas();
            $provas = $this->respostaModel->getAllProvas();
            $questoes = $this->respostaModel->getAllQuestoes();
            $alunos = $this->respostaModel->getAllAlunos();

            $professorsLookup = [];
            foreach ($professores as $professor) {
                $professorsLookup[$professor['id_professor']] = $professor['nome'];
            }

            $descricaoQuestaoAtual = '';
            $codigoProvaAtual = '';
            $nomeDisciplinaAtual = '';
            $nomeProfessorAtual = '';
            $nomeAlunoAtual = '';

            include __DIR__ . '/../views/respostas/Create_edit.php';
            return;
        }

        try {
            if ($this->respostaModel->createResposta($postData)) {
                $this->redirect('index.php?controller=respostas&action=list&message=' . urlencode("Resposta cadastrada com sucesso!"));
            } else {
                $this->displayErrorPage("Erro ao cadastrar resposta.", 'index.php?controller=respostas&action=showCreateForm');
            }
        } catch (PDOException $e) {
            $erro = $e->getMessage();
            $errorMessage = "Erro ao inserir dados: " . htmlspecialchars($erro);

            if (strpos($erro, 'foreign key constraint fails') !== false) {
                $errorMessage .= "<br>Problema com vínculos de chave estrangeira. Verifique se a COMBINAÇÃO dos IDs de questão ({$postData['id_questao']}), prova ({$postData['id_prova']}), disciplina ({$postData['id_disciplina']}) e professor ({$postData['id_professor']}) EXISTE nas tabelas relacionadas.";
            }
            $this->displayErrorPage($errorMessage, 'index.php?controller=respostas&action=showCreateForm');
        }
    }

    public function handleUpdatePost($postData) {
        if (!isset($postData['id_respostas'])) {
            $this->displayErrorPage("ID da resposta não fornecido para atualização.", 'index.php?controller=respostas&action=list');
            return;
        }

        $errors = $this->validateRespostaData($postData);

        if (!empty($errors)) {
            $respostaData = $postData; 
            $professores = $this->respostaModel->getAllProfessores();
            $disciplinas = $this->respostaModel->getAllDisciplinas();
            $provas = $this->respostaModel->getAllProvas();
            $questoes = $this->respostaModel->getAllQuestoes();
            $alunos = $this->respostaModel->getAllAlunos();

            $professorsLookup = [];
            foreach ($professores as $professor) {
                $professorsLookup[$professor['id_professor']] = $professor['nome'];
            }

            $descricaoQuestaoAtual = $this->respostaModel->getQuestaoDescricaoById($respostaData['id_questao']);
            $codigoProvaAtual = $this->respostaModel->getProvaCodigoById($respostaData['id_prova']);
            $disciplinaInfo = $this->respostaModel->getDisciplinaInfoById($respostaData['id_disciplina']);
            $nomeDisciplinaAtual = $disciplinaInfo['nome'] ?? '';
            $nomeProfessorAtual = $this->respostaModel->getProfessorNomeById($respostaData['id_professor']);
            $nomeAlunoAtual = $this->respostaModel->getAlunoNomeById($respostaData['id_aluno']);

            include __DIR__ . '/../views/respostas/Create_edit.php';
            return;
        }

        try {
            if ($this->respostaModel->updateResposta($postData)) {
                $this->redirect('index.php?controller=respostas&action=list&message=' . urlencode("Resposta atualizada com sucesso!"));
            } else {
                $this->displayErrorPage("Erro ao atualizar resposta.", 'index.php?controller=respostas&action=showEditForm&id=' . $postData['id_respostas']);
            }
        } catch (PDOException $e) {
            $erro = $e->getMessage();
            $errorMessage = "Erro ao atualizar dados: " . htmlspecialchars($erro);
            $this->displayErrorPage($errorMessage, 'index.php?controller=respostas&action=showEditForm&id=' . $postData['id_respostas']);
        }
    }

    // Deletes a response
    public function delete($id) {
        if (!isset($id)) {
            $this->displayErrorPage("ID da resposta não especificado para exclusão.", 'index.php?controller=respostas&action=list');
            return;
        }

        try {
            if ($this->respostaModel->deleteResposta($id)) {
                $this->redirect('index.php?controller=respostas&action=list&message=' . urlencode("Resposta excluída com sucesso!"));
            } else {
                $this->displayErrorPage("Erro ao excluir resposta.", 'index.php?controller=respostas&action=list');
            }
        } catch (PDOException $e) {
            $errorMessage = "Erro ao excluir resposta: " . htmlspecialchars($e->getMessage());
            $this->displayErrorPage($errorMessage, 'index.php?controller=respostas&action=list');
        }
    }

    // Default action in case of an invalid action
    public function defaultAction() {
        $this->displayErrorPage("Ação inválida para Resposta.", 'index.php?controller=respostas&action=list');
    }

    private function validateRespostaData($data) {
        $errors = [];

        if (
            empty($data["codigoRespostas"]) ||
            empty($data["respostaDada"]) ||
            empty($data["id_questao"]) ||
            empty($data["id_prova"]) ||
            empty($data["id_disciplina"]) ||
            empty($data["id_professor"])
        ) {
            $errors[] = "Todos os campos devem ser preenchidos.";
        }

        if (strlen($data["codigoRespostas"]) < 3 || strlen($data["codigoRespostas"]) > 20) {
            $errors[] = "Erro: campo 'Código da Resposta' deve ter entre 3 e 20 caracteres.";
        }

        if (strlen($data["respostaDada"]) != 1 || !preg_match('/^[a-zA-Z]$/', $data["respostaDada"])) {
            $errors[] = "Erro: campo 'Resposta Dada' deve conter um único caractere alfabético.";
        }

        return $errors;
    }

    private function displayErrorPage($message, $redirectUrl = null) {
        echo "<h3>Erro:</h3><p>$message</p>";
        if ($redirectUrl) {
            echo "<p><a href='$redirectUrl'>Voltar</a></p>";
        }
        exit;
    }

    private function redirect($url) {
        header("Location: $url");
        exit;
    }

    
    public function update($id) {
        if (isset($id)) {
            $resposta = $this->Model->getRespostaById($id);
            if ($resposta) {
                include __DIR__ . '/../views/respostas/Create_edit.php';
            } else {
                displayErrorPage("Resposta não encontrada para edição.", 'index.php?controller=resposta&action=list');
            }
        } else {
            displayErrorPage("ID da resposta não especificado para edição.", 'index.php?controller=resposta&action=list');
        }
    }
}