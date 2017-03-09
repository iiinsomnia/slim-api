<?php
namespace App\Dao;

use MongoDB\Collection;

class BaseDao
{
    /**
     * 将 NotORM 查询所得的迭代器转化为数组
     * @param  $iterator 迭代器
     * @param  $isDyadic 是否是二维
     * @return array 转化后的数组
     */
    protected function iterator2Array($iterator, $isDyadic = false)
    {
        $data = [];

        if ($isDyadic) {
            $data = array_map('iterator_to_array', iterator_to_array($iterator));
        } else {
            $data = iterator_to_array($iterator);
        }

        return $data;
    }

    /**
     * 生成 Mongo 文档当前自增的 _id
     * @param  Collection $collection sequence集合
     * @param  $seqId sequence文档的_id
     * @return seq 当前自增的_id
     */
    protected function refreshSequence(Collection $collection, $seqId)
    {
        $collection->updateOne(
            ['_id' => $seqId],
            ['$inc' => ['seq' => 1]],
            ['upsert' => true]
        );

        $upsertedDocument = $collection->findOne([
            '_id' => $seqId,
        ]);

        return $upsertedDocument->seq;
    }
}
?>