<?php
namespace App\Dao\MySQL;

use App\Dao\MySQL;
use Psr\Container\ContainerInterface;

class UserDao extends MySQL
{
    // constructor receives container instance
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di, 'user');
    }

    public function findUserById($id)
    {
        $data = $this->findOne([
                'where' => 'id = ?',
                'binds' => [$id],
            ]);

        return $data;
    }
}
?>