<?php

namespace config\database;

use PDOException;

class FileMigrator
{
    private $pdo;
    private $table;
    private $columns;
    private $data;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function setTable($table, $columns)
    {
        $this->table = $table;
        $this->columns = $columns;
    }

    public function setData($data = [])
    {
        $this->data = $data;
    }

    public function createTable()
    {
        $columnsSql = [];
        foreach ($this->columns as $name => $type) {
            $columnsSql[] = "$name $type";
        }
        $columnsSql = implode(', ', $columnsSql);
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} ($columnsSql)";
        $this->pdo->exec($sql);
    }

    public function migrate()
    {
        foreach ($this->data as $singleRow) {
            $columnNames = implode(", ", array_keys($singleRow));
            $placeholders = implode(", ", array_fill(0, count($singleRow), '?'));
            $values = array_values($singleRow);
            $sql = "INSERT INTO {$this->table} ($columnNames) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);


            try {
                $stmt->execute($values);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return true;
    }

    public function runMigration()
    {
        $this->createTable();
        if (!empty($this->data)) {
            return $this->migrate();
        }
        return true;
    }
}
