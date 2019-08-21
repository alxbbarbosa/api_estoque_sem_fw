<?php

function getConnection()
{
    return \Api\Database\Connection::getConnection();
}

function defineConnection($connection)
{
    \Api\Database\Model::setConnection($connection);
}

function app($service = null, callable $callback = null)
{
    if (is_null($service)) {
        return new \Api\Http\App();
    }
    if (is_null($callback)) {
        return \Api\Http\App::invoke($service);
    }
    \Api\Http\App::register($service, $callback);
}

function auth_validate_token($token = null)
{
    if (is_null($token)) {
        $token = request()->getBearerToken();
    }
    if (!is_null($token)) {
        return \Api\Http\Authentication::validate($token);
    }
    return false;
}

function request($data = null)
{
    return new \Api\Http\Request;
}

function response()
{
    return new \Api\Http\Response(true);
}
