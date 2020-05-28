<?php

namespace MyProject\Controllers;

use MyProject\Services\Database;
use MyProject\Views\View;


class ArticlesController {
    private $view;
    private $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view($article_id){
        $article = $this->db->query('SELECT * FROM `articles` WHERE id = :id', ['id' => $article_id]);

        if(empty($article)){
            $this->view->renderHtml('errors/404.php', [], 'Page Not Found', 404);
            return;
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article[0]]);
    }
}