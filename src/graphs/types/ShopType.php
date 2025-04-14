<?php

namespace types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


class ShopType extends ObjectType
{
    private static ShopType $shopType;

    public function __construct()
    {
        parent::__construct([
            'name' => 'Shop',
            'description' => 'Main addresses to fill the mall',
            'fields' => [
                'id' => Type::id(),
                'name' => Type::string(),
                'category_id' => Type::int(),
                // 'category' => [
                //     'type' => CategoryType::categoryType(),

                //     'resolve' => function ($shop) {

                //         return  array_find(
                //             [
                //                 ['id' => 1, 'name' => 'Electronics'],
                //                 ['id' => 2, 'name' => 'Clothing'],
                //                 ['id' => 3, 'name' => 'Groceries'],
                //                 ['id' => 4, 'name' => 'Furniture'],
                //                 ['id' => 5, 'name' => 'Books'],
                //                 ['id' => 6, 'name' => 'Beauty'],
                //             ],
                //             function ($item) use ($shop) {
                //                 return $item['id'] == $shop['category_id'];
                //             }
                //         );
                //     }
                // ],
            ],

        ]);
    }

    public static function shopType(): ShopType
    {
        return self::$shopType ??= new ShopType();
    }
}
