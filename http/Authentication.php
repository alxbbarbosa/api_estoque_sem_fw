<?php

namespace Api\Http;

/**
 * Classe: Authentication
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
class Authentication
{
    protected $header;
    protected $payload;

    public function __construct($usuario)
    {
        $this->header = $this->encode([
            'alg' => 'HS256',
            'typ' => 'JWT'
        ]);

        $this->payload = $this->encode([
            'iss' => 'localhost',
            'sub' => $usuario->id,
            'iat' => time(),
            'exp' => strtotime("+22 days", time()),
            'name' => $usuario->nome,
            'email' => $usuario->email
        ]);
    }

    public function signature(): string
    {
        $signature = hash_hmac('sha256', "{$this->header}.{$this->payload}",
            App::$secret, true);
        $signature = base64_encode($signature);
        return "$this->header.$this->payload.$signature";
    }

    public static function validate(string $token): bool
    {
        $token     = explode('.', $token);
        $header    = $token[0];
        $payload   = $token[1];
        $signature = $token[2];

        $valid = hash_hmac('sha256', "$header.$payload", App::$secret, true);
        $valid = base64_encode($valid);

        return $signature == $valid;
    }

    protected function encode($data)
    {
        $data = json_encode($data);
        $data = base64_encode($data);
        return $data;
    }
}