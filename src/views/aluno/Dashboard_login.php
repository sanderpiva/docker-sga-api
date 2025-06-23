<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    header("Location: index.php?controller=auth&action=logout");
    exit();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'aluno') {
    header("Location: index.php?controller=auth&action=showLoginForm"); // Corrigido para o controlador certo
    exit();
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Login Aluno</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body class="servicos_forms">
    <div class="form_container">
        <form class="form" method="post" action="index.php?controller=aluno&action=handleSelection">
            <h2>Login Aluno</h2>
            <select id="tipo_atividade" name="tipo_atividade" required>
                <option value="">Selecione:</option>
                <option value="dinamica">Atividades Dinâmicas</option>
                <option value="estatica">Atividades Algebrando</option>
            </select><br><br>

            <button type="submit">Login</button>
        </form>
    </div>
    <a href="index.php?controller=auth&action=logout">Logout -> HomePage</a>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>
