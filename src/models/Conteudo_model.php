<?php


require_once "config/conexao.php";

class ConteudoModel {
    private $db;

    public function __construct($conexao) {
        $this->db = $conexao;
    }

    /**
     * Retorna todos os conteúdos, incluindo o nome da disciplina associada.
     * @return array Um array de conteúdos, cada um com detalhes de disciplina.
     */
    public function getAllConteudos() {
        $stmt = $this->db->query("
            SELECT
                c.*,
                d.nome AS nome_disciplina,
                d.codigoDisciplina AS codigo_disciplina
            FROM
                conteudo AS c
            LEFT JOIN
                disciplina AS d ON c.Disciplina_id_disciplina = d.id_disciplina
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna um conteúdo específico pelo ID.
     * @param int $id O ID do conteúdo.
     * @return array|false Um array associativo com os dados do conteúdo ou false se não encontrado.
     */
    
    
    public function getConteudoById($id) {
        $query = "SELECT 
                      c.*, 
                      d.codigoDisciplina as nomeDisciplina, -- Opcional: para a máscara, se não vier via 'nomeDisciplinaAtual'
                      d.id_disciplina as id_disciplina -- ESTA LINHA É A MAIS IMPORTANTE: ASSEGURA QUE A FK É RETORNADA
                  FROM 
                      conteudo c
                  JOIN 
                      disciplina d ON c.Disciplina_id_disciplina = d.id_disciplina -- Assumindo que sua coluna FK em 'conteudos' é 'id_disciplina'
                  WHERE 
                      c.id_conteudo = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cria um novo conteúdo no banco de dados.
     * @param array $data Um array associativo com os dados do novo conteúdo.
     * @return bool True em caso de sucesso, false caso contrário.
     */
    public function createConteudo($data) {
        $sql = "INSERT INTO conteudo (codigoConteudo, titulo, descricao, data_postagem, professor, disciplina, tipo_conteudo, Disciplina_id_disciplina)
                VALUES (:codigoConteudo, :titulo, :descricao, :data_postagem, :professor, :disciplina, :tipo_conteudo, :id_disciplina)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':codigoConteudo' => $data['codigoConteudo'],
            ':titulo' => $data['titulo'],
            ':descricao' => $data['descricao'],
            ':data_postagem' => $data['data_postagem'],
            ':professor' => $data['professor'], 
            ':disciplina' => $data['disciplina'], 
            ':id_disciplina' => $data['id_disciplina'],
            ':tipo_conteudo' => $data['tipo_conteudo']
        ]);
    }

    /**
     * Atualiza um conteúdo existente no banco de dados.
     * @param array $data Um array associativo com os dados atualizados do conteúdo.
     * @return bool True em caso de sucesso, false caso contrário.
     */
    public function updateConteudo($data) {
    
        $sql = "UPDATE conteudo SET
                    codigoConteudo = :codigoConteudo,
                    titulo = :titulo,
                    descricao = :descricao,
                    data_postagem = :data_postagem,
                    Disciplina_id_disciplina = :id_disciplina,
                    tipo_conteudo = :tipo_conteudo,
                    professor = :professor,
                    disciplina = :disciplina
                WHERE id_conteudo = :id_conteudo";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':codigoConteudo' => $data['codigoConteudo'],
            ':titulo' => $data['titulo'],
            ':descricao' => $data['descricao'],
            ':data_postagem' => $data['data_postagem'],
            ':id_disciplina' => $data['id_disciplina'],
            ':tipo_conteudo' => $data['tipo_conteudo'],
            ':id_conteudo' => $data['id_conteudo'],
            ':professor' => $data['professor'],
            ':disciplina' => $data['disciplina']
        ]);
    }

    /**
     * Deleta um conteúdo do banco de dados.
     * @param int $id O ID do conteúdo a ser deletado.
     * @return bool True em caso de sucesso, false caso contrário.
     */
    public function deleteConteudo($id) {
        $stmt = $this->db->prepare("DELETE FROM conteudo WHERE id_conteudo = :id");
        return $stmt->execute([':id' => $id]);
    }
}