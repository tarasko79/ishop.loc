<?php
//тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
defined('ISHOP') or die ('Access defined. Немає доступу.');

?>


<div id="right-bar"><!-- ПОЧАТОК тут права колонка -->
    <div class="right-bar-cont">
        
        <div class="enter"><!-- тут вхід авторизація в магазин  -->
            <h2>Авторизація</h2>
            <div class="authform">
                <?php
                    if(!$_SESSION['auth']['user']){
                        echo'<form method="post" action="#">';
                            echo'<label for="login">Логін</label><br />';
                            echo'<input type="text" name="login" id="login" /><br />';
                            echo'<label for="pass">Пароль</label><br />';
                            echo'<input type="password" name="pass" id="pass" /><br /><br />';
                            echo'<input type="submit" name="auth" id="auth" value="Вхід" />';
                            echo'<p><a href="?view=reg">Реєстрація</a></p>';
                        echo'</form>';
                        
                        if(isset($_SESSION['auth']['error'])){
                            echo '<div class="error">'.$_SESSION['auth']['error'].'</div>';
                            unset ($_SESSION['auth']);
                        }
                    }else{
                        echo'<p>Ласкаво просимо,'.htmlspecialchars($_SESSION['auth']['user']).'</p>';
                        echo'<a href="?do=logout">Вихід</a>';
                    }
                ?>
                
            </div>
        </div><!-- тут вхід авторизація в магазин  -->
        
        <div class="basket"><!-- тут корзина покупця -->
           <h2>Кошик покупця</h2>
            <div>
                <p>
                <?php if($_SESSION['total_quantity']){
                    echo'Товарів в кошику:<br />
                    <span>' .$_SESSION['total_quantity'].'</span> на суму <span>'.$_SESSION['total_sum'].'</span> грн.
                    <a href="?view=cart"><img src="'.TEMPLATE.'/images/oformyty-zakaz.jpg" alt="Оформити замовлення"/></a>';
                    } else {
                    echo'Кошик поржній';
                    }
                 ?>
                </p>
            </div>
        </div><!-- тут корзина покупця кінець--> 
        
        <div class="share-search">
            <h2>Підбір за параметрами</h2>
                <div>
                    <form  method="get">
                    <input  type="hidden" name="view" value="filter" />
                    <p>Вартість:</p>
                    від <input class="podbor-prise" type="text" name="startprice" value="<?=$startprice?>" maxlength="5"/>
                    до <input class="podbor-prise" type="text" name="endprice" value="<?=$endprice?>" maxlength="5"/>
                    грн
                    <br /> <br />
                    <p>Виробник</p>
                    
                    <?php foreach($cat as $key => $item): ?>
                        <?php if($item[0]): ?>
                        <input type="checkbox" name="brand[]" value="<?=$key?>" id="<?=$key?>"
                             <?php
    	                       if($key == $brand[$key]){
    	                           echo 'checked=""';
    	                       };
                            ?>
                        />
                        <label for="<?=$key?>"><?=$item[0]?></label><br />
                        <?php endif; ?> 
                    <?php endforeach; ?>
	
	
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                  
                    <input class="podbor" type="image" src="<?php echo TEMPLATE ?>images/podbor.jpg"  />
                    </form>
                </div>
        </div>
        

        
    </div>             
</div>