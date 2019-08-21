<?php

namespace Api\Contracts;

/**
 * Interface: iDefaultOperations
 * =============================================================================
 * Objectivo: Cria o contrato de operações básicas do CRUD
 * 
 * 
 * 
 * =============================================================================
 * @author Alexandre Bezerra Barbosa <alxbbarbosa@hotmail.com>
 * 
 * @copyright 2015-2019 AB Babosa Serviços e Desenvolvimento ME
 * =============================================================================
 */
interface iDefaultOperations
{

    public static function setConnection(\PDO $conn);

    public static function create(array $array = []): ?iDefaultOperations;

    public static function find(int $id): ?iDefaultOperations;

    public static function all(int $offset = 0, int $rows = 0): ?array;

    public static function destroy(int $id): bool;
}