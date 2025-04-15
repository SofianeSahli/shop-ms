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
             
            ],

        ]);
    }

    public static function shopType(): ShopType
    {
        return self::$shopType ??= new ShopType();
    }
}
