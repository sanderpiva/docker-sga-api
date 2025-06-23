<?php
// views/disciplina/Create_edit.php

// The controller should pass $disciplinaData (null for new, object for edit),
// $professores, $turmas, and $errors to this view.
$isUpdating = isset($disciplinaData['id_disciplina']) && !empty($disciplinaData['id_disciplina']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?= $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Disciplina</title>
    <link rel="stylesheet" href="public/css/style.css"> </head>
<body class="servicos_forms">
    <div class="form_container">
        <form class="form" action="<?= $isUpdating ? 'index.php?controller=disciplina&action=update' : 'index.php?controller=disciplina&action=create'; ?>" method="post">
            <h2>Formulário: <?= $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Disciplina</h2>
            <hr>

            <?php if (!empty($errors)): ?>
                <div class="errors" style="color: red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
                <hr>
            <?php endif; ?>

            <label for="codigoDisciplina">Código da disciplina:</label>
            <input type="text" name="codigoDisciplina" id="codigoDisciplina" placeholder="Digite o código" value="<?= htmlspecialchars($disciplinaData['codigoDisciplina'] ?? '') ?>" required>
            <?php if ($isUpdating): ?>
                <input type="hidden" name="id_disciplina" value="<?= htmlspecialchars($disciplinaData['id_disciplina']) ?>">
            <?php endif; ?>
            <hr>

            <label for="nomeDisciplina">Nome da disciplina:</label>
            <input type="text" name="nomeDisciplina" id="nomeDisciplina" placeholder="Digite o nome" value="<?= htmlspecialchars($disciplinaData['nome'] ?? '') ?>" required>
            <hr>

            <label for="carga_horaria">Carga horária:</label>
            <input type="number" min="10" name="carga_horaria" id="carga_horaria" placeholder="Digite a carga horária" value="<?= htmlspecialchars($disciplinaData['carga_horaria'] ?? '') ?>" required>
            <hr>

            <label for="professor">Professor:</label>
            <input type="text" name="professor" id="professor" placeholder="Digite o professor" value="<?= htmlspecialchars($disciplinaData['professor'] ?? '') ?>" required>
            <hr>

            <label for="descricaoDisciplina">Descrição da disciplina:</label>
            <input type="text" name="descricaoDisciplina" id="descricaoDisciplina" placeholder="Digite a descrição" value="<?= htmlspecialchars($disciplinaData['descricao'] ?? '') ?>" required>
            <hr>

            <label for="semestre_periodo">Semestre/Período:</label>
            <input type="text" name="semestre_periodo" id="semestre_periodo" placeholder="Digite o semestre/período" value="<?= htmlspecialchars($disciplinaData['semestre_periodo'] ?? '') ?>" required>
            <hr>

            <label for="Professor_id_professor">Selecione o registro do Professor:</label>
            <select name="Professor_id_professor" id="Professor_id_professor" required>
                <option value="">Selecione um professor</option>
                <?php foreach ($professores as $professor): ?>
                    <option value="<?= htmlspecialchars($professor['id_professor']) ?>"
                        <?= (isset($disciplinaData['Professor_id_professor']) && $disciplinaData['Professor_id_professor'] == $professor['id_professor']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($professor['registroProfessor']) ?> - <?= htmlspecialchars($professor['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <hr>

            <label for="Turma_id_turma">Turma:</label>
            <select name="Turma_id_turma" id="Turma_id_turma" required>
                <option value="">Selecione uma turma</option>
                <?php foreach ($turmas as $turma): ?>
                    <option value="<?= htmlspecialchars($turma['id_turma']) ?>"
                        <?= (isset($disciplinaData['Turma_id_turma']) && $disciplinaData['Turma_id_turma'] == $turma['id_turma']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($turma['nomeTurma']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <hr>

            <button type="submit"><?= $isUpdating ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>

    </div>
    <a href="index.php?controller=professor&action=showServicesPage">Serviços</a>
    <hr>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>