<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Captura a URL e limpa barras extras
$rota = (isset($_GET['url'])) ? rtrim($_GET['url'], '/') : 'home';

// Caminhos base para facilitar a manutenção
$dirController = __DIR__ . '/app/src/Controller/UsuarioController.php';
$dirView       = __DIR__ . '/app/src/view/';
$dirAuth       = __DIR__ . '/app/src/auth/';

switch ($rota) {
    case 'home':
        $arquivo = __DIR__ . '/app/src/Public/index.php';
        if (file_exists($arquivo)) {
            require_once $arquivo;
        } else {
            echo "Erro: Arquivo index.php da home não encontrado.";
        }
        break;

    case 'Logar':
        if (file_exists($dirController)) {
            require_once $dirController;
            $controller = new UsuarioController();
            $controller->Logar();
        }
        break;

    case 'Cadastrar':
        if (file_exists($dirController)) {
            require_once $dirController;
            $controller = new UsuarioController();
            $controller->Cadastrar();
        }
        break;

    case 'dashboardAdmin':
        $arquivo = $dirView . 'dashboardAdmin.php';
        if (file_exists($arquivo)) {
            require_once $arquivo;
        } else {
            echo "Erro: Dashboard não encontrado.";
        }
        break;

    case 'Logout':
        $arquivo = $dirAuth . 'Logout.php';
        if (file_exists($arquivo)) {
            require_once $arquivo;
        }
        break;

    case 'ListarAdministradores':
        $arquivo = $dirView . 'VerAdmin.php';
        if (file_exists($arquivo)) {
            require_once $arquivo;
        } else {
            echo "Erro: Tela de listagem não encontrada.";
        }
        break;

    case 'ListarAdministradoresAPI':
        if (file_exists($dirController)) {
            require_once $dirController;
            $controller = new UsuarioController();
            $controller->ListarAdministradores();
        }
        break;

    case 'EditarAdmin':
        if (file_exists($dirController)) {
            require_once $dirController;
            $controller = new UsuarioController();

            // Se for envio de formulário (POST), chama o método de atualizar
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->Atualizar();
            } else {
                // Se for apenas visualização (GET), carrega a tela
                $arquivoView = $dirView . 'EditarAdmin.php';
                if (file_exists($arquivoView)) {
                    require_once $arquivoView;
                }
            }
        }
        break;

    case 'ExcluirAdmin':
        if (file_exists($dirController)) {
            require_once $dirController;
            $controller = new UsuarioController();
            $controller->Excluir();
        }
        break;

    default:
        // Se a rota não existir, volta para a home
        header("Location: home");
        exit();
        break;
}
