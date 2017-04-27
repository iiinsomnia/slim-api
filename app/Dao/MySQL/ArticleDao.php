<?php
namespace App\Dao\MySQL;

use App\Dao\MySQL;
use Psr\Container\ContainerInterface;

class ArticleDao extends MySQL
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
                'where' => 'id = ?',
                'binds' => [$id],
            ]);

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
                'where' => 'id = ?',
                'binds' => [$id],
            ], $data);

        return $result;
    }

    public function deleteArticleById($id)
    {
        $result = $this->delete([
                'where' => 'id = ?',
                'binds' => [$id],
            ]);

        return $result;
    }
}
?>