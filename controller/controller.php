<?php
    //тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
    defined('ISHOP') or die ('Access defined. Немає доступу.');
    
    session_start();

    //тут підключення моделі
    require_once MODEL;
    
    //тут підключення бібліотеки з різними  функціями
    require_once './function/function.php';
    
    
    //тут підключення масиву каталогу моб телефонів і підкатегорій  товару
    $cat = catalog();
    
    //тут підключення  масиву інформерів
    $informers=informer();
    
    //тут регістація нового користувача
    if($_POST['reg']){
        registration();
        redirect();
    }
    
    // тут вихід з сайту
    if($_GET['do']=='logout'){
        logout();
        redirect();
    }
    
    // авторизація
    if($_POST['auth']){
        authorization();
        //redirect();
        if($_SESSION['auth']['user']){
            //якщо  авторизувався користувач
            echo'<p>Ласкаво просимо,'.$_SESSION['auth']['user'].'</p>';
            exit;
        }else{
            //якщо авторизація невдала
            echo $_SESSION['auth']['error'];
            unset ($_SESSION['auth']);
            exit;
        }
        
    }
    
     
    
    //тут вже  пишу роботу контролера
    //підключення динамічної частини шаблона
    if (empty($_GET['view'])){  //якщо в масиві ГЕТ немає view то подефотлу будуть виводитись Лідери продаж.
        $view='hits';
    } else {
        $view=$_GET['view'];
    }
    
    switch ($view){
        //якщо лідери продаж
        case('hits'):
            $eyestoppers = eyestopper('hits');
        break;
        //якщо лідери продаж
        case('new'):
            $eyestoppers = eyestopper('new');
        break;
        //якщо лідери продаж
        case('sale'):
            $eyestoppers = eyestopper('sale');
        break;
        //якщо получаю ссилку з акордіону каталог товарів
        case('cat'):
            $category=abs((int)$_GET['category']);
            
                      
            // параметры для навигации
            $perpage = PERPAGE; // кол-во товаров на страницу
            if(isset($_GET['page'])){
                $page = (int)$_GET['page'];
                if($page < 1) $page = 1;
            }else{
                $page = 1;                              //по дефолту завжди перша сторінка
            }
            
            $count_rows = count_rows($category);        //загальна кількість товарів
            //echo $count_rows;
            $pages_count=ceil($count_rows / $perpage);  //загальна кількість сторінок
            if(!$pages_count){
                $pages_count = 1;                       //мінімум 1 сторінка
            }
            
            if($page > $pages_count){
                $page = $pages_count;                   //ЗАХИСТ якщо  сторінка з товарами більша  максимально можливої  
            }
            
            $start_pos = ($page -1 ) * $perpage;        //початкова позиція для запроса
            
            
            $products = products($category, $start_pos, $perpage);    //одержуємо масив з моделі з потрібними товарами
        break;
        
        case('addtocart'):
            //додати товар до кошика
            $goods_id=abs((int)$_GET['goods_id']);      //тут в сесію  записую додоний товар і  принеобхідності кількість
            addtocart($goods_id);
            
            $_SESSION['total_sum']=total_sum($_SESSION['cart']);  //тут уже модель працює з базою,(назва товару,ціна, кількість, сума і ЗАГАЛЬНА СУМА)
        
            //тут підрахунок ЗАГАЛЬНА КІЛЬКІСТЬ ТОВАРУ + захист провірка выд вводу неіснуючого товару
            total_quantity();
            
            redirect(); //ця функція буде повертати користувавча після кліду добавити в кошик товар на над на ту  сторінку де раніше був  користувач
        break;
        
        case ('cart'):  //тут перегляд вмісту корзини
        
            //одержання способів доставки  товару
            $dostavka=get_dostavka();
            
            //перерахунок товарів в корзині
            if(isset($_GET['id'], $_GET['qty'])){
                $goods_id=abs((int)$_GET['id']);
                $qty=abs((int)$_GET['qty']);
                
                $qty= $qty - $_SESSION['cart'][$goods_id]['qty'];
                addtocart($goods_id, $qty);
                
                $_SESSION['total_sum']=total_sum($_SESSION['cart']);  //СУМА ЗАМОВЛЕННЯ 
                
                total_quantity();   //тут підрахунок ЗАГАЛЬНА КІЛЬКІСТЬ ТОВАРУ + захист провірка выд вводу неіснуючого товару
                redirect();    
            }
            
            //тут буде  процедура  видалення товару з корзини
            if(isset($_GET['delete'])){
                $id=abs((int)$_GET['delete']);
                if($id){
                    delete_from_cart($id);
                }
                redirect();
            }
            if($_POST['odrer_x']){
                //тут буду викликати функцію з додаванням замовлення
                add_order();
                redirect();
            }
            
        break;    
        
        //якщо получаю ссилку на реєстрацію нового користувача
        case('reg'):
                
        break;
        
        // пошук товарів по сайту
        case('search'):
            $result_search = search();       
        
        break; 
        
        case('filter'):
            // выбор по параметрам
            $startprice = (int)$_GET['startprice'];
            $endprice = (int)$_GET['endprice'];
            $brand = array();
            
            if($_GET['brand']){
                foreach($_GET['brand'] as $value){
                    $value = (int)$value;
                    $brand[$value] = $value;
                }
            }
            if($brand){
                $category = implode(',', $brand);
            }
            $products = filter($category, $startprice, $endprice);
            
        
        break;
        
        
        //по дефолту якщо в адресній строці отримано імя битого шаблону (неіснуючого виду)це елемент захисту
        default:
            $view='hits';
            $eyestoppers = eyestopper('hits');
    }


    
    //тут підключення виду активного шаблону
    require_once TEMPLATE.'index.php';



?>