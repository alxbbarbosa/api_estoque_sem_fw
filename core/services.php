<?php
/**
 * Serviços do Injetor de dependência
 */
$service->register('Api\Http\Request',
    function() {
    return new \Api\Http\Request;
});
$service->register('Api\Http\Response',
    function() {
    return new \Api\Http\Response;
});
