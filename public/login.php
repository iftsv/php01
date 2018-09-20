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
                            <form id="form_26367" class="appnitro"  method="POST" action="" accept-charset="utf-8">
                                <ul>
                                    <li id="li_1">
                                        <label class="description" for="element_1">E-mail</label>
                                        <div><input id="element_1" name="email" class="element text medium" type="email" maxlength="50" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_2">
                                        <label class="description" for="element_2">Пароль</label>
                                        <div><input id="element_2" name="password" class="element text medium" type="password" maxlength="50" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li class="buttons">
                                        <input type="hidden" name="form_id" value="26367" />
                                        <input id="saveForm" class="button_text" type="submit" name="submit" value="Войти" />
                                    </li>
                                </ul>
                            </form>
                            <a href='<?="//" . DOMAIN . "/public/registration.php"?>'>Регистрация</a>
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