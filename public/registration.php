<?
require_once('../config/config.php');
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Вход в магазин</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/view.css">
        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../js/registration.js"></script>
    </head>
    <body>
        <div class="container">
            <header>
                <a href="//lp.test"><img src="../img/logo_mini.png" alt="">
                    <h1>Магазин ноутбуков Laptops Heaven [LH]</h1>
                </a>
                <ul class="style_menu">
                    <li><a href="//lp.test">Главная</a></li>
                    <li><a href="../pages/catalog.php">Каталог</a></li>
                    <li><a href="../pages/contacts.html">Контакты</a></li>
                </ul>
            </header>
            <main class="content">
                <h3>Для регистрации на нашем сайте, пожалуйста, заполните следующие поля:</h3>
                <form id="form_26367" class="appnitro" method="POST" action="" accept-charset="utf-8">
                    <ul>
                        <li id="li_1">
                            <label class="description" for="element_1">Ваш e-mail (используется для входа в систему)</label>
                            <div><input id="element_1" name="reg_email" class="element text medium" type="email" maxlength="50" value="" required autocomplete="on" /></div>
                        </li>
                        <li id="li_2">
                            <label class="description" for="element_2">Пароль</label>
                            <div><input id="element_2" name="reg_password" class="element text medium" type="password" maxlength="50" value="" required autocomplete="on"/></div>
                        </li>
                        <li id="li_3">
                            <label class="description" for="element_3">Повторите пароль</label>
                            <div><input id="element_3" class="element text medium" type="password" maxlength="50" value="" required autocomplete="on"/></div>
                        </li>
                        <li class="buttons">
                            <br>
                            <button onclick="CheckPasswordFields()">Зарегистрировать пользователя</button>
                        </li>
                    </ul>
                </form>
            </main>
            <footer>
                <div class="footer_phone"><a href="tel:88005556677">8 (800) 555 6677</a></div>
                <div class="footer_menu">
                    <ul class="footer_menu">
                        <li><a href="/">ГЛАВНАЯ</a></li>
                        <li><a href="catalog.html">КАТАЛОГ</a></li>
                        <li><a href="contacts.html">КОНТАКТЫ</a></li>
                    </ul>
                </div>
                <div class="footer_text">&copy; Все права защищены, 2018</div>
            </footer>
        </div>
    </body>
</html>