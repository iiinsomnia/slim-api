<?php
namespace App\Dao\MySQL;

use App\Dao\MysqlDao;
use Psr\Container\ContainerInterface;

class UserDao extends MysqlDao
{
    // constructor receives container instance
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di, 'user');
    }

    public function findUserById($id)
    {
        $data = $this->findOne([
                'where' => 'id = :id',
            ], [':id' => $id]);

        return $data;
    }

    public function findUserByName($name)
    {
        $data = $this->findOne([
                'where' => 'name = :name',
            ], [':name' => $name]);

        return $data;
    }

    public function findUserByPhone($phone)
    {
        $data = $this->findOne([
                'where' => 'phone = :phone',
            ], [':phone' => $phone]);

        return $data;
    }

    public function addNewUser($data)
    {
        $result = $this->insert($data);

        return $result;
    }

    public function updateUserById($id, $data)
    {
        $result = $this->update([
                'where' => 'id = :id',
                'binds' => [':id' => $id],
            ], $data);

        return $result;
    }
}
?>