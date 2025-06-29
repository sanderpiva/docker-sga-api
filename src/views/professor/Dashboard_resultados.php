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

    <div class="servicos_forms">
      <h1>Página de Resultados dos Alunos: Algebrando</h1>
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
            
            <?php if (isset($registros) && !empty($registros)): ?>
                <?php foreach ($registros as $registro): ?>
                    <tr>
                        <td><?= htmlspecialchars($registro['nome']) ?></td>
                        <td><?= htmlspecialchars($registro['email']) ?></td>
                        <td><?= htmlspecialchars($registro['q1']) ?></td>
                        <td><?= htmlspecialchars($registro['q2']) ?></td>
                        <td><?= htmlspecialchars($registro['q3']) ?></td>
                        <td><?= htmlspecialchars($registro['q4']) ?></td> 
                        <td><?= htmlspecialchars(number_format($registro['nota'], 1)) ?></td>
                        <td><?= htmlspecialchars($registro['turma']) ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan='6'>Nenhum registro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <hr>
    <a href="index.php?controller=auth&action=logout"><em>Logout -> HomePage</em></a>

    </div>
    
  </body>
<footer class="homes">
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>