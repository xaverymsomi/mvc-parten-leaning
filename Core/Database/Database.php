<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

declare (strict_types = 1);

namespace Abc\Database;

use Abc\Utility\ErrorHandler;
use PDO;
use PDOException;

class Database
{
    private string $dbHost = 'localhost';
    private string $dbUname = 'root';
    private string $dbPass = '';
    private string $dbName = 'sample_db';
    private ?PDO $conn;
    
    public string $connection_status;

    protected array $params = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    public function __construct() {
        $this->open();
    }

    public function getConnection()
    {
        return $this->conn;
    }

    private function open(): self
    {
        try {
            $this->conn = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUname, $this->dbPass, $this->params);
            $this->connection_status = 'Connected';
            // return $this->conn;
        } catch (PDOException $e) {
            $this->conn = null;
            $this->connection_status = 'Failed';
            ErrorHandler::exceptionHandler($e, DB_LOG);
        }
        return $this;
    }

    private function close()
    {
        $this->conn = null;
    }

    public function __destruct()
    {
        $this->close();
    }
}
