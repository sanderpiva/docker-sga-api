<?php

require_once "config/conexao.php"; 

class AlunoModel {
    private $db;

    public function __construct($conexao) {
        $this->db = $conexao;
    }

    /**
     * Fetches all students from the database.
     * @return array An array of student data.
     */
    public function getAllAlunos() {
        try {
            $stmt = $this->db->query("SELECT * FROM aluno");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar todos os alunos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetches a single student by ID.
     * @param int $id The ID of the student.
     * @return array|false The student data or false if not found.
     */
    public function getAlunoById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM aluno WHERE id_aluno = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar aluno por ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Creates a new student record in the database.
     * @param string $matricula The student's enrollment number.
     * @param string $nome The full name of the student.
     * @param string $email The student's email.
     * @param string $endereco The student's address.
     * @param string $telefone The student's phone number.
     * @param string $senha The student's password (will be hashed).
     * @param int $turmaId The ID of the class the student belongs to.
     * @return bool True on success, false on failure.
     */
    public function createAluno($matricula, $nome, $email, $endereco, $telefone, $senha, $turmaId) {
        $hashSenha = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha para segurança

        try {
            
            $sql = "INSERT INTO aluno (matricula, nome, cpf, email, data_nascimento, endereco, cidade, telefone, Turma_id_turma, senha)
                    VALUES (:matricula, :nome, :cpf, :email, :data_nascimento, :endereco, :cidade, :telefone, :turma_id, :senha )";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':matricula' => $matricula,
                ':nome'      => $nome,
                ':cpf'       => $cpf, // CPF não está sendo passado, ajuste conforme necessário
                ':email'     => $email,
                ':data_nascimento' => $data_nascimento, // Data de nascimento não está sendo passada, ajuste conforme necessário
                ':endereco'  => $endereco,
                ':cidade'    => $cidade, // Cidade não está sendo passada, ajuste conforme necessário
                ':telefone'  => $telefone,
                ':senha'     => $hashSenha,
                ':turma_id'  => $turmaId
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao criar aluno: " . $e->getMessage());
            return false;
        }
    }

    
    /**
     * Deletes a student record from the database.
     * @param int $id The ID of the student to delete.
     * @return bool|string True on success, false on generic failure, 'dependency_error' on FK constraint violation.
     */
    public function deleteAluno($id) {
        error_log("DEBUG: deleteAluno no modelo - Tentando excluir ID: " . $id);
        try {
            
            $stmt = $this->db->prepare("DELETE FROM aluno WHERE id_aluno = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erro ao deletar aluno: " . $e->getMessage());
            if ($e->getCode() == '23000') { // SQLSTATE for integrity constraint violation
                return 'dependency_error'; // Indicate FK error
            }
            return false;
        }
    }

    /**
     * Fetches all classes.
     * This is useful for populating a dropdown in the student creation/edit form.
     * @return array An array of class data.
     */
    public function getAllTurmas() {
        try {
            $stmt = $this->db->query("SELECT id_turma, codigoTurma, nomeTurma FROM turma ORDER BY codigoTurma");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar todas as turmas: " . $e->getMessage());
            return [];
        }
    }

    public function getAllDisciplinas() {
        $query = "SELECT * FROM disciplina"; // Certifique-se de que essa tabela existe
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);   
    } 
    //
    
    public function getConteudosPorTurmaEDisciplina($turma_selecionada, $disciplina_selecionada) {
    
        echo "<h3>Debug das variáveis recebidas:</h3>";
        var_dump($turma_selecionada, $disciplina_selecionada);

        try {
    
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<p style='color:green;'>✅ Conexão com o banco estabelecida!</p>";

            $sql_conteudos = "SELECT 
                                c.titulo, 
                                c.descricao 
                              FROM 
                                conteudo c 
                              INNER JOIN 
                                disciplina d ON c.Disciplina_id_disciplina = d.id_disciplina 
                              INNER JOIN 
                                turma t ON d.Turma_id_turma = t.id_turma 
                              WHERE 
                                LOWER(t.nomeTurma) LIKE LOWER(:turma_pattern) 
                                AND LOWER(d.nome) = LOWER(:disciplina)";

            $stmt_conteudos = $this->conexao->prepare($sql_conteudos);
            $turma_pattern = $turma_selecionada . '%';
            $stmt_conteudos->bindParam(':turma_pattern', $turma_pattern, PDO::PARAM_STR);
            $stmt_conteudos->bindParam(':disciplina', $disciplina_selecionada, PDO::PARAM_STR);
            $stmt_conteudos->execute();
            
            $resultado = $stmt_conteudos->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (PDOException $e) {
            return "<p style='color:red;'>Erro na conexão com o banco de dados: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }

    public function updateAluno($data) {
        
        error_log("DEBUG ALUNO MODEL: Dados recebidos para atualização: " . print_r($data, true)); //

        $sql = "UPDATE aluno SET
                    matricula = :matricula,
                    nome = :nome,
                    cpf = :cpf,
                    email = :email,
                    data_nascimento = :data_nascimento,
                    endereco = :endereco,
                    cidade = :cidade,
                    telefone = :telefone,
                    Turma_id_turma = :Turma_id_turma";

        $params = [
            ':matricula'       => $data['matricula'],
            ':nome'            => $data['nome'],
            ':cpf'             => $data['cpf'],
            ':email'           => $data['email'],
            ':data_nascimento' => $data['data_nascimento'],
            ':endereco'        => $data['endereco'],
            ':cidade'          => $data['cidade'],
            ':telefone'        => $data['telefone'],
            ':Turma_id_turma'  => $data['Turma_id_turma'],
            ':id_aluno'        => $data['id_aluno'] // Importante para a cláusula WHERE
        ];

        if (isset($data['novaSenha']) && !empty($data['novaSenha'])) {
            $hashSenha = password_hash($data['novaSenha'], PASSWORD_DEFAULT);
            $sql .= ", senha = :senha";
            $params[':senha'] = $hashSenha;
        }

        $sql .= " WHERE id_aluno = :id_aluno";

        error_log("DEBUG ALUNO MODEL: SQL: " . $sql); //
        error_log("DEBUG ALUNO MODEL: Parâmetros: " . print_r($params, true)); //

        try {
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($params);

            error_log("DEBUG ALUNO MODEL: Resultado da execução (true/false): " . ($result ? 'true' : 'false')); //
            if (!$result) {
                error_log("DEBUG ALUNO MODEL: Erro PDOInfo: " . print_r($stmt->errorInfo(), true)); //
            }

            return $result && $stmt->rowCount() > 0;
        
        } catch (PDOException $e) {
            error_log("DEBUG ALUNO MODEL: Erro PDO ao atualizar aluno: " . $e->getMessage()); //
            return false;
        }
    }
     
}