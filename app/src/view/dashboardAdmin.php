<?php
    require_once __DIR__ . '/../auth/VerificarAdmin.php';
  
   $Nome = $_SESSION['NomeUsuario'];

// Formata o nome para a URL do Avatar (substitui espaços por +)
$avatarName = str_replace(' ', '+', $Nome);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - <?php echo $Nome; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-body: #f8fafc;
            --bg-sidebar: #0f172a;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --sidebar-width: 260px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-sidebar);
            color: var(--white);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 1000;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .sidebar.closed { left: calc(-1 * var(--sidebar-width)); }

        .sidebar-header {
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1.4rem;
            font-weight: 800;
            border-bottom: 1px solid #1e293b;
        }

        .sidebar-menu { list-style: none; padding: 20px 10px; flex-grow: 1; }
        .sidebar-menu a {
            padding: 12px 15px;
            color: #94a3b8;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 8px;
            transition: var(--transition);
        }

        .sidebar-menu li.active a, .sidebar-menu a:hover {
            background: rgba(37, 99, 235, 0.15);
            color: var(--white);
        }

        /* --- CONTEÚDO --- */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            width: 100%;
        }

        .main-content.expanded { margin-left: 0; }

        header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            position: sticky;
            top: 0;
            z-index: 900;
            border-bottom: 1px solid #e2e8f0;
        }

        .menu-toggle { cursor: pointer; font-size: 1.2rem; padding: 10px; }

        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-profile img { width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--primary); }

        .content-wrapper { padding: 25px; max-width: 1600px; margin: 0 auto; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .icon-box { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
        .blue { background: #eff6ff; color: #2563eb; }
        .green { background: #f0fdf4; color: #166534; }
        .orange { background: #fff7ed; color: #9a3412; }

        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-container {
            background: var(--white);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            position: relative;
            height: 350px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        @media (max-width: 1024px) { .charts-section { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .sidebar { left: calc(-1 * var(--sidebar-width)); }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; }
            .sidebar-overlay.active { display: block; }
            .hide-mobile { display: none; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span><i class="fas fa-bolt"></i> ULTRA ADMIN</span>
        </div>
        <ul class="sidebar-menu">
            <li class="active"><a href="#"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></a></li>
            <li><a href="#"><i class="fas fa-users"></i> <span>Usuários</span></a></li>
            <li><a href="#"><i class="fas fa-shopping-bag"></i> <span>Vendas</span></a></li>
            <li><a href="#"><i class="fas fa-cog"></i> <span>Ajustes</span></a></li>
        </ul>
        <div style="padding: 20px; border-top: 1px solid #1e293b;">
            <a href="Logout" style="color: #ef4444; text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-sign-out-alt"></i> <span>Sair</span>
            </a>
        </div>
    </nav>

    <div class="main-content" id="main">
        <header>
            <div class="menu-toggle" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </div>
            <div class="user-profile">
                <div style="text-align: right;" class="hide-mobile">
                    <p style="font-weight: 700; font-size: 0.9rem;"><?php echo $Nome; ?></p>
                </div>
                <img src="https://ui-avatars.com/api/?name=<?php echo $avatarName; ?>&background=2563eb&color=fff" alt="Avatar">
            </div>
        </header>

        <div class="content-wrapper">
            <h2 style="margin-bottom: 20px;">Olá, <?php echo explode(' ', $Nome)[0]; ?>! 👋</h2>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="icon-box blue"><i class="fas fa-user-plus"></i></div>
                    <div><h3>Clientes</h3><p style="font-size: 1.5rem; font-weight: 700;">1,482</p></div>
                </div>
                <div class="stat-card">
                    <div class="icon-box green"><i class="fas fa-dollar-sign"></i></div>
                    <div><h3>Receita</h3><p style="font-size: 1.5rem; font-weight: 700;">R$ 45.200</p></div>
                </div>
                <div class="stat-card">
                    <div class="icon-box orange"><i class="fas fa-truck"></i></div>
                    <div><h3>Entregas</h3><p style="font-size: 1.5rem; font-weight: 700;">28</p></div>
                </div>
            </div>

            <div class="charts-section">
                <div class="chart-container">
                    <h4 style="margin-bottom: 15px;">Desempenho Semanal</h4>
                    <canvas id="salesChart"></canvas>
                </div>
                <div class="chart-container">
                    <h4 style="margin-bottom: 15px;">Origem de Tráfego</h4>
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');
            const overlay = document.getElementById('overlay');
            if (window.innerWidth > 768) {
                sidebar.classList.toggle('closed');
                main.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }
        }

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 800 },
            plugins: { legend: { position: 'bottom' } }
        };

        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'],
                datasets: [{
                    label: 'Vendas (R$)',
                    data: [5000, 7000, 6500, 9000, 12000, 15000, 11000],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: chartOptions
        });

        new Chart(document.getElementById('trafficChart'), {
            type: 'doughnut',
            data: {
                labels: ['Google', 'Social', 'Direto'],
                datasets: [{
                    data: [55, 25, 20],
                    backgroundColor: ['#2563eb', '#10b981', '#f59e0b'],
                    borderWidth: 0
                }]
            },
            options: chartOptions
        });
    </script>
</body>
</html>