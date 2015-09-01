<?php
    //це точка входу
    //тут захист від прямого доступу в інші файли, встановлюю захисну КОНСТАНТУ
    define('ISHOP',TRUE);
    
    //тут підключаю конфігурацію і підключення до БД
    require_once'config.php';
    
    //тут підключаю контролер
    require_once CONTROLLER;
    
    
    //echo "<hr>";
    //echo TITLE;

 ?>