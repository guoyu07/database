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

use FastD\Database\Drivers\DriverInterface;
use FastD\Http\Request;

/**
 * Class Repository
 *
 * @package FastD\Database\Repository
 */
abstract class Repository
{
    /**
     * @var string
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
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var array
     */
    protected $structure = [];

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $params;

    /**
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface = null)
    {
        $this->setDriver($driverInterface);
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param DriverInterface|null $driverInterface
     * @return $this
     */
    public function setDriver(DriverInterface $driverInterface = null)
    {
        $this->driver = $driverInterface;

        return $this;
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
     * @return Entity
     */
    public function getEntity()
    {
        if (!($this->entity instanceof Entity)) {
            $this->entity = new $this->entity($this->getDriver());
        }

        return clone $this->entity;
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
        return $this->driver
            ->table(
                $this->getTable()
            )
            ->where($where)
            ->field(array () === $field ? $this->getFields() : $field)
            ->find()
            ;
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
        return $this->driver
            ->table(
                $this->getTable()
            )
            ->where($where)
            ->field($field)
            ->findAll()
        ;
    }

    /**
     * Save row into table.
     *
     * @param array $data
     * @param array $where
     * @param array $params
     * @return bool|int
     */
    public function save(array $data = [], array $where = [], array $params = [])
    {
        return $this->driver
            ->table(
                $this->getTable()
            )
            ->save(empty($data) ? $this->data : $data, $where, empty($params) ? $this->params : $params);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function handleRequest(Request $request)
    {
        return $this->handleRequestParams(
            $request->isMethod('get') ? $request->query->all() : $request->request->all()
        );
    }

    /**
     * @param array $params
     * @return array Return request handle parameters.
     * @throws \Exception
     */
    public function handleRequestParams(array $params)
    {
        if (array() === $params) {
            throw new \Exception("Request params error.");
        }
        foreach ($params as $name => $value) {
            if (array_key_exists($name, $this->structure)) {
                if (strlen($value) > $this->structure[$name]['length']) {
                    throw new \Exception("Params length invalid.");
                }
                $name = $this->structure[$name]['name'];
                $this->data[$name] = ':' . $name;
                $this->params[$name] = $value;
            }
        }
    }

    /**
     * @param array $where
     * @param array $params
     * @return int|bool
     */
    public function count(array $where = [], array $params = [])
    {
        return $this->driver->table($this->getTable())->count($where, $params);
    }

    /**
     * @param string $sql
     * @return DriverInterface
     */
    public function createQuery($sql)
    {
        return $this->driver->createQuery($sql);
    }

    /**
     * @param int  $page
     * @param int  $showList
     * @param int  $showPage
     * @param null $lastId
     * @return
     */
    /*public function pagination($page = 1, $showList = 25, $showPage = 5, $lastId = null)
    {
        return $this->driver->pagination($this->getTable(), $page, $showList, $showPage, $lastId);
    }*/

    /**
     * Return query errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->driver->getErrors();
    }

    /**
     * @return \FastD\Database\Drivers\Query\QueryBuilderInterface
     */
    public function getQueryBuilder()
    {
        return $this->driver->getQueryBuilder();
    }
}