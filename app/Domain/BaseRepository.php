<?php
declare(strict_types=1);

namespace App\Domain;


abstract class BaseRepository
{
    protected static string $modelClass;

    public function add(BaseModel $entity): BaseModel
    {
        $entity->save();
        return $entity;
    }

    public function update(BaseModel $entity): BaseModel
    {
        $entity->save();
        return $entity;
    }

    public function delete(BaseModel $entity): bool
    {
        return (bool) $entity->delete();
    }

    public function findOneByUuid(string $uuid): BaseModel
    {
        /**
         * @var class-string $className
         */
        $className = static::$modelClass;

        return $className::find($uuid);
    }
}
