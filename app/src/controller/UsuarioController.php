<?php
require_once __DIR__ . '/../Model/Usuario.php';
require_once __DIR__ . '/../auth/HashId.php';

class UsuarioController {
    
    public function Logar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $identificacao = $_POST['Nome'] ?? null;
        $senha = $_POST['Senha'] ?? null;

        $usuario = new Usuario();
        if ($usuario->Logar($identificacao, $senha)) {
            header("Location: dashboardAdmin");
        } else {
            $_SESSION['erro_login'] = "Usuário ou senha incorretos.";
            header("Location: home");
        }
        exit();
    }

    public function Cadastrar() {
        $nome  = $_POST['Nome'] ?? null;
        $email = $_POST['Email'] ?? null;
        $senha = $_POST['Senha'] ?? null;

        $usuario = new Usuario();
        if ($usuario->Cadastrar($nome, $senha, $email)) {
            header("Location: home?sucesso=cadastrado");
        } else {
            header("Location: home?erro=cadastro");
        }
        exit();
    }

    public function ListarAdministradores() {
        $model = new Usuario();
        $admins = $model->ListarAdministradores();

        // Aplica criptografia nos IDs para o JavaScript usar
        foreach ($admins as &$admin) {
            $admin['IdHash'] = HashId::criptografar($admin['Id']);
        }

        header('Content-Type: application/json');
        echo json_encode($admins);
    }

    public function Atualizar() {
        // Descriptografa o ID que veio do formulário oculto
        $idReal = HashId::descriptografar($_POST['id']);
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        $usuario = new Usuario();
        if ($idReal && $usuario->atualizarAdmin($idReal, $nome, $email)) {
            header("Location: ListarAdministradores?sucesso=editado");
        } else {
            echo "Erro ao atualizar.";
        }
        exit();
    }

    public function Excluir() {
        // Descriptografa o ID que veio via GET da URL
        $idReal = HashId::descriptografar($_GET['id'] ?? '');
        
        $usuario = new Usuario();
        if ($idReal && $usuario->deletarAdmin($idReal)) {
            header("Location: ListarAdministradores?sucesso=excluido");
        } else {
            echo "Erro ao excluir ou ID inválido.";
        }
        exit();
    }
}