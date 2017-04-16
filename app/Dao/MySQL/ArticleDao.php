<?php
namespace App\Dao\MySQL;

use App\Dao\MysqlDao;
use Psr\Container\ContainerInterface;

class ArticleDao extends MysqlDao
{
    // constructor receives container instance
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di, 'article');
    }

    public function getAllArticles()
    {
        $data = $this->findAll();

        return $data;
    }

    public function getArticleById($id)
    {
        $data = $this->findOne([
                'where' => 'id = :id',
            ], [':id' => $id]);

        return $data;
    }

    public function addNewArticle($data)
    {
        $result = $this->insert($data);

        return $result;
    }

    public function updateArticleById($id, $data)
    {
        $result = $this->update([
                'where' => 'id = :id',
                'binds' => [':id' => $id],
            ], $data);

        return $result;
    }

    public function deleteArticleById($id)
    {
        $result = $this->delete('id = :id', [':id' => $id], $data);

        return $result;
    }
}
?>