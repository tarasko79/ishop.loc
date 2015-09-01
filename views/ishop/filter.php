<?php
    //тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
    defined('ISHOP') or die ('Access defined. Немає доступу.');
?>
    
<div class="catalog-index">
    <h1>Вибір за параметрами</h1>
        
        <?php //print_arr($_GET); ?>
        <?php //print_arr($brand); ?>
        <?php //echo $category; ?>
        <?php print_arr($products); ?>
        
         

                

    
</div>