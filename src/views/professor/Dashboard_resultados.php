<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    header("Location: index.php?controller=auth&action=logout");
    exit();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'professor') {
    header("Location: index.php?controller=auth&action=showLoginForm"); // Corrigido para o controlador certo
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Página Resultados dos Alunos: Algebrando</title>
  </head>
  <body>

    <div class="table_container">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Q1</th>
            <th>Q2</th>
            <th>Q3</th>
            <th>Q4</th>
            <th>Média</th>
            <th>Turma</th>
          </tr>
        </thead>
        <tbody>
        <?php

        global $conexao; 

        try {
            $sql = "SELECT * FROM tabeladados";
            $stmt = $conexao->prepare($sql);
            $stmt->execute();

            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $num_registros = count($registros);

            echo "<caption>Registros encontrados: " . $num_registros . "</caption>";

            if ($num_registros > 0) {
                foreach ($registros as $reg) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($reg['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['q1']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['q2']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['q3']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['q4']) . "</td>";
                    echo "<td>" . htmlspecialchars(number_format($reg['nota'], 1)) . "</td>"; // Formata a média para 1 casa decimal
                    echo "<td>" . htmlspecialchars($reg['turma']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Nenhum registro encontrado.</td></tr>";
            }

        } catch (PDOException $e) {
            echo "<tr><td colspan='8' style='color:red;'>Erro ao carregar dados: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>

    <br><br><br>
    <a href="index.php?controller=auth&action=logout"><em>Logout -> HomePage</em></a>

  </body>
<footer class="homes">
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>