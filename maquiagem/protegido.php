<?php
session_start();
include_once('includes/functions.php');
include_once('includes/data.php');

// Verificar se o usuário está logado
checarAutenticacao();

include_once('includes/header.php');

$operacao_concluida = false;
$mensagem_erro = '';

// Processar envio do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter e sanitizar os dados do formulário
    $titulo = sanitizar($_POST['titulo'] ?? '');
    $categoria = sanitizar($_POST['categoria'] ?? '');
    $descricao = sanitizar($_POST['descricao'] ?? '');
    $imagem = sanitizar($_POST['imagem'] ?? '');
      // Validar dados recebidos
    if (empty($titulo) || empty($categoria) || empty($descricao) || empty($imagem)) {
        $mensagem_erro = 'Todos os campos marcados com * são obrigatórios.';
    } else {
        // Preparar dados do produto para cadastro
        $produto_dados = [
            'titulo' => $titulo,
            'categoria' => $categoria,
            'descricao' => $descricao,
            'imagem' => $imagem,
        ];
        
        // Processar atributos adicionais
        // Primeiro atributo opcional
        if (!empty($_POST['atributo1_nome']) && !empty($_POST['atributo1_valor'])) {
            $nome_atributo = sanitizar($_POST['atributo1_nome']);
            $produto_dados[$nome_atributo] = sanitizar($_POST['atributo1_valor']);
        }
        
        // Segundo atributo opcional
        if (!empty($_POST['atributo2_nome']) && !empty($_POST['atributo2_valor'])) {
            $nome_atributo = sanitizar($_POST['atributo2_nome']);
            $produto_dados[$nome_atributo] = sanitizar($_POST['atributo2_valor']);
        }
        
        // Registrar o novo produto no catálogo
        if (adicionarNovoItem($produto_dados)) {
            $operacao_concluida = true;
        } else {
            $mensagem_erro = 'Não foi possível adicionar o produto ao catálogo.';
        }
    }
}
?>

<div class="container mt-4">
    <h1>Área Restrita - Cadastro de Itens</h1>
    
    <div class="alert alert-info mb-4">
        Bem-vindo à área restrita, <?php echo $_SESSION['usuario']; ?>! Aqui você pode cadastrar novos itens para o catálogo.
    </div>
      <?php if ($operacao_concluida): ?>
        <div class="alert alert-success">
            Produto adicionado com sucesso ao catálogo!
        </div>
    <?php endif; ?>
    
    <?php if (!empty($mensagem_erro)): ?>
        <div class="alert alert-danger">
            <?php echo $mensagem_erro; ?>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <h2>Cadastrar Novo Item</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="protegido.php">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título *</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria *</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach(getCategorias() as $categoria): ?>
                            <option value="<?php echo $categoria; ?>"><?php echo $categoria; ?></option>
                        <?php endforeach; ?>
                        <option value="Nova">Nova Categoria</option>
                    </select>
                </div>
                
                <div class="mb-3" id="nova-categoria-div" style="display:none;">
                    <label for="nova-categoria" class="form-label">Nova Categoria</label>
                    <input type="text" class="form-control" id="nova-categoria" name="nova_categoria">
                </div>
                
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição *</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="imagem" class="form-label">URL da Imagem *</label>
                    <input type="text" class="form-control" id="imagem" name="imagem" required>
                    <small class="form-text text-muted">Exemplo: assets/img/produto1.jpg</small>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="atributo1_nome" class="form-label">Atributo Extra 1 (Nome)</label>
                        <input type="text" class="form-control" id="atributo1_nome" name="atributo1_nome" placeholder="Ex: Autor, Marca, Ano">
                    </div>
                    <div class="col-md-6">
                        <label for="atributo1_valor" class="form-label">Valor</label>
                        <input type="text" class="form-control" id="atributo1_valor" name="atributo1_valor">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="atributo2_nome" class="form-label">Atributo Extra 2 (Nome)</label>
                        <input type="text" class="form-control" id="atributo2_nome" name="atributo2_nome" placeholder="Ex: Diretor, Preço, Edição">
                    </div>
                    <div class="col-md-6">
                        <label for="atributo2_valor" class="form-label">Valor</label>
                        <input type="text" class="form-control" id="atributo2_valor" name="atributo2_valor">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Cadastrar Item</button>
                <a href="index.php" class="btn btn-secondary">Voltar para o Catálogo</a>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('categoria');
    const novaCategoriaDiv = document.getElementById('nova-categoria-div');
    const novaCategoriaInput = document.getElementById('nova-categoria');
    
    categoriaSelect.addEventListener('change', function() {
        if (this.value === 'Nova') {
            novaCategoriaDiv.style.display = 'block';
            novaCategoriaInput.setAttribute('required', 'required');
        } else {
            novaCategoriaDiv.style.display = 'none';
            novaCategoriaInput.removeAttribute('required');
        }
    });
});
</script>

<?php include_once('includes/footer.php'); ?>
