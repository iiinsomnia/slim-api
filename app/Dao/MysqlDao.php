<?php
namespace App\Dao;

use Illuminate\Database\QueryException;
use Psr\Container\ContainerInterface;

/**
 * MySQL操作基类
 * 如有需要，请自行扩展
 * 文档参考Laravel查询构造器
 */
class MysqlDao
{
    private $_di;
    private $_db;
    private $_table;
    private $_prefix;

    /**
     * constructor receives container instance
     * @param ContainerInterface $di container instance
     * @param string $table 表名称
     * @param string $db 数据库配置名称，默认：db
     */
    public function __construct(ContainerInterface $di, $table, $db = 'db')
    {
        $this->_di = $di;
        $this->_db = $di->get($db);
        $this->_table = $table;

        $settings = $di->get('settings')[$db];
        $this->_prefix = $settings['prefix'];
    }

    /**
     * 插入一条记录
     * @param array $data 插入的数据
     * @return int/false 返回记录ID
     */
    protected function insert($data)
    {
        try {
            $id = $this->_db::table($this->_table)->insertGetId($data);

            return $id;
        } catch (QueryException $e) {
            $logger = $this->_di->get('logger');
            $logger->error(sprintf("[MySQL] Insert Error: %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * 批量插入记录
     * @param array $data 插入的数据
     * @return bool 返回是否成功
     */
    protected function batchInsert($data)
    {
        try {
            $success = $this->_db::table($this->_table)->insert($data);

            return $success;
        } catch (QueryException $e) {
            $logger = $this->_di->get('logger');
            $logger->error(sprintf("[MySQL] BatchInsert Error: %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * 更新记录
     * @param array $query 查询条件，如：
     *        [
     *            'where' => 'id = :id',
     *            'binds' => [':id' => 1],
     *        ]
     * @param array $data 更新的数据
     * @return int/false 更新影响的行数
     */
    protected function update($query, $data)
    {
        $sql = $this->_buildUpdate($query['where'], $query['binds'], $data);

        try {
            $affectRows = $this->_db::update($sql, $query['binds']);

            return $affectRows;
        } catch (QueryException $e) {
            $logger = $this->_di->get('logger');
            $logger->error(sprintf("[MySQL] Update Error: %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * 字段增量
     * @param array $query 查询条件，如：
     *        [
     *            'where' => 'id = :id',
     *            'binds' => [':id' => 1],
     *        ]
     * @param string $data 增量的字段
     * @param int $inc 增量的值，默认：1
     * @return int/false 更新影响的行数
     */
    protected function increment($query, $column, $inc = 1)
    {
        $set = sprintf("%s = %s + %d", $column, $column, $inc);
        $table = sprintf("%s%s", $this->_prefix, $this->_table);

        $sql = sprintf("UPDATE %s SET %s WHERE %s", $table, $set, $query['where']);

        $this->_buildIn($sql, $query['binds']);

        try {
            $affectRows = $this->_db::update($sql, $query['binds']);

            return $affectRows;
        } catch (QueryException $e) {
            $logger = $this->_di->get('logger');
            $logger->error(sprintf("[MySQL] Increment Error: %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * 字段减量
     * @param array $query 查询条件，如：
     *        [
     *            'where' => 'id = :id',
     *            'binds' => [':id' => 1],
     *        ]
     * @param string $data 减量的字段
     * @param int $dec 减量的值，默认：1
     * @return int/false 更新影响的行数
     */
    protected function decrement($query, $column, $dec = 1)
    {
        $set = sprintf("%s = %s - %d", $column, $column, $dec);
        $table = sprintf("%s%s", $this->_prefix, $this->_table);

        $sql = sprintf("UPDATE %s SET %s WHERE %s", $table, $set, $query['where']);

        $this->_buildIn($sql, $query['binds']);

        try {
            $affectRows = $this->_db::update($sql, $query['binds']);

            return $affectRows;
        } catch (QueryException $e) {
            $logger = $this->_di->get('logger');
            $logger->error(sprintf("[MySQL] Decrement Error: %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * 事务操作
     * @param array $actions 操作集合 (插入、更新和删除)，如：
     *        [
     *            'insert' => [
     *                'table' => 'article',
     *                'data'  => [插入的数据，若是批量插入，则是二维数组],
     *            ],
     *            'update' => [
     *                'table' => 'user',
     *                'where' => 'status = :status',
     *                'binds' => [':status' => 1],
     *                'data'  => ['status' => 0]',
     *            ],
     *            'delete' => [
     *                'table' => 'user',
     *                'where' => 'status = :status',
     *                'binds' => [':status' => 1],
     *            ],
     *        ]
     *        注：不传table字段，则操作当前表
     * @return bool 是否成功
     */
    protected function doTransaction($actions)
    {
        $this->_db::beginTransaction();

        try {
            foreach ($actions as $key => $action) {
                switch ($key) {
                    case 'insert':
                        $table = !empty($action['table']) ? $action['table'] : $this->_table;
                        $this->_db::table($table)->insert($action);
                        break;
                    case 'update':
                        $table = !empty($action['table']) ? $action['table'] : null;
                        $sql = $this->_buildUpdate($action['where'], $action['binds'], $action['data'], $table);
                        $this->_db::update($sql, $action['binds']);
                        break;
                    case 'delete':
                        $table = !empty($action['table']) ? $action['table'] : null;
                        $sql = $this->_buildDelete($action['where'], $action['binds'], $table);
                        $this->_db::delete($sql, $action['binds']);
                        break;
                    default:
                        break;
                }
            }

            $this->_db::commit();

            return true;
        } catch (QueryException $e) {
            $this->_db::rollback();

            $logger = $this->_di->get('logger');
            $logger->error(sprintf("[MySQL] DoTransaction Error: %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * 查询单条记录
     * @param array $query 查询条件数组，如：
     *        [
     *            'select' => ['id', 'name'],
     *            'where'  => 'id = :id',
     *        ]
     * @param array $binds 查询语句中的绑定值，如：[':id' => 1]
     * @return array 返回查询结果
     */
    protected function findOne($query, $binds = [])
    {
        $query['limit'] = 1;

        $sql = $this->_buildQuery($query, $binds);
        $data = $this->_db::selectOne($sql, $binds);

        if (empty($data)) {
            return [];
        }

        $result = $this->_toArray($data);

        return $result;
    }

    /**
     * 查询多条记录
     * @param array $query 查询条件数组，如：
     *        [
     *            'select' => ['article.id', 'article.name', 'user.name AS username'],
     *            'join'   => [['LEFT JOIN', 'user', 'article.uid = user.id']],
     *            'where'  => 'article.id IN (:id) AND article.status =: status,
     *            'order'  => 'article.id DESC',
     *            'offset' => 0,
     *            'limit'  => 10,
     *        ]
     * 注：join条件是一个二维数组，可以进行多个JOIN操作
     * @param array $binds 查询语句中的绑定值，如：[':id' => [1, 2], ':status' => 1]
     * @return array 返回查询结果
     */
    protected function find($query, $binds = [])
    {
        $sql = $this->_buildQuery($query, $binds);
        $data = $this->_db::select($sql, $binds);

        $result = $this->_toArray($data, true);

        return $result;
    }

    /**
     * 查询所有记录
     * @param array $select 查询的字段
     * @return array 返回查询结果
     */
    protected function findAll($select = ['*'])
    {
        $fields = implode(',', $select);
        $table = sprintf("%s%s", $this->_prefix, $this->_table);

        $sql = sprintf("SELECT %s FROM %s", $fields, $table);
        $data = $this->_db::select($sql);

        $result = $this->_toArray($data, true);

        return $result;
    }

    /**
     * 获取记录数
     * @param array $query 查询条件数组，如：
     *        [
     *            'where'  => 'id = :id',
     *        ]
     * @param array $binds 查询语句中的绑定值，如：[':id' => 1]
     * @return int 返回记录数
     */
    protected function count($query = [], $binds = [], $column = '*')
    {
        if (empty($query['select'])) {
            $query['select'] = [sprintf("COUNT(%s) AS count", $column)];
        }

        $sql = $this->_buildQuery($query, $binds);
        $data = $this->_db::selectOne($sql, $binds);

        return $data->count;
    }

    /**
     * 删除记录
     * @param string $where WHERE语句，如：'id = :id'
     * @param array $binds WHERE语句中的绑定值，如：[':id' => 1]
     * @return int/false 更新影响的行数
     */
    protected function delete($where, $binds)
    {
        try {
            $sql = $this->_buildDelete($where, $binds);
            $affectRows = $this->_db::delete($sql, $binds);

            return $affectRows;
        } catch (QueryException $e) {
            $logger = $this->_di->get('logger');
            $logger->error(sprintf("BatchInsert Error: %s", $e->getMessage()));

            return false;
        }
    }

    // build update sql
    private function _buildUpdate($where, &$binds, $data, $table = null)
    {
        $updates = [];

        foreach ($data as $key => $value) {
            $updates[] = sprintf("%s = %s", $key, $value);
        }

        $set = implode(', ', $updates);
        $updateTable = !empty($table) ? sprintf("%s%s", $this->_prefix, $table) : sprintf("%s%s", $this->_prefix, $this->_table);

        $sql = sprintf("UPDATE %s SET %s WHERE %s", $updateTable, $set, $where);

        $this->_buildIn($sql, $binds);

        return $sql;
    }

    // bulid query sql
    private function _buildQuery($query, &$binds)
    {
        $clauses = [
            $this->_buildSelect($query),
            $this->_buildFrom(),
            $this->_buildJoin($query),
            $this->_buildWhere($query),
            $this->_buildGroupBy($query),
            $this->_buildOrder($query),
            $this->_buildOffset($query),
            $this->_buildLimit($query),
        ];

        $separator = ' ';
        $sql = implode($separator, array_filter($clauses));

        $this->_buildIn($sql, $binds);

        return $sql;
    }

    // build delete sql
    private function _buildDelete($where, &$binds, $table = null)
    {
        $deleteTable = !empty($table) ? sprintf("%s%s", $this->_prefix, $table) : sprintf("%s%s", $this->_prefix, $this->_table);

        $sql = sprintf("DELETE FROM %s WHERE %s", $deleteTable, $where);

        $this->_buildIn($sql, $binds);

        return $sql;
    }

    // build select
    private function _buildSelect($query)
    {
        if (empty($query['select'])) {
            return 'SELECT *';
        }

        $fields = implode(',', $query['select']);

        return sprintf("SELECT %s", $fields);
    }

    // build from
    private function _buildFrom()
    {
        $table = sprintf("%s%s", $this->_prefix, $this->_table);

        return sprintf("FROM %s", $table);
    }

    // build join
    private function _buildJoin($query)
    {
        if (empty($query['join'])) {
            return '';
        }

        $joins = [];

        foreach ($query['join'] as $val) {
            $table = sprintf("%s%s", $this->_prefix, $val[1]);
            $join = sprintf("%s %s ON %s", $val[0], $table, $val[2]);
            $joins[] = $join;
        }

        $separator = ' ';

        return implode($separator, $joins);
    }

    // build where
    private function _buildWhere($query)
    {
        if (empty($query['where'])) {
            return '';
        }

        return sprintf("WHERE %s", $query['where']);
    }

    // build groupby
    private function _buildGroupBy($query)
    {
        if (empty($query['group'])) {
            return '';
        }

        return sprintf("GROUP BY %s", $query['group']);
    }

    // build orderby
    private function _buildOrder($query)
    {
        if (empty($query['order'])) {
            return '';
        }

        return sprintf("ORDER BY %s", $query['order']);
    }

    // build offset
    private function _buildOffset($query)
    {
        if (empty($query['offset'])) {
            return '';
        }

        return sprintf("OFFSET %s", $query['offset']);
    }

    // build limit
    private function _buildLimit($query)
    {
        if (empty($query['limit'])) {
            return '';
        }

        return sprintf("LIMIT %s", $query['limit']);
    }

    // build in
    private function _buildIn(&$sql, &$binds)
    {
        foreach ($binds as $key => &$value) {
            if (is_array($value)) {
                $in = implode(',', $value);
                $sql = str_replace($key, $in, $sql);

                unset($binds[$key]);
            }
        }

        return;
    }

    // convert stdClass to array
    private function _toArray($data, $multiple = false)
    {
        $result = [];

        if ($multiple) {
            foreach ($data as $obj) {
                $result[] = get_object_vars($obj);
            }
        } else {
            $result = get_object_vars($data);
        }

        return $result;
    }
}
?>