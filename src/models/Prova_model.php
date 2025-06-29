<?php


class ProvaModel {
    private $db;

    public function __construct($conexao) {
        $this->db = $conexao;
    }
    
    public function getAllProvas() {
        $stmt = $this->db->query("
            SELECT
                p.*,
                d.nome AS nome_disciplina,          -- Adiciona o nome da disciplina
                d.codigoDisciplina AS codigo_disciplina, -- Adiciona o código da disciplina
                p.professor AS nome_professor,        -- Adiciona o nome do professor
                prof.registroProfessor AS registro_professor -- Adiciona o registro do professor
            FROM
                prova AS p
            LEFT JOIN
                disciplina AS d ON p.Disciplina_id_disciplina = d.id_disciplina
            LEFT JOIN
                professor AS prof ON p.Disciplina_Professor_id_professor = prof.id_professor
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProvaById($id) {
        $stmt = $this->db->prepare("
            SELECT
                p.*,
                d.nome AS nome_disciplina,
                d.codigoDisciplina AS codigoDisciplina,
                prof.nome AS nome_professor,
                prof.registroProfessor AS registro_professor
            FROM
                prova AS p
            LEFT JOIN
                disciplina AS d ON p.Disciplina_id_disciplina = d.id_disciplina
            LEFT JOIN
                professor AS prof ON p.Disciplina_Professor_id_professor = prof.id_professor
            WHERE
                p.id_prova = :id
            ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function createProva($data) {
        

        $sql = "INSERT INTO prova (codigoProva, tipo_prova, disciplina, conteudo, data_prova, professor, Disciplina_id_disciplina, Disciplina_Professor_id_professor)
                VALUES (:codigo, :tipo, :disciplina, :conteudo, :data, :professor_nome, :id_disciplina, :id_professor)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':codigo' => $data['codigoProva'],
            ':tipo' => $data['tipo_prova'],
            ':disciplina' => $data['disciplina'],
            ':conteudo' => $data['conteudo'],
            ':data' => $data['data_prova'],
            ':professor_nome' => $data['nome_professor'],
            ':id_disciplina' => $data['id_disciplina'],
            ':id_professor' => $data['id_professor']
            
        ]);

    }

    
    public function updateProva($data) {
        $sql = "UPDATE prova SET
                    codigoProva = :codigoProva,
                    tipo_prova = :tipo_prova,
                    disciplina = :disciplina,
                    conteudo = :conteudo,
                    data_prova = :data_prova,
                    professor = :nome_professor,
                    Disciplina_id_disciplina = :Disciplina_id_disciplina,
                    Disciplina_Professor_id_professor = :Disciplina_Professor_id_professor

                WHERE id_prova = :id_prova";
        
        $stmt = $this->db->prepare($sql);
    
        return $stmt->execute([
            ':codigoProva' => $data['codigoProva'],
            ':tipo_prova' => $data['tipo_prova'],
            ':disciplina' => $data['disciplina'],
            ':conteudo' => $data['conteudo'],
            ':data_prova' => $data['data_prova'],
            ':nome_professor' => $data['nome_professor'],
            ':id_prova' => $data['id_prova'],
            ':Disciplina_id_disciplina' => $data['id_disciplina'],
            ':Disciplina_Professor_id_professor' => $data['id_professor']
            
        ]);
    }


    public function deleteProva($id) {
        $stmt = $this->db->prepare("DELETE FROM prova WHERE id_prova = :id");
        return $stmt->execute([':id' => $id]);
    }

    //
}
?>
