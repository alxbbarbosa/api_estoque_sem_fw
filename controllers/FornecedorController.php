<?php

namespace Api\Controllers;

use Api\Contracts\iControllerDefault;
use Api\Models\Fornecedor;
use Api\Http\Request;
use Api\Http\Response;

/**
 * Classe: FornecedorController
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
class FornecedorController implements iControllerDefault
{

    public function create(Request $request)
    {
        if (auth_validate_token()) {
            $data = $request->all();
            if (Fornecedor::create($data)) {
                return response()->json(['message' => 'Created successfuly'],
                        201);
            }
            return response()->json(['message' => 'Could not be created'], 400);
        } else {
            return response()->json(['error' => 'Unauthorized access'], 401);
        }
    }

    public function delete($id)
    {
        if (auth_validate_token()) {
            if (Fornecedor::destroy($id)) {
                return response()->json(['message' => 'Deleted successfuly'],
                        204);
            }
            return response()->json(['message' => 'Could not be deleted'], 400);
        } else {
            return response()->json(['error' => 'Unauthorized access'], 401);
        }
    }

    public function index()
    {
        if (auth_validate_token()) {
            return Fornecedor::all();
        } else {
            return response()->json(['error' => 'Unauthorized access'], 401);
        }
    }

    public function show($id)
    {
        if (auth_validate_token()) {
            $data = Fornecedor::find($id);
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Unauthorized access'], 401);
        }
    }

    public function update($id, Request $request)
    {
        if (auth_validate_token()) {
            $data    = $request->all();
            $cliente = Fornecedor::find($id);
            if ($cliente) {
                $cliente->update($data);
                return response()->json(['message' => 'Updated successfuly'],
                        200);
            }
            return response()->json(['message' => 'Could not be updated'], 400);
        } else {
            return response()->json(['error' => 'Unauthorized access'], 401);
        }
    }
}