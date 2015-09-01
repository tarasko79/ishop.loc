<?php
//тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
defined('ISHOP') or die ('Access defined. Немає доступу.');
?>

<div class="footer"><!-- ПОЧАТОК тут  футер -->
    <div class="flogo">
        <a href="#"><img src="<?php echo TEMPLATE ?>images/flogo.jpg" /></a>
        <p>Copiryght &copy; 2012</p> 
    </div>
    
    <div class="ffone">
        <h2>Телефон</h2>
        <h1>8 (800) 700-00-01</h1>
        
        <h2>Режим роботи:</h2>
        <p>Будні дні з 9:00 до 18:00<br />
        Субота,Неділя - вихідні</p>
    </div>            
    
    <div class="fmenu">
        <p>Меню:</p>
        <ul>
            <li><a href="#">Главная</a></li>
            <li><a href="#">О магазине</a></li>
            <li><a href="#">Оптата и доставка</a></li>
        </ul>

        <ul>
            <li><a href="#">Покупка в кредит</a></li>
            <li><a href="#">Контакти</a></li>
        </ul>
    </div>
</div>