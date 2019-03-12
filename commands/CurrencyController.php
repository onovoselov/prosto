<?php
namespace app\commands;

use app\models\Currency;
use app\services\CurrencyService;
use SimpleXMLElement;
use yii\console\Controller;
use yii\console\ExitCode;

class CurrencyController extends Controller {
    const URL_CBR = 'http://www.cbr.ru/scripts/XML_daily.asp';

    /**
     * Загружает курсы валют в таблицу Currency.
     * @return int Exit code
     */
    public function actionIndex() {
        $context  = stream_context_create(['http' => ['header' => 'Accept: application/xml', 'max_redirects' => 101]]);
        /** @var SimpleXMLElement $xml */
        $xml = simplexml_load_string(file_get_contents(self::URL_CBR, false, $context));
        $currencies = [];
        /** @var SimpleXMLElement $item */
        foreach ($xml->Valute as $item) {
            $rate = floatval(str_replace(',', '.', str_replace('.', '', (string) $item->Value)));
            $currencies[] = [
                'code' => (string) $item->CharCode,
                'name' => (string) $item->Name,
                'rate' => $rate / (float) $item->Nominal,
            ];
        }

        $currencyService = new CurrencyService();
        $currencyService->save($currencies);

        return ExitCode::OK;
    }
}