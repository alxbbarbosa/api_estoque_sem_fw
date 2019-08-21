<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

include_once './vendor/autoload.php';

try {
    /**
     * Define um hash para aplicação
     */
    \Api\Http\App::$secret  = hash_hmac('sha256', "this-is-an-example", true);
    /**
     *  Configurando conexão com banco de dados nos Models ORM
     */
    defineConnection(getConnection());

    /**
     * Configurar Injetor de Dependência do Container
     */
    app('di',
        function() {
        $service = new Api\Http\DependencyInjector();
        include_once './core/services.php';
        return $service;
    });

    /**
     * Configurar roteador e adicionar rotas
     */
    app('router',
        function() {
        $router = new Api\Http\Router();
        include_once './routes/api.php';
        return $router;
    });
} catch (\Exception $e) {
    echo $e->getMessage();
}