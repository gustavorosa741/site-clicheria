<?php
session_start(); // Inicia a sessão para permitir login e armazenamento de dados do usuário
include 'BD/conexao.php'; // Inclui o arquivo de conexão com o banco de dados

// Consulta para buscar todos os usuários cadastrados
$consulta_usuario = "SELECT * FROM usuario";
$resultado_usuario = $conn->query($consulta_usuario);

// Caso não existam usuários cadastrados, cria automaticamente o usuário padrão "admin"
if ($resultado_usuario->num_rows == 0) {
    $nome = 'admin';
    $usuario = 'admin';
    $senha = '1234';
    $permissao = '1';

    // Criptografa a senha padrão
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara e executa o comando para inserir o usuário admin
    $sql = "INSERT INTO usuario (nome, usuario, senha, nivel_acesso) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $usuario, $senha_hash, $permissao);

    // Verifica se o cadastro do admin foi bem-sucedido
    if ($stmt->execute()) {
        echo "<script>console.log('Usuário admin criado automaticamente');</script>";
    } else {
        echo "<script>console.error('Erro ao criar usuário admin: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

// Verifica se o formulário foi enviado via método POST (tentativa de login)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario']; // Recebe o usuário digitado
    $senha = $_POST['senha'];     // Recebe a senha digitada

    // Busca o usuário no banco pelo campo "usuario"
    $sql = "SELECT id, nome, senha, nivel_acesso FROM usuario WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se encontrou exatamente um usuário com esse nome
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nome, $senha_hash, $nivel_acesso);
        $stmt->fetch();

        // Verifica se a senha digitada confere com a senha armazenada (hash)
        if (password_verify($senha, $senha_hash)) {

            // Armazena dados do usuário na sessão
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['nivel_acesso'] = $nivel_acesso;

            // Redireciona para a página principal se o login for válido
            header("Location: ../pagina_principal.php");
            exit;

        } else {
            // Usuário encontrado, mas senha incorreta
            echo "<script>alert('Senha incorreta!');</script>";
        }
    } else {
        // Nenhum usuário com esse nome encontrado
        echo "<script>alert('Usuário não encontrado!');</script>";
    }

    $stmt->close();
}

$conn->close(); // Encerra a conexão com o banco de dados
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=0.7"> <!-- Ajuste responsivo -->
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f8ff;
        color: #003366;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 80vh;

    }

    h1 {
        margin-top: 40px;
        margin-bottom: 30px;
        font-size: 28px;
    }

    .form-container {
        background-color: white;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        width: 350px;
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 14px;
    }

    input[type="text"],
    input[type="password"],
    select {
        padding: 10px;
        border: 1px solid #253236;
        border-radius: 5px;
        font-size: 14px;
        color: #003366;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 15px;
    }

    input:focus,
    select:focus {
        border-color: #3399ff;
        box-shadow: 0 0 5px rgba(51, 153, 255, 0.5);
        outline: none;
    }

    button {
        padding: 12px;
        background-color: #3399ff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
    }

    button:hover {
        background-color: #267acc;
    }
</style>

<body>
    <img src="./assets/imagens/logo.jfif" alt="Logo" style="height: 100px;"> <!-- Logo da página -->
    <h1>Login</h1>

    <!-- Formulário de login -->
    <form class="form-container" action="" method="post">

        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Logar</button>

    </form>

</body>

</html>