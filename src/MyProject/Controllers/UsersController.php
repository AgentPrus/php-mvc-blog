<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentsException;
use MyProject\Models\Users\User;
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
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentsException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
        }

        if ($user instanceof User) {
            $this->view->renderHtml('users/successSignUp.php', ['userEmail' => $user->getEmail()], 'Registration');
            return;
        }
        $this->view->renderHtml('users/signUp.php', [], 'Registration');
    }
}