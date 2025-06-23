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
    <title>Lista de Turmas</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body class="servicos_forms">
<h2>Lista de Turmas</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($turmas as $turma): ?>
            <tr>
                <td><?= htmlspecialchars($turma['codigoTurma']) ?></td>
                <td><?= htmlspecialchars($turma['nomeTurma']) ?></td>
                <td>
                    <!-- Botão Atualizar agora usa a função JS -->
                    <button onclick="atualizarTurma(<?= htmlspecialchars($turma['id_turma']) ?>)"><i class='fa-solid fa-pen'></i> Atualizar</button>
                    
                    <!-- Botão Excluir agora usa a função JS -->
                    <button onclick="excluirTurma(<?= htmlspecialchars($turma['id_turma']) ?>)"><i class='fa-solid fa-trash'></i> Excluir</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>
<a href="index.php?controller=professor&action=showServicesPage">Voltar ao Serviços</a>
<br><hr>
<a href="index.php?controller=auth&action=logout" style="margin-left:20px;">Logout →</a>

<script>
    function atualizarTurma(id_turma) {
        window.location.href = "index.php?controller=turma&action=showEditForm&id=" + id_turma;
    }

    function excluirTurma(id_turma) {
        const confirmar = confirm("Tem certeza que deseja excluir a turma com ID: " + id_turma + "?");
        if (confirmar) {
            window.location.href = "index.php?controller=turma&action=delete&id=" + id_turma;
        }
    }
</script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>
