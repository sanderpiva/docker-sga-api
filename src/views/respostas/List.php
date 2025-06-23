<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    header("Location: index.php?controller=auth&action=logout");
    exit();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'professor') {
    header("Location: index.php?controller=auth&action=showLoginForm"); // Corrigido para o controlador certo
    exit();
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Respostas</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
             integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
             crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body class="servicos_forms">

    <h2>Lista de Respostas</h2>

    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_GET['message']) ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Código Resposta</th>
                <th>Resposta Dada</th>
                <th>Acertou?</th>
                <th>Nota</th>
                <th>Descrição Questão</th>
                <th>Código Prova</th>
                <th>Nome Disciplina</th>
                <th>Nome Professor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($respostas)):
                foreach ($respostas as $resposta):
                    $id_resposta = htmlspecialchars($resposta['id_respostas']);
            ?>
                <tr>
                    <td><?= htmlspecialchars($resposta['nome_aluno']) ?></td>
                    <td><?= htmlspecialchars($resposta['codigoRespostas']) ?></td>
                    <td><?= htmlspecialchars($resposta['respostaDada']) ?></td>
                    <td><?= (htmlspecialchars($resposta['acertou']) ? 'Sim' : 'Não') ?></td>
                    <td><?= htmlspecialchars($resposta['nota']) ?></td>
                    <td><?= htmlspecialchars($resposta['descricao_questao']) ?></td>
                    <td><?= htmlspecialchars($resposta['codigo_prova']) ?></td>
                    <td><?= htmlspecialchars($resposta['nome_disciplina']) ?></td>
                    <td><?= htmlspecialchars($resposta['nome_professor']) ?></td>
                    <td id='buttons-wrapper'>
                         <!-- Botão Atualizar agora usa a função JS -->
                        <button onclick='atualizarResposta("<?= $id_resposta ?>")'><i class='fa-solid fa-pen'></i> Atualizar</button>
                        <!-- Botão Excluir agora usa a função JS -->
                        <button onclick='excluirResposta("<?= $id_resposta ?>")'><i class='fa-solid fa-trash'></i> Excluir</button>
                    </td>
                </tr>
            <?php
                endforeach;
            else:
            ?>
                <tr><td colspan='10'>Nenhuma resposta encontrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php?controller=professor&action=showServicesPage">Voltar aos Serviços</a>
    <hr>
    <a href="index.php?controller=auth&action=logout" style="margin-left:20px;">Logout →</a>

    <script>
        function atualizarResposta(id) {
            window.location.href = "index.php?controller=respostas&action=showEditForm&id=" + id;
        }

        function excluirResposta(id) {
            const confirmar = confirm("Tem certeza que deseja excluir a resposta com ID: " + id + "?");
            if (confirmar) {
                window.location.href = "index.php?controller=respostas&action=delete&id=" + id;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>