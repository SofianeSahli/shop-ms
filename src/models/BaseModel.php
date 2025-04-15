<?php
namespace app\models;

use config\database\Connection;
use PDO;

require './config/Connection.php';

abstract class BaseModel
{
    protected $pdo;
    protected $table;
    protected $primaryKey;
    protected array $columns;


    public function __construct(string $table_name, string $primaryKey, array $column)
    {
        $this->pdo = Connection::getInstance();
        $this->table = $table_name;
        $this->primaryKey = $primaryKey;
        $this->columns = $column;
    }


    // CRUD Methods:

    // CREATE: Insert a record
    public function create($data)
    {

        $columns = array_keys($data);
        $placeholders = array_map(function ($column) {
            return ":$column";
        }, $columns);

        $sql = "INSERT INTO $this->table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";

        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    // READ: Get a single record by ID
    public function read($id)
    {

        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // READ: Get all records
    public function readAll()
    {


        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE: Update a record by ID
    public function update($id, $data)
    {
        $setClause = [];
        foreach ($data as $column => $value) {
            $setClause[] = "$column = :$column";
        }

        $sql = "UPDATE $this->table SET " . implode(", ", $setClause) . " WHERE $this->primaryKey = :id";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    // DELETE: Delete a record by ID
    public function delete($id)
    {

        $sql = "DELETE FROM $this->table WHERE $this->primaryKey = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
