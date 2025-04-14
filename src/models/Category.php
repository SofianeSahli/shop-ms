<?php
// Category.php
class Category
{
    public int $id;
    public string $category;

    public function __construct(int $id, string $category)
    {
        $this->id = $id;
        $this->category = $category;
    }
}
