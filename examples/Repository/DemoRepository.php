<?php

namespace Examples\Repository;

use Examples\Entity\Demo;
use FastD\Database\ORM\Repository;

class DemoRepository extends Repository
{
    protected $table = 'demo';

    protected $fields = [
        'id' => [
            'type' => 'int',
            'name' => 'id',
        ],
        'nickname' => [
            'type' => 'varchar',
            'name' => 'nickname',
        ],
        'catId' => [
            'type' => 'int',
            'name' => 'category_id',
        ],
        'trueName' => [
            'type' => 'varchar',
            'name' => 'true_name',
        ],
    ];

    protected $keys = ['id' => 'id','nickname' => 'nickname','catId' => 'category_id','trueName' => 'true_name'];

    protected $entity = 'Examples\Entity\Demo';

    public function persist(Demo $demo)
    {}

    public function remove(Demo $demo)
    {}
}