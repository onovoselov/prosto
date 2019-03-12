<?php
/**
 * Created by PhpStorm.
 * User: OLEG
 * Date: 3/8/2019
 * Time: 8:44 AM
 */

namespace app\controllers;

use app\services\ProductService;
use yii\web\Controller;

class ProductController extends Controller
{
    /**
     * Displays the product tree.
     *
     * @return string
     */
    public function actionIndex()
    {
        $productService = new ProductService();
        return $this->render('index', ['items' => $productService->getProductTree()]);
    }
}