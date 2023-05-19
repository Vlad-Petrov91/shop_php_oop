<?php

namespace app\controllers;

use app\engine\App;

class ProductController extends Controller
{
    public function actionCatalog($params = [])
    {
       // $page = App::call()->request->params['page'] ?? 0;
        //$catalog = Product::getAll();
       // die(var_dump($params));
        $page = $params['page'] ?? 0;
        $catalog = App::call()->productRepository->getLimit(($page + 1) * 3);
        echo $this->render('catalog/index', [
            'catalog' => $catalog,
            'page' => ++$page
        ]);
    }

    public function actionCard($params = [])
    {
        // $id = $_GET['id'];
        //$id = (new Request())->__get('params')['id'];
//        $id = App::call()->request->params['id'];
        $id = $params['id'];
        $product = App::call()->productRepository->getOne($id);
        echo $this->render('catalog/card', [
            'product' => $product
        ]);
    }
}