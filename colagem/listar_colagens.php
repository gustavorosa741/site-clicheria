<?php
include '../BD/conexao.php';

// Parâmetros de paginação
$registrosPorPagina = 15;
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Parâmetros de filtro
$filtroProduto = isset($_GET['produto']) ? $_GET['produto'] : '';
$filtroCodigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';
$filtroFamilia = isset($_GET['familia']) ? $_GET['familia'] : '';
$filtroColador = isset($_GET['colador']) ? $_GET['colador'] : '';

// Construir query com filtros
$sql = "SELECT id_colagem, produto, codigo, camisa, familia, colador, datacolagem FROM tab_nova_colagem WHERE 1=1";
$params = [];
$types = "";

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

if (!empty($filtroFamilia)) {
    $sql .= " AND familia = ?";
    $params[] = $filtroFamilia;
    $types .= "s";
}

if (!empty($filtroColador)) {
    $sql .= " AND colador = ?";
    $params[] = $filtroColador;
    $types .= "s";
}

// Contar total de registros
$sqlCount = str_replace("SELECT id_colagem, produto, codigo, camisa, familia, colador, datacolagem", "SELECT COUNT(*) as total", $sql);
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
$sql .= " ORDER BY id_colagem DESC LIMIT ? OFFSET ?";
$params[] = $registrosPorPagina;
$params[] = $offset;
$types .= "ii";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$colagens = [];
while ($row = $result->fetch_assoc()) {
    $colagens[] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Colagens Cadastradas</title>
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
        }

        .btn-filtrar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
        }

        .btn-limpar {
            padding: 10px 25px;
            background: white;
            color: #1976d2;
            border: 2px solid #1976d2;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-limpar:hover {
            background: #f5f5f5;
        }

        .info-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #e3f2fd;
        }

        .total-registros {
            font-size: 14px;
            color: #424242;
        }

        .table-container {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .colagens-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .colagens-table thead {
            background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
            color: white;
        }

        .colagens-table th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .colagens-table th:last-child {
            border-right: none;
        }

        .colagens-table tbody tr {
            border-bottom: 1px solid #e0e0e0;
            transition: background 0.2s ease;
        }

        .colagens-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .colagens-table tbody tr:hover {
            background: #e3f2fd;
        }

        .colagens-table td {
            padding: 12px;
            font-size: 14px;
            color: #424242;
            border-right: 1px solid #f0f0f0;
        }

        .colagens-table td:last-child {
            border-right: none;
        }

        .produto-col {
            font-weight: 600;
            color: #1976d2;
        }

        .codigo-col {
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .actions-col {
            width: 200px;
            text-align: center;
        }

        .actions-cell {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-ver {
            background: #2196f3;
            color: white;
        }

        .btn-ver:hover {
            background: #1976d2;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(33, 150, 243, 0.3);
        }

        .btn-alterar {
            background: #ff9800;
            color: white;
        }

        .btn-alterar:hover {
            background: #f57c00;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(255, 152, 0, 0.3);
        }

        .btn-excluir {
            background: #f44336;
            color: white;
        }

        .btn-excluir:hover {
            background: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(244, 67, 54, 0.3);
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
            font-size: 14px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            padding: 20px;
        }

        .pagination a {
            padding: 10px 20px;
            background: #1976d2;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: #0d47a1;
            transform: translateY(-2px);
        }

        .pagination a.disabled {
            background: #e0e0e0;
            color: #9e9e9e;
            cursor: not-allowed;
            pointer-events: none;
        }

        .page-info {
            color: #424242;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .header {
                grid-template-columns: 1fr;
                gap: 15px;
                justify-content: center;
            }

            .header-left,
            .header-center,
            .header-right {
                justify-self: center;
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

            .table-container {
                overflow-x: visible;
            }

            .colagens-table,
            .colagens-table thead,
            .colagens-table tbody,
            .colagens-table th,
            .colagens-table td,
            .colagens-table tr {
                display: block;
            }

            .colagens-table thead {
                display: none;
            }

            .colagens-table tbody tr {
                margin-bottom: 15px;
                border: 2px solid #e3f2fd;
                border-radius: 10px;
                padding: 15px;
                border-left: 4px solid #2196f3;
            }

            .colagens-table td {
                border: none;
                padding: 10px 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .colagens-table td::before {
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
                <h1>📋 Colagens Cadastradas</h1>
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
                        <label for="filtroProduto">Produto</label>
                        <input type="text" id="filtroProduto" name="produto" placeholder="Buscar por produto..." value="<?php echo htmlspecialchars($filtroProduto); ?>">
                    </div>
                    <div class="filter-group">
                        <label for="filtroCodigo">Código</label>
                        <input type="text" id="filtroCodigo" name="codigo" placeholder="Buscar por código..." value="<?php echo htmlspecialchars($filtroCodigo); ?>">
                    </div>
                    <div class="filter-group">
                        <label for="filtroFamilia">Família</label>
                        <select id="filtroFamilia" name="familia">
                            <option value="">Todas</option>
                            <option value="Família A" <?php echo $filtroFamilia == 'Família A' ? 'selected' : ''; ?>>Família A</option>
                            <option value="Família B" <?php echo $filtroFamilia == 'Família B' ? 'selected' : ''; ?>>Família B</option>
                            <option value="Família C" <?php echo $filtroFamilia == 'Família C' ? 'selected' : ''; ?>>Família C</option>
                            <option value="Família D" <?php echo $filtroFamilia == 'Família D' ? 'selected' : ''; ?>>Família D</option>
                            <option value="Família E" <?php echo $filtroFamilia == 'Família E' ? 'selected' : ''; ?>>Família E</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="filtroColador">Colador</label>
                        <select id="filtroColador" name="colador">
                            <option value="">Todos</option>
                            <option value="João Silva" <?php echo $filtroColador == 'João Silva' ? 'selected' : ''; ?>>João Silva</option>
                            <option value="Maria Santos" <?php echo $filtroColador == 'Maria Santos' ? 'selected' : ''; ?>>Maria Santos</option>
                            <option value="Pedro Oliveira" <?php echo $filtroColador == 'Pedro Oliveira' ? 'selected' : ''; ?>>Pedro Oliveira</option>
                            <option value="Ana Costa" <?php echo $filtroColador == 'Ana Costa' ? 'selected' : ''; ?>>Ana Costa</option>
                            <option value="Carlos Souza" <?php echo $filtroColador == 'Carlos Souza' ? 'selected' : ''; ?>>Carlos Souza</option>
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
                <?php if (count($colagens) > 0): ?>
                <table class="colagens-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Código</th>
                            <th>Camisa</th>
                            <th>Família</th>
                            <th>Colador</th>
                            <th>Data</th>
                            <th class="actions-col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($colagens as $colagem): ?>
                        <tr>
                            <td class="produto-col" data-label="Produto"><?php echo htmlspecialchars($colagem['produto']); ?></td>
                            <td class="codigo-col" data-label="Código"><?php echo htmlspecialchars($colagem['codigo']); ?></td>
                            <td data-label="Camisa"><?php echo htmlspecialchars($colagem['camisa']); ?></td>
                            <td data-label="Família"><?php echo htmlspecialchars($colagem['familia']); ?></td>
                            <td data-label="Colador"><?php echo htmlspecialchars($colagem['colador']); ?></td>
                            <td data-label="Data"><?php echo $colagem['datacolagem'] ? date('d/m/Y', strtotime($colagem['datacolagem'])) : '-'; ?></td>
                            <td>
                                <div class="actions-cell">
                                    <a href="ver_colagem.php?id_colagem=<?php echo $colagem['id_colagem']; ?>" class="btn-action btn-ver">Ver</a>
                                    <a href="editar_colagem.php?id_colagem=<?php echo $colagem['id_colagem']; ?>" class="btn-action btn-alterar">Alterar</a>
                                    <button class="btn-action btn-excluir" onclick="excluirColagem(<?php echo $colagem['id_colagem']; ?>, '<?php echo htmlspecialchars($colagem['produto']); ?>')">Excluir</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <h3>📭 Nenhum registro encontrado</h3>
                    <p>Não há colagens cadastradas com os filtros selecionados.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Paginação -->
            <?php if ($totalPaginas > 1): ?>
            <div class="pagination">
                <?php if ($paginaAtual > 1): ?>
                    <a href="?pagina=<?php echo $paginaAtual - 1; ?>&produto=<?php echo urlencode($filtroProduto); ?>&codigo=<?php echo urlencode($filtroCodigo); ?>&familia=<?php echo urlencode($filtroFamilia); ?>&colador=<?php echo urlencode($filtroColador); ?>">
                        ◀ Anterior
                    </a>
                <?php else: ?>
                    <a class="disabled">◀ Anterior</a>
                <?php endif; ?>

                <span class="page-info">
                    Página <strong><?php echo $paginaAtual; ?></strong> de <strong><?php echo $totalPaginas; ?></strong>
                </span>

                <?php if ($paginaAtual < $totalPaginas): ?>
                    <a href="?pagina=<?php echo $paginaAtual + 1; ?>&produto=<?php echo urlencode($filtroProduto); ?>&codigo=<?php echo urlencode($filtroCodigo); ?>&familia=<?php echo urlencode($filtroFamilia); ?>&colador=<?php echo urlencode($filtroColador); ?>">
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
        function voltarPagina() {
            window.location.href = '../principal.php';
        }

        function novoCadastro() {
            window.location.href = '/colagem/cad_colagem.php';
        }

        function limparFiltros() {
            window.location.href = 'listar_colagens.php';
        }

        function excluirColagem(id, produto) {
            if (confirm(`⚠️ ATENÇÃO!\n\nTem certeza que deseja EXCLUIR a colagem do produto "${produto}"?\n\nEsta ação não poderá ser desfeita!`)) {
                window.location.href = `excluir_colagem.php?id_colagem=${id}`;
            }
        }
    </script>
</body>
</html>
