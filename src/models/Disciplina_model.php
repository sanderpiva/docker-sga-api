<?php


require_once "config/conexao.php";

class DisciplinaModel {
    private $db;

    public function __construct($conexao) {
        $this->db = $conexao;
    }

    public function getAllDisciplinas() {
        $stmt = $this->db->query("
            SELECT
                d.id_disciplina,
                d.codigoDisciplina,
                d.nome,
                d.carga_horaria,
                d.professor AS professor_digitado,
                d.descricao,
                d.semestre_periodo,
                d.Professor_id_professor,
                d.Turma_id_turma,
                p.nome AS nome_professor,
                t.nomeTurma AS nome_turma_associada
            FROM
                disciplina d
            JOIN
                professor p ON d.Professor_id_professor = p.id_professor
            LEFT JOIN
                turma t ON d.Turma_id_turma = t.id_turma;
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDisciplinaById($id) {
        $stmt = $this->db->prepare("
            SELECT
                d.*,
                p.registroProfessor,
                t.nomeTurma
            FROM
                disciplina d
            LEFT JOIN
                professor p ON d.Professor_id_professor = p.id_professor
            LEFT JOIN
                turma t ON d.Turma_id_turma = t.id_turma
            WHERE id_disciplina = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createDisciplina($data) {
        $sql = "INSERT INTO disciplina (codigoDisciplina, nome, carga_horaria, professor, descricao, semestre_periodo, Professor_id_professor, Turma_id_turma)
                VALUES (:codigoDisciplina, :nomeDisciplina, :carga_horaria, :professor, :descricaoDisciplina, :semestre_periodo, :id_professor, :id_turma)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':codigoDisciplina' => $data['codigoDisciplina'],
            ':nomeDisciplina' => $data['nomeDisciplina'],
            ':carga_horaria' => $data['carga_horaria'],
            ':professor' => $data['professor'],
            ':descricaoDisciplina' => $data['descricaoDisciplina'],
            ':semestre_periodo' => $data['semestre_periodo'],
            ':id_professor' => $data['Professor_id_professor'],
            ':id_turma' => $data['Turma_id_turma']
        ]);
    }

    public function updateDisciplina($data) {
        $sql = "UPDATE disciplina SET
                    codigoDisciplina = :codigoDisciplina,
                    nome = :nomeDisciplina,
                    carga_horaria = :carga_horaria,
                    professor = :professor,
                    descricao = :descricaoDisciplina,
                    semestre_periodo = :semestre_periodo,
                    Professor_id_professor = :Professor_id_professor,
                    Turma_id_turma = :Turma_id_turma
                WHERE id_disciplina = :id_disciplina";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':codigoDisciplina' => $data['codigoDisciplina'],
            ':nomeDisciplina' => $data['nomeDisciplina'],
            ':carga_horaria' => $data['carga_horaria'],
            ':professor' => $data['professor'],
            ':descricaoDisciplina' => $data['descricaoDisciplina'],
            ':semestre_periodo' => $data['semestre_periodo'],
            ':Professor_id_professor' => $data['Professor_id_professor'],
            ':Turma_id_turma' => $data['Turma_id_turma'],
            ':id_disciplina' => $data['id_disciplina']
        ]);
    }

    public function deleteDisciplina($id) {
        $stmt = $this->db->prepare("DELETE FROM disciplina WHERE id_disciplina = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getAllProfessors() {
        $stmt = $this->db->query("SELECT id_professor, registroProfessor, nome FROM professor");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTurmas() {
        $stmt = $this->db->query("SELECT id_turma, nomeTurma FROM turma");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}