<?php require_once __DIR__ . '/../auth/VerificarAdmin.php' ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Lista</title>
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f4f7f6;
            --text-color: #333;
            --danger-color: #e74c3c;
            --success-color: #27ae60;
            --border-color: #ddd;
            --nav-bg: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            /* Removido padding para a nav encostar no topo */
        }

        /* --- ESTILIZAÇÃO DA NAV --- */
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 2rem;
            background-color: var(--nav-bg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .nav-link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: #2c3e50;
        }

        .nav-link-danger {
            color: var(--danger-color);
            font-weight: 600;
            text-decoration: none;
            padding: 6px 16px;
            border: 1.8px solid var(--danger-color);
            border-radius: 6px;
            transition: all 0.3s;
        }

        .nav-link-danger:hover {
            background-color: var(--danger-color);
            color: white;
        }

        /* --- CONTAINER E CONTEÚDO --- */
        .container {
            max-width: 1000px;
            margin: 0 auto 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 15px;
        }

        h1 {
            margin: 0;
            font-size: 1.5rem;
            color: #2c3e50;
        }

        /* --- TABELA --- */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            text-align: left;
            padding: 14px 15px;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: #7f8c8d;
        }

        tbody tr:hover {
            background-color: #f1f4f7;
        }

        /* --- BOTÕES DE AÇÃO --- */
        .btn-group {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-edit {
            background-color: #f39c12;
            color: white;
        }

        .btn-delete {
            background-color: var(--danger-color);
            color: white;
        }

        .btn:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }

        /* --- TAGS / BADGES --- */
        .badge-admin {
            background-color: #e8f5e9;
            color: var(--success-color);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        @media (max-width: 600px) {
            nav {
                padding: 1rem;
            }

            .container {
                margin: 10px;
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

    <nav>
        <div>
            <a href="dashboardAdmin" class="nav-link">Dashboard</a>
        </div>
        <a href="Logout" class="nav-link-danger">Sair do Sistema</a>
    </nav>

    <div class="container">
        <header class="header">
            <h1>Lista de Administradores</h1>
        </header>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Cargo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="relatorio">
                </tbody>
            </table>
        </div>
    </div>

   <script>
    async function ListarAdministradores() {
        try {
            const relatorio = document.querySelector('.relatorio');
            const response = await fetch('ListarAdministradoresAPI');
            const data = await response.json();

            if (Array.isArray(data)) {
                relatorio.innerHTML = data.map(user => `
                    <tr>
                        <td>${user.Id}</td>
                        <td>${user.Nome}</td>
                        <td>${user.Email}</td>
                        <td><span class="badge-admin">Admin</span></td>
                        <td>
                            <div class="btn-group">
                                <a href="EditarAdmin?id=${user.IdHash}" class="btn btn-edit">Editar</a>
                                <a href="javascript:void(0)" onclick="confirmarExclusao('${user.IdHash}')" class="btn btn-delete">Excluir</a>
                            </div>
                        </td>
                    </tr>
                `).join('');
            }
        } catch (error) { console.error("Erro:", error); }
    }

    function confirmarExclusao(idHash) {
        if (confirm("Tem certeza que deseja excluir?")) {
            window.location.href = `ExcluirAdmin?id=${idHash}`;
        }
    }
    ListarAdministradores();
    setInterval(ListarAdministradores, 5000);
</script>
</body>

</html>