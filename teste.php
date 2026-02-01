<?php

include './BD/conexao.php';




if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $teste = $_POST['teste'];

    $sql = "INSERT INTO teste (teste) VALUES (?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $teste);

    if ($stmt->execute()) {
        echo "<script>alert('Categoria cadastrada com sucesso!');</script>";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

}
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teste</title>
</head>
<body>
    <form method="post" action="">
        <input type="text" id="teste" name="teste" placeholder="Digite o teste">
        <button type="submit">Cadastrar</button>
    </form>
    
</body>
</html>