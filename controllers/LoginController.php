<?php

namespace Api\Controllers;

use Api\Http\Request;
use Api\Models\Usuario;
use Api\Http\Authentication;

/**
 * Classe: LoginController
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
class LoginController
{

    public function login(Request $request)
    {
        $data     = $request->only('username', 'password');
        $password = $data['password'];
        $usuario  = Usuario::where('username', '=', $data['username'])->first();
        // Necessário retirar o hash e inverter para senha criptorgrafada
        $check    = password_verify($password,
            password_hash($usuario->password, PASSWORD_DEFAULT));
        if ($check) {
            $jwt = new \Api\Http\Authentication($usuario);
            return [
                'username' => $usuario->username,
                'email' => $usuario->email,
                'token' => $jwt->signature()
            ];
        }
    }

    public function validate($token)
    {
        return Authentication::validate($token);
    }
}