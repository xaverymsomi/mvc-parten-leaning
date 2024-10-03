<?php
/*
 * This file is part of the Abc package.
 *
 * This source code is for educational purposes only. 
 * It is not recommended using it in production as it is.
 */

declare (strict_types = 1);

namespace Abc\Base;

use Abc\Utility\Log;
use PDO;

abstract class AbstractBaseModel extends BaseModel
{
    public function create($data)
    {
        Log::write('Saving a new object');
        $keys = implode(",", array_keys($data));
        $values = '\'' . implode("', '", array_values($data)) . '\'';

        $sql = 'INSERT INTO ' . $this->tableSchema . '(' . $keys . ') VALUES (' . $values . ')';
        // echo $sql;
        // exit;

        return $this->getDBConnection()->query($sql);
    }

    public function read($limit = null)
    {
        Log::write('Retrieving object(s) from the table');

        $limit = $limit ? ' LIMIT ' . $limit['from'] . ', ' . $limit['to'] : '';
        $sql = "SELECT * FROM " . $this->tableSchema . $limit;
        // echo $sql;
        // exit;

        $statement = $this->getDBConnection()->query($sql);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        // print_r($results);

        return $results;
    }

    public function update($id)
    {
        Log::write('Updating the object using its ID');
    }

    public function delete($id)
    {
        Log::write('Deleting the object using its ID');
    }

    public function count()
    {
        Log::write('Counting records in the table');
        $sql = "SELECT * FROM " . $this->tableSchema;

        $statement = $this->getDBConnection()->query($sql);
        // print_r($statement->rowCount());
        Log::write('Found ' . $statement->rowCount() . ' record(s)');

        return $statement->rowCount();
    }
}
