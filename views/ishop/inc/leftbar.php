<?php
    //тут захист від прямого доступу в цей файл, провіряю чи встановлена захисна КОНСТАНТА
    defined('ISHOP') or die ('Access defined. Немає доступу.');
?>

<div id="left-bar"><!-- ПОЧАТОК тут ліва колонка -->
    <div id="left-bar-cont">
        <h2><span>Каталог</span></h2><!-- тут має бути стиль глянець для заголовка КАТАЛОГ мені не вдалось то  зробити в  фотошопі -->
        <h3 class="nav-new"><a href="?view=new">Новинки</a></h3>
        <h3 class="nav-lider"><a href="?view=hits">Лідери продажі</a></h3>
        <h3 class="nav-sale"><a href="?view=sale">Розпродаж</a></h3>
        <h4><span>-Мобільні телефони</span></h4>
            
            <!-- меню каталог-->
            <ul class="nav-catalog" id="accordion">
                
                <?php
                foreach($cat as $key => $item){
                //print_arr($item);
                //echo count($item);
                if(count($item)>1){             //якщо це батьківська категорія
                    echo"<h3><li><a href='#'>$item[0]</a></li></h3>";
                    
                    echo"<ul class='nav-catalog-dodatkovo'>";
                        echo"<li>-<a href='?view=cat&category=$key'>Всі моделі</a></li>";
                        foreach($item['sub'] as $key => $sub){
                            echo"<li>-<a href='?view=cat&category=$key'>$sub</a></li>";
                        }
                    echo"</ul>";
                    } elseif ($item[0]){
                    echo"<li><a href='?view=cat&category=$key'>$item[0]</a></li>";
                    }
                }
                ?>
            </ul>
            <!-- меню каталог-->

        <div class="bar-contact">
            <h3>Контакти:</h3>
            <p><strong>Телефон:</strong><br />
            <span>8 (800) 700-00-01</span></p>
            
            <p><strong>Режим роботи:</strong><br />
            Будні дні:<br />
            з 9:00 до 18:00<br />
            Субота, Неділя:<br />
            Вихідні</p>
        </div>
        <div class="news">
            <h3>Новини</h3>
            <p>
                <span>24.03.2013</span>
                <a href="#">Поступили в продажу новые телефоны sumsung</a>
            </p>
            <p>
                <span>23.02.2013</span>
                <a href="#">Подарки всем купившим apple iphone 4s</a>
            </p>
            <a class="news-arh" href="#">Архів новин</a>
        </div>


        <!-- Інформери -->
        <?php
            foreach ($informers as $informer) {
                echo'<div class="info">';
                echo "<h3>".$informer[0]."</h3>";   //виввід Заголовків тем інформерів
                    foreach ($informer['sub'] as $key => $sub){
                        echo"<p><a href='?view=informer&id=$key'>".$sub."</a></p>";
                    }
                echo '</div>';
            }
        ?>
         <!-- Інформери -->
        
        
        
        
    </div>           
</div><!-- КІНЕЦЬ  ліва колонка -->