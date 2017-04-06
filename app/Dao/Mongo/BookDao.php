<?php
namespace App\Dao\Mongo;

use App\Dao\BaseDao;
use Psr\Container\ContainerInterface;

class BookDao extends BaseDao
{
    private $_di;
    private $_mongo;

    // constructor receives container instance
    public function __construct(ContainerInterface $di){
        $this->_di = $di;
        $this->_mongo = $di->get('mongo');
    }

    public function find($query = [])
    {
        $collection = $this->_mongo->library->book;
        $cursor = $collection->find($query);

        $data = [];

        foreach ($cursor as $doc) {
           $data[] = $doc;
        }

        return $data;
    }

    public function findOne($query)
    {
        $collection = $this->_mongo->library->book;
        $data = $collection->findOne($query);

        return $data;
    }

    public function insertOne($data)
    {
        $collection = $this->_mongo->library->book;

        try {
            $id = $this->refreshSequence($this->_mongo->library->sequence, 'book');
            $data['_id'] = $id;
            $result = $collection->insertOne($data);

            return $result->getInsertedId();
        } catch (MongoDB\Exception\InvalidArgumentException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        } catch (MongoDB\Driver\Exception\BulkWriteException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        } catch (MongoDB\Driver\Exception\RuntimeException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        }
    }

    public function updateOne($query, $data)
    {
        $collection = $this->_mongo->library->book;

        try {
            $result = $collection->updateOne($query, ['$set' => $data]);

            return $result;
        } catch (MongoDB\Exception\UnsupportedException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        } catch (MongoDB\Exception\InvalidArgumentException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        } catch (MongoDB\Driver\Exception\BulkWriteException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        } catch (MongoDB\Driver\Exception\RuntimeException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        }
    }

    public function deleteOne($query)
    {
        $collection = $this->_mongo->library->book;

        try {
            $result = $collection->deleteOne($query);

            return $result;
        } catch (MongoDB\Exception\UnsupportedException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        } catch (MongoDB\Exception\InvalidArgumentException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        } catch (MongoDB\Driver\Exception\BulkWriteException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        } catch (MongoDB\Driver\Exception\RuntimeException $e) {
            $logger = $this->_di->get('logger');
            $logger->error($e->getMessage());

            return false;
        }
    }
}
?>