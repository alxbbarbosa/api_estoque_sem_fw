<?php
/**
 * Login
 */
$router->post('login', "\Api\Controllers\LoginController@login");

/**
 * Cadastros Gerais
 */
// Rotas Usuarios
$router->resource("usuarios", "\Api\Controllers\UsuarioController");

// Rotas Clientes
$router->resource("clientes", "\Api\Controllers\ClienteController");

// Rotas Fornecedores
$router->resource("fornecedores", "\Api\Controllers\FornecedorController");

// Rotas Transportadoras
$router->resource("transportadoras", "\Api\Controllers\TransportadoraController");

// Rotas Produtos
$router->resource("produtos", "\Api\Controllers\ProdutoController");
