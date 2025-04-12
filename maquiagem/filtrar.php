<?php
session_start();
include_once('includes/header.php');
include_once('includes/functions.php');
include_once('includes/data.php');

// Inicializar variáveis
$itens = getItens();
$categoriaFiltrada = '';

// Verificar se foi solicitado um filtro
if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $categoriaFiltrada = sanitizar($_GET['categoria']);
    $itens = filtrarItensPorCategoria($categoriaFiltrada);
}

$categorias = getCategorias();
?>

<div class="container mt-4">
    <h1 class="mb-4">Filtrar Catálogo</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="filtrar.php" method="GET">
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select name="categoria" id="categoria" class="form-select">
                        <option value="">Todas as categorias</option>
                        <?php foreach($categorias as $categoria): ?>
                            <option value="<?php echo $categoria; ?>" <?php echo ($categoriaFiltrada == $categoria) ? 'selected' : ''; ?>>
                                <?php echo $categoria; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="filtrar.php" class="btn btn-secondary">Limpar filtros</a>
            </form>
        </div>
    </div>
    
    <h2>Resultados</h2>
    
    <?php if (empty($itens)): ?>
        <div class="alert alert-info">
            Nenhum item encontrado com os filtros selecionados.
        </div>
    <?php else: ?>
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
    <?php endif; ?>
</div>

<?php include_once('includes/footer.php'); ?>
