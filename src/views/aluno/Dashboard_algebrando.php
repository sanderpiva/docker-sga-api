<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    header("Location: index.php?controller=auth&action=logout");
    exit();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'aluno') {
    header("Location: index.php?controller=auth&action=showLoginForm");
    exit();
}

$pa_status = $_SESSION['pa_status'] ?? 0;
$pg_status = $_SESSION['pg_status'] ?? 0;
$porcentagem_status = $_SESSION['porcentagem_status'] ?? 0;
$proporcao_status = $_SESSION['proporcao_status'] ?? 0;

$all_activities_completed = ($pa_status == 1 && $pg_status == 1 && $porcentagem_status == 1 && $proporcao_status == 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Atividades/Provas - Algebrando</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="home">
    <h1> Atividades/Provas - Algebrando </h1><br>

    <div id="cards-container">
        <div class="card">
            <a href="index.php?controller=aluno&action=viewPA">
                <img src="public/img/i_pa.png" alt="Progressão Aritmética">
            </a>
            <?php echo $pa_status == 1 ? '<img class="check" src="public/img/checked1.png" alt="Concluído">' : '<p style="color: red;">❌ Não visto</p>'; ?>
        </div>
        <div class="card">
            <a href="index.php?controller=aluno&action=viewPG">
                <img src="public/img/i_pg.png" alt="Progressão Geométrica">
            </a>
            <?php echo $pg_status == 1 ? '<img class="check" src="public/img/checked1.png" alt="Concluído">' : '<p style="color: red;">❌ Não visto</p>'; ?>
        </div>
        <div class="card">
            <a href="index.php?controller=aluno&action=viewPorcentagem">
                <img src="public/img/i_porcentagem.png" alt="Porcentagem">
            </a>
            <?php echo $porcentagem_status == 1 ? '<img class="check" src="public/img/checked1.png" alt="Concluído">' : '<p style="color: red;">❌ Não visto</p>'; ?>
        </div>
        <div class="card">
            <a href="index.php?controller=aluno&action=viewProporcao">
                <img src="public/img/i_proporcao.png" alt="Proporção">
            </a>
            <?php echo $proporcao_status == 1 ? '<img class="check" src="public/img/checked1.png" alt="Concluído">' : '<p style="color: red;">❌ Não visto</p>'; ?>
        </div>
    </div>

    <div class="btn_prova">
        <?php if ($all_activities_completed): ?>
            <form method="post" action="index.php?controller=aluno&action=viewProva">
                <button type="submit" name="fazer_prova" class="btn_prova">Fazer Prova</button>
            </form>
        <?php else: ?>
            <button class="btn_prova" onclick="mostrarMensagem()">Fazer Prova</button>
            <p id="mensagem-erro" style="color: red; display: none;">Você não fez todas as tarefas!</p>
        <?php endif; ?>
    </div>
    <hr>
    <a href="index.php?controller=auth&action=logout" style="text-align: center; display: block;">Logout →</a>
</body><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>