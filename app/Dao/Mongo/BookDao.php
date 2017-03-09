<?php
namespace App\Dao\Mongo;

use App\Dao\BaseDao;
use Psr\Container\ContainerInterface;

class BookDao extends BaseDao
{
    protected $mongo;

    // constructor receives container instance
    public function __construct(ContainerInterface $di) {
        $this->mongo = $di->get('mongo');
    }

    public function find($query = [])
    {
        $collection = $this->mongo->library->book;
        $cursor = $collection->find($query);

        $data = [];

        foreach ($cursor as $doc) {
           $data[] = $doc;
        };

        return $data;
    }

    public function findOne($query)
    {
        $collection = $this->mongo->library->book;
        $data = $collection->findOne($query);

        return $data;
    }

    public function insertOne($data)
    {
        $collection = $this->mongo->library->book;

        try {
            $id = $this->refreshSequence($this->mongo->library->sequence, 'book');
            $data['_id'] = $id;
            $result = $collection->insertOne($data);

            return $result->getInsertedId();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }

    public function updateOne($query, $data)
    {
        $collection = $this->mongo->library->book;

        try {
            $result = $collection->updateOne($query, ['$set' => $data]);

            return $result;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }

    public function deleteOne($query)
    {
        $collection = $this->mongo->library->book;

        try {
            $result = $collection->deleteOne($query);

            return $result;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }
}
?>