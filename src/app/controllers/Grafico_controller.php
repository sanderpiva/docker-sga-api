<?php

//require_once 'app/models/Prova.php';
require_once __DIR__ . '/../models/Prova.php';

class Grafico_controller {
    public function viewProvasPorProfessorEDisciplina() {
        //include 'app/views/graficos/provasPorProfessorEDisciplina.php';
        include __DIR__ . '/../views/graficos/provasPorProfessorEDisciplina.php';
    }

    public function dadosProvasPorProfessorEDisciplina() {
        $model = new Prova();
        $data = $model->getProvasPorProfessorEDisciplina();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>