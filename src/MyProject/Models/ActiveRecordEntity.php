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

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    /**
     * @return static[]
     */
    public static function getAll(): array
    {
        $db = Database::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $db = Database::getInstance();
        $entities = $db->query('SELECT * FROM `' . static::getTableName() . '` WHERE id = :id;',
            [':id' => $id],
            static::class);
        return $entities ? $entities[0] : null;
    }

    private function mapPropertyToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;

        }
        return $mappedProperties;
    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertyToDbFormat();
        if ($this->id === null) {
            $this->create($mappedProperties);
        } else {
            $this->update($mappedProperties);
        }
    }

    private function update(array $mappedProperties): void
    {

        $properties = [];
        $values = [];

        foreach ($mappedProperties as $column => $value) {
            $properties[] = $column . ' = :' . $column;
            $values[$column] = $value;
        }

        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $properties) . ' WHERE id = ' . $this->id;

        $db = Database::getInstance();
        $db->query($sql, $values, static::class);
    }

    private function create(array $mappedProperties): void
    {
        $properties = [];
        $values = [];
        $params = [];

        foreach ($mappedProperties as $column => $value) {
            if ($value !== null) {
                $properties[] = $column;
                $values[] = ':' . $column;
                $params[':' . $column] = $value;
            }
        }

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . implode(', ', $properties) . ')' . ' VALUES ' . '(' . implode(', ', $values) . ')';

        $db = Database::getInstance();
        $db->query($sql, $params, static::class);
        $this->id = $db->getLastInsertId();
        $db->getLastInsertId();
        $this->refresh();
    }

    public function refresh(): void
    {
        $objectFromDb = static::getById($this->id);
        $properties = get_object_vars($objectFromDb);

        foreach ($properties as $key => $value){
            $this->$key = $value;
        }
    }

    abstract protected static function getTableName(): string;
}