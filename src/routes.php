<?php
use MyProject\Controllers\MainController;
use MyProject\Controllers\ArticlesController;
return [
    '~^welcome/(.*)$~' => [MainController::class, 'welcome'],
    '~articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'],
    '~^articles/create$~' => [ArticlesController::class, 'create'],
    '~^$~' => [MainController::class, 'main']
];