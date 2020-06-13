<?php

namespace MyProject\Models\Users;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Exceptions\InvalidArgumentsException;

class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    private function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    public function getNickName(): string
    {
        return $this->nickname;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function signUp(array $userData): User
    {
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentsException('Nickname field cannot be empty!');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentsException('Nickname should contain only english letters and numbers!');
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentsException('Email field cannot be empty!');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentsException('Wrong email format!');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentsException('Password field cannot be empty!');
        }

        if (strlen($userData['password']) < 6) {
            throw new InvalidArgumentsException('Password should be greater than six char!');
        }

        if (static::findOne('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentsException('Nickname already exist!');
        }

        if (static::findOne('nickname', $userData['email']) !== null) {
            throw new InvalidArgumentsException('Email already exist!');
        }

        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }

    public static function login(array $loginDate): User
    {
        if (empty($loginDate['email'])) {
            throw new InvalidArgumentsException('Email is required');
        }

        if (empty($loginDate['password'])) {
            throw new InvalidArgumentsException('Password is required');
        }

        $user = User::findOne('email', $loginDate['email']);
        if ($user == null) {
            throw new InvalidArgumentsException('No user with this email');
        }

        if (!password_verify($loginDate['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentsException('Wrong Password!');
        }

        if (!$user->isConfirmed) {
            throw new InvalidArgumentsException('User dose not activated');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }
}