<?php
namespace app\services;
use app\models\Currency;

/**
* Сервис реализует всю бизнес логику работы с валютами.
*/
class CurrencyService {

    /**
     * Сохроняем курсы валют в БД
     *
     * @param array $currencies содержит массив элементов
     * ['code' => <код валюты>, 'name' => <наименование>, 'rate' => <курс к рублю>]
     * @throws \Exception
     */
    public function save(array $currencies) {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            foreach ($currencies as $item) {
                $currency = Currency::findOne($item['code']);
                if(!$currency) {
                    $currency = new Currency();
                }

                $currency->id = $item['code'];
                $currency->name = $item['name'];
                $currency->rate = $item['rate'];
                $currency->save();
            }
            $transaction->commit();
        } catch (\Exception $ex) {
            $transaction->rollBack();
            throw $ex;
        }
    }

    /**
     * Возвращает список доступных валют, отсортированыых по их коду.
     *
     * @param int $start - номер первого возращаемого элемента
     * @param int $count - колличество возвращаемых элементов. Если $count = 0, вернет все начиная с $start
     * @return array
     */
    public function getList($start = 0, $count = 0) {
        if($count == 0) {
            $count = null;
        }

        return Currency::find()->offset($start)->limit($count)->select(['id', 'name'])->asArray()->all();
    }

    /**
     * Возвращает валюту по его идентификатору. Если нет валюты с таким идентификатором, то возвращаем null
     *
     * @param string $id - идентификатор валюты
     * @return Currency|null
     */
    public function getItem($id) {
        return Currency::findOne(strtoupper($id));
    }

}