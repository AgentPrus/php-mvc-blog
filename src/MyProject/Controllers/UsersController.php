<?php

namespace MyProject\Controllers;

use MyProject\Views\View;

class UsersController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function signUp()
    {
        $this->view->renderHtml('users/signUp.php', [], 'Registration');
    }

}