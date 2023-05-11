<?php

namespace app\controllers;

use app\engine\Request;
use app\models\repositories\ProductRepository;
use app\engine\App;

class ProductController extends Controller
{
    public function actionCatalog()
    {
        $page = App::call()->request->params['page'] ?? 0;
        //$catalog = Product::getAll();
        $catalog = App::call()->productRepository->getLimit(($page + 1) * 3);
        echo $this->render('catalog/index', [
            'catalog' => $catalog,
            'page' => ++$page
        ]);
    }

    public function actionCard()
    {
        // $id = $_GET['id'];
        //$id = (new Request())->__get('params')['id'];
        $id = App::call()->request->params['id'];
        $product = App::call()->productRepository->getOne($id);
        echo $this->render('catalog/card', [
            'product' => $product
        ]);
    }
}