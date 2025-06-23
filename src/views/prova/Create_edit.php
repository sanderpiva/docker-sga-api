<?php


$isUpdating = isset($provaData['id_prova']) && !empty($provaData['id_prova']);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $isUpdating ? 'Atualizar' : 'Cadastrar'; ?> Prova</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="servicos_forms">
    <div class="form_container">
        <form class="form" action="<?= $isUpdating ? 'index.php?controller=prova&action=update' : 'index.php?controller=prova&action=create'; ?>" method="post">
            <h2>Formulário: <?= $isUpdating ? 'Atualizar' : 'Cadastrar'; ?> Prova</h2>

            <label for="codigoProva">Código da prova:</label>
            <?php if ($isUpdating): ?>
                <input type="text" name="codigoProva" id="codigoProva" placeholder="Digite codigo" value="<?php echo htmlspecialchars($provaData['codigoProva'] ?? ''); ?>" required>
                <input type="hidden" name="id_prova" value="<?php echo htmlspecialchars($provaData['id_prova'] ?? ''); ?>">
            <?php else: ?>
                <input type="text" name="codigoProva" id="codigoProva" placeholder="Digite codigo" required>
            <?php endif; ?>
            <hr>

            <label for="tipo_prova">Tipo de prova:</label>
            <input type="text" name="tipo_prova" id="tipo_prova" placeholder="Digite tipo de prova" value="<?php echo htmlspecialchars($provaData['tipo_prova'] ?? ''); ?>" required>
            <hr>

            <label for="disciplina">Nome disciplina:</label>
            <input type="text" name="disciplina" id="disciplina" placeholder="Digite tipo de prova" value="<?php echo htmlspecialchars($provaData['disciplina'] ?? ''); ?>" required>
            <hr>

            <label for="conteudo">Conteúdo de prova:</label>
            <input type="text" name="conteudo" id="conteudo" placeholder="Digite conteudo" value="<?php echo htmlspecialchars($provaData['conteudo'] ?? ''); ?>" required>
            <hr>

            <label for="data_prova">Data da prova:</label>
            <input type="date" name="data_prova" id="data_prova" placeholder="Digite a data" value="<?php echo htmlspecialchars($provaData['data_prova'] ?? ''); ?>" required>
            <hr>

            <label for="nome_professor">Nome professor:</label>
            <input type="text" name="nome_professor" id="nome_professor" placeholder="Digite nome professor" value="<?php echo htmlspecialchars($provaData['professor'] ?? ''); ?>" required>
            <hr>

            <label for="id_disciplina">Código disciplina:</label>
            <?php if ($isUpdating): ?>
                <input type="text" value="<?php echo htmlspecialchars($provaData['codigoDisciplina'] ?? 'N/A'); ?>" readonly required>
                <input type="hidden" name="id_disciplina" value="<?php echo htmlspecialchars($provaData['Disciplina_id_disciplina'] ?? ''); ?>">
            
            <?php else: ?>
                <select name="id_disciplina" required>
                    <option value="">Selecione codigo disciplina</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <option value="<?= $disciplina['id_disciplina'] ?>">
                            <?= htmlspecialchars($disciplina['codigoDisciplina'] ?? '') ?> - <?= htmlspecialchars($disciplina['nome_professor'] ?? '') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <hr>

            <label for="id_professor">Registro do Professor:</label>
            <?php if ($isUpdating): ?>
                <!-- Mostra o nome do professor como texto -->
                <input type="text" value="<?php echo htmlspecialchars($professores['registroProfessor'] ?? 'N/A'); ?>" readonly required>
    
                <!-- Passa o ID ocultamente -->
                <input type="hidden" name="id_professor" value="<?php echo htmlspecialchars($provaData['Disciplina_Professor_id_professor'] ?? ''); ?>">
            <?php else: ?>
                <select name="id_professor" required>
                    <option value="">Selecione um professor</option>
                    <?php foreach ($professores as $professor): ?>
                        <option value="<?= $professor['id_professor'] ?>">
                            <?= htmlspecialchars($professor['registroProfessor'] ?? '') ?> - <?= htmlspecialchars($professor['nome'] ?? '') ?>
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