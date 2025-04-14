<?php

namespace types;

use Category;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

require 'types/CategoryType.php';

class GraphQlListener
{
    private $categories = [
        ['id' => 1, 'name' => 'Electronics'],
        ['id' => 2, 'name' => 'Clothing'],
        ['id' => 3, 'name' => 'Groceries'],
        ['id' => 4, 'name' => 'Furniture'],
        ['id' => 5, 'name' => 'Books'],
        ['id' => 6, 'name' => 'Beauty'],
    ];
    private    $shops = [
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
    public $schema;
    public function __construct()
    {

        $this->schema = new Schema([
            'query' => new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'shopsByCategoryId' => [
                        'type' => Type::listOf(ShopType::shopType()),
                        'args' => [
                            'id' => Type::nonNull(Type::int()),

                        ],
                        'resolve' => function ($rootValue, $args) {
                            return array_filter($this->shops, function ($item)  use ($args) {
                                return $item['category_id'] == $args['id'];
                            });
                        }
                    ],

                    'categoriesById' => [
                        'name' => 'categoriesById',
                        'type' => CategoryType::categoryType(),
                        'args' => [
                            'id' => Type::nonNull(Type::int()),

                        ],

                        'resolve' => function ($rootValue, $args) {
                            return array_find($this->categories, function ($item)  use ($args) {
                                return $item['id'] == $args['id'];
                            });
                        }
                    ],
                    'categories' => [
                        'name' => 'categories',

                        'type' => Type::listOf(CategoryType::categoryType()),
                        'resolve' => function ($rootValue, $args) {
                            return $this->categories;
                        }
                    ],

                ]
            ])
        ]);
    }

    public function listen()
    {
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];
        $variableValues = isset($input['variables']) ? $input['variables'] : null;

        try {
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQL::executeQuery($this->schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (\Exception $e) {
            $output = [
                'errors' => [
                    [
                        $e->getMessage()
                    ]
                ]

            ];
        }
        header('Content-Type: application/json');
        echo json_encode($output, JSON_THROW_ON_ERROR);
    }
}
