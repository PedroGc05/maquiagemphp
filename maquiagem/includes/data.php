<?php
// Base de dados do catálogo - simulação de banco de dados 
function obterCatalogo() {
    // Coleção base de produtos cadastrados
    $produtos = [
        1 => [
            'titulo' => 'Filme: O Poderoso Chefão',
            'categoria' => 'Cinema',
            'descricao' => 'Um drama sobre a família mafiosa Corleone sob o patriarca Vito Corleone.',
            'imagem' => 'assets/img/filme1.jpg',
            'ano' => '1972',
            'diretor' => 'Francis Ford Coppola'
        ],
        2 => [
            'titulo' => 'Livro: Dom Casmurro',
            'categoria' => 'Livro',
            'descricao' => 'Romance escrito por Machado de Assis, publicado em 1899.',
            'imagem' => 'assets/img/livro1.jpg',
            'autor' => 'Machado de Assis',
            'ano' => '1899'
        ],
        3 => [
            'titulo' => 'Filme: Interestelar',
            'categoria' => 'Filme',
            'descricao' => 'Um grupo de astronautas viaja através de um buraco de minhoca em busca de um novo lar para a humanidade.',
            'imagem' => 'assets/img/filme2.jpg',
            'ano' => '2014',
            'diretor' => 'Christopher Nolan'
        ],
        4 => [
            'titulo' => 'Livro: Orgulho e Preconceito',
            'categoria' => 'Livro',
            'descricao' => 'Romance de Jane Austen publicado em 1813.',
            'imagem' => 'assets/img/livro2.jpg',
            'autor' => 'Jane Austen',
            'ano' => '1813'
        ],
        5 => [
            'titulo' => 'Produto: Smartphone XYZ',
            'categoria' => 'Eletrônico',
            'descricao' => 'Smartphone com tela de 6.5 polegadas, 8GB RAM e 128GB de armazenamento.',
            'imagem' => 'assets/img/produto1.jpg',
            'preco' => 'R$ 2.500,00',
            'marca' => 'XYZ Tech'
        ]
    ];
      // Adicionar produtos da sessão, se existirem
    if (isset($_SESSION['catalogo_items']) && is_array($_SESSION['catalogo_items'])) {
        $id_final = max(array_keys($produtos));
        
        foreach ($_SESSION['catalogo_items'] as $produto) {
            $id_final++;
            $produtos[$id_final] = $produto;
        }
    }
    
    return $produtos;
}

// Retorna todas as categorias disponíveis no sistema
function listarCategorias() {
    $produtos = obterCatalogo();
    $tipos_categoria = [];
    
    foreach ($produtos as $produto) {
        if (!in_array($produto['categoria'], $tipos_categoria)) {
            $tipos_categoria[] = $produto['categoria'];
        }
    }
    
    return $tipos_categoria;
}

// Função para buscar um produto específico pelo código
function buscarProdutoPorCodigo($codigo) {
    $produtos = obterCatalogo();
    
    if (isset($produtos[$codigo])) {
        return $produtos[$codigo];
    }
    
    return null;
}

// Função para filtrar produtos por sua categoria
function filtrarProdutosPorTipo($tipo_categoria) {
    $produtos = obterCatalogo();
    $resultado = [];
    
    foreach ($produtos as $codigo => $produto) {
        if ($produto['categoria'] == $tipo_categoria) {
            $resultado[$codigo] = $produto;
        }
    }
    
    return $resultado;
}
