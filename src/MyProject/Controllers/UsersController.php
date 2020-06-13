<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentsException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\UserAuthService;
use MyProject\Services\EmailSender;

class UsersController extends AbstractController
{
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
            $code = UserActivationService::createActivationCode($user);

            EmailSender::send($user, 'Activation', 'userActivation.php',
                [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

            $this->view->renderHtml('users/successSignUp.php', ['userEmail' => $user->getEmail()],
                'Registration');
            return;
        }
        $this->view->renderHtml('users/signUp.php', [], 'Registration');
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::getById($userId);
        $isValidCode = UserActivationService::checkActivationCode($user, $activationCode);
        //TODO: Handle possible exception
        if ($isValidCode) {
            $user->activate();
            echo 'Your account have been activated';
        }
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UserAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentsException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        if (!empty($_COOKIE['token'])) {
            setcookie('token', '', time() - 60 * 60 * 24 * 365, '/'); // delete cookie by name token
        }
        header('Location: /users/login');
    }
}