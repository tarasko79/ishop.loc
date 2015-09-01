<?php
    //тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
    defined('ISHOP') or die ('Access defined. Немає доступу.');

    /* === каталог Мобыльних телефонів з ліваодержання  масиву ===*/
    function catalog(){
        $query = "SELECT * FROM `brands` ORDER BY `parent_id`, `brand_name`";
        $res = mysql_query($query) or die (mysql_query());  //виконати запит і в разі помилки вивести повідомлення про помилку
        
        //створення масиву категорій товарів і підкатегорій товарів
        $cat = array();
        
        while($row = mysql_fetch_assoc($res)){
            if(!$row['parent_id']){
                $cat[$row['brand_id']][] = $row['brand_name'];
            } else {
                $cat[$row['parent_id']]['sub'][$row['brand_id']] = $row['brand_name'];
            }
        }
        return $cat;
}
    /* === каталог одержання  масиву ===*/

    /* === масив інформеры та лінків - одержання масиву ===*/
    function informer(){
        $query="SELECT * FROM links
                    INNER JOIN informers ON
                        links.parent_informer=informers.informer_id
                            ORDER BY informer_position, links_position";
        $res=mysql_query($query) or die(mysql_query());  //виконати запит і в разі помилки вивести повідомлення про помилку

        $informers=array();
        $name = '';  // флаг імені інформера
        while ($row = mysql_fetch_assoc ($res)){
            if($row['informer_name'] != $name){ //якщо такого інформера в масивы ще неамає
                $informers[$row['informer_id']][]=$row['informer_name'];  //добавляєм інформер
                $name=$row['informer_name'];
            }
            $informers[$row['parent_informer']]['sub'][$row['link_id']]=$row['link_name']; //заносимо сторінки в інформер
        }
        return $informers;
    }
    /* === масив інформеры та лінків кінець ===*/
    
    /* === Айстопери  отримання  масиву  новинки,лідери продаж,розпродажа ===*/
    
   
    function eyestopper($eyestopper){
        $query="SELECT goods_id, name, img, price FROM goods
                    WHERE visible='1' AND $eyestopper='1'
                        ";
        $res=mysql_query($query) or die (mysql_error()); //виконати запит і в разі помилки вивести повідомлення про помилку
        
        $eyestoppers=array();
        while($row=mysql_fetch_assoc($res)){
            $eyestoppers[]=$row;
        }
        return $eyestoppers;
    }
    /* === Айстопери кінець===*/
    
    
    /* === одержання кількості товарів для навігації ===*/
    function count_rows($category){
        $query="(SELECT COUNT(goods_id) as count_rows
                  FROM `goods`
                    WHERE goods_brandid=$category AND visible='1')
                UNION
                (SELECT COUNT(goods_id) as count_rows
                    FROM `goods`
                    WHERE goods_brandid IN
                        (
                            SELECT brand_id FROM brands WHERE parent_id=$category
                        ) AND visible='1')";
        $res = mysql_query($query) or die (mysql_error());                        
        
        while($row = mysql_fetch_assoc($res)){
            if($row['count_rows']){
                $count_rows = $row['count_rows'];
            }
        }
        return $count_rows;                            
    }
    
    
    
    
    /* === одержання масиву товарів  по категоріях===*/
    
    function products($category, $start_pos, $perpage){
        $query="(SELECT * FROM `goods`
                    WHERE goods_brandid=$category AND visible='1')
                UNION
                (SELECT * FROM `goods`
                    WHERE goods_brandid IN
                        (
                            SELECT brand_id FROM brands WHERE parent_id=$category
                        ) AND visible='1') LIMIT $start_pos, $perpage";
        $res=mysql_query($query) or die (mysql_error()); //виконати запит і в разі помилки вивести повідомлення про помилку
        
        $products=array();
        while($row=mysql_fetch_assoc($res)){
            $products[]=$row;
        }
        return $products; 
    }
    /* === одержання масиву товарів  по категоріях кінець ===*/
    
    /* === вибір товарів  по параметрам ===*/
        function filter($category, $startprice, $endprice){
            $products=array();
            
            if($category OR $endprice){
            
                $predicat1="visible='1'";
                if($category){
                    $predicat1.="AND goods_brandid IN ($category)";
                    $predicat2 ="UNION
                                    (SELECT *
                                        FROM goods
                                            WHERE goods_brandid IN
                                            (
                                                SELECT brand_id FROM brands WHERE parent_id IN ($category)
                                            ) AND visible='1'";
                    if($endprice) $predicat2.="AND price BETWEEN $startprice AND $endprice";
                    
                    $predicat2.=")";
                }
                if($endprice){
                    $predicat1.= "AND price BETWEEN $startprice AND $endprice";
                }                
                
                $query = "(SELECT *  
                            FROM goods
                                WHERE $predicat1) $predicat2";
                
                //echo $query;
                
                $res=mysql_query($query) or die (mysql_error()); //виконати запит і в разі помилки вивести повідомлення про помилку
                
                if(mysql_num_rows($res) > 0){
                while($row = mysql_fetch_assoc($res)){
                    $products[] = $row;
                    }
                }else{
                    $products['notfound']="<div class='error'>По вказаних параметрах нічого не задано.</div>";    
                }
        
            }else{
                $products['notfound']="<div class='error'>Ви не вказали параметри для підбору.</div>";
            }
            return $products;
        }
        
    
    
    
    /* === вибір товарів  по параметрам кінець ===*/
    
    
    /* === сума замовлення і  атрибути товару ===*/
    function total_sum($goods){
        $total_sum=0;
        
        $str_goods=implode(',',array_keys($goods));
        
        $query="SELECT goods_id, name, price, img
                    FROM goods
                        WHERE goods_id IN ($str_goods)";
        $res=mysql_query($query) or die (mysql_error());
        
        while ( $row=mysql_fetch_assoc($res)){
            $_SESSION['cart'][$row['goods_id']]['name']=$row['name'];
            $_SESSION['cart'][$row['goods_id']]['price']=$row['price'];
            $_SESSION['cart'][$row['goods_id']]['img']=$row['img'];
            $total_sum += $_SESSION['cart'][$row['goods_id']]['qty']*$row['price'];
        }
        return $total_sum;
    }
    
     /* === реєстрація користувача і провірка ===*/
    function registration(){
        $error="";
        $login=clear($_POST['login']);
        $pass=trim($_POST['pass']);
        $name=clear($_POST['name']);
        $email=clear($_POST['email']);
        $phone=clear($_POST['phone']);
        $address=clear($_POST['address']);
       
        if(empty($login)){$error.='<li>Не заповнено логін</li>';};
        if(empty($pass)){$error.='<li>Не заповнено пароль</li>';};
        if(empty($name)){$error.='<li>Не заповнено ПІП</li>';};
        if(empty($email)){$error.='<li>Не заповнено емейл</li>';};
        if(empty($phone)){$error.='<li>Не заповнено телефон</li>';};
        if(empty($address)){$error.='<li>Не заповнено адрес</li>';};
        
        if(empty ($error)){
            //тут  якщо всі поля заповнені
            //тут провіряю  чи немає такого логіну в БД
            $query="SELECT customer_id FROM customers WHERE login='$login' LIMIT 1";
            $res=mysql_query($query) or die (mysql_error());
            $row=mysql_num_rows($res);  //1 (рядок)-є такий користувач в БД 0-ще немає такого
            if($row){
                //якщо  такий логін вже є
                $_SESSION['reg']['res']="<div class='error'>Користувач з таким логіном вже зареєстрований на сайті.Введіть інший логін.</div>";
                $_SESSION['reg']['name']=$name;
                $_SESSION['reg']['email']=$email;
                $_SESSION['reg']['phone']=$phone;
                $_SESSION['reg']['address']=$address;   
                
            } else {
                //якщо  такого логіну ще немає
                $pass = md5($pass);
                $query="INSERT INTO customers (name, email, phone, address, login, password)
                            VALUES ('$name', '$email', '$phone', '$address', '$login', '$pass')";
                //echo $query;
                $res=mysql_query($query) or die (mysql_error());
                
                //тут провірка виконання запросу
                if(mysql_affected_rows()>0){
                    //якщо функція mysql_affected_rows (перевіряє скільки рядків змінилось в результаті роботи запросу)
                    //якщо більше 0 тоді значить запрос виконався успішно.
                    $_SESSION['reg']['res'] = "<div class='success'>Успішно зареєстровано.</div>";
                    $_SESSION['auth']['user'] = $name;
                    $_SESSION['auth']['customer_id'] = mysql_insert_id();
                    $_SESSION['auth']['email'] = $email;
                    
                }
            }
        } else {
            //тут  якщо НЕ ЗАПОВНЕНІ поля
            $_SESSION['reg']['res']="<div class='error'> Не заповнені обовязкові поля: <ul> $error </ul></div>";
            $_SESSION['reg']['login']=$login;
            $_SESSION['reg']['name']=$name;
            $_SESSION['reg']['email']=$email;
            $_SESSION['reg']['phone']=$phone;
            $_SESSION['reg']['address']=$address;
        }  
    }    
    
/* === авторизація користувача і провірка ===*/
    function authorization(){
        $login=mysql_real_escape_string(trim($_POST['login']));
        $pass=trim($_POST['pass']);
        
        if(empty($login)OR empty ($pass)){
            //якщо порожні поля логін і пароль
            $_SESSION['auth']['error']="Не заповнені поля логін/пароль.";
        } else {
            //якщо заповнені поля логін і пароль
            $pass=md5($pass);
            
            $query="SELECT customer_id, name, email FROM customers
                        WHERE login='$login' AND password='$pass' LIMIT 1";
             $res=mysql_query($query) or die (mysql_error());
             if(mysql_num_rows($res)==1){
                //тут успішна авторизіція
                $row=mysql_fetch_row($res);
                $_SESSION['auth']['customer_id']=$row[0];
                $_SESSION['auth']['user']=$row[1];
                $_SESSION['auth']['email']=$row[2];
             } else {
                //тут кли невірні логін/пароль
                $_SESSION['auth']['error']="Помилкові логін або пароль.";
             }
        }
    }    

/* === способи доставки ===*/
    function get_dostavka(){
        $query="SELECT *  FROM dostavka";
        $res=mysql_query($query) or die(mysql_error()) ;
        
        $dostavka=array();
        while($row=mysql_fetch_assoc($res)){
            $dostavka[]=$row;
        }
        return $dostavka;
    }

/* === Добавлення замовлення === */
    function add_order(){
        //одержуєм  загальні дані для всіх покупців (авторизовані  і не авторизовані  покупці)
        
        $dostavka_id = (int)$_POST['dostavka'];
        if(!$dostavka_id){
            $dostavka_id = 1;       // тут по дефолту   спосіб доставки 1-й
        }
        $prim = clear($_POST['prim']);
        if($_SESSION['auth']['user']){
            $customer_id = $_SESSION['auth']['customer_id'];
        }
        if(!$_SESSION['auth']['user']){
            $error="";
            $name=clear($_POST['name']);
            $email=clear($_POST['email']);
            $phone=clear($_POST['phone']);
            $address=clear($_POST['address']);
           
            if(empty($name)){$error.='<li>Не заповнено ПІП</li>';};
            if(empty($email)){$error.='<li>Не заповнено емейл</li>';};
            if(empty($phone)){$error.='<li>Не заповнено телефон</li>';};
            if(empty($address)){$error.='<li>Не заповнено адрес</li>';};
            
            if (empty($error)){
                //добавляємо гостя в замовники товару (але без логіну і пароля)
                $customer_id = add_customer($name, $email, $phone, $address);
                if(!$customer_id){return false;}       // припиняємо роботу в  випадку помилки добавлення гостя-замовника
                
            } else {
                //тут  якщо НЕ ЗАПОВНЕНІ поля
                $_SESSION['order']['res']="<div class='error'> Не заповнені обовязкові поля: <ul> $error </ul></div>";
               
                $_SESSION['order']['name']=$name;
                $_SESSION['order']['email']=$email;
                $_SESSION['order']['phone']=$phone;
                $_SESSION['order']['address']=$address;
                $_SESSION['order']['prim']=$prim;
                return false;
            }
        }
        $_SESSION['order']['email'] = $email;
        save_order($customer_id, $dostavka_id, $prim );    
        
    }

/* === Добавлення гостя замовника === */
    function add_customer($name, $email, $phone, $address){
        $query = "INSERT INTO customers (name, email, phone, address)
                    VALUES ('$name', '$email', '$phone', '$address')";
        $res = mysql_query($query);
        if(mysql_affected_rows()>0){
            //якщо гість  доданий в  замовники, ти ми отримуємо ІД гостя-замовника
            return mysql_insert_id();
        } else {
            //якщо  відбуласть помилка при добавленні  ного замовника-гостя
            $_SESSION['order']['res']="<div class='error'> Відбулась помилка при реєстрації замовлення: <ul> $error </ul></div>";
            $_SESSION['order']['name']=$name;
            $_SESSION['order']['email']=$email;
            $_SESSION['order']['phone']=$phone;
            $_SESSION['order']['address']=$address;
            $_SESSION['order']['prim']=$prim;
            return false;
        }
    }

/* === Збереження замовлення === */
    function save_order($customer_id, $dostavka_id, $prim){
        $query = "INSERT INTO orders (`customer_id`, `date`, `dostavka_id`, `prim`)
                    VALUES($customer_id, NOW(), $dostavka_id, '$prim')";
        mysql_query($query) or  die (mysql_error());
        
        if(mysql_affected_rows()== -1){
            //якщо не вдалось зберегти замовлення тоді ми  удаляємо гостя-замовника з БД
            mysql_query("DELETE FROM customers
                             WHERE customer_id=$customer_id AND login = '' ");
            return false;
        }
        $order_id = mysql_insert_id(); //ID номер збереженого замовлення
        
        foreach($_SESSION['cart'] as $goods_id => $value){
                $val.="($order_id, $goods_id, {$value['qty']} ),";
        }
        $val = substr($val, 0, -1); //удаляємо останню кому в рядку.  
        
        $query = "INSERT INTO zakaz_tovar (orders_id, goods_id, quantity)
                    VALUES $val";
        
        mysql_query($query) or die (mysql_error());
        if(mysql_affected_rows()== -1){
            //якщо не вигрузився в БД замовлення тоді ми  удаляємо гостя-замовника з табл-customers і
            // сам заказ з табл-orders
            mysql_query("DELETE FROM order WHERE order_id = $order_id");
            mysql_query("DELETE FROM customers WHERE customer_id = $customer_id AND login = '' ");
            return false;
        }
        
        if($_SESSION['auth']['email']){
            $email = $_SESSION['auth']['email'];
            } else {
                $email = $_SESSION['order']['email'];
            }
            
        mail_order($order_id, $email);
        
        
                   
        // якщо замовлення вигрузилось  в табличку тоді очищаю сесію
        unset($_SESSION['cart']);
        unset($_SESSION['total_sum']);
        unset($_SESSION['total_quantity']);
        $_SESSION['order']['res']="<div class='success'> Дякуємо за замовлення, до Вас зателефонує менеджер для  затвердження замовлення.<ul> $error </ul></div>";
        return true;        
                         
}

/* === Відправка повідомлення про замовлення товару не  ел пошту === */
    function mail_order($order_id, $email){
        // mail(to, subject, body, header);
        
        // тема листа
        $subject = "Замовлення товару в інтернет магазині.";
        
        // заголовки
        $headers .= "Content-type: text/plain; charset=utf-8\r\n";
        $headers .= "From: ishop.loc";
        
        // тіло вміст листа
        $mail_body = "дакуємо  Вам за замовлення. \r\n Номер Вашого замовлення-{$order_id}
         \r\n\r\n\r\n Замовлені товари: \r\n";
        
        //атрибути товару
        foreach ($_SESSION['cart'] as $goods_id =>$value){
            $mail_body .= "Назва: {$value['name']}, Ціна: {$value['price']}, Кількість: {$value['qty']} шт. \r\n";
        }
        $mail_body .="\r\n Разом: {$_SESSION['total_quantity']} на суму: {$_SESSION['total_sum']}";
        
        //відправка листів
        @mail($email, $subject, $mail_body, $headers); //для клієнта
        @mail(ADMIN_EMAIL, $subject, $mail_body, $headers); //для менеджера-адміністратора магазину
        
    }



/* === пошук товару на сайті === */
        function search(){
        $search = clear($_GET['search']);
        $result_search = array(); //результат поиска
        
        if(mb_strlen($search, 'UTF-8') < 4){
        $result_search['notfound'] = "<div class='error'>Пошуковий запит має складати не менше 4-х символів</div>";
        }else{
            $query = "SELECT *
                        FROM goods
                            WHERE MATCH(name) AGAINST('{$search}*' IN BOOLEAN MODE) AND visible='1'";
            $res = mysql_query($query) or die(mysql_error());
            
            if(mysql_num_rows($res) > 0){
                while($row_search = mysql_fetch_assoc($res)){
                    $result_search[] = $row_search;
                }
            }else{
                $result_search['notfound'] = "<div class='error'>По Вашому запиту нічого не знайдено</div>";
            }
        }   
        
        return $result_search;
    } 








?>