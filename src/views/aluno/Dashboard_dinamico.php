<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style-atividades-dinamicas.css"> 
    <title>Atividades Dinâmicas</title>
</head>
<body class="servicos_forms">
    <h1>Atividades Dinâmicas</h1>

    <?php
    if (isset($erro_conexao) && $erro_conexao) {
        
        echo "<p class='error-message'>" . htmlspecialchars($erro_conexao) . "</p>";
    } elseif (isset($turma_selecionada) && isset($disciplina_selecionada)) {
        
        echo "<p class='info-header'>Conteúdos para Turma: <strong>" . htmlspecialchars($turma_selecionada) . "</strong> e Disciplina: <strong>" . htmlspecialchars($disciplina_selecionada) . "</strong></p>";

        if (!empty($conteudos)) {
            
            echo "<div class='card-container'>";
            foreach ($conteudos as $conteudo) {
                echo "<a href='index.php?controller=aluno&action=detalheConteudoDinamico&id=" . htmlspecialchars($conteudo["id_conteudo"]) . "' class='card'>";
                echo "<h2>" . htmlspecialchars($conteudo["titulo"]) . "</h2>";
                echo "<p>Clique para ver mais detalhes</p>";
                echo "</a>";
            }
            echo "</div>";
        } else {
            echo "<div class='message-container'>";
            echo "<p>Nenhum conteúdo encontrado para a disciplina '" . htmlspecialchars($disciplina_selecionada) . "' na turma '" . htmlspecialchars($turma_selecionada) . "'.</p>";
            echo "<a href='index.php?controller=aluno&action=showDynamicOptions' class='button'>Voltar para Seleção</a>";
            echo "</div>";
        }
    } else {
        echo "<div class='message-container'>";
        echo "<p class='error-message'>Nenhuma turma e disciplina selecionadas. Por favor, volte e faça sua seleção.</p>";
        echo "<a href='index.php?controller=aluno&action=showDynamicOptions' class='button'>Voltar para Seleção</a>";
        echo "</div>";
    }
    ?>
    
    <div class="action-links-container">
        <?php if (isset($turma_selecionada) && isset($disciplina_selecionada) && !empty($conteudos)) : ?>
            <a class="button-primary" href="">Prova</a>
        <?php endif; ?>
        
        <a class="button-danger" href="index.php?controller=auth&action=logout">Logout -> HomePage</a>
    </div>

</body>
<footer class="homes">
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>
