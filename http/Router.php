<?php

namespace Api\Http;

/**
 * Classe: Router
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
class Router
{
    protected $collection = [];

    public function get($pattern, $callback)
    {
        return $this->action('get', $pattern, $callback);
    }

    public function post($pattern, $callback)
    {
        return $this->action('post', $pattern, $callback);
    }

    public function put($pattern, $callback)
    {
        return $this->action('put', $pattern, $callback);
    }

    public function patch($pattern, $callback)
    {
        return $this->action('patch', $pattern, $callback);
    }

    public function delete($pattern, $callback)
    {
        return $this->action('delete', $pattern, $callback);
    }

    public function resource($name, $controller)
    {
        $this->get("{$name}", "{$controller}@index");
        $this->get("{$name}/{id}", "{$controller}@show");
        $this->post("{$name}", "{$controller}@create");
        $this->put("{$name}/{id}", "{$controller}@update");
        $this->delete("{$name}/{id}", "{$controller}@delete");
    }

    public function action($verb, $pattern, $callback)
    {
        $this->collection[strtolower($verb)][$pattern] = $callback;
    }

    public function parseParams(array $pattern, array $uri)
    {
        foreach ($pattern as $key => $value) {
            if (preg_match("/\{[A-Za-z]{1,}\}/", $value)) {
                $param[str_replace('{', '', str_replace('}', '', $value))] = $uri[$key];
            }
        }
        $response         = new \stdClass();
        $response->params = $param ?? null;

        return $response;
    }

    public function parseCallback($callback)
    {
        $response = new \stdClass();
        if (is_callable($callback)) {
            $response->callback = $callback;
        } else if (is_string($callback) || is_array($callback)) {
            if (is_string($callback)) {
                $prepare = explode('@', $callback);
            } else {
                $prepare = array_values($callback);
            }
            $obj   = new $prepare[0];
            $teste = new \ReflectionClass($obj);
            if ($teste->hasMethod($prepare[1])) {
                $response->callback = $obj;
                $response->method   = $prepare[1];
            }
        }
        return $response;
    }

    public function where($verb, $uri)
    {
        $patterns = $this->collection[strtolower($verb)];

        $meta = '([A-Za-z0-9]{1,}|[1-9]|[1-9][0-9]{1,})';

        foreach ($patterns as $current => $callback) {
            if (preg_match("/\{[A-Za-z]{1,}\}/", $current, $matches)) {
                $test = preg_replace("/\{[A-Za-z]{1,}\}/", $meta, $current);
            } else {
                $test = $current;
            }

            if (preg_match("#^{$test}$#", $uri, $matches)) {
                $pattern   = explode('/', $current);
                $uriParams = explode('/', $uri);
                if (count($pattern) == count($uriParams)) {
                    return (object) array_merge((array) $this->parseCallback($callback),
                            (array) $this->parseParams($pattern, $uriParams));
                }
            }
        }
    }
}