<?php
namespace App\Dao\Mongo;

use App\Dao\Mongo;
use Psr\Container\ContainerInterface;

class StudentDao extends Mongo
{
    // constructor receives container instance
    function __construct(ContainerInterface $c){
        parent::__construct($c, 'student');
    }

    public function getAll()
    {
        $data = $this->findAll();

        return $data;
    }

    public function getById($id)
    {
        $data = $this->findOne(['_id' => intval($id)]);

        return $data;
    }

    public function getByName($name)
    {
        $regex = new \MongoDB\BSON\Regex(sprintf(".*%s.*", $name));
        $data = $this->find(['name' => $regex]);

        return $data;
    }

    public function addNewRecord($data)
    {
        $result = $this->insert($data);

        return $result;
    }

    public function updateById($id, $data)
    {
        $result = $this->update(['_id' => intval($id)], $data);

        return $result;
    }

    public function deleteById($id)
    {
        $result = $this->delete(['_id' => intval($id)]);

        return $result;
    }
}
?>