<?php
require_once __DIR__ . '/Conexao.php';

class Usuario {
    // Método para validar login
    public function Logar($identificacao, $senha) {
        $pdo = Conectar();
        if (!$pdo) return false;

        $sql = 'SELECT * FROM Usuario WHERE Nome = :id OR Email = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', trim($identificacao));
        $stmt->execute();

        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioData && password_verify($senha, $usuarioData['Senha'])) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['IdUsuario'] = $usuarioData['Id'];
            $_SESSION['NomeUsuario'] = $usuarioData['Nome'];
            return true;
        }
        return false;
    }

    // Método para registrar novo usuário
    public function Cadastrar($nome, $senha, $email) {
        $pdo = Conectar();
        if (!$pdo) return false;

        $SenhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO Usuario (Nome, Senha, Email) VALUES (:nome, :senha, :email)';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nome' => $nome,
            ':senha' => $SenhaHash,
            ':email' => $email
        ]);
    }

    // Lista todos para a tabela
    public function ListarAdministradores() {
        $pdo = Conectar();
        if (!$pdo) return [];
        $sql = 'SELECT Id, Nome, Email FROM Usuario';
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca um único usuário pelo ID (usado na edição)
    public function buscarPorId($id) {
        $pdo = Conectar();
        if (!$pdo) return false;
        $sql = "SELECT Id, Nome, Email FROM Usuario WHERE Id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualiza dados do admin
    public function atualizarAdmin($id, $nome, $email) {
        $pdo = Conectar();
        if (!$pdo) return false;
        $sql = "UPDATE Usuario SET Nome = :nome, Email = :email WHERE Id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Deleta do banco
    public function deletarAdmin($id) {
        $pdo = Conectar();
        if (!$pdo) return false;
        $sql = "DELETE FROM Usuario WHERE Id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}