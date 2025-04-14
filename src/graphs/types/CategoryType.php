<?php

namespace types;

use Category;
use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

require 'ShopType.php';
class CategoryType extends ObjectType
{
    private static CategoryType $categoryType;

    public    $shops = [
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
    public function __construct()
    {

        parent::__construct([
            'name' => 'Category',
            'description' => 'Categories types',
            'fields' =>  [
                'id' => Type::id(),
                'name' => Type::string(),
                'shops' => [
                    'name'=>'shops',
                    'type' => Type::listOf(ShopType::shopType()),
                    'resolve' => function ($category){
                        return array_filter($this->shops, function ($item)  use ($category) {
              
                            return $item['category_id'] == $category['id'];
                        });
                    }
                ],

            ]
        ]);
    }


    public static function categoryType(): CategoryType
    {
        return self::$categoryType ??= new CategoryType();
    }
}
