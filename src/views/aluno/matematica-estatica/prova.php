<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'aluno') {
    header("Location: ../index.php"); // Redireciona para a home ou login se não for aluno logado
    exit(); // Interrompe a execução do script para evitar processamento indevido
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_unset(); // Remove todas as variáveis de sessão.
    session_destroy(); // Destrói a sessão.
    
    echo '<!DOCTYPE html>
          <html>
          <head>
              <title>Saindo...</title>
              <meta charset="utf-8">
              <link rel="stylesheet" href="../css/style.css">
          </head>
          <body class="servicos_forms">
              <div class="form_container">
                  <p>Você foi desconectado com sucesso!</p>
                  <p>Redirecionando para a HomePage...</p>
              </div>
              <script>
                  setTimeout(function() {
                      window.location.href = "../index.php";
                  }, 3000); // Redireciona após 3 segundos (3000 milissegundos).
              </script>
          </body>
          </html>';
    exit(); // Garante que nenhum outro conteúdo da página seja renderizado.
}

$nome_aluno_sessao = $_SESSION['nome_usuario'] ?? 'Nome Desconhecido';
$email_aluno_sessao = $_SESSION['email_usuario'] ?? 'email_desconhecido@example.com';
$turma_aluno_sessao = $_SESSION['nome_turma'] ?? 'Turma Desconhecida';
$id_aluno_sessao = $_SESSION['id_usuario'] ?? null; // Adicione o ID do aluno, se disponível na sessão.

global $conexao;

$aluno_ja_fez_prova = false;
$mensagem_alerta = "";

if ($email_aluno_sessao !== 'email_desconhecido@example.com') { // Garante que temos um email válido para checar.
    try {
        $sql_checa_prova = "SELECT COUNT(*) FROM tabeladados WHERE email = :email";
        $stmt_checa_prova = $conexao->prepare($sql_checa_prova);
        $stmt_checa_prova->bindParam(':email', $email_aluno_sessao, PDO::PARAM_STR);
        $stmt_checa_prova->execute();
        $count = $stmt_checa_prova->fetchColumn();

        if ($count > 0) {
            $aluno_ja_fez_prova = true;
            $mensagem_alerta = "<p style='color:orange; font-weight:bold; text-align: center;'>Você já realizou esta prova!</p>";
        }
    } catch (PDOException $e) {
        $mensagem_alerta = "<p style='color:red;'>Erro ao verificar status da prova. Tente novamente mais tarde.</p>";
        // Opcional: error_log("Erro PDO em prova.php (checar prova): " . $e->getMessage());
    }
} else {
    $mensagem_alerta = "<p style='color:red;'>Não foi possível verificar seu status na prova. Informações de login incompletas.</p>";
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Página Web - Prova</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        /* Estilos adicionais para desabilitar o formulário visualmente */
        .form.disabled {
            opacity: 0.7;
            pointer-events: none; /* Impede cliques em elementos dentro do form */
        }
    </style>
</head>

<body class="servicos_forms">

    <div class="form_container">
        <form class="form <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>" method="post" action="">
            <h2>Prova</h2>
            <hr>

            <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome_aluno_sessao); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email_aluno_sessao); ?></p>
            <p><strong>Turma:</strong> <?php echo htmlspecialchars($turma_aluno_sessao); ?></p>
            <hr>

            <input type="hidden" name="nome" value="<?php echo htmlspecialchars($nome_aluno_sessao); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email_aluno_sessao); ?>">
            <input type="hidden" name="turma" value="<?php echo htmlspecialchars($turma_aluno_sessao); ?>">

            <?php echo $mensagem_alerta; // Exibe a mensagem de alerta aqui ?>

            <h3>Questão 1</h3>
            <p>Qual o valor do quarto termo da PA: a1 = 2, r = 3?</p>
            <label>
                <input type="radio" name="q1" value="a" required <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> a) 11
            </label><br>
            <label>
                <input type="radio" name="q1" value="b" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> b) 6
            </label><br>
            <label>
                <input type="radio" name="q1" value="c" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> c) 7
            </label><br>
            <label>
                <input type="radio" name="q1" value="d" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> d) 8
            </label><br>
            <hr>

            <h3>Questão 2</h3>
            <p>Qual o valor do quarto termo da PG: a1 = 2, q = 2?</p>
            <label>
                <input type="radio" name="q2" value="a" required <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> a) 15
            </label><br>
            <label>
                <input type="radio" name="q2" value="b" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> b) 16
            </label><br>
            <label>
                <input type="radio" name="q2" value="c" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> c) 3
            </label><br>
            <label>
                <input type="radio" name="q2" value="d" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> d) 8
            </label><br>
            <hr>

            <h3>Questão 3</h3>
            <p>Quanto que é 20% de 200?</p>
            <label>
                <input type="radio" name="q3" value="a" required <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> a) 15
            </label><br>
            <label>
                <input type="radio" name="q3" value="b" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> b) 6
            </label><br>
            <label>
                <input type="radio" name="q3" value="c" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> c) 40
            </label><br>
            <label>
                <input type="radio" name="q3" value="d" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> d) 100
            </label><br>
            <hr>

            <h3>Questão 4</h3>
            <p>Se 2 operários produzem 10 blusas, 6 operários produzem?</p>
            <label>
                <input type="radio" name="q4" value="a" required <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> a) 15
            </label><br>
            <label>
                <input type="radio" name="q4" value="b" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> b) 6
            </label><br>
            <label>
                <input type="radio" name="q4" value="c" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> c) 7
            </label><br>
            <label>
                <input type="radio" name="q4" value="d" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>> d) 30
            </label><br>
            <hr>

            <button type="submit" <?php echo $aluno_ja_fez_prova ? 'disabled' : ''; ?>>Enviar Prova</button>
        </form>

        <?php
        // Processamento do formulário de submissão da prova
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $re_aluno_ja_fez_prova = false;
            if ($email_aluno_sessao !== 'email_desconhecido@example.com') {
                try {
                    $sql_re_checa_prova = "SELECT COUNT(*) FROM tabeladados WHERE email = :email";
                    $stmt_re_checa_prova = $conexao->prepare($sql_re_checa_prova);
                    $stmt_re_checa_prova->bindParam(':email', $email_aluno_sessao, PDO::PARAM_STR);
                    $stmt_re_checa_prova->execute();
                    if ($stmt_re_checa_prova->fetchColumn() > 0) {
                        $re_aluno_ja_fez_prova = true;
                    }
                } catch (PDOException $e) {
                    // Logar erro, mas não impedir a submissão se a verificação falhou
                    error_log("Erro PDO em prova.php (re-checar prova): " . $e->getMessage());
                }
            }

            if ($re_aluno_ja_fez_prova) {
                echo "<p style='color:red; font-weight:bold; text-align: center;'>Você já realizou esta prova. Não é possível enviá-la novamente.</p>";
            } else {
                // Se o aluno NÃO fez a prova, procede com o processamento normal
                $nome = $_POST["nome"] ?? '';
                $email = $_POST["email"] ?? '';
                $turma = $_POST["turma"] ?? '';

                $q1 = $_POST["q1"] ?? '';
                $q2 = $_POST["q2"] ?? '';
                $q3 = $_POST["q3"] ?? '';
                $q4 = $_POST["q4"] ?? '';

                if (empty($q1) || empty($q2) || empty($q3) || empty($q4)) {
                    echo "<p style='color:red;'>Por favor, responda todas as questões antes de enviar.</p>";
                } else {
                    $gabarito = array(
                        "q1" => "a", "q2" => "b", "q3" => "c", "q4" => "d"
                    );

                    $acertos = 0;
                    if ($q1 == $gabarito["q1"]) $acertos++;
                    if ($q2 == $gabarito["q2"]) $acertos++;
                    if ($q3 == $gabarito["q3"]) $acertos++;
                    if ($q4 == $gabarito["q4"]) $acertos++;

                    $porcentagem = ($acertos / 4) * 100;
                    $media = $porcentagem / 10;

                    echo "<h3>Resultados da Prova:</h3>";
                    echo "<p><strong>Nome:</strong> " . htmlspecialchars($nome) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
                    echo "<p><strong>Turma:</strong> " . htmlspecialchars($turma) . "</p>";
                    echo "<p>Questão 1: " . htmlspecialchars($q1) . " (Gabarito: " . $gabarito["q1"] . ")</p>";
                    echo "<p>Questão 2: " . htmlspecialchars($q2) . " (Gabarito: " . $gabarito["q2"] . ")</p>";
                    echo "<p>Questão 3: " . htmlspecialchars($q3) . " (Gabarito: " . $gabarito["q3"] . ")</p>";
                    echo "<p>Questão 4: " . htmlspecialchars($q4) . " (Gabarito: " . $gabarito["q4"] . ")</p>";
                    echo "<p>Porcentagem de acertos: " . $porcentagem . "%</p>";
                    echo "<p>Média (0-10): " . number_format($media, 1) . "</p>";

                    if ($porcentagem == 100) {
                        echo "<p style='color:green; font-weight:bold;'>Parabéns! Você gabaritou a prova!</p>";
                    } elseif ($porcentagem >= 70) {
                        echo "<p style='color:blue; font-weight:bold;'>Sucesso! Você foi aprovado!</p>";
                    } else {
                        echo "<p style='color:red; font-weight:bold;'>Que pena, você não foi aprovado nesta prova. Estude mais!</p>";
                    }

                    try {
                        $sql = "INSERT INTO tabeladados (nome, email, q1, q2, q3, q4, nota, turma)
                                VALUES (:nome, :email, :q1, :q2, :q3, :q4, :media, :turma)";
                        $stmt = $conexao->prepare($sql);
                        
                        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->bindParam(':q1', $q1, PDO::PARAM_STR);
                        $stmt->bindParam(':q2', $q2, PDO::PARAM_STR);
                        $stmt->bindParam(':q3', $q3, PDO::PARAM_STR);
                        $stmt->bindParam(':q4', $q4, PDO::PARAM_STR);
                        $stmt->bindParam(':media', $media, PDO::PARAM_STR);
                        $stmt->bindParam(':turma', $turma, PDO::PARAM_STR);
                        
                        $stmt->execute();
                        
                        if ($stmt->rowCount() > 0) {
                            echo "<p style='color:green;'>Resultado da prova salvo com sucesso no banco de dados!</p>";
                        } else {
                            echo "<p style='color:orange;'>Erro: Nenhum dado foi inserido (pode ser duplicidade ou outro problema no DB).</p>";
                        }
                    } catch (PDOException $e) {
                        error_log("Erro PDO em prova.php ao salvar resultados: " . $e->getMessage());
                        echo "<p style='color:red;'>Erro ao salvar o resultado da prova. Por favor, tente novamente mais tarde.</p>";
                    }
                }
            }
        }
        ?>
    </div>
    <a class="btn_dashboard" href="?logout=true">Logout -> Home</a>

</body>
<footer style="text-align: center; margin-top: 20px; padding: 10px; background-color: #f4f4f4;">
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>