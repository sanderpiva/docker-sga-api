<?php

require_once "config/conexao.php";

class AuthModel {
    private $pdo;

    public function __construct() {

        global $conexao;
        $this->pdo = $conexao;
    }

    /**
     * Tenta autenticar um usuário (professor ou aluno) com base no login e senha.
     * @param string $login O email/login do usuário.
     * @param string $senhaDigitada A senha digitada pelo usuário.
     * @return array|false Retorna um array com 'type' (professor/aluno) e 'data' (dados do usuário), ou false se a autenticação falhar.
     */
    public function authenticate($login, $senhaDigitada) {

        $stmtProfessor = $this->pdo->prepare("SELECT id_professor, nome, email, senha FROM professor WHERE email = :login");
        $stmtProfessor->bindParam(':login', $login, PDO::PARAM_STR);
        $stmtProfessor->execute();

        if ($stmtProfessor->rowCount() === 1) {
            $professor = $stmtProfessor->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senhaDigitada, $professor['senha'])) {
                return ['type' => 'professor', 'data' => $professor];
            }
        }

        $stmtAluno = $this->pdo->prepare("SELECT a.id_aluno, a.nome, a.email, a.senha, t.nomeTurma
                                           FROM aluno a
                                           JOIN turma t ON a.Turma_id_turma = t.id_turma
                                           WHERE a.email = :login");
        $stmtAluno->bindParam(':login', $login, PDO::PARAM_STR);
        $stmtAluno->execute();

        if ($stmtAluno->rowCount() === 1) {
            $aluno = $stmtAluno->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senhaDigitada, $aluno['senha'])) {
                return ['type' => 'aluno', 'data' => $aluno];
            }
        }

        return false; 
    }

    /**
     * Registra um novo professor no banco de dados.
     * @param array $data Dados do professor (registroProfessor, nomeProfessor, etc.).
     * @return bool True se o registro for bem-sucedido, false caso contrário.
     */
    public function registerProfessor($data) {
        $registro = $data['registroProfessor'] ?? '';
        $nome     = $data['nomeProfessor'] ?? '';
        $email    = $data['emailProfessor'] ?? '';
        $endereco = $data['enderecoProfessor'] ?? '';
        $telefone = $data['telefoneProfessor'] ?? '';
        $senha    = $data['senha'] ?? '';
        $hashSenha = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO professor (registroProfessor, nome, email, endereco, telefone, senha)
                    VALUES (:registroProfessor, :nome, :email, :endereco, :telefone, :senha)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':registroProfessor' => $registro,
                ':nome'              => $nome,
                ':email'             => $email,
                ':endereco'          => $endereco,
                ':telefone'          => $telefone,
                ':senha'             => $hashSenha
            ]);
        } catch (PDOException $e) {
            // Em vez de morrer, você pode logar o erro e retornar false ou relançar.
            // Para simplicidade, vamos apenas retornar false aqui.
            error_log("Erro ao cadastrar professor: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Valida os dados de entrada para o cadastro de professor.
     * @param array $data Os dados do formulário.
     * @return string Uma string contendo mensagens de erro HTML, vazia se não houver erros.
     */
    public function validateProfessorData($data) {
        $errors = "";

        if (empty($data["registroProfessor"]) || empty($data["nomeProfessor"]) ||
            empty($data["emailProfessor"]) || empty($data["enderecoProfessor"]) ||
            empty($data["telefoneProfessor"]) || empty($data["senha"])) {
            $errors .= "Todos os campos devem ser preenchidos.<br>";
        }

        if (strlen($data["registroProfessor"]) < 3 || strlen($data["registroProfessor"]) > 20) {
            $errors .= "Erro: campo 'Registro do Professor' deve ter entre 3 e 20 caracteres.<br>";
        }
        if (strlen($data["nomeProfessor"]) < 10 || strlen($data["nomeProfessor"]) > 30) {
            $errors .= "Erro: campo 'Nome do Professor' deve ter entre 10 e 30 caracteres.<br>";
        }
        if (!filter_var($data["emailProfessor"], FILTER_VALIDATE_EMAIL)) {
            $errors .= "Erro: campo 'E-mail' inválido.<br>";
        }
        if (strlen($data["enderecoProfessor"]) < 5 || strlen($data["enderecoProfessor"]) > 100) {
            $errors .= "Erro: campo 'Endereço' deve ter entre 5 e 100 caracteres.<br>";
        }
        if (strlen($data["telefoneProfessor"]) < 10 || strlen($data["telefoneProfessor"]) > 25) {
            $errors .= "Erro: campo 'Telefone' deve ter entre 10 e 25 caracteres.<br>";
        }

        return $errors;
    }

    public function validateAlunoData($data) {
        $errors = "";

        // Verificação de campos obrigatórios
        if (empty($data["matricula"]) || empty($data["nome"]) ||
            empty($data["email"]) || empty($data["endereco"]) ||
            empty($data["telefone"])) {
            $errors .= "Todos os campos devem ser preenchidos.<br>";
        }

        if (strlen($data["matricula"]) < 3 || strlen($data["matricula"]) > 20) {
            $errors .= "Erro: campo 'Matricula do Aluno' deve ter entre 3 e 20 caracteres.<br>";
        }
        if (strlen($data["nome"]) < 10 || strlen($data["nome"]) > 30) {
            $errors .= "Erro: campo 'Nome do Aluno' deve ter entre 10 e 30 caracteres.<br>";
        }
        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            $errors .= "Erro: campo 'E-mail' inválido.<br>";
        }
        if (strlen($data["endereco"]) < 5 || strlen($data["endereco"]) > 100) {
            $errors .= "Erro: campo 'Endereço' deve ter entre 5 e 100 caracteres.<br>";
        }
        if (strlen($data["telefone"]) < 10 || strlen($data["telefone"]) > 25) {
            $errors .= "Erro: campo 'Telefone' deve ter entre 10 e 25 caracteres.<br>";
        }

        return $errors;
    }

    public function getTurmas() {
        $sql = "SELECT id_turma, nomeTurma FROM turma ORDER BY nomeTurma ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerAluno($data) {
        
        $matricula = $data['matricula'] ?? '';
        $nome = $data['nome'] ?? '';
        $cpf = $data['cpf'] ?? '';
        $email = $data['email'] ?? '';
        $data_nascimento = $data['data_nascimento'] ?? '';
        $endereco = $data['endereco'] ?? '';
        $cidade = $data['cidade'] ?? '';
        $telefone = $data['telefone'] ?? '';
        $id_turma = $data['Turma_id_turma'] ?? '';
        $senha = $data['senha'] ?? '';
        $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
        
        try {
            $sql = "INSERT INTO aluno (matricula, nome, cpf, email, data_nascimento, endereco, cidade, telefone, Turma_id_turma, senha) VALUES (:matricula, :nome, :cpf, :email, :data_nascimento, :endereco, :cidade, :telefone, :id_turma, :senha)";
            $stmt = $this->pdo->prepare($sql); 
            return $stmt->execute([
                ':matricula' => $matricula,
                ':nome' => $nome,
                ':cpf' => $cpf,
                ':email' => $email,
                ':data_nascimento' => $data_nascimento,
                ':endereco' => $endereco,
                ':cidade' => $cidade,
                ':telefone' => $telefone,
                ':id_turma' => $id_turma,
                ':senha' => $hashSenha
            ]);
        } catch (PDOException $e) {
            
            error_log("Erro ao cadastrar aluno: " . $e->getMessage());
            return false; 
        }
    }
   
}