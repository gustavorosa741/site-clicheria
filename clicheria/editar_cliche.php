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

$id = (int) $_GET['id_cliche'];

// Processar atualização se for POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = $_POST["cliente"];
    $produto = $_POST["produto"];
    $codigo = $_POST["codigo"];
    $armario = $_POST["armario"];
    $prateleira = $_POST["prateleira"];
    $cores = $_POST["cores"];

    $cor01 = $_POST["cor01"] ?? null;
    $cor02 = $_POST['cor02'] ?? null;
    $cor03 = $_POST["cor03"] ?? null;
    $cor04 = $_POST["cor04"] ?? null;
    $cor05 = $_POST["cor05"] ?? null;
    $cor06 = $_POST["cor06"] ?? null;
    $cor07 = $_POST["cor07"] ?? null;
    $cor08 = $_POST["cor08"] ?? null;
    $cor09 = $_POST["cor09"] ?? null;
    $cor10 = $_POST["cor10"] ?? null;

    $gravacao01 = $_POST["gravacao01"] ?? null;
    $gravacao02 = $_POST["gravacao02"] ?? null;
    $gravacao03 = $_POST["gravacao03"] ?? null;
    $gravacao04 = $_POST["gravacao04"] ?? null;
    $gravacao05 = $_POST["gravacao05"] ?? null;
    $gravacao06 = $_POST["gravacao06"] ?? null;
    $gravacao07 = $_POST["gravacao07"] ?? null;
    $gravacao08 = $_POST["gravacao08"] ?? null;
    $gravacao09 = $_POST["gravacao09"] ?? null;
    $gravacao10 = $_POST["gravacao10"] ?? null;

    $reserva01 = isset($_POST["reserva01"]) ? 1 : 0;
    $reserva02 = isset($_POST["reserva02"]) ? 1 : 0;
    $reserva03 = isset($_POST["reserva03"]) ? 1 : 0;
    $reserva04 = isset($_POST["reserva04"]) ? 1 : 0;
    $reserva05 = isset($_POST["reserva05"]) ? 1 : 0;
    $reserva06 = isset($_POST["reserva06"]) ? 1 : 0;
    $reserva07 = isset($_POST["reserva07"]) ? 1 : 0;
    $reserva08 = isset($_POST["reserva08"]) ? 1 : 0;
    $reserva09 = isset($_POST["reserva09"]) ? 1 : 0;
    $reserva10 = isset($_POST["reserva10"]) ? 1 : 0;

    $observacao = $_POST["observacao"];
    $camisa = $_POST["camisa"];

    $sql = "UPDATE tab_nova_clicheria SET 
            cliente = ?, produto = ?, codigo = ?, armario = ?, prateleira = ?, cores = ?,
            cor01 = ?, cor02 = ?, cor03 = ?, cor04 = ?, cor05 = ?, cor06 = ?, cor07 = ?, cor08 = ?, cor09 = ?, cor10 = ?,
            gravacao01 = ?, gravacao02 = ?, gravacao03 = ?, gravacao04 = ?, gravacao05 = ?, gravacao06 = ?, gravacao07 = ?, gravacao08 = ?, gravacao09 = ?, gravacao10 = ?,
            reserva01 = ?, reserva02 = ?, reserva03 = ?, reserva04 = ?, reserva05 = ?, reserva06 = ?, reserva07 = ?, reserva08 = ?, reserva09 = ?, reserva10 = ?,
            observacao = ?, camisa = ?
            WHERE id_cliche = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssisssssssssssssssssssssssiiiiiiiiiissi",
        $cliente,
        $produto,
        $codigo,
        $armario,
        $prateleira,
        $cores,
        $cor01,
        $cor02,
        $cor03,
        $cor04,
        $cor05,
        $cor06,
        $cor07,
        $cor08,
        $cor09,
        $cor10,
        $gravacao01,
        $gravacao02,
        $gravacao03,
        $gravacao04,
        $gravacao05,
        $gravacao06,
        $gravacao07,
        $gravacao08,
        $gravacao09,
        $gravacao10,
        $reserva01,
        $reserva02,
        $reserva03,
        $reserva04,
        $reserva05,
        $reserva06,
        $reserva07,
        $reserva08,
        $reserva09,
        $reserva10,
        $observacao,
        $camisa,
        $id
    );

    if ($stmt->execute()) {
        echo "<script>alert('✅ Clichê atualizado com sucesso!'); window.location.href='listar_cliches.php';</script>";
    } else {
        echo "<script>alert('❌ Erro ao atualizar clichê: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Buscar dados do clichê
$sql = "SELECT * FROM tab_nova_clicheria WHERE id_cliche = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
        alert('❌ Erro: Clichê não encontrado!');
        window.location.href = 'listar_cliches.php';
    </script>";
    $stmt->close();
    $conn->close();
    exit;
}

$cliche = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Clichê</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            min-height: 100vh;
            padding: 15px;
        }

        .container {
            max-width: 1880px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: calc(100vh - 30px);
            display: flex;
            flex-direction: column;
        }

        .header {
            background: linear-gradient(135deg, #ff9800 0%, #fb8c00 100%);
            color: white;
            padding: 20px 30px;
            text-align: center;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .header button {
            display: flex;
            align-items: center;
            position: absolute;
            left: 30px;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            gap: 8px;
        }

        .header button:hover {
            background: white;
            color: #ff9800;
            transform: translateX(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .form-content {
            padding: 25px 30px;
            overflow-y: auto;
            flex: 1;
        }

        .form-section {
            margin-bottom: 25px;
        }

        .section-title {
            color: #ff9800;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #ffe0b2;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.span-2 {
            grid-column: span 2;
        }

        .form-group.span-3 {
            grid-column: span 3;
        }

        .form-group.span-6 {
            grid-column: span 6;
        }

        label {
            color: #424242;
            font-weight: 500;
            margin-bottom: 6px;
            font-size: 13px;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            padding: 8px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #ff9800;
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 70px;
        }

        /* Tabela de Cores */
        .cores-table-container {
            overflow-x: auto;
            margin-bottom: 15px;
        }

        .cores-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 2px solid #ffe0b2;
            border-radius: 8px;
        }

        .cores-table thead {
            background: linear-gradient(135deg, #ff9800 0%, #fb8c00 100%);
            color: white;
        }

        .cores-table th {
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cores-table th:last-child {
            border-right: none;
        }

        .cores-table tbody tr {
            border-bottom: 1px solid #e0e0e0;
        }

        .cores-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .cores-table tbody tr:hover {
            background: #ffe0b2;
        }

        .cores-table td {
            padding: 10px;
            border-right: 1px solid #e0e0e0;
        }

        .cores-table td:last-child {
            border-right: none;
        }

        .cores-table td.cor-numero {
            font-weight: 600;
            color: #ff9800;
            text-align: center;
            width: 60px;
        }

        .cores-table input[type="text"],
        .cores-table input[type="date"] {
            width: 100%;
            padding: 6px 10px;
            font-size: 13px;
        }

        .checkbox-cell {
            text-align: center;
            width: 80px;
        }

        .checkbox-cell input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #ff9800;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            padding-top: 20px;
            border-top: 2px solid #ffe0b2;
        }

        button {
            padding: 12px 35px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-salvar {
            background: linear-gradient(135deg, #ff9800 0%, #fb8c00 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
        }

        .btn-salvar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 152, 0, 0.4);
        }

        .btn-cancelar {
            background: white;
            color: #ff9800;
            border: 2px solid #ff9800;
        }

        .btn-cancelar:hover {
            background: #fff3e0;
        }

        /* Mobile Layout */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                height: auto;
                min-height: calc(100vh - 20px);
            }

            .header h1 {
                font-size: 22px;
            }

            .form-content {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .form-group.span-2,
            .form-group.span-3,
            .form-group.span-6 {
                grid-column: span 1;
            }

            /* Tabela vira cards no mobile */
            .cores-table-container {
                overflow-x: visible;
            }

            .cores-table,
            .cores-table thead,
            .cores-table tbody,
            .cores-table th,
            .cores-table td,
            .cores-table tr {
                display: block;
            }

            .cores-table thead {
                display: none;
            }

            .cores-table tbody tr {
                margin-bottom: 15px;
                background: #f5f5f5;
                border: 2px solid #ffe0b2;
                border-radius: 10px;
                padding: 15px;
                border-left: 4px solid #ff9800;
            }

            .cores-table td {
                border: none;
                padding: 8px 0;
                display: flex;
                flex-direction: column;
            }

            .cores-table td.cor-numero {
                font-size: 16px;
                margin-bottom: 10px;
                text-align: left;
            }

            .cores-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #424242;
                margin-bottom: 5px;
                font-size: 12px;
            }

            .cores-table td.cor-numero::before {
                content: '';
                display: none;
            }

            .checkbox-cell {
                width: 100%;
                text-align: left;
            }

            .checkbox-cell input[type="checkbox"] {
                margin-top: 5px;
            }

            .button-group {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }

        /* Ajuste para telas médias (tablets) */
        @media (min-width: 769px) and (max-width: 1366px) {
            .form-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <button onclick="window.location.href='listar_cliches.php'">◀ VOLTAR</button>
            <h1>✏️ Editar Clichê</h1>
        </div>

        <div class="form-content">
            <form id="clicheForm" method="post" action="">
                <div class="form-section">
                    <h2 class="section-title">Informações Básicas</h2>
                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label for="cliente">Cliente *</label>
                            <input type="text" id="cliente" name="cliente"
                                value="<?php echo htmlspecialchars($cliche['cliente']); ?>" required>
                        </div>
                        <div class="form-group span-2">
                            <label for="produto">Produto *</label>
                            <input type="text" id="produto" name="produto"
                                value="<?php echo htmlspecialchars($cliche['produto']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Código *</label>
                            <input type="number" pattern="[0-9]+" id="codigo" name="codigo"
                                value="<?php echo htmlspecialchars($cliche['codigo']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="cores">Nº de Cores *</label>
                            <input type="number" id="cores" name="cores"
                                value="<?php echo htmlspecialchars($cliche['cores']); ?>" min="1" max="10"
                                oninput="validarNumero(this)" required>
                        </div>
                        <div class="form-group">
                            <label for="armario">Armário</label>
                            <input type="text" id="armario" name="armario"
                                value="<?php echo htmlspecialchars($cliche['armario']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prateleira">Prateleira</label>
                            <input type="text" id="prateleira" name="prateleira"
                                value="<?php echo htmlspecialchars($cliche['prateleira']); ?>" required>
                        </div>
                        <div class="form-group span-2">
                            <label for="camisa">Camisa</label>
                            <input type="text" id="camisa" name="camisa"
                                value="<?php echo htmlspecialchars($cliche['camisa']); ?>" required>
                        </div>
                        <div class="form-group span-2">
                            <label for="observacoes">Observações</label>
                            <textarea id="observacoes" name="observacao"
                                rows="2"><?php echo htmlspecialchars($cliche['observacao']); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Cores do Clichê</h2>
                    <div class="cores-table-container">
                        <table class="cores-table">
                            <thead>
                                <tr>
                                    <th>Cor</th>
                                    <th>Nome da Cor</th>
                                    <th>Data de Gravação</th>
                                    <th>Reserva</th>
                                </tr>
                            </thead>
                            <tbody id="coresTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" class="btn-cancelar"
                        onclick="if(confirm('Deseja cancelar a edição? Todas as alterações serão perdidas.')) window.location.href='listar_cliches.php'">
                        ✕ Cancelar
                    </button>
                    <button type="submit" class="btn-salvar">✓ Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Dados do PHP para JavaScript
        const clicheData = <?php echo json_encode($cliche); ?>;

        // Gerar linhas da tabela de cores
        function gerarTabelaCores() {
            const tbody = document.getElementById('coresTableBody');
            tbody.innerHTML = '';

            // Captura o valor do input de número de cores
            const numCores = parseInt(document.getElementById('cores').value) || 10;

            for (let i = 1; i <= numCores; i++) {
                const corNum = i.toString().padStart(2, '0');
                const corField = `cor${corNum}`;
                const gravacaoField = `gravacao${corNum}`;
                const reservaField = `reserva${corNum}`;

                const corValue = clicheData[corField] || '';
                const gravacaoValue = clicheData[gravacaoField] || '';
                const reservaValue = clicheData[reservaField] == 1 ? 'checked' : '';

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="cor-numero" data-label="">Cor ${corNum}</td>
                    <td data-label="Nome da Cor">
                        <input type="text" id="cor${corNum}" name="cor${corNum}" value="${corValue}" placeholder="Nome da cor">
                    </td>
                    <td data-label="Data de Gravação">
                        <input type="date" id="gravacao${corNum}" name="gravacao${corNum}" value="${gravacaoValue}" placeholder="dd/mm/aaaa">
                    </td>
                    <td class="checkbox-cell" data-label="Reserva">
                        <input type="checkbox" id="reserva${corNum}" name="reserva${corNum}" value="1" ${reservaValue}>
                    </td>
                `;
                tbody.appendChild(tr);
            }
        }

        function validarNumero(input) {
            let valor = parseInt(input.value);

            if (valor > 10) {
                input.value = 10;
            } else if (valor < 1) {
                input.value = 1;
            }

            // Atualiza a tabela quando mudar
            gerarTabelaCores();
        }

        // Chama a função quando o valor do input mudar
        document.getElementById('cores').addEventListener('change', gerarTabelaCores);

        // Gera a tabela inicial ao carregar a página
        window.addEventListener('DOMContentLoaded', gerarTabelaCores);
    </script>
</body>

</html>