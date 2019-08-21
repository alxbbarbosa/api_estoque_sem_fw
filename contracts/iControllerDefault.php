<?php

namespace Api\Contracts;
use Api\Http\Request;

/**
 * Interface: iControllerDefault
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
interface iControllerDefault
{

    public function index();

    public function show($id);

    public function create(Request $request);

    public function update($id, Request $request);

    public function delete($id);
}