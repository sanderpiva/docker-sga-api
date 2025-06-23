<?php
/**
 * Configuração centralizada do banco de dados
 * Este arquivo é utilizado pelos arquivos index.php e relatorio.php
 */

// Configurações para conexão com o banco MySQL
function getDbConfig() {
    return [
        'host'     => getenv('DB_HOST') ?: 'mysql',
        'dbname'   => getenv('DB_NAME') ?: 'gerenciamento_academico_completo',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: 'rootpassword',
        'options'  => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ];
}

/**
 * Função para conectar ao banco de dados
 * @return PDO|null Conexão PDO ou null em caso de erro
 */
function conectarBD() {
    $config = getDbConfig();
    
    try {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $conexao = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        return $conexao;
    } catch (PDOException $e) {
        error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
        return null;
    }
}

/**
 * Função para exibir erro de conexão
 * @param PDOException $e Exceção de conexão
 * @return string Mensagem de erro formatada
 */
function getDbErrorMessage($e) {
    return "<p class='error'>Erro de conexão com o banco de dados: " . $e->getMessage() . "</p>";
}
?>
