<?php

$isUpdating = isset($questaoProvaData['id_questao']) && !empty($questaoProvaData['id_questao']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?= $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Questão Prova</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        
    
        <form class="form" action="<?= $isUpdating ? 'index.php?controller=questoes&action=update' : 'index.php?controller=questoes&action=create'; ?>" method="post">
            <h2>Formulário: <?= $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Questão Prova</h2>
            <hr>

            <?php if (!empty($errors)): ?>
                <div class="errors" style="color: red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
                <hr>
            <?php endif; ?>

            <label for="codigoQuestaoProva">Código Questão:</label>
            <input type="text" name="codigoQuestaoProva" id="codigoQuestaoProva" placeholder="Digite codigo questao" value="<?= htmlspecialchars($questaoProvaData['codigoQuestao'] ?? $questaoProvaData['codigoQuestaoProva'] ?? '') ?>" required>
            <?php if ($isUpdating): ?>
                <input type="hidden" name="id_questao" value="<?= htmlspecialchars($questaoProvaData['id_questao'] ?? '') ?>">
            <?php endif; ?>
            <hr>

            <label for="descricao_questao">Descrição questão de prova:</label>
            <input type="text" name="descricao_questao" id="descricao_questao" placeholder="Descricao prova" value="<?= htmlspecialchars($questaoProvaData['descricao'] ?? $questaoProvaData['descricao_questao'] ?? '') ?>" required>
            <hr>

            <label for="tipo_prova">Tipo prova:</label>
            <input type="text" name="tipo_prova" id="tipo_prova" placeholder="Digite tipo prova" value="<?= htmlspecialchars($questaoProvaData['tipo_prova'] ?? '') ?>" required>
            <hr>

            <?php if ($isUpdating): ?>
                <label for="id_prova">Código prova:</label>
                <input type="text" value="<?= htmlspecialchars($nomeProvaAtual ?? '') ?>" readonly required>
                <input type="hidden" name="id_prova" value="<?= htmlspecialchars($questaoProvaData['Prova_id_prova'] ?? '') ?>">
                <hr>
            <?php else: ?>
                <label for="id_prova">Código prova:</label>
                <select name="id_prova" required>
                    <option value="">Selecione codigo de prova</option>
                    <?php foreach ($provas as $prova): ?>
                        <option value="<?= $prova['id_prova'] ?>"
                            <?= (isset($questaoProvaData['id_prova']) && $questaoProvaData['id_prova'] == $prova['id_prova']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($prova['codigoProva']) ?> - <?= htmlspecialchars($prova['professor'] ?? 'N/A') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <hr>
            <?php endif; ?>

            <?php if ($isUpdating): ?>
                <label for="id_disciplina">Disciplina:</label>
                <input type="text" value="<?= htmlspecialchars($nomeDisciplinaAtual ?? '') ?>" readonly required>
                <input type="hidden" name="id_disciplina" value="<?= htmlspecialchars($questaoProvaData['Prova_Disciplina_id_disciplina'] ?? '') ?>">
                <hr>
            <?php else: ?>
                <label for="id_disciplina">Disciplina:</label>
                <select name="id_disciplina" required>
                    <option value="">Selecione uma disciplina (Professor)</option>
                    <?php foreach ($disciplinas as $disciplina):
                        $professorId = $disciplina['Professor_id_professor'] ?? null;
                        $professorNome = $professorsLookup[$professorId] ?? 'Professor Desconhecido';
                        ?>
                        <option value="<?= $disciplina['id_disciplina'] ?>"
                            <?= (isset($questaoProvaData['id_disciplina']) && $questaoProvaData['id_disciplina'] == $disciplina['id_disciplina']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($disciplina['nome']) . ' (' . htmlspecialchars($professorNome) . ')' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <hr>
            <?php endif; ?>

            <?php if ($isUpdating): ?>
                <label for="id_professor">Nome Professor:</label>
                <input type="text" value="<?= htmlspecialchars($nomeProfessorAtual ?? '') ?>" readonly required>
                <input type="hidden" name="id_professor" value="<?= htmlspecialchars($questaoProvaData['Prova_Disciplina_Professor_id_professor'] ?? '') ?>">
                <hr>
            <?php else: ?>
                <label for="id_professor">Nome Professor:</label>
                <select name="id_professor" required>
                    <option value="">Selecione um professor</option>
                    <?php foreach ($professores as $professor): ?>
                        <option value="<?= $professor['id_professor'] ?>"
                            <?= (isset($questaoProvaData['id_professor']) && $questaoProvaData['id_professor'] == $professor['id_professor']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($professor['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <hr>
            <?php endif; ?>

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