<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Services\Database;
use MyProject\Views\View;


class ArticlesController
{
    private $view;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $article_id)
    {
        $article = Article::getById($article_id);

        if (empty($article)) {
            $this->view->renderHtml('errors/404.php', [], 'Page Not Found', 404);
            return;
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article]);

    }
}