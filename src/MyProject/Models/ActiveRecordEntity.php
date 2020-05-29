<?php

namespace MyProject\Models;

use MyProject\Services\Database;

abstract class ActiveRecordEntity
{

    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * @return static[]
     */
    public static function getAll(): array
    {
        $db = new Database();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $db = new Database();
        $entities = $db->query('SELECT * FROM `' . static::getTableName() . '`;' . 'WHERE id= :id;',
            [':id' => $id],
            static::class);
        return $entities ? $entities[0] : null;
    }

    abstract protected static function getTableName(): string;
}