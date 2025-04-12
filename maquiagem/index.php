<?php
session_start();
include_once('includes/header.php');
include_once('includes/functions.php');
include_once('includes/data.php');
require_once 'funcoes.php';

// Verificar se há itens adicionados na sessão
$itens = getItens();
?>

<div class="container mt-4">
    <h1 class="mb-4">Catálogo de Produtos</h1>
    
    <div class="mb-4">
        <form action="filtrar.php" method="GET" class="form-inline">
            <div class="form-group mr-2">
                <label for="categoria" class="mr-2">Filtrar por categoria:</label>
                <select name="categoria" id="categoria" class="form-control">
                    <option value="">Todas as categorias</option>
                    <?php foreach(getCategorias() as $categoria): ?>
                        <option value="<?php echo $categoria; ?>"><?php echo $categoria; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
    </div>

    <div class="row">
        <?php foreach($itens as $id => $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo $item['imagem']; ?>" class="card-img-top" alt="<?php echo $item['titulo']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $item['titulo']; ?></h5>
                        <p class="card-text">Categoria: <?php echo $item['categoria']; ?></p>
                        <a href="detalhes.php?id=<?php echo $id; ?>" class="btn btn-primary">Ver mais</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
