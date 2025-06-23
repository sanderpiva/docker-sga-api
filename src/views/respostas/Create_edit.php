<?php

$isUpdating = isset($respostaData['id_respostas']) && !empty($respostaData['id_respostas']);

$errors = $errors ?? [];
$questoes = $questoes ?? [];
$provas = $provas ?? [];
$disciplinas = $disciplinas ?? [];
$professores = $professores ?? [];
$alunos = $alunos ?? [];
$professorsLookup = $professorsLookup ?? [];

$descricaoQuestaoAtual = $descricaoQuestaoAtual ?? 'N/A';
$codigoProvaAtual = $codigoProvaAtual ?? 'N/A';
$nomeDisciplinaAtual = $nomeDisciplinaAtual ?? 'N/A';
$nomeProfessorAtual = $nomeProfessorAtual ?? 'N/A';
$nomeAlunoAtual = $nomeAlunoAtual ?? 'N/A';

function getFormValue($data, $post, $key) {
    if (isset($post[$key])) {
        return htmlspecialchars($post[$key]);
    }
    if (isset($data[$key])) {
        return htmlspecialchars($data[$key]);
    }
    return '';
}

$selectedQuestaoId = $_POST['id_questao'] ?? ($respostaData['Questoes_id_questao'] ?? '');
$selectedProvaId = $_POST['id_prova'] ?? ($respostaData['Questoes_Prova_id_prova'] ?? '');
$selectedDisciplinaId = $_POST['id_disciplina'] ?? ($respostaData['Questoes_Prova_Disciplina_id_disciplina'] ?? '');
$selectedProfessorId = $_POST['id_professor'] ?? ($respostaData['Questoes_Prova_Disciplina_Professor_id_professor'] ?? '');
$selectedAlunoId = $_POST['id_aluno'] ?? ($respostaData['Aluno_id_aluno'] ?? '');

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web - <?= $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Respostas</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?= $isUpdating ? 'index.php?controller=respostas&action=update' : 'index.php?controller=respostas&action=create'; ?>" method="post">
            <h2>Formulário: <?= $isUpdating ? 'Atualizar' : 'Cadastro'; ?> Respostas</h2>
            <hr>

            <?php if (!empty($errors)): ?>
                <div class="errors" style="color: red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
                <hr>
            <?php endif; ?>

            <label for="codigoRespostas">Código Respostas:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="codigoRespostas" id="codigoRespostas" placeholder="" value="<?= getFormValue($respostaData, $_POST, 'codigoRespostas') ?>" required>
                <!-- AQUI TAMBÉM: o name do hidden input deve ser 'id_respostas' -->
                <input type="hidden" name="id_respostas" value="<?= htmlspecialchars($respostaData['id_respostas'] ?? '') ?>">
            <?php else: ?>
                <input type="text" name="codigoRespostas" id="codigoRespostas" placeholder="" value="<?= getFormValue($respostaData, $_POST, 'codigoRespostas') ?>" required>
            <?php endif; ?>
            <hr>

            <label for="respostaDada">Resposta Dada:</label>
            <input type="text" name="respostaDada" id="respostaDada" placeholder="" value="<?= getFormValue($respostaData, $_POST, 'respostaDada') ?>" required maxlength="1">
            <hr>

            <label>Acertou?</label>
            <div>
                <input type="radio" id="acertouSim" name="acertou" value="1" 
                    <?= (getFormValue($respostaData, $_POST, 'acertou') == '1') ? 'checked' : ''; ?> required>
                <label for="acertouSim">Sim</label>
                <input type="radio" id="acertouNao" name="acertou" value="0" 
                    <?= (getFormValue($respostaData, $_POST, 'acertou') == '0') ? 'checked' : ''; ?> required>
                <label for="acertouNao">Não</label>
            </div>
            <hr>

            <label for="nota">Nota:</label>
            <input type="number" step="0.01" name="nota" id="nota" placeholder="" value="<?= getFormValue($respostaData, $_POST, 'nota') ?>" required min="0">
            <hr>

            <label for="id_questao">Descrição da Questão:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?= htmlspecialchars($descricaoQuestaoAtual) ?>" readonly required>
                <input type="hidden" name="id_questao" value="<?= htmlspecialchars($respostaData['Questoes_id_questao'] ?? '') ?>">
            <?php else: ?>
                <select name="id_questao" id="id_questao" required>
                    <option value="">Selecione a descrição da questão</option>
                    <?php foreach ($questoes as $questao): ?>
                        <option value="<?= htmlspecialchars($questao['id_questao']) ?>"
                            <?= ($selectedQuestaoId == $questao['id_questao']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($questao['descricao']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <hr>

            <label for="id_prova">Código Prova:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?= htmlspecialchars($codigoProvaAtual) ?>" readonly required>
                <input type="hidden" name="id_prova" value="<?= htmlspecialchars($respostaData['Questoes_Prova_id_prova'] ?? '') ?>">
            <?php else: ?>
                <select name="id_prova" id="id_prova" required>
                    <option value="">Selecione uma prova</option>
                    <?php foreach ($provas as $prova): ?>
                        <option value="<?= htmlspecialchars($prova['id_prova']) ?>"
                            <?= ($selectedProvaId == $prova['id_prova']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($prova['codigoProva']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <hr>

            <label for="id_disciplina">Disciplina:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?= htmlspecialchars($nomeDisciplinaAtual) ?>" readonly required>
                <input type="hidden" name="id_disciplina" value="<?= htmlspecialchars($respostaData['Questoes_Prova_Disciplina_id_disciplina'] ?? '') ?>">
                <hr>
            <?php else: ?>
                <select name="id_disciplina" id="id_disciplina" required>
                    <option value="">Selecione uma disciplina (Professor)</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <?php
                            $professorId = $disciplina['Professor_id_professor'] ?? null;
                            $professorNome = $professorsLookup[$professorId] ?? 'Professor Desconhecido';
                        ?>
                        <option value="<?= htmlspecialchars($disciplina['id_disciplina']) ?>"
                            <?= ($selectedDisciplinaId == $disciplina['id_disciplina']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($disciplina['nome']) . ' (' . htmlspecialchars($professorNome) . ')' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <hr>

            <label for="id_professor">Professor:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?= htmlspecialchars($nomeProfessorAtual) ?>" readonly required>
                <input type="hidden" name="id_professor" value="<?= htmlspecialchars($respostaData['Questoes_Prova_Disciplina_Professor_id_professor'] ?? '') ?>">
                <hr>
            <?php else: ?>
                <select name="id_professor" id="id_professor" required>
                    <option value="">Selecione um professor</option>
                    <?php foreach ($professores as $professor): ?>
                        <option value="<?= htmlspecialchars($professor['id_professor']) ?>"
                            <?= ($selectedProfessorId == $professor['id_professor']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($professor['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <hr>

            <label for="id_aluno">Aluno:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?= htmlspecialchars($nomeAlunoAtual) ?>" readonly required>
                <input type="hidden" name="id_aluno" value="<?= htmlspecialchars($respostaData['Aluno_id_aluno'] ?? '') ?>">
                <hr>
            <?php else: ?>
                <select name="id_aluno" id="id_aluno" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?= htmlspecialchars($aluno['id_aluno']) ?>"
                            <?= ($selectedAlunoId == $aluno['id_aluno']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($aluno['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
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
