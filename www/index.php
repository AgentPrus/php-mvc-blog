<?php
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
});

$route = $_GET['route'] ?? '';


$isRouteFound = false;
$routes = require __DIR__ . '/../src/routes.php';

foreach ($routes as $pattern => $controllerAndAction){
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}

if(!$isRouteFound){
    echo 'Page Not Found';
    return;
}
unset($matches[0]);

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName();
$controller->$actionName(...$matches);