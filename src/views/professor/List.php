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
    <title>Consulta Professor</title>
    <link rel="stylesheet" href="public/css/style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="servicos_forms">

    <h2>Lista de Professor</h2>

    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_GET['message']) ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Registro</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($professores) && !empty($professores)): ?>
                <?php foreach ($professores as $professor): ?>
                    <tr>
                        <td><?= htmlspecialchars($professor['registroProfessor']) ?></td>
                        <td><?= htmlspecialchars($professor['nome']) ?></td>
                        <td><?= htmlspecialchars($professor['email']) ?></td>
                        <td><?= htmlspecialchars($professor['endereco']) ?></td>
                        <td><?= htmlspecialchars($professor['telefone']) ?></td>
                        <td id='buttons-wrapper'>
                            <!-- Botão Atualizar agora usa a função JS -->
                            <button onclick="atualizarProfessor(<?= htmlspecialchars($professor['id_professor']) ?>)" class="edit-button">
                                <i class='fa-solid fa-pen'></i> Atualizar
                            </button>
                            <!-- Botão Excluir agora usa a função JS -->
                            <button onclick="excluirProfessor(<?= htmlspecialchars($professor['id_professor']) ?>, '<?= htmlspecialchars($professor['nome']) ?>')" class="delete-button">
                                <i class='fa-solid fa-trash'></i> Excluir
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan='6'>Nenhum professor encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php?controller=professor&action=showServicesPage">Voltar aos Serviços</a>
    <hr>
    <a href="index.php?controller=auth&action=logout" style="margin-left:20px;">Logout →</a>
    <script>
        function atualizarProfessor(id_professor) {
            window.location.href = "index.php?controller=professor&action=showEditForm&id=" + id_professor;
        }

        function excluirProfessor(id_professor, nome_professor) {
            const confirmar = confirm("Tem certeza que deseja excluir o professor " + nome_professor + " (ID: " + id_professor + ")?");
            if (confirmar) {
                window.location.href = "index.php?controller=professor&action=delete&id=" + id_professor;
            }
        }
    </script>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>