<?php //тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
    defined('ISHOP') or die ('Access defined. Немає доступу.');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE ?>css/style.css" />

<!-- тут підключили умовний коментар для виправлення недоліків IE (в меню та інших) але ще треба  переконатись чи це допомагає сайту -->
<!--[if lt IE 8]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
<![endif]-->


<script type="text/javascript" src="<?php echo TEMPLATE ?>js/functions.js"></script>    <!-- тут підключили скрипт для пошуку в шапці -->
<script type="text/javascript" src="<?php echo TEMPLATE ?>js/jquery-1.7.2.min.js"></script> <!-- тут підключили скрипт для меню зліва акордион -->
<script type="text/javascript" src="<?php echo TEMPLATE ?>js/jquery-ui-1.8.22.custom.min.js"></script> <!-- тут підключили скрипт для меню зліва акордион -->
<script type="text/javascript" src="<?php echo TEMPLATE ?>js/jquery.cookie.js"></script> <!-- тут підключили скрипт для меню зліва акордион -->
<script type="text/javascript" src="<?php echo TEMPLATE ?>js/workscripts.js"></script> <!-- тут підключили скрипт для меню зліва акордион -->
<script type="text/javascript"> var query='<?php echo $_SERVER['QUERY_STRING']?>';</script><!-- тут підключили скрипт для перемикача сітка або лінійний вигляд -->

<title><?php echo TITLE ?></title>
</head>
    
    
    <body><!-- начнем работать с телом документа -->
    <div class="main">
            <div class="header"><!-- початок header  -->
                <a href="/"> <img class="logo" src="<?php echo TEMPLATE ?>images/logo.jpg" alt="Інтернет магазин моб телефонів" /></a>
                <img class="slogan" src="<?php echo TEMPLATE ?>images/slogan.jpg" alt="Слоган Інтернет магазин моб телефонів"  />
                <div class="head-contact">
                <p><strong>Телефон:</strong>
                <br />
                <span>8 (800) 700-00-01</span></p>
                <p><strong>Режим работы:</strong><br /> Будние дни: с 9:00 до 18:00 <br /> Суббота, Воскресенье - выходные </p>
            </div>
            <form method="get">
                <ul class="search-head">
                    <li>
                        <input type="hidden" name="view" value="search" />
                        <input type="text" name="search" id="quickquery" placeholder="Що бажаєш купити?" />
                        
                        <script type="text/javascript">
                        //<![CDATA[
                        placeholderSetup('quickquery');
                        //]]>
                        </script>                
                    </li>
                    <li> <input type="image" class="search-btn" src="<?php echo TEMPLATE ?>images/search-btn.jpg"/> </li>
                </ul>
            </form>
            </div><!-- кінець header  -->
            <ul class="menu">
                <li><a href="#">Главная</a></li>
                <li><a href="#">О магазине</a></li>
                <li><a href="#">Оплата и доставка</a></li>
                <li><a href="#">Покупка в кредит</a></li>
                <li><a href="#">Контакты</a></li>
           </ul>
          