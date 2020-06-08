<?php

namespace MyProject\Controllers;

use Couchbase\PasswordAuthenticator;
use MyProject\Exceptions\InvalidArgumentsException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Views\View;
use MyProject\Services\EmailSender;

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

    public function activate(int $userId, string $activationCode){
        $user = User::getById($userId);
        $isValidCode = UserActivationService::checkActivationCode($user, $activationCode);
        if($isValidCode){
            $user->activate();
            echo 'Your account have been activated';
        }
    }
}