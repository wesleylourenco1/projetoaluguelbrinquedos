<?php
class Router
{
    private $routes = [];

    public function addRoute($url, $handler)
    {
        $this->routes[$url] = $handler;
    }

    public function handleRequest($url)
    {
        if (array_key_exists($url, $this->routes)) {
            $handler = $this->routes[$url];

            if (is_callable($handler)) {
                $handler();
            } elseif (is_string($handler) && strpos($handler, '@') !== false) {
                list($class, $method) = explode('@', $handler);
                $instance = new $class();
                $instance->$method();
            } else {
                echo "Handler inválido para a rota: $url";
            }
        } else {
            echo "Rota não encontrada: $url";
        }
    }
}
