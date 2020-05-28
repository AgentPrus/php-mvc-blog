<?php
use MyProject\Controllers\MainController;
use MyProject\Controllers\ArticlesController;
return [
    '~^welcome/(.*)$~' => [MainController::class, 'welcome'],
    '~articles/(\d+)$~' => [ArticlesController::class, 'view'],
    '~^$~' => [MainController::class, 'main']
];