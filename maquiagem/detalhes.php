<?php
session_start();
include_once('includes/header.php');
include_once('includes/functions.php');
include_once('includes/data.php');

// Verificar se o ID foi fornecido
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$item = getItemPorId($id);

// Se o item não existir, redirecionar para a página inicial
if ($item === null) {
    header('Location: index.php');
    exit;
}
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Início</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $item['titulo']; ?></li>
        </ol>
    </nav>

    <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?php echo $item['imagem']; ?>" class="img-fluid rounded-start" alt="<?php echo $item['titulo']; ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $item['titulo']; ?></h2>
                    <p class="card-text"><strong>Categoria:</strong> <?php echo $item['categoria']; ?></p>
                    <p class="card-text"><strong>Descrição:</strong> <?php echo $item['descricao']; ?></p>
                    
                    <?php foreach($item as $chave => $valor): ?>
                        <?php if(!in_array($chave, ['titulo', 'categoria', 'descricao', 'imagem'])): ?>
                            <p class="card-text"><strong><?php echo ucfirst($chave); ?>:</strong> <?php echo $valor; ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <a href="index.php" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
