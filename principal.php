<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Sistema de Gestão - Plasc</title>
</head>

<body>
    <div class="header">
        <div class="logo-area">
            <div class="logo-placeholder">P</div>
            <div class="company-name">Plasc</div>
        </div>
    </div>

    <div class="container">
        <div class="main-content">
            <div class="welcome-section">
                <h1>Sistema de Gestão Clicheria</h1>
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
                            <button class="menu-button" data-page="clicheria/cad_clicheria.php">
                                Cadastro Clichê
                            </button>
                        </li>   
                        <li class="menu-item">
                            <button class="menu-button" data-page="clicheria/listar_cliches.php">
                                Clichês Cadastrados
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
                            <button class="menu-button" data-page="colagem/cad_colagem.php">
                                Cadastro Colagem
                            </button>
                        </li>
                        <li class="menu-item">
                            <button class="menu-button" data-page="colagem/listar_colagens.php">
                                Colagens Cadastradas
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
        document.querySelectorAll('.menu-button').forEach(button => {
            button.addEventListener('click', function() {
                const page = this.getAttribute('data-page');
                if (page) {
                    window.location.href = page;
                }
            });
        });

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