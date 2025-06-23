<?php
$isUpdating = isset($turma);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $isUpdating ? 'Atualizar' : 'Cadastrar' ?> Turma</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
              integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">
<div class="form_container">
    <form class="form" action="<?= $isUpdating ? 'index.php?controller=turma&action=update' : 'index.php?controller=turma&action=create'; ?>" method="post">
        <h2>Formulário: <?= $isUpdating ? 'Atualizar' : 'Cadastrar' ?> Turma</h2>
        <hr>

        <label for="codigoTurma">Código Turma:</label>
        <input type="text" name="codigoTurma" id="codigoTurma" value="<?= htmlspecialchars($turma['codigoTurma'] ?? '') ?>" required>

        <label for="nomeTurma">Nome da Turma:</label>
        <input type="text" name="nomeTurma" id="nomeTurma" value="<?= htmlspecialchars($turma['nomeTurma'] ?? '') ?>" required>

        <?php if ($isUpdating): ?>
            <input type="hidden" name="id_turma" value="<?= htmlspecialchars($turma['id_turma']) ?>">
            <input type="hidden" name="action" value="update">
        <?php else: ?>
            <input type="hidden" name="action" value="create">
        <?php endif; ?>

        <button type="submit"><?= $isUpdating ? 'Atualizar' : 'Cadastrar' ?></button>
    </form>
    
</div>
<a href="index.php?controller=professor&action=showServicesPage">Serviços</a>
<hr>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>