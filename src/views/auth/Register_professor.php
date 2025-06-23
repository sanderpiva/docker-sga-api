<?php

$isUpdating = isset($professorData['id_professor']) && !empty($professorData['id_professor']);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $isUpdating ? 'Atualizar Professor' : 'Cadastro Professor'; ?></title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="servicos_forms">

    <div class="form_container">
        <form class="form" action="<?= $isUpdating ? 'index.php?controller=professor&action=updateProfessor' : 'index.php?controller=auth&action=registerProfessor'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar Professor' : 'Cadastro Professor'; ?></h2>
            <hr>

            <label for="registroProfessor">Registro:</label>
            <input type="text" name="registroProfessor" id="registroProfessor" placeholder="Digite o registro" value="<?php echo htmlspecialchars($professorData['registroProfessor'] ?? ''); ?>" required>
            <?php if ($isUpdating): ?>
                <input type="hidden" name="id_professor" value="<?php echo htmlspecialchars($professorData['id_professor'] ?? ''); ?>">
            <?php endif; ?>
            <hr>

            <label for="nomeProfessor">Nome:</label>
            <input type="text" name="nomeProfessor" id="nomeProfessor" placeholder="Digite o nome" value="<?php echo htmlspecialchars($professorData['nome'] ?? ''); ?>" required>
            <hr>

            <label for="emailProfessor">Login/Email:</label>
            <input type="email" name="emailProfessor" id="emailProfessor" placeholder="Digite o email" value="<?php echo htmlspecialchars($professorData['email'] ?? ''); ?>" required>
            <hr>

            <label for="enderecoProfessor">Endereço:</label>
            <input type="text" name="enderecoProfessor" id="enderecoProfessor" placeholder="Digite o endereço" value="<?php echo htmlspecialchars($professorData['endereco'] ?? ''); ?>" required>
            <hr>

            <label for="telefoneProfessor">Telefone:</label>
            <input type="text" name="telefoneProfessor" id="telefoneProfessor" placeholder="Digite o telefone" value="<?php echo htmlspecialchars($professorData['telefone'] ?? ''); ?>" required>
            <hr>

            <?php if ($isUpdating): ?>
                <label for="novaSenha">Nova Senha:</label>
                <input type="password" id="novaSenha" name="novaSenha" placeholder="Precisa implementar ainda..." readonly>
                <input type="hidden" name="acao" value="atualizar">
            <?php else: ?>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Digite a senha" required>
                <input type="hidden" name="acao" value="cadastrar">
            <?php endif; ?>

            <br><br>
            <button type="submit"><?php echo $isUpdating ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>

        <?php if (!empty($errors)): ?>
            <?php echo $errors; ?>
        <?php endif; ?>
        
    </div>
    <a href="index.php?controller=professor&action=showServicesPage">Serviços</a>
    <hr>
</body>
</html>