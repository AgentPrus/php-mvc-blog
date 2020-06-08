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

    public function activate():void {
        $this->isConfirmed = true;
        $this->save();
    }
}