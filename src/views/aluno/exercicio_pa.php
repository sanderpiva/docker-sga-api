<?php

$resultado_pa = "";
$passos_pa = "";

if (isset($_POST['calcular_pa'])) {
    $a1 = isset($_POST['a1_pa']) ? floatval($_POST['a1_pa']) : null;
    $r = isset($_POST['r_pa']) ? floatval($_POST['r_pa']) : null;
    $n = isset($_POST['n_pa']) ? intval($_POST['n_pa']) : null;

    if (!is_null($a1) && !is_null($r) && !is_null($n)) {
        $sequencia = [];
        $termo_atual = $a1;
        $passos = "Cálculo do Termo Geral da PA:\n";

        for ($i = 1; $i <= $n; $i++) {
            $sequencia[] = $termo_atual;
            $passos .= "Termo " . $i . ": a" . $i . " = " . number_format($a1, 2, ',', '.') . " + (" . ($i - 1) . ") * " . number_format($r, 2, ',', '.') . " = " . number_format($termo_atual, 2, ',', '.') . "\n";
            $termo_atual += $r;
        }
        $resultado_pa = "Sequência da PA: " . implode(', ', array_map(function($v){ return number_format($v, 2, ',', '.'); }, $sequencia));
        $passos_pa = $passos;
    } else {
        $resultado_pa = "<p style='color: red;'>Por favor, preencha todos os campos para calcular a PA.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Progressão Aritmética (PA)</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css"> 
    <style>
        /* Estilos específicos para esta view */
        body.home {
            background-color: #f4f7f6;
            font-family: 'Inter', sans-serif;
            color: #333;
            padding: 20px;
        }
        #pa_form, #pa_result {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            text-align: center;
        }
        .titulo_pa {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 1.8em;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            text-align: left;
        }
        form input[type="number"] {
            width: calc(100% - 22px); /* Ajusta a largura e considera padding/borda */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
            box-sizing: border-box; /* Inclui padding e border na largura total */
        }
        .btn_calcular {
            background-color: #28a745; /* Verde para calcular */
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn_calcular:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
        #pa_result h3 {
            color: #34495e;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.4em;
        }
        #pa_result pre {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            text-align: left;
            white-space: pre-wrap; /* Preserva espaços e quebras de linha */
            font-family: monospace;
            overflow-x: auto; /* Adiciona scroll horizontal se necessário */
        }
        #pa_result p {
            font-size: 1.1em;
            font-weight: bold;
            color: #007bff;
        }
        .btn_dashboard, .btn_logout {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn_dashboard:hover, .btn_logout:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .btn_logout {
            background-color: #dc3545; /* Vermelho para logout */
            margin-left: 10px;
        }
        .btn_logout:hover {
            background-color: #c82333;
        }
        
        /* Estilos responsivos */
        @media (max-width: 768px) {
            #pa_form, #pa_result {
                margin: 20px 10px;
                padding: 20px;
            }
            .titulo_pa {
                font-size: 1.5em;
            }
            form input[type="number"] {
                width: calc(100% - 20px);
            }
            .btn_calcular, .btn_dashboard, .btn_logout {
                display: block;
                width: 100%;
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body class="home">
    <div id="pa_form"><br><br>
        <h1 class="titulo_pa">Calcule o Termo Geral da Progressão Aritmética (PA)</h1>
        
        <form method="post" action=""> <!-- Action vazia para postar para a própria página -->
            <label for="a1_pa">Primeiro Termo (a1):</label>
            <input type="number" id="a1_pa" name="a1_pa" placeholder="a1" min="1" step="any" value="<?php echo isset($_POST['a1_pa']) ? htmlspecialchars($_POST['a1_pa']) : ''; ?>" required><br>

            <label for="r_pa">Razão (r)...................:</label>
            <input type="number" id="r_pa" name="r_pa" placeholder="r" step="any" value="<?php echo isset($_POST['r_pa']) ? htmlspecialchars($_POST['r_pa']) : ''; ?>" required><br>

            <label for="n_pa">Número de Termos (n):</label>
            <input type="number" id="n_pa" name="n_pa" placeholder="n" min="1" value="<?php echo isset($_POST['n_pa']) ? htmlspecialchars($_POST['n_pa']) : ''; ?>" required><br>

            <button class="btn_calcular" type="submit" name="calcular_pa">calcular</button><br><br>
        </form>
    </div>

    <div id="pa_result">
        <?php
        if (!empty($passos_pa)) {
            echo "<h3>Passo a Passo:</h3>";
            echo "<pre>" . htmlspecialchars($passos_pa) . "</pre>";
        }
        if (!empty($resultado_pa)) {
            echo "<h3>Resultado:</h3>";
            echo "<p>" . htmlspecialchars($resultado_pa) . "</p>";
        }
        ?>
        <br><br>
        <a class="btn_dashboard" href="index.php?controller=aluno&action=showDynamicServicesPage">Finalizar</a>
        <a class="btn_logout" href="index.php?controller=auth&action=logout">Logout →</a>
    </div>
    
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>
