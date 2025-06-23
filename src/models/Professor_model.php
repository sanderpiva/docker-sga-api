<?php
require_once "config/conexao.php"; 

class ProfessorModel {
    private $db;

    public function __construct($conexao) {
        $this->db = $conexao;
    }

    /**
     * Retorna todos os professores cadastrados.
     * @return array Um array de arrays associativos, onde cada array representa um professor.
     */
    public function getAllProfessores() {
        $stmt = $this->db->query("SELECT * FROM professor");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna um professor específico pelo seu ID.
     * @param int $id O ID do professor.
     * @return array|false Um array associativo com os dados do professor, ou false se não encontrado.
     */
    public function getProfessorById($id) {
        $stmt = $this->db->prepare("SELECT * FROM professor WHERE id_professor = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cria um novo professor no banco de dados.
     * @param string $registro O registro do professor.
     * @param string $nome O nome completo do professor.
     * @param string $email O email do professor.
     * @param string $endereco O endereço do professor.
     * @param string $telefone O telefone do professor.
     * @param string $senha A senha do professor (será hashed antes de inserir).
     * @return bool True em caso de sucesso, false em caso de falha.
     */
    public function createProfessor($registro, $nome, $email, $endereco, $telefone, $senha) {
        $hashSenha = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha para segurança

        try {
            $sql = "INSERT INTO professor (registroProfessor, nome, email, endereco, telefone, senha)
                    VALUES (:registroProfessor, :nome, :email, :endereco, :telefone, :senha)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':registroProfessor' => $registro,
                ':nome'              => $nome,
                ':email'             => $email,
                ':endereco'          => $endereco,
                ':telefone'          => $telefone,
                ':senha'             => $hashSenha
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao criar professor: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Atualiza os dados de um professor existente.
     * @param int $id O ID do professor a ser atualizado.
     * @param string $registro O novo registro do professor.
     * @param string $nome O novo nome do professor.
     * @param string $email O novo email do professor.
     * @param string $endereco O novo endereço do professor.
     * @param string $telefone O novo telefone do professor.
     * @param string|null $senha A nova senha do professor (opcional, se não for alterada, passe null ou string vazia).
     * @return bool True em caso de sucesso, false em caso de falha.
     */
    public function updateProfessor($data) { 
        
       
        $sql = "UPDATE professor SET 
                    registroProfessor = :registroProfessor, 
                    nome = :nome, 
                    email = :email, 
                    endereco = :endereco, 
                    telefone = :telefone";
        
        $params = [
            ':registroProfessor' => $data['registroProfessor'],
            ':nome'              => $data['nome'],
            ':email'             => $data['email'],
            ':endereco'          => $data['endereco'],
            ':telefone'          => $data['telefone'],
            ':id_professor'      => $data['id_professor'] // Usando id_professor da chave do array
        ];

        if (isset($data['novaSenha']) && !empty($data['novaSenha'])) {
            $hashSenha = password_hash($data['novaSenha'], PASSWORD_DEFAULT);
            $sql .= ", senha = :senha";
            $params[':senha'] = $hashSenha;
        }

        $sql .= " WHERE id_professor = :id_professor"; // Cláusula WHERE usando id_professor

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar professor: " . $e->getMessage());
            return false;
        }
    }
    /**
     * Deleta um professor do banco de dados.
     * @param int $id O ID do professor a ser deletado.
     * @return bool True em caso de sucesso, false em caso de falha.
     */
    public function deleteProfessor($id) {
        error_log("DEBUG: deleteProfessor no modelo - Tentando excluir ID: " . $id); // Para depuração
        try {
            $stmt = $this->db->prepare("DELETE FROM professor WHERE id_professor = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erro ao deletar professor: " . $e->getMessage());
            return false;
        }
    }
}
?>