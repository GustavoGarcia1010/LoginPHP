<?php
require_once __DIR__ . '/../Model/Usuario.php';

class UsuarioController {
    public function Logar() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    // Pegamos 'nome' (minúsculo) conforme está no seu HTML: <input name="nome">
    $identificacao = $_POST['Nome'] ?? null; 
    $senha = $_POST['Senha'] ?? null;

    if (!$identificacao || !$senha) {
        $_SESSION['erro_login'] = "Preencha todos os campos!";
        header("Location: home");
        exit();
    }

    $usuario = new Usuario();
    if ($usuario->Logar($identificacao, $senha)) {
        header("Location: dashboardAdmin");
        exit(); 
    } else {
        $_SESSION['erro_login'] = "Usuário ou senha incorretos.";
        header("Location: home");
        exit();
    }
}

    public function Cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: home");
            exit();
        }

        $nome  = $_POST['Nome'] ?? null; 
        $email = $_POST['Email'] ?? null;
        $senha  = $_POST['Senha'] ?? null;

        if (!$nome || !$email || !$senha) {
            $_SESSION['erro_cadastro'] = "Preencha todos os campos!";
            header("Location: home");
            exit();
        }

        $usuario = new Usuario();
    // ... código anterior ...
    if ($usuario->Cadastrar($nome, $senha, $email)) {
        $_SESSION['sucesso_cadastro'] = "Conta criada! Agora é só entrar.";
        header("Location: home"); // Redireciona para a home para exibir a mensagem
        exit(); 
    } else {
            $_SESSION['erro_cadastro'] = "Erro ao cadastrar. Tente novamente.";
            header("Location: home");
            exit();
        }
    }

   public function ListarAdministradores() {
    $usuario = new Usuario();
    $dataUsers = $usuario->ListarAdministradores(); 

    // Limpa qualquer saída acidental anterior
    ob_clean(); 

    // Define o cabeçalho para o navegador entender que é um JSON
    header('Content-Type: application/json');

    // Retorna os dados para o JavaScript
    echo json_encode($dataUsers);
    exit(); 
}
}