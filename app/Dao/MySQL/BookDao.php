<?php
namespace App\Dao\MySQL;

use App\Dao\MySQL;
use Psr\Container\ContainerInterface;

class BookDao extends MySQL
{
    // constructor receives container instance
    public function __construct(ContainerInterface $c)
    {
        parent::__construct($c, 'book');
    }

    public function getAll()
    {
        $data = $this->findAll();

        return $data;
    }

    public function getById($id)
    {
        $data = $this->findOne([
                'where' => 'id = ?',
                'binds' => [$id],
            ]);

        return $data;
    }

    public function addNewRecord($data)
    {
        $result = $this->insert($data);

        return $result;
    }

    public function updateById($id, $data)
    {
        $result = $this->update([
                'where' => 'id = ?',
                'binds' => [$id],
            ], $data);

        return $result;
    }

    public function deleteById($id)
    {
        $result = $this->delete([
                'where' => 'id = ?',
                'binds' => [$id],
            ]);

        return $result;
    }
}
?>