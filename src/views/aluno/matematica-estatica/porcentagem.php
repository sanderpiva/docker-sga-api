<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/*
if (isset($_POST['a1']) && isset($_POST['r']) && isset($_POST['n'])) {
    session_start();
    $_SESSION['pa_status'] = 1; // Define o status da atividade na sessão
}*/
?>


<!DOCTYPE html>
<html>
<head>
    <title>Porcentagem</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="home">
    <div id="porcentagem_form"><br><br>
        <h1 class="titulo_porcentagem">Cálculo de Porcentagem</h1>
        <h2>Conceito</h2>
        <p>Porcentagem é uma forma de expressar uma parte de um todo como uma fração de 100. O símbolo "%" significa "por cento". Podemos calcular a porcentagem de um valor, o valor correspondente a uma porcentagem ou a porcentagem que um valor representa de outro.</p>
        <p>Escolha o tipo de cálculo que você deseja realizar:</p>
        <label for="tipo_calculo">Tipo de Cálculo:</label><br>
        <select id="tipo_calculo" name="tipo_calculo">
            <option value="">Selecione:</option>
            <option value="calcular_porcentagem">Calcular a porcentagem de um valor</option>
            <option value="calcular_valor">Calcular o valor correspondente a uma porcentagem</option>
            <option value="calcular_percentual">Calcular o percentual entre dois valores</option>
        </select><br><br>

        <div id="form_calcular_porcentagem" style="display: none;">
            <h3>Calcular a porcentagem de um valor</h3>
            <form method="post" action="">
                <label for="valor_total_porc">Digite o valor total:</label><br>
                <input type="number" id="valor_total_porc" name="valor_total_porc" placeholder="Valor Total" min="1" required><br><br>
                <label for="porcentagem_porc">Digite a porcentagem (%):</label><br>
                <input type="number" id="porcentagem_porc" name="porcentagem_porc" placeholder="Porcentagem" min="1" required><br><br>
                <button class="btn_calcular" type="submit" name="calcular_porcentagem_btn">Calcular</button><br><br>
            </form>
        </div>

        <div id="form_calcular_valor" style="display: none;">
            <h3>Calcular o valor correspondente a uma porcentagem</h3>
            <form method="post" action="">
                <label for="porcentagem_valor">Digite a porcentagem (%):</label><br>
                <input type="number" id="porcentagem_valor" name="porcentagem_valor" placeholder="Porcentagem" min="1" required><br><br>
                <label for="total_valor">Digite o valor total:</label><br>
                <input type="number" id="total_valor" name="total_valor" placeholder="Valor Total" min="1" required><br><br>
                <button class="btn_calcular" type="submit" name="calcular_valor_btn">Calcular</button><br><br>
            </form>
        </div>

        <div id="form_calcular_percentual" style="display: none;">
            <h3>Calcular o percentual entre dois valores</h3>
            <form method="post" action="">
                <label for="valor_parte_perc">Digite o valor da parte:</label><br>
                <input type="number" id="valor_parte_perc" name="valor_parte_perc" min="1" placeholder="Valor da Parte" required><br><br>
                <label for="valor_total_perc">Digite o valor total:</label><br>
                <input type="number" id="valor_total_perc" name="valor_total_perc" min="1" placeholder="Valor Total" required><br><br>
                <button class="btn_calcular" type="submit" name="calcular_percentual_btn">Calcular</button><br><br>
            </form>
        </div>
    </div>
    <div id="porcentagem_result">
        <?php
            //session_start(); // Inicia a sessão no início do arquivo
            // O PHP para processar os resultados continua o mesmo,
            // pois ele já verifica qual botão de submit foi clicado.
            // Certifique-se de que este bloco PHP esteja onde você deseja que os resultados apareçam.
            if (isset($_POST['calcular_porcentagem_btn'])) {
                $valor_total = $_POST['valor_total_porc'];
                $porcentagem = $_POST['porcentagem_porc'];
                $resultado = ($porcentagem / 100) * $valor_total;
                echo "$porcentagem% de $valor_total é: ($porcentagem / 100) * $valor_total = $resultado";
                $_SESSION['porcentagem_status'] = 1;
            } elseif (isset($_POST['calcular_valor_btn'])) {
                $porcentagem = $_POST['porcentagem_valor'];
                $total = $_POST['total_valor'];
                $resultado = ($porcentagem != 0) ? ($total / ($porcentagem / 100)) : 0;
                echo "Se $total é $porcentagem%, o valor total é: $total / ($porcentagem / 100) = $resultado";
                $_SESSION['porcentagem_status'] = 1;
            } elseif (isset($_POST['calcular_percentual_btn'])) {
                $valor_parte = $_POST['valor_parte_perc'];
                $valor_total = $_POST['valor_total_perc'];
                $resultado = ($valor_total != 0) ? ($valor_parte / $valor_total) * 100 : 0;
                echo "$valor_parte é " . round($resultado, 2) . "% de $valor_total";
                $_SESSION['porcentagem_status'] = 1;
            }
        ?>
        <br><br>
        <a class="btn_dashboard" href="index.php?controller=aluno&action=showStaticServicesPage">Finalizar</a>
    </div>

    <script>
        document.getElementById('tipo_calculo').addEventListener('change', function() {
            // Limpa o conteúdo da div de resultados
            document.getElementById('porcentagem_result').innerHTML = ''; 

            document.getElementById('form_calcular_porcentagem').style.display = 'none';
            document.getElementById('form_calcular_valor').style.display = 'none';
            document.getElementById('form_calcular_percentual').style.display = 'none';

            if (this.value === 'calcular_porcentagem') {
                document.getElementById('form_calcular_porcentagem').style.display = 'block';
            } else if (this.value === 'calcular_valor') {
                document.getElementById('form_calcular_valor').style.display = 'block';
            } else if (this.value === 'calcular_percentual') {
                document.getElementById('form_calcular_percentual').style.display = 'block';
            }
        });
    </script>

</body><br><br><br><br><br><br><br><br><br><br><br><br>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>