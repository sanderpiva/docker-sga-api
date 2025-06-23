<?php

$isUpdating = isset($matricula); 

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Matrícula</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?php echo $isUpdating ? 'index.php?controller=matricula&action=update' : 'index.php?controller=matricula&action=create'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Matrícula</h2>
            <hr>

            <label for="aluno_id">Aluno:</label>
            <select name="aluno_id" id="aluno_id" required>
                <option value="">Selecione um aluno</option>
                <?php foreach ($alunos as $aluno): ?>
                    <option value="<?= htmlspecialchars($aluno['id_aluno']) ?>"
                        <?php if ($isUpdating && $aluno['id_aluno'] == $matricula['Aluno_id_aluno']) echo 'selected'; ?>>
                        <?= htmlspecialchars($aluno['nome']) ?> (<?= htmlspecialchars($aluno['matricula']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <hr>

            <label for="disciplina_id">Disciplina:</label>
            <select name="disciplina_id" id="disciplina_id" required>
                <option value="">Selecione uma disciplina (Professor)</option>
                <?php foreach ($disciplinas as $disciplina): ?>
                    <?php
                        $professorId = $disciplina['Professor_id_professor'] ?? null;
                        $professorNome = $professorsLookup[$professorId] ?? 'Professor Desconhecido';
                    ?>
                    <option value="<?= htmlspecialchars($disciplina['id_disciplina']) ?>"
                        <?php if ($isUpdating && $disciplina['id_disciplina'] == $matricula['Disciplina_id_disciplina']) echo 'selected'; ?>>
                        <?= htmlspecialchars($disciplina['nome']) . ' (' . htmlspecialchars($professorNome) . ')' ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <hr>

            <?php if ($isUpdating): ?>
                <input type="hidden" name="original_aluno_id" value="<?php echo htmlspecialchars($matricula['Aluno_id_aluno']); ?>">
                <input type="hidden" name="original_disciplina_id" value="<?php echo htmlspecialchars($matricula['Disciplina_id_disciplina']); ?>">
            <?php endif; ?>

            <button type="submit"><?php echo $isUpdating ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>

        <?php
            
            if (isset($_GET['message'])) {
                echo "<p style='color:green;'>" . htmlspecialchars($_GET['message']) . "</p>";
            }
            if (isset($_GET['error'])) {
                echo "<p style='color:red;'>" . htmlspecialchars($_GET['error']) . "</p>";
            }
        ?>

        <hr>
    </div>
    <a href="index.php?controller=professor&action=showServicesPage">Serviços</a>
    <hr>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>