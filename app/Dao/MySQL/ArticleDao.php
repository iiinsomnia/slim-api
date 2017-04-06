<?php
namespace App\Dao\MySQL;

use App\Dao\BaseDao;
use Psr\Container\ContainerInterface;

class ArticleDao extends BaseDao
{
    private $_db;

    // constructor receives container instance
    public function __construct(ContainerInterface $di)
    {
        $this->_db = $di->get('db');
    }

    public function findAll()
    {
        $rows = $this->_db->article();

        $data = $this->iterator2Array($rows, true);

        return !empty($data) ? $data : [];
    }

    public function findById($id)
    {
        $row = $this->_db->article()->where('id = ?', $id)->fetch();

        if (empty($row)) {
            return [];
        }

        $data = $this->iterator2Array($row);

        return $data;
    }

    public function findByName($name)
    {
        $rows = $this->_db->article()->where('name LIKE ?', $name);

        $data = $this->iterator2Array($rows, true);

        return !empty($data) ? $data : [];
    }

    public function insert($data)
    {
        $result = $this->_db->article()->insert($data);

        return $result;
    }

    public function updateById($id, $data)
    {
        $result = $this->_db->article()->where('id = ?', $id)->update($data);

        if ($result === false) {
            return false;
        }

        return true;
    }

    public function deleteById($id)
    {
        $result = $this->_db->article()->where('id = ?', $id)->delete();

        if ($result === false) {
            return false;
        }

        return true;
    }
}
?>