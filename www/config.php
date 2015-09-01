<?php
    //тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
    defined('ISHOP') or die ('Access defined. Немає доступу.');    
    
    
    
    
    //домен
    define('PATH','http://ishop.loc/');
    
    //модель
    define('MODEL','model/model.php');
    
    //контроллер
    define('CONTROLLER','controller/controller.php');
    
    //вигляд
    define('VIEW','views/');
    
    //активний поточний шаблон ,тут можна міняти вигляди сайту
    define('TEMPLATE', VIEW.'ishop/');
    
    //папка з картинками товарів
    define('PRODUCTIMG', PATH.'/userfiles/');
    
    //сервер
    define('HOST','localhost');
    
    //користувач
    define('USER','ishop_user');
    
    //пароль користувача
    define('PASS','123');
    
    //назва БД з якою ми працюємо
    define('DB','ishop');
    
    //назва  інтернет магазину
    define('TITLE','Інтернет магазин мобільних телефонів');
    
    //e-mail адміністратора сайту менеджера магазину
    define('ADMIN_EMAIL','admin@ishop.com');
    
    //кількість товарів на сторінку при посторінковій навігації
    define('PERPAGE','9');
    
    
    
    
    //тут  підключаюсь до сервера
    mysql_connect( HOST, USER, PASS) or die ('No conect to Server. Відсутнє з`єднання з сервером');
    
    //тут  підключаюсь до бази даних
    mysql_select_db(DB) or die ('No conect to Data Base. Відсутнє з`єднання з базою даних');
    
    //тут встановлюююкодування для роботи з базою даних
    mysql_query("SET NAMES 'UTF8'") or die ('Cant set charset/ Неможливо встановити кодування');
    
    
    
    
    

?>