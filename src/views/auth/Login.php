<!DOCTYPE html>
<html>
<head>
    <title>Sistema Academico</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>SISTEMA ACADÊMICO: IRACEMA RODRIGUES</h1>
    <?php if (isset($clima) && $clima): ?>
        <div style="background: #f9fbfd; border: 1px solid #d0e2f0; border-radius: 10px; padding: 10px 16px; width: fit-content; margin: 20px auto; box-shadow: 0 2px 6px rgba(0,0,0,0.05); font-family: Arial, sans-serif; font-size: 14px; color: #333; display: flex; align-items: center; gap: 12px">
            <strong>Clima atual em Machado/MG:</strong>
            <span><?= htmlspecialchars($clima['descricao']) ?>,</span>
            <span><?= htmlspecialchars($clima['temperatura']) ?> °C</span>
            <span style="font-size: 1.5em;"><?= htmlspecialchars($clima['icone']) ?></span>
            <span>| Máx: <?= htmlspecialchars($clima['temp_max']) ?> °C</span>
            <span>Min: <?= htmlspecialchars($clima['temp_min']) ?> °C</span>
        </div>
        
    <?php endif; ?>

    <div class="content-columns-wrapper">
        <div class="img_home"><br><br>
            <img class="img_dimens" src="public/img/home2.jpg" alt="Foto Iracema Rodrigues">
        </div>
        <div class="form_container">
            <form class="form" method="post" action="index.php?controller=auth&action=login">
                <h2>Login</h2>
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" required>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
                <button type="submit">Login</button>
            </form>
            <div class="cadastro-links" style="margin-top: 20px; text-align: center;">
                <p>Não tem cadastro? Crie sua conta:</p>
                <a href="index.php?controller=auth&action=showProfessorRegisterForm">Cadastrar como Professor</a> |
                <a href="index.php?controller=auth&action=showAlunoRegisterForm">Cadastrar como Aluno</a>
            </div>
        </div>
    </div><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br>
    <footer>
        <p>Desenvolvido por Juliana e Sander</p>
    </footer>
</body>
</html>