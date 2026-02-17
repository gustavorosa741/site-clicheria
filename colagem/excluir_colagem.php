<?php
include '../BD/conexao.php';

// Verifica se o ID foi passado
if (!isset($_GET['id_colagem']) || empty($_GET['id_colagem'])) {
    echo "<script>
        alert('❌ Erro: ID não fornecido!');
        window.location.href = 'listar_colagens.php';
    </script>";
    exit;
}

$id = (int)$_GET['id_colagem'];

// Verifica se o registro existe antes de excluir
$sqlVerifica = "SELECT produto FROM tab_nova_colagem WHERE id_colagem = ?";
$stmtVerifica = $conn->prepare($sqlVerifica);
$stmtVerifica->bind_param("i", $id);
$stmtVerifica->execute();
$resultVerifica = $stmtVerifica->get_result();

if ($resultVerifica->num_rows === 0) {
    echo "<script>
        alert('❌ Erro: Colagem não encontrada!');
        window.location.href = 'listar_colagens.php';
    </script>";
    $stmtVerifica->close();
    $conn->close();
    exit;
}

$dados = $resultVerifica->fetch_assoc();
$stmtVerifica->close();

// Executa a exclusão
$sql = "DELETE FROM tab_nova_colagem WHERE id_colagem = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>
        alert('✅ Colagem do produto \"{$dados['produto']}\" excluída com sucesso!');
        window.location.href = 'listar_colagens.php';
    </script>";
} else {
    echo "<script>
        alert('❌ Erro ao excluir colagem: " . addslashes($stmt->error) . "');
        window.location.href = 'listar_colagens.php';
    </script>";
}

$stmt->close();
$conn->close();
?>
