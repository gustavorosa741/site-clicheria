<?php
/**
 * Script de Teste de Conexão MySQL
 * Arquivo: teste_conexao.php
 */

// ====================================
// CONFIGURAÇÕES DO BANCO DE DADOS
// ====================================
// ALTERE ESTAS INFORMAÇÕES CONFORME SEU BANCO
$host = "localhost";        // Endereço do servidor MySQL
$usuario = "root";   // Usuário do banco
$senha = "1234#abcd";       // Senha do banco
$banco = "clicheria";       // Nome do banco de dados
$porta = 3306;              // Porta do MySQL (padrão: 3306)

echo "<h1>🔍 Teste de Conexão MySQL</h1>";
echo "<hr>";

// ====================================
// TESTE 1: Conexão com o servidor
// ====================================
echo "<h2>Teste 1: Conectando ao servidor MySQL...</h2>";

$conn = @new mysqli($host, $usuario, $senha, "", $porta);

if ($conn->connect_error) {
    echo "❌ <strong>ERRO na conexão com o servidor:</strong><br>";
    echo "Código do erro: " . $conn->connect_errno . "<br>";
    echo "Mensagem: " . $conn->connect_error . "<br>";
    echo "<br><strong>Possíveis causas:</strong><ul>";
    echo "<li>Servidor MySQL não está rodando</li>";
    echo "<li>Host incorreto (verifique se é 'localhost' ou '127.0.0.1')</li>";
    echo "<li>Usuário ou senha incorretos</li>";
    echo "<li>Porta incorreta (padrão: 3306)</li>";
    echo "<li>Firewall bloqueando a conexão</li>";
    echo "</ul>";
    exit;
}

echo "✅ <strong>Conexão com o servidor MySQL OK!</strong><br>";
echo "Servidor: " . $conn->host_info . "<br>";
echo "Versão do MySQL: " . $conn->server_info . "<br>";
echo "<br>";

// ====================================
// TESTE 2: Selecionando o banco de dados
// ====================================
echo "<h2>Teste 2: Selecionando o banco de dados '$banco'...</h2>";

if (!$conn->select_db($banco)) {
    echo "❌ <strong>ERRO ao selecionar o banco de dados:</strong><br>";
    echo "Mensagem: " . $conn->error . "<br>";
    echo "<br><strong>Possíveis causas:</strong><ul>";
    echo "<li>O banco de dados '$banco' não existe</li>";
    echo "<li>O usuário não tem permissão para acessar este banco</li>";
    echo "</ul>";
    echo "<br><strong>Solução:</strong> Crie o banco com o comando:<br>";
    echo "<code>CREATE DATABASE $banco;</code><br>";
    $conn->close();
    exit;
}

echo "✅ <strong>Banco de dados selecionado com sucesso!</strong><br>";
echo "Banco atual: " . $banco . "<br>";
echo "Charset da conexão: " . $conn->character_set_name() . "<br>";
echo "<br>";

// ====================================
// TESTE 3: Verificando tabelas
// ====================================
echo "<h2>Teste 3: Verificando tabelas no banco...</h2>";

$resultado = $conn->query("SHOW TABLES");

if (!$resultado) {
    echo "❌ <strong>ERRO ao listar tabelas:</strong> " . $conn->error . "<br>";
} else {
    $numTabelas = $resultado->num_rows;
    echo "✅ <strong>Total de tabelas encontradas: $numTabelas</strong><br><br>";
    
    if ($numTabelas > 0) {
        echo "<strong>Tabelas existentes:</strong><ul>";
        while ($row = $resultado->fetch_array()) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "⚠️ <em>Nenhuma tabela encontrada no banco.</em><br>";
    }
}
echo "<br>";

// ====================================
// TESTE 4: Verificando tabela 'cliches'
// ====================================
echo "<h2>Teste 4: Verificando tabela 'cliches'...</h2>";

$resultado = $conn->query("SHOW TABLES LIKE 'cliches'");

if ($resultado && $resultado->num_rows > 0) {
    echo "✅ <strong>Tabela 'cliches' existe!</strong><br><br>";
    
    // Mostra estrutura da tabela
    echo "<strong>Estrutura da tabela:</strong><br>";
    $estrutura = $conn->query("DESCRIBE cliches");
    
    if ($estrutura) {
        echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
        echo "<tr style='background-color: #667eea; color: white;'>";
        echo "<th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th>";
        echo "</tr>";
        
        while ($campo = $estrutura->fetch_assoc()) {
            echo "<tr>";
            echo "<td><strong>" . $campo['Field'] . "</strong></td>";
            echo "<td>" . $campo['Type'] . "</td>";
            echo "<td>" . $campo['Null'] . "</td>";
            echo "<td>" . $campo['Key'] . "</td>";
            echo "<td>" . ($campo['Default'] ?? '<em>NULL</em>') . "</td>";
            echo "<td>" . $campo['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    }
    
    // Conta registros
    $count = $conn->query("SELECT COUNT(*) as total FROM cliches");
    if ($count) {
        $total = $count->fetch_assoc();
        echo "<strong>Total de registros na tabela:</strong> " . $total['total'] . "<br>";
    }
    
} else {
    echo "❌ <strong>Tabela 'cliches' NÃO existe!</strong><br>";
    echo "<br><strong>Execute este SQL para criar a tabela:</strong><br>";
    echo "<textarea rows='20' cols='100' style='font-family: monospace; font-size: 12px;'>";
    echo "CREATE TABLE cliches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(255) NOT NULL,
    produtos VARCHAR(255) NOT NULL,
    codigo VARCHAR(100) NOT NULL,
    numero_cores VARCHAR(50) NOT NULL,
    armario VARCHAR(100),
    prateleira VARCHAR(100),
    camisa VARCHAR(100),
    observacoes TEXT,
    
    cor1 VARCHAR(100),
    cor2 VARCHAR(100),
    cor3 VARCHAR(100),
    cor4 VARCHAR(100),
    cor5 VARCHAR(100),
    cor6 VARCHAR(100),
    cor7 VARCHAR(100),
    cor8 VARCHAR(100),
    cor9 VARCHAR(100),
    cor10 VARCHAR(100),
    
    data_cores_01 DATE,
    data_cores_02 DATE,
    data_cores_03 DATE,
    data_cores_04 DATE,
    data_cores_05 DATE,
    data_cores_06 DATE,
    data_cores_07 DATE,
    data_cores_08 DATE,
    data_cores_09 DATE,
    data_cores_10 DATE,
    
    reserva_cor_01 VARCHAR(100),
    reserva_cor_02 VARCHAR(100),
    reserva_cor_03 VARCHAR(100),
    reserva_cor_04 VARCHAR(100),
    reserva_cor_05 VARCHAR(100),
    reserva_cor_06 VARCHAR(100),
    reserva_cor_07 VARCHAR(100),
    reserva_cor_08 VARCHAR(100),
    reserva_cor_09 VARCHAR(100),
    reserva_cor_10 VARCHAR(100),
    
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
    echo "</textarea><br>";
}
echo "<br>";

// ====================================
// TESTE 5: Teste de INSERT (simulado)
// ====================================
echo "<h2>Teste 5: Testando permissões de escrita...</h2>";

$testTable = "teste_conexao_temp_" . time();
$sqlCreate = "CREATE TEMPORARY TABLE $testTable (id INT, nome VARCHAR(50))";

if ($conn->query($sqlCreate)) {
    echo "✅ <strong>Permissão de CREATE: OK</strong><br>";
    
    $sqlInsert = "INSERT INTO $testTable (id, nome) VALUES (1, 'teste')";
    if ($conn->query($sqlInsert)) {
        echo "✅ <strong>Permissão de INSERT: OK</strong><br>";
        
        $sqlSelect = "SELECT * FROM $testTable";
        if ($result = $conn->query($sqlSelect)) {
            echo "✅ <strong>Permissão de SELECT: OK</strong><br>";
            $result->free();
        }
    }
    
    // Tabela temporária é destruída automaticamente
} else {
    echo "❌ <strong>Erro nas permissões:</strong> " . $conn->error . "<br>";
}
echo "<br>";

// ====================================
// INFORMAÇÕES DO SISTEMA
// ====================================
echo "<h2>📊 Informações do Sistema</h2>";
echo "<strong>Versão do PHP:</strong> " . phpversion() . "<br>";
echo "<strong>Extensão MySQLi:</strong> " . (extension_loaded('mysqli') ? '✅ Carregada' : '❌ Não carregada') . "<br>";
echo "<strong>Sistema Operacional:</strong> " . PHP_OS . "<br>";
echo "<strong>Servidor Web:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<br>";

// ====================================
// RESUMO FINAL
// ====================================
echo "<hr>";
echo "<h2>✅ RESUMO DO TESTE</h2>";
echo "<div style='background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px;'>";
echo "<strong>Conexão com MySQL: FUNCIONANDO!</strong><br>";
echo "Host: $host<br>";
echo "Usuário: $usuario<br>";
echo "Banco: $banco<br>";
echo "Porta: $porta<br>";
echo "<br>";
echo "Você pode usar estas configurações no seu script PHP principal.";
echo "</div>";

// Fechar conexão
$conn->close();
echo "<br><p><em>Conexão fechada com sucesso.</em></p>";

?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f5f5f5;
    }
    h1 { color: #333; }
    h2 { 
        color: #667eea; 
        margin-top: 20px;
        padding: 10px;
        background-color: #f0f0f0;
        border-left: 4px solid #667eea;
    }
    code {
        background-color: #f4f4f4;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
    }
    table {
        margin: 10px 0;
        font-size: 14px;
    }
    textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
    }
</style>
