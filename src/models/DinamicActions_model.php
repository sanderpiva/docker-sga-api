<?php

class DinamicActionsModel {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function getConteudosPorTurmaEDisciplina($turma, $disciplina) {
        $turma_str = is_array($turma) ? implode('', $turma) : (string) $turma;
        $disciplina_str = is_array($disciplina) ? implode('', $disciplina) : (string) $disciplina;

        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql_conteudos = "SELECT
                                    c.id_conteudo,
                                    c.titulo,
                                    c.descricao
                                  FROM
                                    conteudo c
                                  INNER JOIN
                                    disciplina d ON c.Disciplina_id_disciplina = d.id_disciplina
                                  INNER JOIN
                                    turma t ON d.Turma_id_turma = t.id_turma
                                  WHERE
                                    LOWER(t.nomeTurma) = LOWER(:turma_param)
                                    AND LOWER(d.nome) = LOWER(:disciplina_param)";

            $stmt_conteudos = $this->conexao->prepare($sql_conteudos);

            $stmt_conteudos->bindParam(':turma_param', $turma_str, PDO::PARAM_STR);
            $stmt_conteudos->bindParam(':disciplina_param', $disciplina_str, PDO::PARAM_STR);
            $stmt_conteudos->execute();

            $resultado = $stmt_conteudos->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;

        } catch (PDOException $e) {
            error_log("Erro ao buscar conteúdos por turma e disciplina: " . $e->getMessage());
            return [];
        }
    }

    public function getConteudoById($id_conteudo) {
        try {
            $sql = "SELECT id_conteudo, titulo, descricao, disciplina FROM conteudo WHERE id_conteudo = :id_conteudo"; 
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindParam(':id_conteudo', $id_conteudo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar conteúdo por ID: " . $e->getMessage());
            return false;
        }
    }
}
