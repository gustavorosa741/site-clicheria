<?php
include '../BD/conexao.php';

// Verifica se o ID foi passado
if (!isset($_GET['id_cliche']) || empty($_GET['id_cliche'])) {
    echo "<script>
        alert('❌ Erro: ID não fornecido!');
        window.location.href = 'listar_cliches.php';
    </script>";
    exit;
}

$id = (int)$_GET['id_cliche'];

// Verifica se o registro existe antes de excluir
$sqlVerifica = "SELECT cliente, produto FROM tab_nova_clicheria WHERE id_cliche = ?";
$stmtVerifica = $conn->prepare($sqlVerifica);
$stmtVerifica->bind_param("i", $id);
$stmtVerifica->execute();
$resultVerifica = $stmtVerifica->get_result();

if ($resultVerifica->num_rows === 0) {
    echo "<script>
        alert('❌ Erro: Clichê não encontrado!');
        window.location.href = 'listar_cliches.php';
    </script>";
    $stmtVerifica->close();
    $conn->close();
    exit;
}

$dados = $resultVerifica->fetch_assoc();
$stmtVerifica->close();

// Executa a exclusão
$sql = "DELETE FROM tab_nova_clicheria WHERE id_cliche = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>
        alert('✅ Clichê do cliente \"{$dados['cliente']}\" excluído com sucesso!');
        window.location.href = 'listar_cliches.php';
    </script>";
} else {
    echo "<script>
        alert('❌ Erro ao excluir clichê: " . addslashes($stmt->error) . "');
        window.location.href = 'listar_cliches.php';
    </script>";
}

$stmt->close();
$conn->close();
?>