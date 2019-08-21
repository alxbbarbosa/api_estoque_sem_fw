<?php

namespace Api\Http;

/**
 * Classe: Dispacher
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
class Dispacher
{

    public function handler($callback_package)
    {
        return $this->dispach($callback_package);
    }

    protected function dispach($callback_package)
    {
        if (is_object($callback_package->callback)) {
            $test = new \ReflectionClass($callback_package->callback);
            if ($test->hasMethod($callback_package->method)) {
                $methods   = $test->getMethod($callback_package->method);
                $di_params = $methods->getParameters();
                $injected  = [];
                foreach ($di_params as $k => $p) {
                    $test_p = $p->getClass();
                    if ($test_p) {
                        $injected[$p->getName()] = app('di')->getService($test_p->getName());
                    }
                }
                if (count($injected) > 0) {
                    if (!is_null($callback_package->params)) {
                        $callback_package->params = array_merge($callback_package->params,
                            $injected);
                    } else {
                        $callback_package->params = $injected;
                    }
                }
                return call_user_func_array(array($callback_package->callback, $callback_package->method),
                    $callback_package->params ?? []);
            }
        } else if (is_callable($callback_package)) {
            return call_user_func($callback_package->callback,
                $callback_package->params ?? []);
        }
    }
}