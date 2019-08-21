<?php

namespace Api\Http;

/**
 * Classe: Request
 * =============================================================================
 * Objectivo: Administrar as requisições enviadas ao servidor
 * 
 * 
 * 
 * =============================================================================
 * @author Alexandre Bezerra Barbosa <alxbbarbosa@hotmail.com>
 * 
 * @copyright 2015-2019 AB Babosa Serviços e Desenvolvimento ME
 * =============================================================================
 */
class Request
{
    protected $data    = [];
    protected $headers = [];
    protected $full_uri;
    protected $method;
    protected $protocol;
    protected $uri;
    protected $token;

    public function __construct()
    {
        $this->headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $this->headers[str_replace(' ', '-',
                        ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))))]
                    = $value;
            }
        }

        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $this->token = $_SERVER['HTTP_AUTHORIZATION'];
        } else if (isset($_SERVER['Authorization'])) {
            $this->token = $_SERVER['Authorization'];
        }

        foreach (getallheaders() as $key => $value) {
            $this->headers[$key] = $value;
        }
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        switch ($this->method) {
            case 'post':
                $this->data = $this->collectData($_POST);
                break;
            case 'get':
                $this->data = $this->collectData($_GET);
                break;
            case 'put':
            case 'patch':
            case 'delete':
            case 'head':
            case 'option':
                parse_str(file_get_contents("php://input"), $data);
                $this->data = $this->collectData($data);
                break;
        }

        $this->uri      = $_REQUEST['uri'];
        $this->full_uri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
                ? "https" : "http")."://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    protected function collectData($data)
    {
        if (isset($this->headers['Content-Type']) && $this->headers['Content-Type']
            == 'application/json') {
            $data = array_filter($data);
            if (empty($data)) {
                $data = (array) json_decode(file_get_contents("php://input"));
            } else {
                $data = json_decode(array_pop($data));
            }
        }
        if (is_string($data)) {
            $data = json_decode($data);
        }
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = htmlspecialchars(strip_tags($value));
            }
        }
        return $data;
    }

    public function getBearerToken()
    {
        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $this->token, $matches)) {
            $token = $matches[1];
        }
        return $token;
    }

    public function fullUri()
    {
        return $this->full_uri;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function method()
    {
        return $this->method;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function header($header)
    {
        if (isset($this->headers[$header])) {
            return $this->headers[$header];
        }
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function all()
    {
        return $this->data;
    }

    public function input($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
    }

    public function get($name)
    {
        return $this->input($name);
    }

    public function only($args)
    {
        if (func_num_args() > 0) {
            $args   = func_get_args();
            $result = [];
            foreach ($this->data as $key => $value) {
                if (in_array($key, $args)) {
                    $result[$key] = $value;
                }
            }
            return $result;
        }
    }

    public function except($args)
    {
        if (func_num_args() > 0) {
            $args   = func_get_args();
            $result = [];
            foreach ($this->data as $key => $value) {
                if (!in_array($key, $args)) {
                    $result[$key] = $value;
                }
            }
            return $result;
        }
    }
}