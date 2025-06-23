<?php

require_once "config/conexao.php";

class RespostaModel {
    private $db;

    public function __construct(PDO $conexao) {
        $this->db = $conexao;
    }

    public function getAllDisciplinas() {
        $stmt = $this->db->query("SELECT * FROM disciplina");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProfessores() {
        $stmt = $this->db->query("SELECT * FROM professor");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProvas() {
        $stmt = $this->db->query("SELECT * FROM prova");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllQuestoes() {
        $stmt = $this->db->query("SELECT * FROM questoes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAlunos() {
        $stmt = $this->db->query("SELECT * FROM aluno");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRespostaById($id) {
        $query = "
            SELECT 
                r.*, -- Seleciona todas as colunas da tabela respostas (inclui todas as FKs como Questoes_id_questao, Aluno_id_aluno, etc.)
                q.descricao AS descricao_questao_completa, -- ALIAS para a descrição da questão
                p.codigoProva AS codigo_prova_completa,   -- ALIAS para o código da prova
                d.nome AS nome_disciplina_completa,      -- ALIAS para o nome da disciplina
                prof.nome AS nome_professor_completa,    -- ALIAS para o nome do professor
                a.nome AS nome_aluno_completa            -- ALIAS para o nome do aluno
            FROM 
                respostas r
            JOIN questoes q ON r.Questoes_id_questao = q.id_questao
            JOIN prova p ON r.Questoes_Prova_id_prova = p.id_prova
            JOIN disciplina d ON r.Questoes_Prova_Disciplina_id_disciplina = d.id_disciplina
            JOIN professor prof ON r.Questoes_Prova_Disciplina_Professor_id_professor = prof.id_professor
            JOIN aluno a ON r.Aluno_id_aluno = a.id_aluno
            WHERE 
                r.id_respostas = :id_respostas"; // Corrigido de ':id' para ':id_respostas' e também na query
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id_respostas' => $id]); // Corrigido de ':id' para ':id_respostas'
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // ... (resto do método) ...
        return $result;
    }

    public function getQuestaoDescricaoById($id) {
        $stmt = $this->db->prepare("SELECT descricao FROM questoes WHERE id_questao = :id");
        $stmt->execute([':id' => $id]);
        $questao = $stmt->fetch(PDO::FETCH_ASSOC);
        return $questao['descricao'] ?? '';
    }

    public function getProvaCodigoById($id) {
        $stmt = $this->db->prepare("SELECT codigoProva FROM prova WHERE id_prova = :id");
        $stmt->execute([':id' => $id]);
        $prova = $stmt->fetch(PDO::FETCH_ASSOC);
        return $prova['codigoProva'] ?? '';
    }

    public function getDisciplinaInfoById($id) {
        $stmt = $this->db->prepare("SELECT nome, Professor_id_professor FROM disciplina WHERE id_disciplina = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProfessorNomeById($id) {
        $stmt = $this->db->prepare("SELECT nome FROM professor WHERE id_professor = :id");
        $stmt->execute([':id' => $id]);
        $professor = $stmt->fetch(PDO::FETCH_ASSOC);
        return $professor['nome'] ?? '';
    }

    public function getAlunoNomeById($id) {
        $stmt = $this->db->prepare("SELECT nome FROM aluno WHERE id_aluno = :id");
        $stmt->execute([':id' => $id]);
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
        return $aluno['nome'] ?? '';
    }

    public function createResposta($data) {
        $sql = "INSERT INTO respostas (codigoRespostas, respostaDada, acertou, nota, Questoes_id_questao, Questoes_Prova_id_prova, Questoes_Prova_Disciplina_id_disciplina, Questoes_Prova_Disciplina_Professor_id_professor, Aluno_id_aluno)
                VALUES (:codigoRespostas, :respostaDada, :acertou, :nota, :id_questao, :id_prova, :id_disciplina, :id_professor, :id_aluno)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':codigoRespostas' => $data['codigoRespostas'],
            ':respostaDada' => $data['respostaDada'],
            ':acertou' => $data['acertou'],
            ':nota' => $data['nota'],
            ':id_questao' => $data['id_questao'],
            ':id_prova' => $data['id_prova'],
            ':id_disciplina' => $data['id_disciplina'],
            ':id_professor' => $data['id_professor'],
            ':id_aluno' => $data['id_aluno']
        ]);
    }

    public function updateResposta($data) {
        $sql = "UPDATE respostas SET
                    codigoRespostas = :codigoRespostas,
                    respostaDada = :respostaDada,
                    acertou = :acertou,
                    nota = :nota,
                    Questoes_id_questao = :id_questao,
                    Questoes_Prova_id_prova = :id_prova,
                    Questoes_Prova_Disciplina_id_disciplina = :id_disciplina,
                    Questoes_Prova_Disciplina_Professor_id_professor = :id_professor,
                    Aluno_id_aluno = :id_aluno
                WHERE id_respostas = :id_respostas";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':codigoRespostas' => $data['codigoRespostas'],
            ':respostaDada' => $data['respostaDada'],
            ':acertou' => $data['acertou'],
            ':nota' => $data['nota'],
            ':id_questao' => $data['id_questao'],
            ':id_prova' => $data['id_prova'],
            ':id_disciplina' => $data['id_disciplina'],
            ':id_professor' => $data['id_professor'],
            ':id_aluno' => $data['id_aluno'],
            ':id_respostas' => $data['id_respostas']
        ]);
    }

    public function deleteResposta($id) {
        $stmt = $this->db->prepare("DELETE FROM respostas WHERE id_respostas = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getAllRespostasDetailed() {
        $stmt = $this->db->query("
            SELECT
                a.nome AS nome_aluno,
                r.id_respostas,
                r.codigoRespostas,
                r.respostaDada,
                r.acertou,
                r.nota,
                q.descricao AS descricao_questao,
                p.codigoProva AS codigo_prova,
                d.nome AS nome_disciplina,
                prof.nome AS nome_professor
            FROM respostas r
            JOIN aluno a ON r.Aluno_id_aluno = a.id_aluno
            JOIN questoes q ON r.Questoes_id_questao = q.id_questao
            JOIN prova p ON r.Questoes_Prova_id_prova = p.id_prova
            JOIN disciplina d ON r.Questoes_Prova_Disciplina_id_disciplina = d.id_disciplina
            JOIN professor prof ON r.Questoes_Prova_Disciplina_Professor_id_professor = prof.id_professor
            ORDER BY a.nome;
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}