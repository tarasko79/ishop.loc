<?php defined('ISHOP') or die('Access denied'); ?>



<div id="conrent-zakaz">
    <h2>Оформлення замовлення</h2>

    <?php print_arr($_SESSION); ?>
    <?php //print_arr($order); ?>
    
    <?php
     if(isset($_SESSION['order']['res'])){
        echo $_SESSION['order']['res']; 
     }
     ?>

<?php if($_SESSION['cart']): //провірка корзити якщо в корзині є товари тоді виводимо спиток товарів ?>    

            <table class="zakaz-main-table" border="0" cellspacing="0" cellpadding="0"><!-- тут початок таблиці товарів -->
            <form method="post" action=""><!-- тут початок форми для прийому замовлення-->
                <tr><!-- тут рядок заголовка таблиці -->
                    <td class="z_top">&nbsp;&nbsp;&nbsp;Назва</td>
                    <td class="z_top">Кількість</td>
                    <td class="z_top">Ціна</td>
                    <td class="z_top">&nbsp;</td>
                </tr>

            <?php   foreach($_SESSION['cart'] as $key => $item): ?>                
                <tr><!-- тут рядок 1 товару таблиці -->
                    <td class="z_name">
                        <a href="#"><img src="<?=PRODUCTIMG  ?><?=$item['img'] ?>" width="32" title="<?=$item['name'] ?> " </a>
                        <a href="#"><?=$item['name']?></a>
                    </td>
                    <td class="z_kol"><input id="id<?=$key?>" class="kolvo" type="text" value="<?=$item['qty'] ?>" name=""/></td>
                    <td class="z_price"><?=$item['price'] ?></td>
                    <td class="z_del">
                        <a href="?view=cart&delete=<?=$key?>"><img src="<?=TEMPLATE ?>images/delete.jpg" title="Видалити товар з замовлення"/></a>
                    </td>
                </tr>
            <?php endforeach; ?>
                
                <tr>
                    <td class="z_bot">&nbsp;&nbsp;&nbsp;&nbsp;Разом:</td>
                    <td class="z_bot" colspan="3" align="right"><?=$_SESSION['total_quantity'] ?> шт&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$_SESSION['total_sum'] ?> грн.</td>
        
                </tr>
            </table><!-- тут кінець таблиці товарів -->
                
                <div class="sposob-dostavki"><!-- тут вибір Спосіб доставки товару -->
                    <h4>Спосіб доставки товару:</h4>
                    <?php foreach ($dostavka as $item): ?>
                        <p><input  type="radio" name="dostavka" value="<?=$item['dostavka_id']?>"/> <?=$item['name'];?> </p>
                    <?php endforeach; ?>
                    
                </div>
                
                <h3>Інформація для доставки товару:</h3>
                
                <?php if(!$_SESSION['auth']['user']): //привітка  чи авторизований  користувач?>
                
                <table class="zakaz-data" border="0" cellspacing="0" cellpadding="0"><!-- тут початок таблиці інф для доставки -->
                    <tr class="notauth">
                        <td class="zakaz-txt">* П І П</td>
                        <td class="zakaz-input"><input type="text" name="name" value="<?=$_SESSION['order']['name'] ?>" /></td>
                        <td class="zakaz-prim">Наприклад: Іванов Сергій Олександрович</td>
                    </tr>
                    <tr class="notauth">
                        <td class="zakaz-txt">* Е-маіл</td>
                        <td class="zakaz-input"><input type="text" name="email" value="<?=$_SESSION['order']['email'] ?>" /></td>
                        <td class="zakaz-prim">Наприклад: test@mail.ru</td>
                    </tr>
                    <tr class="notauth">
                        <td class="zakaz-txt">* Телефон</td>
                        <td class="zakaz-input"><input type="text" name="phone" value="<?=$_SESSION['order']['phone'] ?>" /></td>
                        <td class="zakaz-prim">Наприклад: 8 937 999 99 99</td>
                    </tr>
        
                    <tr class="notauth">
                        <td class="zakaz-txt">* Адреса доставки</td>
                        <td class="zakaz-input"><input type="text" name="address" value="<?=$_SESSION['order']['address'] ?>" /></td>
                        <td class="zakaz-prim">Наприклад: Львівська обл. м.Золочів вул. Польна б.28 кв.53</td>
                    </tr>
                    
                    <tr>
                        <td class="zakaz-txt" style="vertical-align: top;">Примітка</td>
                        <td class="zakaz-txtarea"><textarea name="prim" > <?=$_SESSION['order']['prim'];?> </textarea></td>
                        <td class="zakaz-prim" style="vertical-align: top;"> Наприклад: При необхідності  телефонуйте  після 19 год., бо ранія  я буду на роботі</td>
                    </tr>
                    
                </table>
                
                <?php else: //якщо користувач авторизований?>
                <table class="zakaz-data" border="0" cellspacing="0" cellpadding="0"><!-- тут  примітка для АВТОРИЗОВАНОГО користувача -->
                    <tr>
                        <td class="zakaz-txt" style="vertical-align: top;">Примітка</td>
                        <td class="zakaz-txtarea"><textarea name="prim"></textarea></td>
                        <td class="zakaz-prim" style="vertical-align: top;"> Наприклад: При необхідності  телефонуйте  після 19 год., бо ранія  я буду на роботі</td>
                    </tr>
                </table>
                <?php endif; //кінець умови провірки чи авторизований був  користувач ?>
                
                <input type="image" name="odrer" src="<?=TEMPLATE ?>images/zakaz.jpg" />
                
                <br /><br /><br /><br />
                                          
            
            </form><!-- тут кінець форми для прийому замовлення-->
            
<?php else: //тут якщо товарів немає в корзині?>
        <p>Корзина зараз порожня!!!</p>            
<?php endif; //тут  кінець умови провірки чи  порожня корзина?>

<?php
unset($_SESSION['order']);
?>

                                       
</div>