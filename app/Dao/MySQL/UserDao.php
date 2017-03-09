<?php
namespace App\Dao\MySQL;

use App\Dao\BaseDao;
use Psr\Container\ContainerInterface;

class UserDao extends BaseDao
{
    protected $db;
    protected $logger;

    // constructor receives container instance
    public function __construct(ContainerInterface $di) {
        $this->db = $di->get('db');
        $this->logger = $di->get('logger');
    }

    public function findAll()
    {
        $rows = $this->db->user();
        $data = $this->iterator2Array($rows, true);

        return $data;
    }

    public function findById($id)
    {
        $row = $this->db->user()->where('id = ?', $id)->fetch();
        $data = $this->iterator2Array($row);

        return $data;
    }

    public function insert($data)
    {
        try {
            $result = $this->db->user()->insert($data);

            return $result;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }

    public function updateById($id, $data)
    {
        try {
            $result = $this->db->user()->where('id = ?', $id)->update($data);

            if ($result === false) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }

    public function deleteById($id)
    {
        try {
            $result = $this->db->user()->where('id = ?', $id)->delete();

            return $result;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }
}
?>