<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/12
 * Time: 上午11:15
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace FastD\Database\ORM;

use FastD\Database\Driver\Driver;

/**
 * Class Repository
 *
 * @package FastD\Database\Repository
 */
class Repository
{
    /**
     * @var
     */
    protected $table;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $keys;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var Driver
     */
    protected $connection;

    /**
     * @param Driver $driver
     */
    public function __construct(Driver $driver = null)
    {
        $this->connection = $driver;
    }

    /**
     * Return mapping database table full name.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Fetch one row.
     *
     * @param array $where
     * @param array $field
     * @return object The found object.
     */
    public function find(array $where = [], array $field = [])
    {
        return $this->connection->find($this->getTable(), $where, $field);
    }

    /**
     * Fetch all rows.
     *
     * @param array $where
     * @param array|string $field
     * @return object The found object.
     */
    public function findAll(array $where = [],  array $field = [])
    {
        return $this->connection->findAll($this->getTable(), $where, $field);
    }

    /**
     * @param array $data
     * @return int|bool
     */
    public function insert(array $data = array())
    {
        return $this->connection->insert($this->getTable(), $data);
    }
    /**
     * @param array $data
     * @param array $where
     * @return int|bool
     */
    public function update(array $data = [], array $where = [])
    {
        return $this->connection->update($this->getTable(), $data, $where);
    }

    /**
     * @param array $where
     * @return int|bool
     */
    public function count(array $where = [])
    {
        return $this->connection->count($this->getTable(), $where);
    }

    /**
     * @param $dql
     * @return Driver
     */
    public function createQuery($dql)
    {
        return $this->connection->createQuery($dql);
    }

    /**
     * @param int  $page
     * @param int  $showList
     * @param int  $showPage
     * @param null $lastId
     * @return \FastD\Database\Pagination\QueryPagination
     */
    public function pagination($page = 1, $showList = 25, $showPage = 5, $lastId = null)
    {
        return $this->connection->pagination($this->getTable(), $page, $showList, $showPage, $lastId);
    }

    /**
     * Return query errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->connection->getErrors();
    }

    /**
     * Return last query log.
     *
     * @return string
     */
    public function getLastQuery()
    {
        return $this->connection->getQueryString();
    }

    /**
     * Return all query logs.
     *
     * @return array
     */
    public function getQueryLogs()
    {
        return $this->connection->getLogs();
    }
}