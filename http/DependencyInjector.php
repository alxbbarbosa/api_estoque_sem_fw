<?php

namespace Api\Http;

/**
 * Classe: DependencyInjector
 * =============================================================================
 * Objectivo:
 * 
 * 
 * 
 * =============================================================================
 * @author Alexandre Bezerra Barbosa <alxbbarbosa@hotmail.com>
 * 
 * @copyright 2015-2019 AB Babosa Serviços e Desenvolvimento ME
 * =============================================================================
 */
class DependencyInjector
{
    protected $services = [];

    public function __construct()
    {
        //
    }

    public function __isset($service)
    {
        return $this->services[$service];
    }

    public function register($service, callable $callback)
    {
        if (array_key_exists($service, $this->services)) {
            throw new \Exception("Service {$service} already exists");
        }
        $this->services[$service] = $callback;
        return $this;
    }

    public function getService($service)
    {
        if (!array_key_exists($service, $this->services)) {
            throw new \Exception("Service {$service} does not exists");
        }
        return call_user_func($this->services[$service]);
    }

    public function __set($service, callable $callable)
    {
        $this->register($service, $callback);
        return $this;
    }
}