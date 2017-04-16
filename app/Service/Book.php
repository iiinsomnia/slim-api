<?php

namespace App\Service;

use App\Dao\Mongo\BookDao;
use Psr\Container\ContainerInterface;

class Book extends IIInsomnia
{
    private $_di;

    function __construct(ContainerInterface $di)
    {
        $this->_di = $di;
    }

    // 处理书籍列表请求
    public function handleActionList(&$resCode, &$resMsg, &$resData)
    {
        $bookDao = new BookDao($this->_di);
        $dbData = $bookDao->getAllBooks();

        $resData = $dbData;

        return;
    }

    // 处理书籍详情请求
    public function handleActionDetail($id, &$resCode, &$resMsg, &$resData)
    {
        $bookDao = new BookDao($this->_di);
        $dbData = $bookDao->getBookById(['_id' => intval($id)]);

        if (!$dbData) {
            $resData = [];
            return;
        }

        $resData = $dbData;

        return;
    }

    // 处理书籍添加请求
    public function handleActionAdd($postData, &$resCode, &$resMsg, &$resData)
    {
        $bookDao = new BookDao($this->_di);
        $id = $bookDao->addNewBook($postData);

        if (!$id) {
            $resCode = -1;
            $resMsg = 'failed';

            return;
        }

        $resData = $id;

        return;
    }

    // 处理书籍编辑请求
    public function handleActionUpdate($id, $putData, &$resCode, &$resMsg)
    {
        $bookDao = new BookDao($this->_di);
        $result = $bookDao->updateBookById(['_id' => intval($id)], $resData);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }

    // 处理书籍删除请求
    public function handleActionDelete($id, &$resCode, &$resMsg)
    {
        $bookDao = new BookDao($this->_di);
        $result = $bookDao->deleteBookById(['_id' => intval($id)]);

        if (!$result) {
            $resCode = -1;
            $resMsg = 'failed';
        }

        return;
    }
}
?>