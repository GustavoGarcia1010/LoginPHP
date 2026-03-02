<?php

if (session_status() === PHP_SESSION_NONE) session_start();
$rota = (isset($_GET['url'])) ? rtrim($_GET['url'], '/') : 'home';

switch ($rota) {
    case 'home':
        $arquivo = __DIR__ . '/app/src/Public/index.php';
        if (file_exists($arquivo)) {
            require_once $arquivo;
        } else {
            echo "Erro: Arquivo index.php não encontrado.";
        }
        break;

    case 'Logar':
        require_once __DIR__ . '/app/src/Controller/UsuarioController.php';
        $controller = new UsuarioController();
        $controller->Logar();
        break;

    case 'Cadastrar':
        require_once __DIR__ . '/app/src/Controller/UsuarioController.php';
        $controller = new UsuarioController();
        $controller->Cadastrar();
        break;

    case 'dashboardAdmin':
        $arquivo = __DIR__ . '/app/src/view/dashboardAdmin.php';
        if (file_exists($arquivo)) {
            require_once $arquivo;
        } else {
            echo "Erro: Arquivo dashboardAdmin.php não encontrado.";
        }
        break;

    case 'Logout':
        require_once __DIR__ . '/app/src/auth/Logout.php';
        break;

    case 'ListarAdministradores':
        require_once __DIR__ . '/app/src/view/VerAdmin.php';
        break;

    case 'ListarAdministradoresAPI':
        require_once __DIR__ . '/app/src/controller/UsuarioController.php';
        $controller = new UsuarioController();
        $controller->ListarAdministradores();
        break;


    default:
        header("Location: home");
        break;
}
