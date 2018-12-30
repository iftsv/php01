<?
require_once('../config/config.php');

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Корзина</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="container">
            <header>
                <a href="//lp.test"><img src="../img/logo_mini.png" alt="">
                    <h1>Ноутбуки от Laptops Heaven [LH]</h1>
                </a>
                <ul class="style_menu">
                    <li><a href="//lp.test">Главная</a></li>
                    <li><a href="../pages/catalog.php">Каталог</a></li>
                    <li><a href="../pages/contacts.html">Контакты</a></li>
                </ul>
            </header>
            <ul class="authpanel">
                <?echo BuildAuthMenu();?>
            </ul>
            <ul class="breadcrumb">
                <li><a href="//lp.test">Главная</a></li>
                <li>Заказы</li>
            </ul>
            <main class="content">
                <table style="width: 100%;" class="adminpanel-item">
                    <tr>
                        <td style="width: 20%">
                            <p><a href="#" class="admin_button">Кнопка 1</a></p>
                            <p><a href="#" class="admin_button">Кнопка 2</a></p>
                        </td>
                        <td>
                            Содержимое формы
                        </td>
                    </tr>

                </table>
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