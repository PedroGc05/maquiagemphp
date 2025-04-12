<?php
session_start();
include_once('includes/header.php');
include_once('includes/functions.php');

// Definindo as credenciais de acesso (normalmente viriam de um banco de dados)
// Senha: admin123 (já está com hash)
$usuario_correto = 'admin';
$senha_hash_correto = '$2y$10$8MWocUMGSP1AXAWq3LBn8uNKGnhxbpY8VGm.TmBbHBmlb7.pIEADG';

$erro = '';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = sanitizar($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';
    
    if (empty($usuario) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } elseif ($usuario !== $usuario_correto) {
        $erro = 'Usuário ou senha incorretos.';
    } elseif (!verificaSenha($senha, $senha_hash_correto)) {
        $erro = 'Usuário ou senha incorretos.';
    } else {
        // Login bem-sucedido, iniciar a sessão
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $usuario;
        
        // Redirecionar para a área protegida
        header('Location: protegido.php');
        exit;
    }
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Login</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($erro)): ?>
                        <div class="alert alert-danger">
                            <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="login.php">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0"><strong>Usuário:</strong> admin <strong>Senha:</strong> admin123</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
