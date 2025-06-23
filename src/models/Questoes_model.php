<?php


require_once "config/conexao.php";

class QuestoesModel {
    private $db;

    public function __construct(PDO $conexao) {
        $this->db = $conexao;
        
    }
    
    public function insertQuestao(array $data) {
        $sql = "INSERT INTO questoes (codigoQuestao, descricao, tipo_prova, Prova_id_prova, Prova_Disciplina_id_disciplina, Prova_Disciplina_Professor_id_professor)
                VALUES (:codigo, :descricao, :tipo, :id_prova, :id_disciplina, :id_professor)";
        
        try {
            $stmt = $this->db->prepare($sql);
            
            
            $success = $stmt->execute([
                ':codigo' => $data['codigoQuestaoProva'], 
                ':descricao' => $data['descricao_questao'], 
                ':tipo' => $data['tipo_prova'], 
                ':id_prova' => $data['id_prova'], 
                ':id_disciplina' => $data['id_disciplina'], 
                ':id_professor' => $data['id_professor'] 
            ]);

            return $success; 

        } catch (PDOException $e) {
            error_log("Erro de PDO ao inserir questão: " . $e->getMessage() . " | SQLSTATE: " . $e->getCode());
            return false;
        }
     
    }

    public function updateQuestao(array $data) {
        $sql = "UPDATE questoes SET
                    codigoQuestao = :codigo,
                    descricao = :descricao,
                    tipo_prova = :tipo,
                    Prova_id_prova = :id_prova,
                    Prova_Disciplina_id_disciplina = :id_disciplina,
                    Prova_Disciplina_Professor_id_professor = :id_professor
                WHERE id_questao = :id_questao"; 
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':codigo' => $data['codigoQuestaoProva'],
            ':descricao' => $data['descricao_questao'],
            ':tipo' => $data['tipo_prova'],
            ':id_prova' => $data['id_prova'],
            ':id_disciplina' => $data['id_disciplina'],
            ':id_professor' => $data['id_professor'],
            ':id_questao' => $data['id_questao'] 
        ]);
    }

    public function deleteQuestao(int $id) {
        $sql = "DELETE FROM questoes WHERE id_questao = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getQuestaoById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM questoes WHERE id_questao = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllQuestoes() {
        $stmt = $this->db->query("
            SELECT
                q.id_questao,
                q.codigoQuestao,
                q.descricao,
                q.tipo_prova,
                p.codigoProva AS codigo_prova,
                d.nome AS nome_disciplina,
                prof.nome AS nome_professor
            FROM
                questoes q
            JOIN
                prova p ON q.Prova_id_prova = p.id_prova
            JOIN
                disciplina d ON q.Prova_Disciplina_id_disciplina = d.id_disciplina
            JOIN
                professor prof ON q.Prova_Disciplina_Professor_id_professor = prof.id_professor;
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDisciplinas() {
        return $this->db->query("SELECT * FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProfessores() {
        return $this->db->query("SELECT * FROM professor")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProvas() {
        
        return $this->db->query("SELECT * FROM prova")->fetchAll(PDO::FETCH_ASSOC);
    }


}