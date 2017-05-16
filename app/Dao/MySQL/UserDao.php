<?php
namespace App\Dao\MySQL;

use App\Dao\MySQL;
use Psr\Container\ContainerInterface;

class UserDao extends MySQL
{
    // constructor receives container instance
    function __construct(ContainerInterface $c)
    {
        parent::__construct($c, 'user');
    }

    public function getById($id)
    {
        $data = $this->findOne([
                'where' => 'id = ?',
                'binds' => [$id],
            ]);

        return $data;
    }

    public function getByName($name)
    {
        $data = $this->findOne([
                'where' => 'name = ?',
                'binds' => [$name],
            ]);

        return $data;
    }

    public function getByPhone($phone)
    {
        $data = $this->findOne([
                'where' => 'phone = ?',
                'binds' => [$phone],
            ]);

        return $data;
    }
}
?>