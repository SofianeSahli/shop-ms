<?php

namespace app\models;
use app\models\BaseModel;

// Category.php
class Category extends BaseModel
{
    public int $id;
    public string $category;

    public function __construct()
    {
        parent::__construct('categories', 'id', ['name', 'id']);
    }
}
