<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\entities\Product;
use app\models\Repository;

class ProductRepository extends Repository
{

    public function getProductPrice($id)
    {
        $sql = "SELECT `price` FROM {$this->getTableName()} WHERE id = :id";
        return App::call()->db->queryColumn($sql, [
            'id' => $id
        ]);
    }


    protected function getTableName()
    {
        return 'products';
    }

    protected function getEntityClass()
    {
        return Product::class;
    }
}