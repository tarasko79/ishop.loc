  <?php
    //тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
    defined('ISHOP') or die ('Access defined. Немає доступу.');
?>




<div class="catalog-index">
    
    <div class="kroshka"><!-- тут стрічка шлях (хлібні крошки) по сайту -->
        <a href="#">Мобільні телефони</a> / <a href="#">LG</a> / <span>Слайдери</span>
    </div><!-- тут стрічка шлях (хлібні крошки) по сайту -->
    
    <div class="vid-sort"><!-- тут панель для сортування товару -->
        Вигляд:         
            <a href="#" id="grid" class="grid_list" ><img src="<?php echo TEMPLATE;?>/images/vid-tabl.jpg" title="табличний вигляд" alt="табличний вигляд"/></a>
            <a href="#" id="list" class="grid_list" ><img src="<?php echo TEMPLATE;?>/images/vid-ryad.jpg" title="рядковий вигляд" alt="рядковий вигляд"/></a>
            &nbsp;&nbsp;
        Сортувати за:&nbsp;
            <a href="#" class="sort-top-act">ціною</a> &nbsp;&nbsp;
            <a href="#" class="sort-top">назвою</a> &nbsp;&nbsp;
            <a href="#" class="sort-bot">поступленні</a> &nbsp;&nbsp;
    </div><!-- тут панель для сортування товару -->
    
<?php
    if($products){ //якщо в масиві ми маємо товари що відповідають обраному бренду і  його категорії
       
        foreach($products as $product){
        
        //тут частинка  яка буде відповідати за  відображення товарів в каталозі сітка  або лінійний вигляд
        //$switch=0;
        //if($switch){
        if(!isset($_COOKIE['display']) or $_COOKIE['display']=='grid'){
                        
            echo'<div class="product-table"><!-- тут ТАБЛИЧНИЙ вигляд товару --><!-- ПОЧАТОК -->';
                echo'<h2><a href="?view=product&amp;goods_id='.$product['goods_id'].'">'.$product['name'].'</a></h2>';
                echo'<div class="product-table-img-main">';
                    echo'<div class="product-table-img">';                                   
                    
                        echo'<a href="?view=product&amp;goods_id='.$product['goods_id'].'"><img src="'.PRODUCTIMG.$product['img'].'" alt="" width="64" /></a>';
                        
                        echo'<div>';    //блок з іконками для товару табличний вигляд
                            if($product['hits']){
                                echo'<img src="'. TEMPLATE.'images/ico-cat-lider.jpg" alt="лідер"/>';
                            }
                            if($product['new']){
                                echo'<img src="'. TEMPLATE.'images/ico-cat-new.jpg" alt="новинка"/>';    
                            }
                            if($product['sale']){
                                echo'<img src="'. TEMPLATE.'images/ico-cat-sale.jpg" alt="розпродаж"/>';    
                            }
                        echo'</div>';
                        
                    echo'</div>';
                echo'</div>';
                echo'<p class="cat-table-more"><a href="?view=product&amp;goods_id='.$product['goods_id'].'">детально...</a></p>';
                echo'<p>Ціна : <span>'.$product['price'].'</span> </p>';
                echo'<a href="?view=addtocart&amp;goods_id='.$product['goods_id'].'"><img class="addcard-index" src="'.TEMPLATE.'images/addcard-table.jpg" alt="Додати в корзину"/> </a>';
            echo'</div><!-- тут ТАБЛИЧНИЙ вигляд товару --><!-- КІНЕЦЬ -->';
            
        } else {
         
        echo'<div class="product-line"><!-- тут лінійний  вигляд товару -->';
            echo'<div class="product-line-img"><!-- картинка товару лінійний  вигляд -->';
            echo'<a href="?view=product&amp;goods_id='.$product['goods_id'].'"><img src="'.PRODUCTIMG.$product['img'].'" alt="" width="48" /></a>';
            echo'</div>';

            echo'<div class="product-line-price"><!-- ціна товару лінійний  вигляд-->';
                echo'<p>Ціна : <span>'.$product['price'].'</span> </p>';
                echo'<a href="?view=addtocart&amp;goods_id='.$product['goods_id'].'"><img class="addcard-index" src="'.TEMPLATE.'images/addcard-table.jpg" alt="Додати в корзину"/> </a>';  
                
                /*echo'<div><!-- іконки додатково про товар -->';
                     echo'<img src="'.TEMPLATE.'images/ico-line-new.jpg"/>';
                     echo'<img src="'.TEMPLATE.'images/ico-line-lider.jpg"/>';
                     echo'<img src="'.TEMPLATE.'images/ico-line-sale.jpg"/>';
                echo'</div>';*/
                
                echo'<div>';    //блок з іконками для товару лінійний вигляд
                            if($product['hits']){
                                echo'<img src="'. TEMPLATE.'images/ico-line-lider.jpg" alt="лідер"/>';
                            }
                            if($product['new']){
                                echo'<img src="'. TEMPLATE.'images/ico-line-new.jpg" alt="новинка"/>';    
                            }
                            if($product['sale']){
                                echo'<img src="'. TEMPLATE.'images/ico-line-sale.jpg" alt="розпродаж"/>';    
                            }
                        echo'</div>';
                
                echo'<p class="cat-line-more"><a href="?view=product&amp;goods_id='.$product['goods_id'].'">детально...</a></p>';
            echo'</div>'; 
        
            echo'<div class="product-line-opis"><!-- опис товару лінійний  вигляд-->';
                echo'<h2><a href="?view=product&amp;goods_id='.$product['goods_id'].'">'.$product['name'].'</a></h2>';
                echo'<p>'.$product['anons'].' </p>';
            echo'</div>';
        echo'</div>';
            
    }

    }
    
    echo '<div class="clear"></div>';
          
    if($pages_count >1){
        pagination($page, $pages_count); //посторінкова навігація
    } 
    
    } else {
        echo'<p>Тут товарів, зараз немає.</p>';    
    }
    ?>
    
    <a name="nav"></a>
    
    <?php
    
?>  
   
    
  
    
</div>