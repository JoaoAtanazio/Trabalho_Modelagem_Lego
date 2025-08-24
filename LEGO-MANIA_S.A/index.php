 <?php 
    session_start();
    require_once 'conexao.php';

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);  
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario && password_verify($senha, $usuario['senha'])) {
            // Login bem sucedido define variáveis de sessão
            $_SESSION['usuario'] = $usuario['nome'];  // corrigido
            $_SESSION['perfil'] = $usuario['id_perfil'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];

            // Verifica se a senha é temporária
            if($usuario['senha_temporaria']) {
                header("Location: alterar_senha.php");
                exit();
            } else {
                header("Location: principal.php");
                exit();
            }
        } else {
            echo "<script>alert('E-mail ou senha incorretos');window.location.href='index.php';</script>";
        }
    }
?> 


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="login.css">
    <title>Login - Lego mania</title>
    <style>
        body{
            overflow-y: hidden;
        }
    </style>
</head>
<body>
    
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <h3 class="text-dark"><i class="bi bi-person-circle"></i></h3>
            <h4 class="mb-0">Login</h4>
            <small class="text-muted">Acesse sua conta</small>
        </div>

        <form action="index.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="remember">
                <label class="form-check-label" for="remember">
                    Lembrar-me
                </label>
                </div>
                <a href="esqueceu_senha.php" class="text-decoration-none">Esqueceu a senha?</a>
            </div>

            <button type="submit" class="btn btn-dark w-100">Entrar</button><br><br><br>
        </form>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
