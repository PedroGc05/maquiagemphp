<?php
// Funções úteis para o sistema

// Função para verificar login
function checarAutenticacao() {
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        header('Location: login.php');
        exit;
    }
}

// Função para cadastrar um novo item
function adicionarNovoItem($item) {
    // Verifica se já existe uma lista de itens na sessão
    if (!isset($_SESSION['catalogo_items'])) {
        $_SESSION['catalogo_items'] = [];
    }
    
    // Adiciona o novo item à lista
    $_SESSION['catalogo_items'][] = $item;
    
    return true;
}

// Função para gerar hash seguro de senha
function criarHashSenha($senha) {
    return password_hash($senha, PASSWORD_DEFAULT);
}

// Função para verificar senha
function validarSenha($senha, $hash) {
    return password_verify($senha, $hash);
}

// Função para sanitizar entrada de dados
function sanitizar($dado) {
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}

function getCategorias() {
    // Example categories, replace with actual data retrieval logic
    return ['Maquiagem', 'Perfumes', 'Cuidados com a Pele'];
}

function getItens() {
    return [
        1 => ['titulo' => 'Batom Vermelho', 'categoria' => 'Maquiagem', 'imagem' => 'img/batom.jpg'],
        2 => ['titulo' => 'Base Líquida', 'categoria' => 'Maquiagem', 'imagem' => 'img/base.jpg'],
        3 => ['titulo' => 'Paleta de Sombras', 'categoria' => 'Maquiagem', 'imagem' => 'img/sombras.jpg'],
    ];
}