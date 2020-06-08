<?php

namespace MyProject\Models\Users;

use MyProject\Services\Database;

class UserActivationService
{
    private const TABLE_NAME = 'users_activation_code';

    public static function createActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));

        $db = Database::getInstance();
        $db->query(
            'INSERT INTO ' . self::TABLE_NAME . ' (user_id, code) VALUES (:user_id, :code)',
            [
                'user_id' => $user->getId(),
                'code' => $code
            ]);

        return $code;
    }

    public static function checkActivationCode(User $user, string $code):bool
    {
        $db = Database::getInstance();
        $result = $db->query('SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id = :id AND code = :code',
            [
                'id' => $user->getId(),
                'code' => $code
            ]);
        return !empty($result);
    }
}