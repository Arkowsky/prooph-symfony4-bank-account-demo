<?php

namespace App\Projection;

trait ReadModelTrait
{
    public function init(): void
    {
        $sql = $this->getSchemaDefinition()->toSql($this->connection->getDatabasePlatform())[0];
        $statement = $this->connection->prepare($sql);

        $statement->execute();
    }
}