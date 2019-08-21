<?php

namespace Api\Contracts;

/**
 * Interface: iSupportOperations
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
interface iSupportOperations
{

    public function _find(int $id): ?iSupportOperations;

    public function _all(int $offset = 0, int $rows = 0): ?array;

    public function _delete(): bool;

    public function save(): ?iSupportOperations;

    public function delete(): bool;
}