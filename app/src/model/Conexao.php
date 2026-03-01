<?php 

$localhost = 'localhost';
$username = 'root';
$senha = '';
$db = 'Login_Sistema';


function Conectar() {
    global $localhost, $username, $senha, $db;
    try {
        $pdo = new PDO('mysql:host=' . $localhost . ';dbname=' . $db, $username, $senha);
        return $pdo;
    } catch (PDOException $e) {
        echo "Erro de conexão: " . $e->getMessage();
        return null;
    }
}



?>