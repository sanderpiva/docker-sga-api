<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');


class Dashboard_controller {

    public function __construct() {

        requireAuth();
    }

    /**
     * Exibe o dashboard principal para professores.
     */
    public function showProfessorDashboard() {
                        
        requireAuth('professor');
        require_once __DIR__ . '/../views/professor/Dashboard_login.php';
    }

    public function showAlunoDashboard() {
                
        
        requireAuth('aluno');
        require_once __DIR__ . '/../views/aluno/Dashboard_login.php';
    }
}
?>