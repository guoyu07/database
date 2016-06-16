<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Database\Tests\ORM;

use FastD\Database\Drivers\MySQLDriver;
use FastD\Database\Query\QueryBuilder;
use FastD\Database\Tests\Fixture_Database_TestCast;
use Test\Entities\TestEntity;

class EntityTest extends Fixture_Database_TestCast
{
    public function testEntityInit()
    {
        $entity = new TestEntity(new MySQLDriver(static::CONNECTION));
        
        $this->assertInstanceOf(QueryBuilder::class, $entity->getQueryBuilder());
    }
}