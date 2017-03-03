<?php
namespace App\Dao;

use Psr\Container\ContainerInterface;

class UserDao
{
    protected $db;

    // constructor receives container instance
    public function __construct(ContainerInterface $di) {
        $this->db = $di->get('db');
    }

    public function getUserInfoById($id)
    {
        $data = $this->db->user()->where('id = ?', $id)->fetch();

        return $data;
    }

    public function getUserList()
    {
        $data = $this->db->user();

        return $data;
    }
}
?>