<?php 
require_once __DIR__ . '/../auth/VerificarAdmin.php';
require_once __DIR__ . '/../Model/Usuario.php';
require_once __DIR__ . '/../auth/HashId.php';

$idHash = $_GET['id'] ?? '';
$idReal = HashId::descriptografar($idHash);

$usuarioModel = new Usuario();
$admin = $idReal ? $usuarioModel->buscarPorId($idReal) : null;

if (!$admin) {
    echo "<script>alert('ID Inválido!'); window.location.href='ListarAdministradores';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; display: flex; justify-content: center; padding: 50px; }
        .box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 350px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { background: #4a90e2; color: white; border: none; padding: 10px; width: 100%; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Editar Admin</h2>
        <form action="EditarAdmin" method="POST">
            <input type="hidden" name="id" value="<?= $idHash ?>">
            
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($admin['Nome']) ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($admin['Email']) ?>" required>
            
            <button type="submit" class="btn">Salvar Alterações</button>
            <a href="ListarAdministradores" style="display:block; text-align:center; margin-top:10px; color:#666;">Cancelar</a>
        </form>
    </div>
</body>
</html>