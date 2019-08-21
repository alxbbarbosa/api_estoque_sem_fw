<?php

namespace Api\Models;

use Api\Database\Model;
/**
 * Classe: Usuario
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
class Usuario extends Model
{
    public function __construct()
    {
        parent::__construct('usuarios');
    }
}