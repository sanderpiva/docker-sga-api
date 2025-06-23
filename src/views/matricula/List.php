<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    header("Location: index.php?controller=auth&action=logout");
    exit();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'professor') {
    header("Location: index.php?controller=auth&action=showLoginForm"); // Redireciona para o login
    exit();
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Web Consulta Matrícula</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          xintegrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">

    <h2>Lista de Matrícula</h2>

    <?php
        
        if (isset($_GET['message'])) {
            echo "<p style='color:green;'>" . htmlspecialchars($_GET['message']) . "</p>";
        }
        if (isset($_GET['error'])) {
            echo "<p style='color:red;'>" . htmlspecialchars($_GET['error']) . "</p>";
        }
    ?>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Matrícula Aluno</th>
                <th>Disciplina</th>
                <th>Professor</th>
                <th>Código Turma</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($matriculas) > 0): ?>
                <?php foreach ($matriculas as $matricula): ?>
                    <tr>
                        <td><?= htmlspecialchars($matricula['nome_aluno']) ?></td>
                        <td><?= htmlspecialchars($matricula['matricula_aluno']) ?></td>
                        <td><?= htmlspecialchars($matricula['nome_disciplina']) ?></td>
                        <td><?= htmlspecialchars($matricula['nome_professor'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($matricula['codigo_turma']) ?></td>
                        <td id='buttons-wrapper'>
                            <!-- Botão Atualizar agora usa a função JS -->
                            <button onclick="atualizarMatricula(<?= htmlspecialchars($matricula['Aluno_id_aluno']) ?>, <?= htmlspecialchars($matricula['Disciplina_id_disciplina']) ?>)">
                                <i class='fa-solid fa-pen'></i> Atualizar
                            </button>
                            <!-- Botão Excluir agora usa a função JS -->
                            <button onclick="excluirMatricula(<?= htmlspecialchars($matricula['Aluno_id_aluno']) ?>, '<?= htmlspecialchars($matricula['nome_aluno']) ?>', '<?= htmlspecialchars($matricula['nome_disciplina']) ?>')">
                                <i class='fa-solid fa-trash'></i> Excluir
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan='6'>Nenhuma matrícula encontrada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php?controller=professor&action=showServicesPage">Voltar aos Serviços</a>
    <hr>
    <a href="index.php?controller=auth&action=logout" style="margin-left:20px;">Logout →</a>

    <script>
        function atualizarMatricula(alunoId, disciplinaId) {
            const url = `index.php?controller=matricula&action=showEditForm&aluno_id=${alunoId}&disciplina_id=${disciplinaId}`;
            window.location.href = url;
        }

        function excluirMatricula(alunoId, alunoNome, disciplinaNome) {
            const confirmar = confirm(`Tem certeza que deseja excluir a matrícula do aluno '${alunoNome}' na disciplina '${disciplinaNome}'? Esta ação é irreversível.`);
            if (confirmar) {
                const url = `index.php?controller=matricula&action=delete&id=${alunoId}`;
                window.location.href = url;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>
