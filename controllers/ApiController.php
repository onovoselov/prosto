<?php
namespace app\controllers;

use app\services\CurrencyService;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\HttpException;
use yii\web\Response;

class ApiController extends ActiveController{
    public $modelClass = 'models\User';

    public function behaviors() {
        parent::behaviors();

        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/xml' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::className()
            ],
        ];
    }

    public function actions() {
        return [];
    }

    /**
     * Возвращает список валют c возможностью пагинации
     *
     * @param int $page - номер страницы, для постраничного вывода
     * @param int $numItems - колличество элементов на странице. Если $numItems = 0, то возращаем все элементы
     * @return array спмсок курсов валют
     */
    public function actionCurrencies($page = 0, $numItems = 0) {
        $currencyService = new CurrencyService();

        return $currencyService->getList(($page - 1) * $numItems, $numItems);
    }

    /**
     * Возвращает курс валюты для переданного id
     *
     * @param string $id - идентификатор валюты
     * @return array - курс валюты ['id' => <идентификатор валюты>, 'rate' => <курс к рублю>]
     * @throws HttpException
     */
    public function actionCurrency($id) {
        $currencyService = new CurrencyService();

        $currency = $currencyService->getItem($id);
        if($currency) {
            return ['id' => $id, 'rate' => floatval($currency->rate)];
        } else
            throw new HttpException(404, "Currency $id - not found");
    }
}