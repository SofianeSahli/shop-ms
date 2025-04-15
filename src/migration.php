<?php

require_once './config/Connection.php';
require_once './config/FileMigrator.php';

use  config\database\FileMigrator;
use  config\database\Connection;

$env = file_get_contents(".env");
$lines = explode("\n", $env);

foreach ($lines as $line) {
    preg_match("/([^#]+)\=(.*)/", $line, $matches);
    if (isset($matches[2])) {
        putenv(trim($line));
    }
}

$connection = Connection::getInstance();
$migrator = new FileMigrator($connection);
$columns = [
    'name' => 'VARCHAR(255)',
    'id' => 'BIGINT AUTO_INCREMENT PRIMARY KEY'
];
$migrator->setTable('categories', $columns);
$data = [
    ['id' => 1, 'name' => 'Electronics'],
    ['id' => 2, 'name' => 'Clothing'],
    ['id' => 3, 'name' => 'Groceries'],
    ['id' => 4, 'name' => 'Furniture'],
    ['id' => 5, 'name' => 'Books'],
    ['id' => 6, 'name' => 'Beauty'],
];
$migrator->setData($data);


if ($migrator->runMigration()) {
    echo "Data  categories migrated successfully!";
} else {
    echo "Failed to migrate data!";
}


$migrator = new FileMigrator($connection);
$columns = [
    'name' => 'VARCHAR(255)',
    'id' => 'BIGINT AUTO_INCREMENT PRIMARY KEY',
    'category_id' => 'BIGINT,
            FOREIGN KEY (category_id) 
            REFERENCES categories(id)
            ON DELETE SET NULL 
            ON UPDATE CASCADE'
];
$migrator->setTable('shops', $columns);
$data =  [
    ['id' => 101, 'name' => 'Techie World', 'category_id' => 1],
    ['id' => 102, 'name' => 'Gadget Central', 'category_id' => 1],

    ['id' => 201, 'name' => 'Fashion Hub', 'category_id' => 2],
    ['id' => 202, 'name' => 'Style Street', 'category_id' => 2],

    ['id' => 301, 'name' => 'Fresh Mart', 'category_id' => 3],
    ['id' => 302, 'name' => 'Daily Grocer', 'category_id' => 3],

    ['id' => 401, 'name' => 'Home Comforts', 'category_id' => 4],
    ['id' => 402, 'name' => 'FurniStyle', 'category_id' => 4],

    ['id' => 501, 'name' => 'Book Nook', 'category_id' => 5],
    ['id' => 502, 'name' => 'Page Turners', 'category_id' => 5],

    ['id' => 601, 'name' => 'Glow & Go', 'category_id' => 6],
    ['id' => 602, 'name' => 'Beauty Bliss', 'category_id' => 6],
];
$migrator->setData($data);


if ($migrator->runMigration()) {
    echo "Data  categories migrated successfully!";
} else {
    echo "Failed to migrate data!";
}
