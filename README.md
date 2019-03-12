Prosto.Insure
--------------
Тестовое задание

Usage
--------------
Загрузка курсов валют

```
php yii currency 
```

Api

```
curl -i http://localhost/currencies --header "Authorization: Bearer 100-token"
curl -i http://localhost/currencies?page=2&numItems=5 --header "Authorization: Bearer 100-token" 
curl -i http://localhost/currency/azn --header "Authorization: Bearer 100-token"
```