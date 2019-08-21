<?php

namespace Api\Http;

use Api\Http\Router;

/**
 * Classe: App
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
class App extends ApplicationBase
{

    public function handler()
    {
        $result = $this->find();
        if ($result) {
            return $this->call($result);
        }
        return null;
    }
}