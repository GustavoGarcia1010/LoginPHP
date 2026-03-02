<?php require_once __DIR__ . '/../auth/VerificarAdmin.php' 
?>
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
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        /* Tabela */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9; 
        }

        tbody tr:nth-child(odd) {
            background-color: #ffffff; 
        }

        tr:hover {
            background-color: #f1f4f7 !important;
        }

        /* --- AJUSTE DOS BOTÕES (LADO A LADO) --- */
        .btn-group {
            display: flex; 
            gap: 5px;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .btn:hover {
            opacity: 0.8;
            transform: translateY(-1px);
        }

        .btn-edit {
            background-color: #f39c12;
            color: white;
        }

        .btn-delete {
            background-color: var(--danger-color);
            color: white;
        }

        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

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
                <tbody class='relatorio'>
                    </tbody>
            </table>
        </div>
    </div>

    <script>
        async function ListarAdministradores() {
            try {
                const relatorio = document.querySelector('.relatorio');
                const response = await fetch('ListarAdministradoresAPI');

                if (!response.ok) throw new Error("Erro na requisição");

                const data = await response.json();
                
                // Limpa apenas se a requisição deu certo
                relatorio.innerHTML = ""; 

                if (Array.isArray(data)) {
                    data.forEach(user => {
                        const linha = document.createElement('tr');
                        linha.innerHTML = `
                            <td>${user.Id}</td>
                            <td>${user.Nome}</td>
                            <td>${user.Email}</td>
                            <td><span style="color: var(--success-color); font-weight: bold;">Administrador</span></td>
                            <td>
                                <div class="btn-group">
                                    <a href="EditarAdmin.php?id=${user.Id}" class="btn btn-edit">Editar</a>
                                    <a href="ExcluirAdmin.php?id=${user.Id}" class="btn btn-delete">Excluir</a>
                                </div>
                            </td>
                        `;
                        relatorio.appendChild(linha);
                    });
                }
            } catch (error) {
                console.error("Erro ao listar:", error);
            }
        }

        // Inicia na hora
        ListarAdministradores();

        // Atualiza a cada 4 segundos
        setInterval(ListarAdministradores, 4000);
    </script>
</body>

</html>