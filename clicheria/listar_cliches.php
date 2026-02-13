<?php
include '../BD/conexao.php';

// Parâmetros de paginação
$registrosPorPagina = 15;
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Parâmetros de filtro
$filtroCliente = isset($_GET['cliente']) ? $_GET['cliente'] : '';
$filtroProduto = isset($_GET['produto']) ? $_GET['produto'] : '';
$filtroCodigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';
$filtroArmario = isset($_GET['armario']) ? $_GET['armario'] : '';

// Construir query com filtros
$sql = "SELECT id_cliche, cliente, produto, codigo, armario, prateleira FROM tab_clicheria WHERE 1=1";
$params = [];
$types = "";

if (!empty($filtroCliente)) {
    $sql .= " AND cliente LIKE ?";
    $params[] = "%$filtroCliente%";
    $types .= "s";
}

if (!empty($filtroProduto)) {
    $sql .= " AND produto LIKE ?";
    $params[] = "%$filtroProduto%";
    $types .= "s";
}

if (!empty($filtroCodigo)) {
    $sql .= " AND codigo LIKE ?";
    $params[] = "%$filtroCodigo%";
    $types .= "s";
}

if (!empty($filtroArmario)) {
    $sql .= " AND armario = ?";
    $params[] = $filtroArmario;
    $types .= "s";
}

// Contar total de registros
$sqlCount = str_replace("SELECT id_cliche, cliente, produto, codigo, armario, prateleira", "SELECT COUNT(*) as total", $sql);
$stmtCount = $conn->prepare($sqlCount);

if (!empty($params)) {
    $stmtCount->bind_param($types, ...$params);
}

$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$totalRegistros = $resultCount->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
$stmtCount->close();

// Buscar registros com paginação
$sql .= " ORDER BY id_cliche DESC LIMIT ? OFFSET ?";
$params[] = $registrosPorPagina;
$params[] = $offset;
$types .= "ii";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$cliches = [];
while ($row = $result->fetch_assoc()) {
    $cliches[] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clichês Cadastrados</title>
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
            padding: 20px;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
            color: white;
            padding: 25px 30px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 20px;
        }

        .header-left {
            justify-self: start;
        }

        .header-center {
            justify-self: center;
        }

        .header-right {
            justify-self: end;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }

        .btn-voltar {
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-voltar:hover {
            background: white;
            color: #1976d2;
            transform: translateX(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-novo {
            padding: 12px 25px;
            background: white;
            color: #1976d2;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-novo:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .content {
            padding: 30px;
        }

        .filters-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .filters-form {
            display: flex;
            gap: 15px;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            color: #424242;
            font-weight: 500;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .filter-group input,
        .filter-group select {
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .btn-filtrar {
            padding: 10px 25px;
            background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            height: fit-content;
        }

        .btn-filtrar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
        }

        .btn-limpar {
            padding: 10px 25px;
            background: #757575;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            height: fit-content;
        }

        .btn-limpar:hover {
            background: #616161;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(117, 117, 117, 0.3);
        }

        .info-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #e3f2fd;
            border-radius: 8px;
        }

        .total-registros {
            color: #0d47a1;
            font-weight: 600;
            font-size: 14px;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .cliches-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .cliches-table thead {
            background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
            color: white;
        }

        .cliches-table th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .cliches-table th.actions-col {
            text-align: center;
            width: 280px;
        }

        .cliches-table tbody tr {
            border-bottom: 1px solid #e0e0e0;
            transition: all 0.2s ease;
        }

        .cliches-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .cliches-table tbody tr:hover {
            background: #e3f2fd;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(33, 150, 243, 0.15);
        }

        .cliches-table td {
            padding: 15px 12px;
            font-size: 14px;
            color: #424242;
        }

        .cliches-table td.cliente-col {
            font-weight: 600;
            color: #0d47a1;
        }

        .cliches-table td.codigo-col {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #1976d2;
        }

        .actions-cell {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }

        .btn-action {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-ver {
            background: #4caf50;
            color: white;
        }

        .btn-ver:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .btn-alterar {
            background: #ff9800;
            color: white;
        }

        .btn-alterar:hover {
            background: #f57c00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
        }

        .btn-excluir {
            background: #f44336;
            color: white;
        }

        .btn-excluir:hover {
            background: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 25px;
            padding: 20px;
        }

        .pagination a,
        .pagination button {
            padding: 10px 15px;
            border: 2px solid #1976d2;
            background: white;
            color: #1976d2;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .pagination a:hover:not(.disabled),
        .pagination button:hover:not(:disabled) {
            background: #1976d2;
            color: white;
        }

        .pagination a.disabled,
        .pagination button:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .pagination .page-info {
            color: #424242;
            font-weight: 600;
            padding: 0 15px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #757575;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 16px;
        }

        /* Responsivo */
        @media (max-width: 1024px) {
            .table-container {
                overflow-x: scroll;
            }

            .cliches-table {
                min-width: 900px;
            }
        }

        @media (max-width: 768px) {
            .header {
                grid-template-columns: 1fr;
                grid-template-rows: auto auto auto;
                gap: 15px;
                text-align: center;
                padding: 20px;
            }

            .header-left,
            .header-center,
            .header-right {
                justify-self: stretch;
            }

            .header-left {
                order: 1;
            }

            .header-center {
                order: 2;
            }

            .header-right {
                order: 3;
            }

            .btn-voltar,
            .btn-novo {
                width: 100%;
                justify-content: center;
            }

            .header h1 {
                font-size: 22px;
            }

            .content {
                padding: 15px;
            }

            .filters-form {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .btn-filtrar,
            .btn-limpar {
                width: 100%;
            }

            /* Tabela vira cards no mobile */
            .table-container {
                overflow-x: visible;
            }

            .cliches-table,
            .cliches-table thead,
            .cliches-table tbody,
            .cliches-table th,
            .cliches-table td,
            .cliches-table tr {
                display: block;
            }

            .cliches-table thead {
                display: none;
            }

            .cliches-table tbody tr {
                margin-bottom: 15px;
                border: 2px solid #e3f2fd;
                border-radius: 10px;
                padding: 15px;
                border-left: 4px solid #2196f3;
            }

            .cliches-table td {
                border: none;
                padding: 10px 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .cliches-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #0d47a1;
                flex: 0 0 40%;
            }

            .actions-cell {
                flex-direction: column;
                width: 100%;
                gap: 8px;
            }

            .actions-cell::before {
                content: '';
                display: none;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <button class="btn-voltar" onclick="voltarPagina()">
                    ◀ VOLTAR
                </button>
            </div>
            <div class="header-center">
                <h1>📋 Clichês Cadastrados</h1>
            </div>
            <div class="header-right">
                <button class="btn-novo" onclick="novoCadastro()">
                    ➕ Novo Cadastro
                </button>
            </div>
        </div>

        <div class="content">
            <!-- Filtros -->
            <div class="filters-section">
                <form method="GET" action="" class="filters-form">
                    <div class="filter-group">
                        <label for="filtroCliente">Cliente</label>
                        <input type="text" id="filtroCliente" name="cliente" placeholder="Buscar por cliente..." value="<?php echo htmlspecialchars($filtroCliente); ?>">
                    </div>
                    <div class="filter-group">
                        <label for="filtroProduto">Produto</label>
                        <input type="text" id="filtroProduto" name="produto" placeholder="Buscar por produto..." value="<?php echo htmlspecialchars($filtroProduto); ?>">
                    </div>
                    <div class="filter-group">
                        <label for="filtroCodigo">Código</label>
                        <input type="text" id="filtroCodigo" name="codigo" placeholder="Buscar por código..." value="<?php echo htmlspecialchars($filtroCodigo); ?>">
                    </div>
                    <div class="filter-group">
                        <label for="filtroArmario">Armário</label>
                        <select id="filtroArmario" name="armario">
                            <option value="">Todos</option>
                            <option value="1" <?php echo $filtroArmario == '1' ? 'selected' : ''; ?>>Armário 1</option>
                            <option value="2" <?php echo $filtroArmario == '2' ? 'selected' : ''; ?>>Armário 2</option>
                            <option value="3" <?php echo $filtroArmario == '3' ? 'selected' : ''; ?>>Armário 3</option>
                            <option value="4" <?php echo $filtroArmario == '4' ? 'selected' : ''; ?>>Armário 4</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-filtrar">
                        🔍 Filtrar
                    </button>
                    <button type="button" class="btn-limpar" onclick="limparFiltros()">
                        🔄 Limpar
                    </button>
                </form>
            </div>

            <!-- Info Bar -->
            <div class="info-bar">
                <span class="total-registros">
                    📊 Total de registros: <strong><?php echo $totalRegistros; ?></strong>
                </span>
            </div>

            <!-- Tabela -->
            <div class="table-container">
                <?php if (count($cliches) > 0): ?>
                <table class="cliches-table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Produto</th>
                            <th>Código</th>
                            <th>Armário</th>
                            <th>Prateleira</th>
                            <th class="actions-col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cliches as $cliche): ?>
                        <tr>
                            <td class="cliente-col" data-label="Cliente"><?php echo htmlspecialchars($cliche['cliente']); ?></td>
                            <td data-label="Produto"><?php echo htmlspecialchars($cliche['produto']); ?></td>
                            <td class="codigo-col" data-label="Código"><?php echo htmlspecialchars($cliche['codigo']); ?></td>
                            <td data-label="Armário"><?php echo htmlspecialchars($cliche['armario']); ?></td>
                            <td data-label="Prateleira"><?php echo htmlspecialchars($cliche['prateleira']); ?></td>
                            <td>
                                <div class="actions-cell">
                                    <a href="ver_cliche.php?id_cliche=<?php echo $cliche['id_cliche']; ?>" class="btn-action btn-ver">Ver</a>
                                    <a href="editar_cliche.php?id_cliche=<?php echo $cliche['id_cliche']; ?>" class="btn-action btn-alterar">Alterar</a>
                                    <button class="btn-action btn-excluir" onclick="excluirCliche(<?php echo $cliche['id_cliche']; ?>, '<?php echo htmlspecialchars($cliche['cliente']); ?>')">Excluir</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <h3>📭 Nenhum registro encontrado</h3>
                    <p>Não há clichês cadastrados com os filtros selecionados.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Paginação -->
            <?php if ($totalPaginas > 1): ?>
            <div class="pagination">
                <?php if ($paginaAtual > 1): ?>
                    <a href="?pagina=<?php echo $paginaAtual - 1; ?>&cliente=<?php echo urlencode($filtroCliente); ?>&produto=<?php echo urlencode($filtroProduto); ?>&codigo=<?php echo urlencode($filtroCodigo); ?>&armario=<?php echo urlencode($filtroArmario); ?>">
                        ◀ Anterior
                    </a>
                <?php else: ?>
                    <a class="disabled">◀ Anterior</a>
                <?php endif; ?>

                <span class="page-info">
                    Página <strong><?php echo $paginaAtual; ?></strong> de <strong><?php echo $totalPaginas; ?></strong>
                </span>

                <?php if ($paginaAtual < $totalPaginas): ?>
                    <a href="?pagina=<?php echo $paginaAtual + 1; ?>&cliente=<?php echo urlencode($filtroCliente); ?>&produto=<?php echo urlencode($filtroProduto); ?>&codigo=<?php echo urlencode($filtroCodigo); ?>&armario=<?php echo urlencode($filtroArmario); ?>">
                        Próxima ▶
                    </a>
                <?php else: ?>
                    <a class="disabled">Próxima ▶</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Função para voltar
        function voltarPagina() {
            window.location.href = '../principal.php';
        }

        // Função para novo cadastro
        function novoCadastro() {
            window.location.href = 'cad_clicheria.php';
        }

        // Função para limpar filtros
        function limparFiltros() {
            window.location.href = 'listar_cliches.php';
        }

        // Função para excluir clichê
        function excluirCliche(id, cliente) {
            if (confirm(`⚠️ ATENÇÃO!\n\nTem certeza que deseja EXCLUIR o clichê do cliente "${cliente}"?\n\nEsta ação não poderá ser desfeita!`)) {
                // Redireciona para o script de exclusão
                window.location.href = `excluir_cliche.php?id_cliche=${id}`;
            }
        }
    </script>
</body>
</html>