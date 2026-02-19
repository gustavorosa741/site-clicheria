<?php
include '../BD/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $produto = $_POST['produto'] ?? '';
        $codigo = $_POST['codigo'] ?? 0;
        $camisa = $_POST['camisa'] ?? 0;
        $valor_eng = $_POST['valor_eng'] ?? 0;
        $maquina = $_POST['maquina'] ?? '';
        $valor_pon = $_POST['valor_pon'] ?? 0;
        $familia = $_POST['familia'] ?? '';
        $cameron = isset($_POST['cameron']) ? 1 : 0;
        $distanciaCameron = $_POST['distanciaCameron'] ?? 0;
        $engcameron = $_POST['engcameron'] ?? 0;
        $maquinaCameron = $_POST['maquinaCameron'] ?? null;
        $ponCameron = $_POST['ponCameron'] ?? null;
        $distanciaCameron2 = $_POST['distanciaCameron2'] ?? 0;
        $observacoes = $_POST['observacoes'] ?? null;
        $colador = $_POST['colador'] ?? '';

        // Validar e tratar data corretamente
        if (isset($_POST['datacolagem']) && $_POST['datacolagem'] !== '') {
            $datacolagem = $_POST['datacolagem'];
        } else {
            $datacolagem = null;
        }
        echo "<pre>datacolagem final: " . var_export($datacolagem, true) . "</pre>";
        $cores = $_POST['cores'] ?? 0;

        $cor01 = $_POST['cor01'] ?? null;
        $cor02 = $_POST['cor02'] ?? null;
        $cor03 = $_POST['cor03'] ?? null;
        $cor04 = $_POST['cor04'] ?? null;
        $cor05 = $_POST['cor05'] ?? null;
        $cor06 = $_POST['cor06'] ?? null;
        $cor07 = $_POST['cor07'] ?? null;
        $cor08 = $_POST['cor08'] ?? null;
        $cor09 = $_POST['cor09'] ?? null;
        $cor10 = $_POST['cor10'] ?? null;

        $densidade01 = $_POST['densidade01'] ?? null;
        $densidade02 = $_POST['densidade02'] ?? null;
        $densidade03 = $_POST['densidade03'] ?? null;
        $densidade04 = $_POST['densidade04'] ?? null;
        $densidade05 = $_POST['densidade05'] ?? null;
        $densidade06 = $_POST['densidade06'] ?? null;
        $densidade07 = $_POST['densidade07'] ?? null;
        $densidade08 = $_POST['densidade08'] ?? null;
        $densidade09 = $_POST['densidade09'] ?? null;
        $densidade10 = $_POST['densidade10'] ?? null;

        $fornecedor01 = $_POST['fornecedor01'] ?? null;
        $fornecedor02 = $_POST['fornecedor02'] ?? null;
        $fornecedor03 = $_POST['fornecedor03'] ?? null;
        $fornecedor04 = $_POST['fornecedor04'] ?? null;
        $fornecedor05 = $_POST['fornecedor05'] ?? null;
        $fornecedor06 = $_POST['fornecedor06'] ?? null;
        $fornecedor07 = $_POST['fornecedor07'] ?? null;
        $fornecedor08 = $_POST['fornecedor08'] ?? null;
        $fornecedor09 = $_POST['fornecedor09'] ?? null;
        $fornecedor10 = $_POST['fornecedor10'] ?? null;

        // Validações básicas
        if (empty($produto) || empty($codigo) || empty($camisa) || empty($maquina) || empty($familia) || empty($colador)) {
            throw new Exception('Campos obrigatórios não preenchidos!');
        }

        if ($cores == 0) {
            throw new Exception('É necessário adicionar pelo menos uma cor!');
        }

        $sql = "INSERT INTO tab_nova_colagem (
            produto, codigo, camisa, valor_eng, maquina, valor_pon, familia, 
            cameron, distanciaCameron, engcameron, maquinaCameron, ponCameron, 
            distanciaCameron2, observacoes, colador, datacolagem, cores,
            cor01, cor02, cor03, cor04, cor05, cor06, cor07, cor08, cor09, cor10,
            densidade01, densidade02, densidade03, densidade04, densidade05, 
            densidade06, densidade07, densidade08, densidade09, densidade10,
            fornecedor01, fornecedor02, fornecedor03, fornecedor04, fornecedor05,
            fornecedor06, fornecedor07, fornecedor08, fornecedor09, fornecedor10
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "siiisisiiisisssssssssssssssssssssssssssssssssss",
            $produto, $codigo, $camisa, $valor_eng, $maquina, $valor_pon, $familia,
            $cameron, $distanciaCameron, $engcameron, $maquinaCameron, $ponCameron,
            $distanciaCameron2, $observacoes, $colador, $datacolagem, $cores,
            $cor01, $cor02, $cor03, $cor04, $cor05, $cor06, $cor07, $cor08, $cor09, $cor10,
            $densidade01, $densidade02, $densidade03, $densidade04, $densidade05,
            $densidade06, $densidade07, $densidade08, $densidade09, $densidade10,
            $fornecedor01, $fornecedor02, $fornecedor03, $fornecedor04, $fornecedor05,
            $fornecedor06, $fornecedor07, $fornecedor08, $fornecedor09, $fornecedor10
        );

        if ($stmt->execute()) {
            echo "<script>alert('Colagem cadastrada com sucesso!'); window.location.href='../principal.php';</script>";
        } else {
            throw new Exception('Erro ao executar a inserção no banco de dados.');
        }

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        echo "<script>alert('Erro ao salvar colagem: " . $e->getMessage() . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Colagem</title>
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
            background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
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
            padding: 10px 20px;
            color: #2196f3;
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
            color: #1976d2;
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
            color: #1976d2;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e3f2fd;
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
            border-color: #2196f3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 70px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #2196f3;
        }

        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
        }

        .cameron-section {
            background: #fff3e0;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #ff9800;
            margin-top: 15px;
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
            border: 2px solid #e3f2fd;
            border-radius: 8px;
        }

        .cores-table thead {
            background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
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
            background: #e3f2fd;
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
            color: #1976d2;
            text-align: center;
            width: 60px;
        }

        .cores-table input[type="text"],
        .cores-table select {
            width: 100%;
            padding: 6px 10px;
            font-size: 13px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            padding-top: 20px;
            border-top: 2px solid #e3f2fd;
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

        .btn-cadastrar {
            background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        }

        .btn-cadastrar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
        }

        .btn-limpar {
            background: white;
            color: #1976d2;
            border: 2px solid #1976d2;
        }

        .btn-limpar:hover {
            background: #f5f5f5;
        }

        .required {
            color: #f44336;
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
                border: 2px solid #e3f2fd;
                border-radius: 10px;
                padding: 15px;
                border-left: 4px solid #2196f3;
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

            .button-group {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }

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
            <button onclick="window.location.href='../principal.php'">VOLTAR</button>
            <h1>📋 Cadastro de Colagem</h1>
        </div>

        <div class="form-content">
            <form id="colagemForm" method="POST" action="">
                <input type="hidden" name="cores" id="coresInput" value="1">

                <!-- Informações Básicas -->
                <div class="form-section">
                    <h2 class="section-title">Informações Básicas</h2>
                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label for="produto">Produto <span class="required">*</span></label>
                            <input type="text" id="produto" name="produto" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Código <span class="required">*</span></label>
                            <input type="number" id="codigo" name="codigo" required>
                        </div>
                        <div class="form-group">
                            <label for="camisa">Camisa <span class="required">*</span></label>
                            <input type="number" id="camisa" name="camisa" required>
                        </div>
                        <div class="form-group">
                            <label for="familia">Família <span class="required">*</span></label>
                            <select id="familia" name="familia" required>
                                <option value="">Selecione...</option>
                                <option value="Família A">Família A</option>
                                <option value="Família B">Família B</option>
                                <option value="Família C">Família C</option>
                                <option value="Família D">Família D</option>
                                <option value="Família E">Família E</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="colador">Colador <span class="required">*</span></label>
                            <select id="colador" name="colador" required>
                                <option value="">Selecione...</option>
                                <option value="João Silva">João Silva</option>
                                <option value="Maria Santos">Maria Santos</option>
                                <option value="Pedro Oliveira">Pedro Oliveira</option>
                                <option value="Ana Costa">Ana Costa</option>
                                <option value="Carlos Souza">Carlos Souza</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="datacolagem">Data da Colagem</label>
                            <input type="date" id="datacolagem" name="datacolagem">
                        </div>
                        <div class="form-group">
                            <label for="numCores">Nº de Cores <span class="required">*</span></label>
                            <input type="number" id="numCores" name="numCores" value="1" min="1" max="10"
                                oninput="validarNumero(this)" required>
                        </div>
                    </div>
                </div>

                <!-- Configurações de Máquina -->
                <div class="form-section">
                    <h2 class="section-title">Configurações de Máquina</h2>
                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label for="maquina">Máquina <span class="required">*</span></label>
                            <select id="maquina" name="maquina" required>
                                <option value="">Selecione...</option>
                                <option value="Máquina 01">Máquina 01</option>
                                <option value="Máquina 02">Máquina 02</option>
                                <option value="Máquina 03">Máquina 03</option>
                                <option value="Máquina 04">Máquina 04</option>
                                <option value="Máquina 05">Máquina 05</option>
                            </select>
                        </div>
                        <div class="form-group span-2">
                            <label for="valor_eng">Valor ENG <span class="required">*</span></label>
                            <input type="number" id="valor_eng" name="valor_eng" required>
                        </div>
                        <div class="form-group span-2">
                            <label for="valor_pon">Valor PON <span class="required">*</span></label>
                            <input type="number" id="valor_pon" name="valor_pon" required>
                        </div>
                    </div>
                </div>

                <!-- Seção Cameron -->
                <div class="form-section">
                    <h2 class="section-title">Configurações Cameron</h2>
                    <div class="checkbox-group">
                        <input type="checkbox" id="cameron" name="cameron" value="1" onchange="toggleCameron()">
                        <label for="cameron">Utiliza Cameron</label>
                    </div>

                    <div id="cameronFields" class="cameron-section" style="display: none;">
                        <div class="form-grid">
                            <div class="form-group span-2">
                                <label for="distanciaCameron">Distância Cameron 1</label>
                                <input type="number" id="distanciaCameron" name="distanciaCameron">
                            </div>
                            <div class="form-group span-2">
                                <label for="engcameron">ENG Cameron</label>
                                <input type="number" id="engcameron" name="engcameron">
                            </div>
                            <div class="form-group span-2">
                                <label for="maquinaCameron">Máquina Cameron</label>
                                <select id="maquinaCameron" name="maquinaCameron">
                                    <option value="">Selecione...</option>
                                    <option value="Cameron 01">Cameron 01</option>
                                    <option value="Cameron 02">Cameron 02</option>
                                    <option value="Cameron 03">Cameron 03</option>
                                    <option value="Cameron 04">Cameron 04</option>
                                    <option value="Cameron 05">Cameron 05</option>
                                </select>
                            </div>
                            <div class="form-group span-2">
                                <label for="ponCameron">PON Cameron</label>
                                <input type="number" id="ponCameron" name="ponCameron">
                            </div>
                            <div class="form-group span-2">
                                <label for="distanciaCameron2">Distância Cameron 2</label>
                                <input type="number" id="distanciaCameron2" name="distanciaCameron2">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabela de Cores -->
                <div class="form-section">
                    <h2 class="section-title">Cores da Colagem</h2>
                    <div class="cores-table-container">
                        <table class="cores-table">
                            <thead>
                                <tr>
                                    <th>Cor</th>
                                    <th>Nome da Cor</th>
                                    <th>Densidade</th>
                                    <th>Fornecedor</th>
                                </tr>
                            </thead>
                            <tbody id="coresTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Observações -->
                <div class="form-section">
                    <h2 class="section-title">Observações</h2>
                    <div class="form-grid">
                        <div class="form-group span-6">
                            <label for="observacoes">Observações Adicionais</label>
                            <textarea id="observacoes" name="observacoes" rows="3"
                                placeholder="Digite aqui observações relevantes sobre a colagem..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="button-group">
                    <button type="button" class="btn-limpar" onclick="limparFormulario()">
                        🗑️ Limpar Campos
                    </button>
                    <button type="submit" class="btn-cadastrar">✓ Cadastrar Colagem</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleCameron() {
            const cameronCheckbox = document.getElementById('cameron');
            const cameronFields = document.getElementById('cameronFields');

            if (cameronCheckbox.checked) {
                cameronFields.style.display = 'block';
            } else {
                cameronFields.style.display = 'none';
            }
        }

        function gerarTabelaCores() {
            const tbody = document.getElementById('coresTableBody');
            tbody.innerHTML = '';

            const numCores = parseInt(document.getElementById('numCores').value) || 1;
            document.getElementById('coresInput').value = numCores;

            for (let i = 1; i <= numCores; i++) {
                const corNum = i.toString().padStart(2, '0');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="cor-numero" data-label="">Cor ${corNum}</td>
                    <td data-label="Nome da Cor">
                        <input type="text" id="cor${corNum}" name="cor${corNum}" placeholder="Nome da cor" required>
                    </td>
                    <td data-label="Densidade">
                        <select id="densidade${corNum}" name="densidade${corNum}" required>
                            <option value="">Selecione...</option>
                            <option value="100 L">100 L</option>
                            <option value="120 L">120 L</option>
                            <option value="150 L">150 L</option>
                            <option value="175 L">175 L</option>
                            <option value="200 L">200 L</option>
                        </select>
                    </td>
                    <td data-label="Fornecedor">
                        <select id="fornecedor${corNum}" name="fornecedor${corNum}" required>
                            <option value="">Selecione...</option>
                            <option value="Fornecedor A">Fornecedor A</option>
                            <option value="Fornecedor B">Fornecedor B</option>
                            <option value="Fornecedor C">Fornecedor C</option>
                            <option value="Fornecedor D">Fornecedor D</option>
                            <option value="Fornecedor E">Fornecedor E</option>
                        </select>
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

            gerarTabelaCores();
        }

        document.getElementById('numCores').addEventListener('change', gerarTabelaCores);

        function limparFormulario() {
            if (confirm('Deseja realmente limpar todos os campos?')) {
                document.getElementById('colagemForm').reset();
                document.getElementById('cameronFields').style.display = 'none';
                gerarTabelaCores();
            }
        }

        window.addEventListener('DOMContentLoaded', gerarTabelaCores);
    </script>
</body>

</html>