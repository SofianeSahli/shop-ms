<?php

namespace types;

use Category;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use app\models\Category as ModelsCategory;

require 'types/CategoryType.php';

class GraphQlListener
{
    private $categories = [];
    private    $shops =[];
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
                            $cat = new ModelsCategory();
                            return $cat->readAll();
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
