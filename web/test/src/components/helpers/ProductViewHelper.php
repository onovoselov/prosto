<?php
/**
 * Created by PhpStorm.
 * User: OLEG
 * Date: 3/8/2019
 * Time: 10:04 AM
 */

namespace app\components\helpers;


class ProductViewHelper {
    public static function buildCategories(array $productsTree, int $categoryId) {
        $str = '';
        if(isset($productsTree[$categoryId])) {
            foreach ($productsTree[$categoryId] as $item) {
                if($item['type'] == 0) {   // category
                    $strCategory = self::buildCategories($productsTree, $item['id']);
                    if($strCategory) {
                        $str .= "<li class='category'><span>{$item['name']}</span><a class=\"asc\" href=\"#\"></a><a class=\"desc\" href=\"#\"></a>";
                        $str .= "<ul>";
                        $str .= self::buildCategories($productsTree, $item['id']);
                        $str .= "</ul>";
                        $str .= "</li>";
                    } else {
                        $str .= "<li class='category'>{$item['name']}</li>";
                    }
                } else {
                    $str .= "<li class='product'>{$item['name']}</li>";
                }
            }
        }

        return $str;
    }
}