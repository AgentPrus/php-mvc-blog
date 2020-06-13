<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Services\UserAuthService;

class MainController extends AbstractController
{
    public function main()
    {
        $articles = Article::getAll();
        $this->view->renderHtml('main/main.php',
            [
                'articles' => $articles,
                'user' => UserAuthService::getUserByToken()
            ], 'Home');
    }
}