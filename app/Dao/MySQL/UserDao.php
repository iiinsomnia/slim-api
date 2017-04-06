<?php
namespace App\Dao\MySQL;

use App\Dao\BaseDao;
use Psr\Container\ContainerInterface;

class UserDao extends BaseDao
{
    private $_db;

    // constructor receives container instance
    public function __construct(ContainerInterface $di)
    {
        $this->_db = $di->get('db');
    }

    public function findById($id)
    {
        $row = $this->_db->user()->where('id = ?', $id)->fetch();

        if (empty($row)) {
            return [];
        }

        $data = $this->iterator2Array($row);

        return $data;
    }

    public function findByName($name)
    {
        $row = $this->_db->user()->where('name = ?', $name)->fetch();

        if (empty($row)) {
            return [];
        }

        $data = $this->iterator2Array($row);

        return $data;
    }

    public function findByPhone($phone)
    {
        $row = $this->_db->user()->where('phone = ?', $phone)->fetch();

        if (empty($row)) {
            return [];
        }

        $data = $this->iterator2Array($row);

        return $data;
    }

    public function insert($data)
    {
        $result = $this->_db->user()->insert($data);

        return $result;
    }

    public function updateById($id, $data)
    {
        $result = $this->_db->user()->where('id = ?', $id)->update($data);

        if ($result === false) {
            return false;
        }

        return true;
    }
}
?>