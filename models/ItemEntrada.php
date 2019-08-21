<?php

namespace Api\Models;
use Api\Database\Model;
/**
 * Classe: ItemEntrada
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
class ItemEntrada extends Model
{
    public function __construct()
    {
        parent::__construct('itens_entrada');
    }
}