<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Seleção de Atividades</title>
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" method="post" action="index.php?controller=aluno&action=showDynamicOptions">
            <h2>Selecione a Turma e a Disciplina</h2>

            <?php if (!empty($erro_conexao)): ?>
                <p class="erro"><?= htmlspecialchars($erro_conexao) ?></p>
            <?php else: ?>
                <?php if (!empty($erro_form)): ?>
                    <p class="erro"><?= htmlspecialchars($erro_form) ?></p>
                <?php endif; ?>

                <label for="turma_selecionada">Selecione a Turma:</label>
                <select id="turma_selecionada" name="turma_selecionada" required>
                    <option value="">Selecione a Turma</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?= htmlspecialchars($turma['nomeTurma']) ?>" <?= (isset($_POST['turma_selecionada']) && $_POST['turma_selecionada'] == $turma['nomeTurma']) ? 'selected="selected"' : '' ?>>
                            <?= htmlspecialchars($turma['nomeTurma']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <label for="disciplina_selecionada">Selecione a Disciplina:</label>
                <select id="disciplina_selecionada" name="disciplina_selecionada" required>
                    <option value="">Selecione a Disciplina</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <option value="<?= htmlspecialchars($disciplina['nome']) ?>" <?= (isset($_POST['disciplina_selecionada']) && $_POST['disciplina_selecionada'] == $disciplina['nome']) ? 'selected="selected"' : '' ?>>
                            <?= htmlspecialchars($disciplina['nome']) ?> (Professor: <?= htmlspecialchars($disciplina['professor']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <button type="submit">Continuar</button>
            <?php endif; ?>
        </form>
    </div>
    <a href="index.php?controller=auth&action=logout">Logout -> Home Page</a>

</body>
</html>