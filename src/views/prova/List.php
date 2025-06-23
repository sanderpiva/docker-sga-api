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


<?php

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
$error = isset($_GET['erros']) ? htmlspecialchars($_GET['erros']) : '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Provas</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
             integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
             crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">
    <h2>Lista de Provas</h2>

    <?php if ($message): ?>
        <p style="color: green;"><?= $message ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Código de prova</th>
                <th>Tipo</th>
                <th>Nome da Disciplina</th>        <th>Conteúdo</th>
                <th>Data</th>
                <th>Professor</th>         <th>Código da Disciplina</th> <th>Registro do Professor</th> <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($provas)): ?>
                <tr>
                    <td colspan="9">Nenhuma prova encontrada.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($provas as $prova): ?>
                    <tr>
                        <td><?= htmlspecialchars($prova['codigoProva']) ?></td>
                        <td><?= htmlspecialchars($prova['tipo_prova']) ?></td>
                        <td><?= htmlspecialchars($prova['disciplina'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($prova['conteudo']) ?></td>
                        <td><?= htmlspecialchars($prova['data_prova']) ?></td>
                        <td><?= htmlspecialchars($prova['nome_professor'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($prova['codigo_disciplina'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($prova['registro_professor'] ?? 'N/A') ?></td>
                        <td id='buttons-wrapper'>
                             <!-- Botão Atualizar agora usa a função JS -->
                            <button onclick="atualizarProva(<?= htmlspecialchars($prova['id_prova']) ?>)">
                                <i class='fa-solid fa-pen'></i> Atualizar
                            </button>
                            <!-- Botão Excluir agora usa a função JS -->
                            <button onclick="excluirProva(<?= htmlspecialchars($prova['id_prova']) ?>)">
                                <i class='fa-solid fa-trash'></i> Excluir
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php?controller=professor&action=showServicesPage">Voltar aos Serviços</a>
    <hr>
    <a href="index.php?controller=auth&action=logout" style="margin-left:20px;">Logout →</a>

    <script>
        function atualizarProva(id_prova) {
            window.location.href = "index.php?controller=prova&action=showEditForm&id=" + id_prova;
        }

        function excluirProva(id_prova) {
            const confirmar = confirm("Tem certeza que deseja excluir a prova com ID: " + id_prova + "?");
            if (confirmar) {
                window.location.href = "index.php?controller=prova&action=delete&id=" + id_prova;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>