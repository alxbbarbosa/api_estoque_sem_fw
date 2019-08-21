<?php

namespace Api\Http;

/**
 * Classe: ApplicationBase
 * =============================================================================
 * Objectivo: Apenas provê a base para App
 * 
 * 
 * 
 * =============================================================================
 * @author Alexandre Bezerra Barbosa <alxbbarbosa@hotmail.com>
 * 
 * @copyright 2015-2019 AB Babosa Serviços e Desenvolvimento ME
 * =============================================================================
 */
abstract class ApplicationBase
{
    public static $services;
    public static $secret;

    public function find()
    {
        $request = request();
        return self::invoke('router')->where($request->method(), $request->uri());
    }

    public function call($callback_package)
    {
        return (new Dispacher())->handler($callback_package);
    }

    public function __set($name, $callback)
    {
        self::$services[$name] = $callback;
    }

    public function __get($name)
    {
        return self::$services[$name];
    }

    public static function register(string $name, callable $callback)
    {
        $obj        = new static;
        $obj->$name = call_user_func($callback);
    }

    public static function invoke(string $name)
    {
        $obj = new static;
        return $obj->$name;
    }
}