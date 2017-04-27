<?php
namespace App\Dao\Mongo;

use App\Dao\Mongo;
use Psr\Container\ContainerInterface;

class BookDao extends Mongo
{
    // constructor receives container instance
    public function __construct(ContainerInterface $di){
        parent::__construct($di, 'book');
    }

    public function getAllBooks()
    {
        $data = $this->findAll();

        return $data;
    }

    public function getBookById($id)
    {
        $data = $this->findOne(['_id' => intval($id)]);

        return $data;
    }

    public function getBooksByTitle($title)
    {
        $regex = new \MongoDB\BSON\Regex(sprintf(".*%s.*", $title));
        $data = $this->find(['title' => $regex]);

        return $data;
    }

    public function addNewBook($data)
    {
        $result = [$data, $data, $data];

        $result = $this->batchInsert($result);

        return $result;
    }

    public function updateBookById($id, $data)
    {
        $result = $this->update(['_id' => intval($id)], $data);

        return $result;
    }

    public function deleteBookById($id)
    {
        $result = $this->delete(['_id' => intval($id)]);

        return $result;
    }
}
?>