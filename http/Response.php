<?php

namespace Api\Http;

/**
 * Classe: Response
 * =============================================================================
 * Objectivo: Administrar as respostas enviadas ao cliente
 * 
 * 
 * 
 * =============================================================================
 * @author Alexandre Bezerra Barbosa <alxbbarbosa@hotmail.com>
 * 
 * @copyright 2015-2019 AB Babosa Serviços e Desenvolvimento ME
 * =============================================================================
 */
class Response
{
    protected $content;
    protected $headers;
    protected $code;
    protected $http_status_codes = [100 => "Continue", 101 => "Switching Protocols",
        102 => "Processing", 200 => "OK", 201 => "Created", 202 => "Accepted", 203 => "Non-Authoritative Information",
        204 => "No Content", 205 => "Reset Content", 206 => "Partial Content", 207 => "Multi-Status",
        300 => "Multiple Choices", 301 => "Moved Permanently", 302 => "Found", 303 => "See Other",
        304 => "Not Modified", 305 => "Use Proxy", 306 => "(Unused)", 307 => "Temporary Redirect",
        308 => "Permanent Redirect", 400 => "Bad Request", 401 => "Unauthorized",
        402 => "Payment Required", 403 => "Forbidden", 404 => "Not Found", 405 => "Method Not Allowed",
        406 => "Not Acceptable", 407 => "Proxy Authentication Required", 408 => "Request Timeout",
        409 => "Conflict", 410 => "Gone", 411 => "Length Required", 412 => "Precondition Failed",
        413 => "Request Entity Too Large", 414 => "Request-URI Too Long", 415 => "Unsupported Media Type",
        416 => "Requested Range Not Satisfiable", 417 => "Expectation Failed", 418 => "I'm a teapot",
        419 => "Authentication Timeout", 420 => "Enhance Your Calm", 422 => "Unprocessable Entity",
        423 => "Locked", 424 => "Failed Dependency", 424 => "Method Failure", 425 => "Unordered Collection",
        426 => "Upgrade Required", 428 => "Precondition Required", 429 => "Too Many Requests",
        431 => "Request Header Fields Too Large", 444 => "No Response", 449 => "Retry With",
        450 => "Blocked by Windows Parental Controls", 451 => "Unavailable For Legal Reasons",
        494 => "Request Header Too Large", 495 => "Cert Error", 496 => "No Cert",
        497 => "HTTP to HTTPS", 499 => "Client Closed Request", 500 => "Internal Server Error",
        501 => "Not Implemented", 502 => "Bad Gateway", 503 => "Service Unavailable",
        504 => "Gateway Timeout", 505 => "HTTP Version Not Supported", 506 => "Variant Also Negotiates",
        507 => "Insufficient Storage", 508 => "Loop Detected", 509 => "Bandwidth Limit Exceeded",
        510 => "Not Extended", 511 => "Network Authentication Required", 598 => "Network read timeout error",
        599 => "Network connect timeout error"];

    public function __construct($default = true)
    {
        $this->headers = [];
        if ($default) {
            $this->setDefaultApiHeader();
        }
    }

    public function setDefaultApiHeader()
    {
        foreach ([
        "Access-Control-Allow-Origin" => "*",
        "Content-Type" => "application/json; charset=UTF-8"
        ] as $key => $value) {
            $this->headers[$key] = $value;
        }
    }

    public function setApiHeaderJustRead()
    {
        foreach ([
        "Access-Control-Allow-Headers" => " access",
        "Access-Control-Allow-Methods" => "GET",
        "Access-Control-Allow-Credentials" => " true"
        ] as $key => $value) {
            $this->headers[$key] = $value;
        }
    }

    public function setApiHeaderPostUpateDelete()
    {
        foreach ([
        "Access-Control-Allow-Methods" => "POST",
        "Access-Control-Max-Age" => "3600",
        "Access-Control-Allow-Headers" => "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With",
        ] as $key => $value) {
            $this->headers[$key] = $value;
        }
    }

    public function setContent($content)
    {
        if (is_object($content) && $content instanceof Response) {
            $this->headers = $content->headers;
            $this->code    = $content->code;
            $content       = $content->getContent();
        }
        $this->content = is_string($content) ? $content : (string) json_encode($content);
        return $this;
    }

    public function withHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function sendHeaders()
    {
        if (headers_sent()) {
            return $this;
        }
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }
        return $this;
    }

    public function sendContent()
    {
        echo (string) $this->content;
        return $this;
    }

    public function json($array, $code = 200)
    {
        if (is_object($array)) {
            $test = new \ReflectionClass($array);
            if ($test->hasMethod('toArray')) {
                $array = $array->toArray();
            } else {
                $array = (array) $array;
            }
        } else if (!is_array($array)) {
            throw new Exception("Formato não é valido");
        }

        $this->code = $code;
        $this->setContent(json_encode($array));
        return $this;
    }

    public function send()
    {
        http_response_code($this->code);
        $this->sendHeaders();
        $this->sendContent();
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
}