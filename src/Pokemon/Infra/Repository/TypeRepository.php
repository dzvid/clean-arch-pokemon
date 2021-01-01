<?php

declare(strict_types=1);

namespace App\Pokemon\Infra\Repository;

use App\Pokemon\Domain\Factory\TypeFactory;
use App\Pokemon\Domain\Type;
use App\Pokemon\Application\UseCases\Contracts\TypeRepository as TypeRepositoryInterface;
use App\Shared\Contracts\DatabaseConnection;

class TypeRepository implements TypeRepositoryInterface
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function findTypeByName(string $name): ?Type
    {
        $row = $this->connection
            ->setTable('pokemon_types')
            ->select(['conditions' => ['name' => $name]])
            ->fetchOne();

        if (!$row) {
            return null;
        }

        $row['id'] = (int)$row['id'];

        return TypeFactory::create($row);
    }

    public function createType(Type $type): Type
    {
        $insert = $this->connection
            ->setTable('pokemon_types')
            ->insert($type->toArray())
            ->execute();

        $type->setId($this->connection->lastInsertId());

        return $type;
    }

    public function get(int $pk): ?Type
    {
        $row = $this->connection
            ->setTable('pokemon_types')
            ->select(['conditions' => ['id' => $pk]])
            ->fetchOne();

        if (!$row) {
            return null;
        }

        $row['id'] = (int)$row['id'];

        return TypeFactory::create($row);
    }
}