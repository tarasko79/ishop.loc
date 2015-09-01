<?php
    //тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
    defined('ISHOP') or die ('Access defined. Немає доступу.');
?>




<div class="catalog-index">

<h1>Нові товари</h1>

<?php
    if($eyestoppers){
        foreach ($eyestoppers as $eyestopper){
            echo'<div class="product-index">';
            echo"<h2><a href=\"?view=product&goods_id=".$eyestopper['goods_id']."\">".$eyestopper['name']."</a></h2>";
            echo"<a href=\"?view=product&goods_id=".$eyestopper['goods_id']."\"><img src=\"".PRODUCTIMG.$eyestopper['img']."\"/></a>";
            echo"<p>Ціна: <span>".$eyestopper['price']."</span></p>";
            echo"<a href=\"?view=addtocart&goods_id=".$eyestopper['goods_id']."\"><img src=\"".TEMPLATE."images/addcard-index.jpg\" alt=\"Добавити в кошик\"/></a>";
            echo"</div>";
        }
    }else{
        echo'<p>В цій категорії товарів поки немає</p>';
    }
?>
    
    
    
</div>



