<?php
require_once "config/conexao.php"; 

class TabelaDadosAlgebrandoModel {
    private $db;

    public function __construct($conexao) {
        $this->db = $conexao;
    }

    /**
     * Retorna todos os professores cadastrados.
     * @return array Um array de arrays associativos, onde cada array representa um professor.
     */
    public function getAllRecords() {
        $registros = $this->db->query("SELECT * FROM tabeladados");
        return $registros->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>