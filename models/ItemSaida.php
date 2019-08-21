<?php

namespace Api\Models;
use Api\Database\Model;
/**
 * Classe: ItemSaida
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
class ItemSaida extends Model
{
    public function __construct()
    {
        parent::__construct('itens_saida');
    }
}