<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

declare (strict_types = 1);

namespace Abc\Base;

use Abc\Database\Database as DB;
use Abc\Utility\ErrorHandler;
use Abc\Utility\Log;
use Exception;
use PDO;

class BaseModel
{
    protected ?string $tableSchema;
    protected ?string $tableSchemaID;
    protected ?PDO $db;

    public function __construct(string $tableSchema = null, string $tableSchemaID = null)
    {
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;

        $this->db = (new DB)->getConnection();
    }

    public function getSchemaID(): string
    {
        return $this->tableSchemaID;
    }

    public function getSchema(): string
    {
        return $this->tableSchema;
    }

    public function getDBConnection(): ?PDO
    {
        return $this->db;
    }

}