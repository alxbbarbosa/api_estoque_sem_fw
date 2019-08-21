<?php

namespace Api\Controllers;

use Api\Contracts\iControllerDefault;
use Api\Models\Transportadora;
use Api\Http\Request;
use Api\Http\Response;

/**
 * Classe: TransportadoraController
 * =============================================================================
 * Objectivo: Controlar o cadastro de transportadoras
 * 
 * 
 * 
 * =============================================================================
 * @author Alexandre Bezerra Barbosa <alxbbarbosa@hotmail.com>
 * 
 * @copyright 2015-2019 AB Babosa Serviços e Desenvolvimento ME
 * =============================================================================
 */
class TransportadoraController implements iControllerDefault
{

    public function create(Request $request)
    {
        if (auth_validate_token()) {
            $data = $request->all();
            if (Transportadora::create($data)) {
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
            if (Transportadora::destroy($id)) {
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
            return Transportadora::all();
        } else {
            return response()->json(['error' => 'Unauthorized access'], 401);
        }
    }

    public function show($id)
    {
        if (auth_validate_token()) {
            $data = Transportadora::find($id);
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Unauthorized access'], 401);
        }
    }

    public function update($id, Request $request)
    {
        if (auth_validate_token()) {
            $data    = $request->all();
            $cliente = Transportadora::find($id);
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