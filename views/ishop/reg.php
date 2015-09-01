<?php defined('ISHOP') or die('Access denied'); ?>
<div class="content-txt">	
    <h2>Регистрация</h2>

    <form method="post" action="#">
        <table class="zakaz-data" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="zakaz-txt">*Логін</td>
                <td class="zakaz-inpt"><input type="text" name="login" value="<?=$_SESSION['reg']['login']?>" /></td>
                <td class="zakaz-prim"></td>
            </tr>
            <tr>
                <td class="zakaz-txt">*Пароль</td>
                <td class="zakaz-inpt"><input type="password" name="pass" /></td>
                <td class="zakaz-prim"></td>
            </tr>
            <tr>
                <td class="zakaz-txt">*ПІП</td>
                <td class="zakaz-inpt"><input type="text" name="name" value="<?=$_SESSION['reg']['name']?>" /></td>
                <td class="zakaz-prim">Приклад: Іванов Іван Іванович</td>
            </tr>
            <tr>
                <td class="zakaz-txt">*Е-мейл</td>
                <td class="zakaz-inpt"><input type="text" name="email" value="<?=$_SESSION['reg']['email']?>" /></td>
                <td class="zakaz-prim">Приклад: test@ukr.net</td>
            </tr>
            <tr>
                <td class="zakaz-txt">*Телефон</td>
                <td class="zakaz-inpt"><input type="text" name="phone" value="<?=$_SESSION['reg']['phone']?>" /></td>
                <td class="zakaz-prim">Приклад: 0 098 600 03 45</td>
            </tr>
            <tr>
                <td class="zakaz-txt">*Адрес доставки</td>
                <td class="zakaz-inpt"><input type="text" name="address" value="<?=$_SESSION['reg']['address']?>" /></td>
                <td class="zakaz-prim">Приклад: м. Київ, пр. Миру, вул. Петра Сагайчачного б.28, кв 53.</td>
            </tr>                
		</table>
        <input type="submit" name="reg" value="Зареєструватися" />
    </form>	
    
    <?php
        if(isset($_SESSION['reg']['res'])){
            echo $_SESSION['reg']['res'];
            unset($_SESSION['reg']);
        }
    
    ?>
    	
</div> <!-- .content-txt -->