<?php
try {

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
    throw new \MyProject\Exceptions\NotFoundException();
}
unset($matches[0]);

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName();
$controller->$actionName(...$matches);
}catch (\MyProject\Exceptions\DbException $e){
    $view = new \MyProject\Views\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php',  ['error' => $e->getMessage()],'Server Error', 500);
} catch (\MyProject\Exceptions\NotFoundException $e){
    $view = new \MyProject\Views\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 'Page Not Found', 404);
} catch (\MyProject\Exceptions\UnauthorizedException $e){
    $view = new \MyProject\Views\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('401.php', ['error' => $e->getMessage()], 'Unauthorized', 401);
}
