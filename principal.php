<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão - Clicheria</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0d47a1 0%, #1976d2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: white;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-placeholder {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1976d2, #2196f3);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 24px;
        }

        .company-name {
            color: #0d47a1;
            font-size: 28px;
            font-weight: 600;
        }

        .user-info {
            color: #0d47a1;
            font-size: 14px;
        }

        .container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .main-content {
            max-width: 1200px;
            width: 100%;
        }

        .welcome-section {
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .welcome-section h1 {
            font-size: 42px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .welcome-section p {
            font-size: 18px;
            opacity: 0.95;
        }

        .sectors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .sector-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .sector-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .sector-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 3px solid #e3f2fd;
        }

        .sector-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #1976d2, #2196f3);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .sector-title {
            font-size: 28px;
            color: #0d47a1;
            font-weight: 600;
        }

        .menu-list {
            list-style: none;
        }

        .menu-item {
            margin-bottom: 12px;
        }

        .menu-button {
            width: 100%;
            padding: 15px 20px;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            border: none;
            border-radius: 10px;
            color: #0d47a1;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu-button:hover {
            background: linear-gradient(135deg, #2196f3, #1976d2);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
        }

        .menu-button::before {
            content: "▶";
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        .menu-button:hover::before {
            transform: translateX(3px);
        }

        .footer {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .sectors-grid {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .welcome-section h1 {
                font-size: 32px;
            }
        }

        .badge {
            background: #ff9800;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            margin-left: auto;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo-area">
            <div class="logo-placeholder">C</div>
            <div class="company-name">Clicheria</div>
        </div>
        <div class="user-info">
            Bem-vindo, Usuário | <strong>Sistema de Gestão</strong>
        </div>
    </div>

    <div class="container">
        <div class="main-content">
            <div class="welcome-section">
                <h1>Sistema de Gestão Integrado</h1>
                <p>Escolha o setor para acessar os cadastros e consultas</p>
            </div>

            <div class="sectors-grid">
                <!-- Setor Clicheria -->
                <div class="sector-card">
                    <div class="sector-header">
                        <div class="sector-icon">🖨️</div>
                        <h2 class="sector-title">Clicheria</h2>
                    </div>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <button class="menu-button" onclick="navigateTo('cadastro-cliche')">
                                Cadastro de Clichê
                            </button>
                        </li>
                        <li class="menu-item">
                            <button class="menu-button" onclick="navigateTo('saida-cliche')">
                                Saída de Clichê
                            </button>
                        </li>
                        <li class="menu-item">
                            <button class="menu-button" onclick="navigateTo('retorno-cliche')">
                                Retorno de Clichê
                            </button>
                        </li>
                        <li class="menu-item">
                            <button class="menu-button" onclick="navigateTo('ocorrencia-grafica')">
                                Ocorrência Gráfica
                            </button>
                        </li>
                        <li class="menu-item">
                            <button class="menu-button" onclick="navigateTo('producao')">
                                Produção
                            </button>
                        </li>
                        <li class="menu-item">
                            <button class="menu-button" onclick="navigateTo('descarte')">
                                Descarte de Clichê
                            </button>
                        </li>
                        <li class="menu-item">
                            <button class="menu-button" onclick="navigateTo('consulta-cliche')">
                                Consultar Clichês
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Setor Colagem -->
                <div class="sector-card">
                    <div class="sector-header">
                        <div class="sector-icon">📋</div>
                        <h2 class="sector-title">Colagem</h2>
                    </div>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <button class="menu-button" onclick="navigateTo('cadastro-colagem')">
                                Cadastro de Colagem
                            </button>
                        </li>
                        <li class="menu-item">
                            <button class="menu-button" onclick="navigateTo('consulta-colagem')">
                                Consultar Colagens
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2026 Sistema de Gestão - Clicheria | Todos os direitos reservados</p>
    </div>

    <script>
        function navigateTo(page) {
            // Aqui você pode implementar a navegação para as páginas específicas
            alert(`Navegando para: ${page}\n\nEsta funcionalidade será implementada com as páginas internas do sistema.`);

            // Exemplo de como seria a navegação real:
            // window.location.href = `${page}.html`;
        }

        // Adiciona efeito de entrada
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.sector-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>

</html>