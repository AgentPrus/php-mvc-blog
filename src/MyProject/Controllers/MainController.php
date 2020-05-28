<?php

namespace MyProject\Controllers;

use MyProject\Services\Database;
use MyProject\Views\View;

class MainController
{
    private $view;

    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Database();
    }

    public function main()
    {
        $articles = $this->db->query('SELECT * FROM `articles`;');
        $this->view->renderHtml('main/main.php', ['articles' => $articles], 'Home');
    }

    public function welcome(string $name)
    {
        $this->view->renderHtml('main/welcome.php', ['name' => $name], 'Welcome');
    }

    public function sayBye(string $name)
    {
        echo 'Bye ' . $name;
    }
}