<?php

namespace Config\Route;

use Common\Attributes\Route;
use Common\Helpers\HttpFoundation\AppResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseRouter
{
    protected static array $routes = [];

    public static function init(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = current(explode("?", $_SERVER['REQUEST_URI']));

        foreach (self::$routes as $row) {
            $route = $row['route'];
            if ($route->getMethod() === $requestMethod && $route->getPath() === $requestUri) {
                self::handleCallback([$row['class'], $row['method']]);
                return;
            }
        }
        echo '404 - Not Found';
    }

    private static function handleCallback($callback): void
    {
        is_callable($callback)
            ? $callback()
            : self::handleControllerCallback($callback);
    }

    private static function handleControllerCallback(array $callback): void
    {
        [$controllerName, $methodName] = $callback;

        if (class_exists($controllerName)) {
            $controller = new $controllerName();

            if (method_exists($controller, $methodName)) {
                $controller->$methodName(
                    request: Request::createFromGlobals(),
                    response: new AppResponse()
                );
            }
        }
    }

    public static function register(string $class): void
    {
        $reflection = new \ReflectionObject(new $class());

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attributes as $attribute) {
                $route = $attribute->newInstance();

                self::$routes[] = [
                    "route" => $route,
                    "class" => $class,
                    "method" => $method->getName()
                ];
            }
        }
    }
}
