
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style-conteudo-dinamico.css"> 
    <title>Conteúdo Dinâmico</title>
</head>

<body class="servicos_forms">
    <div class="conteudo-container">
        <?php if (isset($erro) && $erro): ?>
            <h2 class="error-message"><?= htmlspecialchars($erro) ?></h2>
            <a class="botao-voltar" href="index.php?controller=aluno&action=showDynamicServicesPage">← Voltar para Atividades</a>
        <?php elseif ($conteudo): ?>
            <h1><?= htmlspecialchars($conteudo['titulo'] ?? 'Título Não Encontrado') ?></h1>
            <?php if (isset($imagem_associada) && $imagem_associada): ?>
                <img src="<?= htmlspecialchars($imagem_associada) ?>" alt="Imagem relacionada ao conteúdo">
            <?php endif; ?>
            <p><?= nl2br(htmlspecialchars($conteudo['descricao'] ?? 'Descrição não disponível.')) ?></p>

            <?php
            

            $exercicio_encontrado = false;
            
            if(isset($conteudo['disciplina']) && isset($conteudo['titulo']) && $conteudo['disciplina'] == 'Matematica') {
                $titulo_lower = strtolower($conteudo['titulo']); // Converte o título para minúsculas para comparação flexível

                if(strpos($titulo_lower, 'progressao aritmetica') !== false):
                    echo '<a class="botao-exercicio" href="index.php?controller=aluno&action=exercicioPA">Exercício demonstrativo (PA)</a>';
                    $exercicio_encontrado = true;
                //Para outras funcionalidades
                /*
                elseif(strpos($titulo_lower, 'progressao geometrica') !== false):
                    echo '<a class="botao-exercicio" href="index.php?controller=aluno&action=exercicioPG">Exercício demonstrativo (PG)</a>';
                    $exercicio_encontrado = true;
                
                elseif(strpos($titulo_lower, 'porcentagem') !== false):
                    echo '<a class="botao-exercicio" href="index.php?controller=aluno&action=exercicioPorcentagem">Exercício demonstrativo (Porcentagem)</a>';
                    $exercicio_encontrado = true;
                */
                endif;
            }

            if (!$exercicio_encontrado) {
                echo '<p>IMPORTANTE! Não há exercício demonstrativo disponível para este conteúdo.</p>';
            }
            ?>
        <?php else: ?>
            <p class="error-message">Conteúdo não disponível.</p>
            <a class="botao-voltar" href="index.php?controller=aluno&action=showDynamicServicesPage">← Voltar para Atividades</a>
        <?php endif; ?><br>

        <a class="botao-voltar" href="index.php?controller=aluno&action=showDynamicServicesPage">← Finalizar</a>
        <a class="botao-logout" href="index.php?controller=auth&action=logout">Logout →</a>
    </div>

</body>
<footer class="homes">
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>
