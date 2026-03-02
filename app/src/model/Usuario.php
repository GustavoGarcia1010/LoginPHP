<?php
require_once __DIR__ . '/Conexao.php';

class Usuario {
    private $id;
    private $nome;
    private $senha;

    public function __construct($id = null, $nome = null, $senha = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->senha = $senha;
    }

    public function Logar($identificacao, $senha) {
    $pdo = Conectar(); 
    if (!$pdo) return false;

    // Buscamos por Nome ou Email (conforme seu form sugere)
    $sql = 'SELECT * FROM Usuario WHERE Nome = :id OR Email = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', trim($identificacao));
    $stmt->execute();

    $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioData) {
        // password_verify é essencial pois o cadastro usa password_hash
        if (password_verify($senha, $usuarioData['Senha'])) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            
            $_SESSION['IdUsuario'] = $usuarioData['Id'];
            $_SESSION['NomeUsuario'] = $usuarioData['Nome'];
            return true;
        }
    }
    return false;
}    public function Cadastrar($nome, $senha, $email){
        $pdo = Conectar();
        if (!$pdo) return false;

        $SenhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO Usuario (Nome,Senha,Email) VALUES (:nome, :senha, :email)';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nome' => $nome,
            ':senha' => $SenhaHash,
            ':email' => $email
        ]);
        }
    
    public function ListarAdministradores() {
        $pdo = Conectar(); 
        if (!$pdo) return false;
        $sql = 'SELECT Id, Nome, Email FROM Usuario';
        $stmt = $pdo->prepare($sql);  
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);


    }
}
