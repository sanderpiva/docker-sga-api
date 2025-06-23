<?php

$isUpdating = isset($conteudoData['id_conteudo']) && !empty($conteudoData['id_conteudo']);

$disciplinas = $disciplinas ?? [];
$errors = $errors ?? [];

$nomeDisciplinaAtual = $nomeDisciplinaAtual ?? '';
$professorsLookup = $professorsLookup ?? [];

$selectedDisciplinaId = $conteudoData['Disciplina_id_disciplina'] ?? ($_POST['id_disciplina'] ?? '');

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $isUpdating ? 'Atualizar' : 'Cadastrar'; ?> Conteúdo</title>
    <link rel="stylesheet" href="public/css/style.css"> 
    </head>
<body class="servicos_forms">
    <div class="form_container">
        <form class="form" action="<?= $isUpdating ? 'index.php?controller=conteudo&action=update' : 'index.php?controller=conteudo&action=create'; ?>" method="post">
            <h2>Formulário: <?= $isUpdating ? 'Atualizar' : 'Cadastrar'; ?> Conteúdo</h2>

            <?php if (!empty($errors)): ?>
                <div class="errors" style="color: red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
                <hr>
            <?php endif; ?>

            <?php if ($isUpdating): ?>
                <input type="hidden" name="id_conteudo" value="<?= htmlspecialchars($conteudoData['id_conteudo'] ?? '') ?>">
            <?php endif; ?>

            <label for="codigoConteudo">Código do Conteúdo:</label><br>
            <input type="text" name="codigoConteudo" id="codigoConteudo" placeholder="Digite o código" value="<?= htmlspecialchars($conteudoData['codigoConteudo'] ?? $_POST['codigoConteudo'] ?? '') ?>" required>
            <hr>

            <label for="titulo">Título do Conteúdo:</label><br>
            <input type="text" name="titulo" id="titulo" placeholder="Digite o título" value="<?= htmlspecialchars($conteudoData['titulo'] ?? $_POST['titulo'] ?? '') ?>" required>
            <hr>

            <label for="descricao">Descrição do Conteúdo:</label><br>
            <textarea name="descricao" id="descricao" placeholder="Digite a descrição" required><?= htmlspecialchars($conteudoData['descricao'] ?? $_POST['descricao'] ?? '') ?></textarea>
            <hr>

            <label for="data_postagem">Data de Postagem:</label><br>    
            <input type="date" name="data_postagem" id="data_postagem" value="<?= htmlspecialchars($conteudoData['data_postagem'] ?? $_POST['data_postagem'] ?? '') ?>" required>
            <hr>

            <label for="professor">Professor:</label><br>
            <input type="text" name="professor" id="professor" placeholder="Digite o nome do professor" value="<?= htmlspecialchars($conteudoData['professor'] ?? $_POST['professor'] ?? '') ?>" required>
            <hr>

            <label for="disciplina">Disciplina:</label><br>
            <input type="text" name="disciplina" id="disciplina" placeholder="Digite o nome da disciplina" value="<?= htmlspecialchars($conteudoData['disciplina'] ?? $_POST['disciplina'] ?? '') ?>" required>
            <hr>

            <label for="tipo_conteudo">Tipo de Conteúdo:</label><br>
            <input type="text" name="tipo_conteudo" id="tipo_conteudo" placeholder="Ex: Artigo, Vídeo, Material de Apoio" value="<?= htmlspecialchars($conteudoData['tipo_conteudo'] ?? $_POST['tipo_conteudo'] ?? '') ?>" required>
            <hr>

            <label for="id_disciplina">Código da disciplina:</label><br>
            <?php if ($isUpdating): ?>
                <input type="text" name="disciplina" value="<?= htmlspecialchars($nomeDisciplinaAtual) ?>" readonly required>
                <input type="hidden" name="id_disciplina" value="<?= htmlspecialchars($conteudoData['id_disciplina'] ?? '') ?>">
                <hr>
                
            <?php else: ?>
                <select name="id_disciplina" required>
                    <option value="">Selecione código da disciplina (Professor)</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <?php
                            $professorId = $disciplina['Professor_id_professor'] ?? null;
                            $professorNome = $professorsLookup[$professorId] ?? 'Professor Desconhecido'; // Usa o lookup
                        ?>
                        <option value="<?= htmlspecialchars($disciplina['id_disciplina']) ?>"
                            <?= ($selectedDisciplinaId == $disciplina['id_disciplina']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($disciplina['codigoDisciplina'] ?? '') . ' (' . htmlspecialchars($professorNome) . ')' ?>
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