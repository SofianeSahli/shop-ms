<?php
namespace models;

require_once 'BaseModel.php';

class Shop extends BaseModel
{
    public int $id;
    public string $name;
    public int $category_id;

    public function __construct(int $id, string $name, int $category_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category_id = $category_id;
    }
}
