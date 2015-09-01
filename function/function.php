<?php
    //тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
    defined('ISHOP') or die ('Access defined. Немає доступу.');

/* === роздруковка масиву ==== */

    function print_arr($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

/* === додавання в кошик ==== */
    function addtocart($goods_id, $qty=1){
        if(isset($_SESSION['cart'][$goods_id])){
            //якщо в масиві cart уже існує той товар який уже перед тим був (раніше) доданий
            $_SESSION['cart'][$goods_id]['qty']+=$qty;    //тоді збільшуєм кількістьровару на  одиницю
            return $_SESSION['cart'];  
        } else {
            // товар вперше кладеться  в корзину
            $_SESSION['cart'][$goods_id]['qty']=$qty;     // кладемо 1 шт товару в кошик
            return $_SESSION['cart'];
        }
    }
/* === додавання в кошик ==== */

/* === видалення з кошика ==== */
    function delete_from_cart($id){
        if($_SESSION['cart']){
            if(array_key_exists($id, $_SESSION['cart'])){
                $_SESSION['total_quantity']-=$_SESSION['cart'][$id]['qty'];
                $_SESSION['total_sum'] -=$_SESSION['cart'][$id]['qty']*$_SESSION['cart'][$id]['price'];
                unset ($_SESSION['cart'][$id]);
            }
        }
    }


/* === видалення з кошика ==== */








/* === редірект === */
// ця функція буде повертати користувавчу після кліду добавити в кошик товар на над на ту  сторінку де раніше був  користувач
    function redirect(){        //томною написа функція на подобу тої що в  відеоуроці
        if(isset($_SERVER['HTTP_REFERER'])){
            $redirect = $_SERVER['HTTP_REFERER'];    
        } else {
            $redirect =PATH;
        }
        header("Location: $redirect");
        exit;
    }

/* === редірект === */

/* === вихід з сайту === */
    function logout(){
        unset ($_SESSION['auth']);
    }
/* === вихід з сайту === */

/* === захист  філтрація  вхідних даних від користувача ===*/
    function clear($var){
        $var=mysql_real_escape_string(strip_tags(trim($var)));
        return $var;
    }
/* === захист  філтрація  вхідних даних від користувача ===*/



/* === тут підрахунок ЗАГАЛЬНА КІЛЬКІСТЬ ТОВАРУ + захист провірка выд вводу неіснуючого товару ===*/
function total_quantity(){
    $_SESSION['total_quantity']=0;
        foreach( $_SESSION['cart'] as $key =>$value){
            if(isset($value['price'])){
                // якщо ми получили ціну товар з БД значить такий товар  з таким ID існує
                // тоді ми сумуємо ЗАГАЛЬНУ КІЛЬКІСТЬ ТОВАРУ
                $_SESSION['total_quantity'] += $value['qty'];
            } else {
                // якщо ми НЕ ПОЛУЧИЛИ ціну товар з БД значить такий товар  з таким ID НЕ ІСНУЄ
                // тоді ми видаяємо ID фальшивого товару з сесії-кошика
                unset($_SESSION['cart'][$key]);
            } 
        }
}
/* === тут підрахунок ЗАГАЛЬНА КІЛЬКІСТЬ ТОВАРУ + захист провірка выд вводу неіснуючого товару ===*/

/* ==  посторінкова навігація === */
//      << < 2 | 3 | 4 | 5 | 6 > >>

    function pagination($page, $pages_count){
        if($_SERVER['QUERY_STRING']){   //якщо є парпметри в строці запиту
            foreach($_GET as $key => $value){
                //фурмуємо строку з параметрами без номера  сторінки
                echo "$key => $value <br>";
                if($key != 'page') $uri .= "{$key}={$value}&amp;";
            }
            
           //echo "<br> $uri";
        }
        //формування ссилок для навігації
        $back ='';             //на зад
        $forward ='';           //вперед
        $startpage='';          //на  початок
        $endpage='';            //в кінець
        $page2left='';          //2 стор з ліва
        $page1left='';          //1 стор з ліва
        $page2right='';         //2 стор з права
        $page1right='';         //1 стор з права
        
        if($page > 1){
            $back = "<a class='nav_link' href='?{$uri}page=".($page-1)."'>&lt</a>";
        }
        if($page < $pages_count){
            $forward = "<a class='nav_link' href='?{$uri}page=".($page+1)."'>&gt</a>";
        }
        if($page > 3){
            $startpage = "<a class='nav_link' href='?{$uri}page=1'>&laquo</a>";
        }
        if($page <($pages_count - 2)){
            $endpage = "<a class='nav_link' href='?{$uri}page={$pages_count}'>&raquo</a>";
        }
        if($page - 2 > 0){
            $page2left = "<a class='nav_link' href='?{$uri}page=".($page-2)."'>" .($page-2). "</a>";
        }
        if($page - 1 > 0){
            $page1left = "<a class='nav_link' href='?{$uri}page=".($page-1)."'>" .($page-1). "</a>";
        }
        if($page + 2 <=$pages_count){
            $page2right = "<a class='nav_link' href='?{$uri}page=".($page+2)."'>" .($page+2). "</a>";
        }
        if($page + 1 <=$pages_count){
            $page1right = "<a class='nav_link' href='?{$uri}page=".($page+1)."'>" .($page+1). "</a>";
        }
        
        //формуємо вивід навігації
        echo'<div class="pagination">'.$startpage.$back.$page2left.$page1left.'<a class="nav_active">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage.'</div>';
        
    }









?>