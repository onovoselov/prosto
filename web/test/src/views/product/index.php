<?php
/* @var $this yii\web\View */

$this->title = 'Product tree';
$script = <<< JS
    $('.sort .asc').on('click', function (e) {
        sorting($('#list'), 1);
    });

    $('.sort .desc').on('click', function (e) {
        sorting($('#list'), 2);
    });
    
    $('.category a.asc').on('click', function (e) {
        sorting($(this).parent().children('ul'), 1);
    });

    $('.category a.desc').on('click', function (e) {
        sorting($(this).parent().children('ul'), 2);
    });    
    
    function sorting(list, direction) {
        var listItems = list.children('li').get();
        listItems.sort(function(a, b) {
           var compA = $(a).text().toUpperCase();
           var compB = $(b).text().toUpperCase();
           if($(a).hasClass('product') && !$(b).hasClass('product'))  // sort only categories
               return false;
           
           if($(b).hasClass('product'))  // sort only categories
               return true;
           
           if(direction === 1)
               return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
           else
               return (compA > compB) ? -1 : (compA < compB) ? 1 : 0;
        });
        $.each(listItems, function(idx, itm) { list.append(itm); });      
    }

JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="sort">
                <a class="asc" href="#"></a>
                <a class="desc" href="#"></a>
            </div>
        </div>
        <div class="row">
            <div class="product-tree">
                <ul id="list">
                    <?= \app\components\helpers\ProductViewHelper::buildCategories($items, 0); ?>
                </ul>
            </div>
        </div>
    </div>
</div>
