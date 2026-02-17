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

$id = (int) $_GET['id_colagem'];

// Busca os dados completos da colagem
$sql = "SELECT * FROM tab_nova_colagem WHERE id_colagem = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
        alert('❌ Erro: Colagem não encontrada!');
        window.location.href = 'listar_colagens.php';
    </script>";
    $stmt->close();
    $conn->close();
    exit;
}

$colagem = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Colagem</title>
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
            max-width: 1200px;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
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
            text-decoration: none;
        }

        .btn-voltar:hover {
            background: white;
            color: #1976d2;
            transform: translateX(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .content {
            padding: 30px;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #1976d2;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e3f2fd;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #2196f3;
        }

        .info-label {
            font-size: 12px;
            color: #757575;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #212121;
            font-weight: 500;
        }

        .colors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 15px;
        }

        .color-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }

        .color-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .color-number {
            font-weight: 600;
            color: #1976d2;
            font-size: 14px;
        }

        .color-name {
            font-size: 14px;
            color: #424242;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .color-detail {
            font-size: 12px;
            color: #757575;
            margin-top: 5px;
        }

        .cameron-section {
            background: #fff3e0;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #ff9800;
        }

        .cameron-label {
            font-weight: 600;
            color: #e65100;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .obs-section {
            background: #fff3e0;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #ff9800;
        }

        .obs-label {
            font-weight: 600;
            color: #e65100;
            margin-bottom: 10px;
        }

        .obs-text {
            color: #424242;
            line-height: 1.6;
        }

        .actions-bar {
            display: flex;
            gap: 15px;
            justify-content: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 2px solid #e0e0e0;
        }

        .btn-action {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-editar {
            background: #ff9800;
            color: white;
        }

        .btn-editar:hover {
            background: #f57c00;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 152, 0, 0.3);
        }

        .btn-excluir {
            background: #f44336;
            color: white;
        }

        .btn-excluir:hover {
            background: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .header h1 {
                font-size: 22px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .colors-grid {
                grid-template-columns: 1fr;
            }

            .actions-bar {
                flex-direction: column;
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
            <h1>🔍 Detalhes da Colagem</h1>
            <a href="listar_colagens.php" class="btn-voltar">◀ VOLTAR</a>
        </div>

        <div class="content">
            <!-- Informações Básicas -->
            <div class="info-section">
                <h2 class="section-title">📋 Informações Básicas</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Produto</div>
                        <div class="info-value"><?php echo htmlspecialchars($colagem['produto']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Código</div>
                        <div class="info-value"><?php echo htmlspecialchars($colagem['codigo']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Camisa</div>
                        <div class="info-value"><?php echo htmlspecialchars($colagem['camisa']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Família</div>
                        <div class="info-value"><?php echo htmlspecialchars($colagem['familia']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Colador</div>
                        <div class="info-value"><?php echo htmlspecialchars($colagem['colador']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Data da Colagem</div>
                        <div class="info-value"><?php echo $colagem['datacolagem'] ? date('d/m/Y', strtotime($colagem['datacolagem'])) : '-'; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Quantidade de Cores</div>
                        <div class="info-value"><?php echo htmlspecialchars($colagem['cores']); ?> cores</div>
                    </div>
                </div>
            </div>

            <!-- Configurações de Máquina -->
            <div class="info-section">
                <h2 class="section-title">⚙️ Configurações de Máquina</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Máquina</div>
                        <div class="info-value"><?php echo htmlspecialchars($colagem['maquina']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Valor ENG</div>
                        <div class="info-value"><?php echo htmlspecialchars($colagem['valor_eng']); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Valor PON</div>
                        <div class="info-value"><?php echo htmlspecialchars($colagem['valor_pon']); ?></div>
                    </div>
                </div>
            </div>

            <!-- Configurações Cameron -->
            <?php if ($colagem['cameron'] == 1): ?>
            <div class="info-section">
                <h2 class="section-title">🔧 Configurações Cameron</h2>
                <div class="cameron-section">
                    <div class="cameron-label">Utiliza Cameron</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Distância Cameron 1</div>
                            <div class="info-value"><?php echo htmlspecialchars($colagem['distanciaCameron']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">ENG Cameron</div>
                            <div class="info-value"><?php echo htmlspecialchars($colagem['engcameron']); ?></div>
                        </div>
                        <?php if (!empty($colagem['maquinaCameron'])): ?>
                        <div class="info-item">
                            <div class="info-label">Máquina Cameron</div>
                            <div class="info-value"><?php echo htmlspecialchars($colagem['maquinaCameron']); ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($colagem['ponCameron'])): ?>
                        <div class="info-item">
                            <div class="info-label">PON Cameron</div>
                            <div class="info-value"><?php echo htmlspecialchars($colagem['ponCameron']); ?></div>
                        </div>
                        <?php endif; ?>
                        <div class="info-item">
                            <div class="info-label">Distância Cameron 2</div>
                            <div class="info-value"><?php echo htmlspecialchars($colagem['distanciaCameron2']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Cores -->
            <div class="info-section">
                <h2 class="section-title">🎨 Cores da Colagem</h2>
                <div class="colors-grid">
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        $corField = "cor" . str_pad($i, 2, '0', STR_PAD_LEFT);
                        $densidadeField = "densidade" . str_pad($i, 2, '0', STR_PAD_LEFT);
                        $fornecedorField = "fornecedor" . str_pad($i, 2, '0', STR_PAD_LEFT);

                        if (!empty($colagem[$corField])) {
                            ?>
                            <div class="color-card">
                                <div class="color-header">
                                    <span class="color-number">Cor <?php echo $i; ?></span>
                                </div>
                                <div class="color-name">
                                    <?php echo htmlspecialchars($colagem[$corField]); ?>
                                </div>
                                <?php if (!empty($colagem[$densidadeField])): ?>
                                    <div class="color-detail">
                                        <strong>Densidade:</strong> <?php echo htmlspecialchars($colagem[$densidadeField]); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($colagem[$fornecedorField])): ?>
                                    <div class="color-detail">
                                        <strong>Fornecedor:</strong> <?php echo htmlspecialchars($colagem[$fornecedorField]); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Observações -->
            <?php if (!empty($colagem['observacoes'])): ?>
                <div class="info-section">
                    <h2 class="section-title">📝 Observações</h2>
                    <div class="obs-section">
                        <div class="obs-label">Observações:</div>
                        <div class="obs-text"><?php echo nl2br(htmlspecialchars($colagem['observacoes'])); ?></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Ações -->
        <div class="actions-bar">
            <a href="editar_colagem.php?id_colagem=<?php echo $colagem['id_colagem']; ?>" class="btn-action btn-editar">
                ✏️ Editar Colagem
            </a>
            <button class="btn-action btn-excluir"
                onclick="excluirColagem(<?php echo $colagem['id_colagem']; ?>, '<?php echo htmlspecialchars($colagem['produto']); ?>')">
                🗑️ Excluir Colagem
            </button>
        </div>
    </div>

    <script>
        function excluirColagem(id, produto) {
            if (confirm(`⚠️ ATENÇÃO!\n\nTem certeza que deseja EXCLUIR a colagem do produto "${produto}"?\n\nEsta ação não poderá ser desfeita!`)) {
                window.location.href = `excluir_colagem.php?id_colagem=${id}`;
            }
        }
    </script>
</body>

</html>
