
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css"> 
    <title>Conteúdo Dinâmico</title>
    <style>
        /* Seus estilos CSS */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .conteudo-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #e0e0e0;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .conteudo-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .conteudo-container h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 2.2em;
        }
        .conteudo-container p {
            text-align: justify;
            line-height: 1.8;
            color: #555;
            font-size: 1.1em;
            margin-bottom: 25px;
            white-space: pre-wrap;
        }
        .botao-exercicio, .botao-voltar, .botao-logout {
            display: inline-block;
            margin: 10px 10px;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .botao-exercicio:hover, .botao-voltar:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .botao-logout {
            background-color: #dc3545;
        }
        .botao-logout:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        .error-message {
            color: #dc3545;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .conteudo-container {
                margin: 20px 10px;
                padding: 20px;
            }
            .conteudo-container h1 {
                font-size: 1.8em;
            }
            .conteudo-container p {
                font-size: 1em;
            }
            .botao-exercicio, .botao-voltar, .botao-logout {
                display: block;
                width: 90%;
                margin: 10px auto;
            }
        }
    </style>
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
</html>
