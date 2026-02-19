<?php
// Ativar exibição de erros para debug (remover em produção)
ini_set('display_errors', 0);
error_reporting(E_ALL);

include '../BD/conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Verifica se é POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    // Verifica se o código foi enviado
    if (!isset($_POST['codigo']) || empty($_POST['codigo'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Código não fornecido'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $codigo = (int)$_POST['codigo'];

    if ($codigo <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Código inválido'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Verifica se o código já existe na tabela de clicheria
    $sql = "SELECT id_cliche, cliente, produto FROM tab_nova_clicheria WHERE codigo = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Erro ao preparar consulta: ' . $conn->error);
    }
    
    $stmt->bind_param("i", $codigo);
    
    if (!$stmt->execute()) {
        throw new Exception('Erro ao executar consulta: ' . $stmt->error);
    }
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Código encontrado
        $cliche = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'existe' => true,
            'message' => 'Código encontrado! Pode continuar o cadastro',
            'dados' => [
                'id' => $cliche['id_cliche'],
                'cliente' => $cliche['cliente'],
                'produto' => $cliche['produto']
            ]
        ], JSON_UNESCAPED_UNICODE);
    } else {
        // Código não encontrado
        echo json_encode([
            'success' => true,
            'existe' => false,
            'message' => 'Código não encontrado! É necessário cadastrar o clichê primeiro'
        ], JSON_UNESCAPED_UNICODE);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    // Retorna erro em formato JSON
    echo json_encode([
        'success' => false,
        'message' => 'Erro: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>