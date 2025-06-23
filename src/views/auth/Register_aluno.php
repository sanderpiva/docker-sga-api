<?php

require_once "config/conexao.php";

if (!isset($alunoData)) {
    $alunoData = [];
}

$isUpdating = isset($alunoData['id_aluno']) && !empty($alunoData['id_aluno']);
$errors = "";
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $isUpdating ? 'Atualizar Aluno' : 'Cadastro Aluno'; ?></title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="servicos_forms">
    <div class="form_container">
        <form class="form" action="<?= $isUpdating ? 'index.php?controller=aluno&action=updateAluno' : 'index.php?controller=auth&action=registerAluno'; ?>" method="post">
            <h2>Formulário: <?php echo $isUpdating ? 'Atualizar Aluno' : 'Cadastro Aluno'; ?></h2>
            <hr>
            <label for="matricula">Matricula:</label>
            <input type="text" name="matricula" id="matricula" placeholder="Digite a matricula" value="<?php echo htmlspecialchars($alunoData['matricula'] ?? ''); ?>" required>
            <?php if ($isUpdating): ?>
                <input type="hidden" name="id_aluno" value="<?php echo htmlspecialchars($alunoData['id_aluno'] ?? ''); ?>">
            <?php endif; ?>
            <hr>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nomeAluno" placeholder="Digite o nome" value="<?php echo htmlspecialchars($alunoData['nome'] ?? ''); ?>" required>
            <hr>
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" placeholder="Digite o CPF" value="<?php echo htmlspecialchars($alunoData['cpf'] ?? ''); ?>" required>
            <hr>
            <label for="email">Email:</label>
            <input type="email" name="email" id="emailAluno" placeholder="Digite o email" value="<?php echo htmlspecialchars($alunoData['email'] ?? ''); ?>" required>
            <hr>
            <label for="data_nascimento">Data nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo htmlspecialchars($alunoData['data_nascimento'] ?? ''); ?>" required>
            <hr>
            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="enderecoAluno" placeholder="Digite o endereço" value="<?php echo htmlspecialchars($alunoData['endereco'] ?? ''); ?>" required>
            <hr>
            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" id="cidadeAluno" placeholder="Digite a cidade" value="<?php echo htmlspecialchars($alunoData['cidade'] ?? ''); ?>" required>
            <hr>
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefoneAluno" placeholder="Digite o telefone" value="<?php echo htmlspecialchars($alunoData['telefone'] ?? ''); ?>" required>
            <hr>
            <label for="id_turma">Nome da turma:</label>
            <?php if ($isUpdating): ?>
                <?php
                $nomeTurmaAtual = '';
                $idTurmaAtual = $alunoData['Turma_id_turma'] ?? '';
                if (!empty($idTurmaAtual) && isset($turmas) && is_array($turmas) && !empty($turmas)) {
                    foreach ($turmas as $turmaItem) {
                        if (isset($turmaItem['id_turma']) && $turmaItem['id_turma'] == $idTurmaAtual) {
                            $nomeTurmaAtual = $turmaItem['nomeTurma'] ?? '';
                            break;
                        }
                    }
                }
                ?>
                <input type="text" value="<?= htmlspecialchars($nomeTurmaAtual) ?>" readonly required>
                <input type="hidden" name="Turma_id_turma" value="<?= htmlspecialchars($idTurmaAtual) ?>">
                <hr>
            <?php else: ?>
                <select name="Turma_id_turma" required>
                    <option value="">Selecione uma turma</option>
                    <?php
                    if (isset($turmas) && is_array($turmas)) {
                        foreach ($turmas as $turmaItem):
                    ?>
                    <option value="<?= htmlspecialchars($turmaItem['id_turma']) ?>" <?= (isset($alunoData['Turma_id_turma']) && $alunoData['Turma_id_turma'] == $turmaItem['id_turma']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($turmaItem['nomeTurma']) ?>
                    </option>
                    <?php endforeach; } ?>
                </select>
                <hr>
            <?php endif; ?>
            
            <?php if ($isUpdating): ?>
                <label for="novaSenha">Nova Senha:</label>
                <input type="password" id="novaSenha" name="novaSenha" placeholder="Precisa implementar ainda..." readonly>
                <br><br>
                <input type="hidden" name="acao" value="atualizar">
            <?php else: ?>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Digite a senha" required><br><br>
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
