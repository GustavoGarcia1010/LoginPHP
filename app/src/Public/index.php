<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login e cadastro</title>
    <style>
        /* --- RESET E BASE --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #0f172a url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1920') no-repeat center center/cover;
            position: relative;
            overflow: hidden;
            perspective: 2000px;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(15, 23, 42, 0.2) 0%, rgba(15, 23, 42, 0.8) 100%);
            backdrop-filter: blur(8px);
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 420px;
            height: 620px; 
            z-index: 2;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }

        .container.rotate {
            transform: rotateY(180deg);
        }

        .form-box {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            padding: 40px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            backface-visibility: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-box {
            transform: rotateY(180deg);
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 5px solid;
            animation: fadeInDown 0.5s ease;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border-left-color: #ef4444;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border-left-color: #22c55e;
        }

  
        h2 {
            color: #1e293b;
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 10px;
            font-weight: 800;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 5px;
            margin-left: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 14px 16px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            outline: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        /* Estilo para validação visual nativa */
        .input-group input:not(:placeholder-shown):invalid {
            border-color: #ef4444;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 38px;
            cursor: pointer;
            width: 20px;
            opacity: 0.5;
        }

        .btn {
            width: 100%;
            height: 54px;
            background: #2563eb;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            transition: 0.3s;
            margin-top: 15px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }

        .footer-text {
            color: #64748b;
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .footer-text a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
        }

        .register-box h2 { color: #059669; }
        .register-box .btn { background: #10b981; }
        .register-box footer-text a { color: #10b981; }
    </style>
</head>
<body>

    <div class="container" id="card">
        
        <div class="form-box login-box">
            <form action="Logar" method="POST">
                <h2>Olá de volta!</h2>
                <p class="subtitle">Acesse sua conta para continuar</p>

                <?php 
                if (isset($_SESSION['erro_login'])) {
                    echo "<div class='alert alert-error'>
                            <span>⚠️</span> {$_SESSION['erro_login']}
                          </div>";
                    unset($_SESSION['erro_login']);
                } elseif (isset($_SESSION['sucesso_cadastro'])) {
                    echo "<div class='alert alert-success'>
                            <span>✅</span> {$_SESSION['sucesso_cadastro']}
                          </div>";
                    unset($_SESSION['sucesso_cadastro']);
                }
                ?>

                <div class="input-group">
                    <label>Identificação</label>
                    <input type="text" name="Nome" placeholder="Usuário ou e-mail" required>
                </div>
                <div class="input-group">
                    <label>Senha</label>
                    <input type="password" name="Senha" id="loginPass" placeholder="••••••••" required>
                    <img src="https://cdn-icons-png.flaticon.com/512/633/633633.png" class="toggle-password" onclick="MostrarSenha('loginPass', this)">
                </div>
                <button type="submit" class="btn">Entrar na Conta</button>
                <p class="footer-text">Não tem uma conta? <a onclick="AlternarFormulario()">Cadastre-se</a></p>
            </form>
        </div>

        <div class="form-box register-box">
            <form action="Cadastrar" method="POST">
                <h2>Nova Conta</h2>
                <p class="subtitle">Junte-se à nossa comunidade premium</p>
                <?php 
                if (isset($_SESSION['erro_cadastro'])) {
                    echo "<div class='alert alert-error'>
                            <span>⚠️</span> {$_SESSION['erro_cadastro']}
                          </div>";
                    unset($_SESSION['erro_cadastro']);
                } elseif (isset($_SESSION['sucesso_cadastro'])) {
                    echo "<div class='alert alert-success'>
                            <span>✅</span> {$_SESSION['sucesso_cadastro']}
                          </div>";
                    unset($_SESSION['sucesso_cadastro']);
                }
                ?>

                
                <div class="input-group">
                    <label>Nome de Usuário</label>
                    <input type="text" name="Nome" placeholder="Ex: alex_smith" 
                           pattern="[A-Za-z0-9_]{3,20}" title="O nome deve ter entre 3 e 20 caracteres (letras, números ou underline)" required>
                </div>
                <div class="input-group">
                    <label>E-mail</label>
                    <input type="email" name="Email" placeholder="seu@email.com" required>
                </div>
                <div class="input-group">
                    <label>Sua Senha</label>
                    <input type="password" name="Senha" id="regPass" placeholder="Mínimo 8 caracteres" 
                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                           title="A senha deve ter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma minúscula e um número" required>
                    <img src="https://cdn-icons-png.flaticon.com/512/633/633633.png" class="toggle-password" onclick="MostrarSenha('regPass', this)">
                </div>
                <button type="submit" class="btn">Criar minha Conta</button>
                <p class="footer-text">Já é membro? <a onclick="AlternarFormulario()">Fazer login</a></p>
            </form>
        </div>

    </div>

    <script>
        function AlternarFormulario() {
            const container = document.getElementById('card');
            container.classList.toggle('rotate');
        }

        function MostrarSenha(inputId, icone) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icone.src = "https://cdn-icons-png.flaticon.com/512/633/633655.png";
            } else {
                input.type = 'password';
                icone.src = "https://cdn-icons-png.flaticon.com/512/633/633633.png";
            }
        }
        window.onload = function() {
    // Se existir a sessão de erro de cadastro, vira o card automaticamente
    <?php if (isset($_SESSION['erro_cadastro'])): ?>
        AlternarFormulario();
    <?php endif; ?>
}
    </script>
</body>
</html>