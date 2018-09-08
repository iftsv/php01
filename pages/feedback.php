<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Наши контакты</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="container">
            <header>
                <a href="//eliastestsite.000webhostapp.com"><img src="../img/logo_mini.png" alt="">
                    <h1>Магазин ноутбуков Laptops Heaven [LH]</h1>
                </a>
                <ul class="style_menu">
                    <li><a href="../index.html">Главная</a></li>
                    <li><a href="catalog.html">Каталог</a></li>
                    <li><a href="contacts.html">Контакты</a></li>
                    <li><a href="feedback.php">Отзывы</a></li>
                </ul>
            </header>
            <ul class="breadcrumb">
                <li><a href="//eliastestsite.000webhostapp.com">Главная</a></li>
                <li>Отзывы</li>
            </ul>
            <main class="content">
                <div class="feedback_form">
                    <h3>Оставить комментарий</h3>
                    <form action="" method="POST">
                        <p><input class="style_input" type="text" placeholder="Ваше имя" required autocomplete="on" name="author_name"></p>
                        <p><input class="style_input" type="email" placeholder="Ваш Email" required autocomplete="on" name="author_email"></p>
                        <p><textarea class="style_input" rows="5" placeholder="Текст сообщения" required name="author_message"></textarea></p>
                        <p><input type="submit" value="Отправить"></p>
                    </form>
                    <br>
                    <h3>Сообщения:</h3>
                    <?include "showfeedback.php"?>
                    <?include "getfeedback.php"?>
                </div>
            </main>
            <footer>
                <div class="footer_phone"><a href="tel:88005556677">8 (800) 555 6677</a></div>
                <div class="footer_menu">
                    <ul class="footer_menu">
                        <li><a href="//eliastestsite.000webhostapp.com">ГЛАВНАЯ</a></li>
                        <li><a href="catalog.html">КАТАЛОГ</a></li>
                        <li><a href="contacts.html">КОНТАКТЫ</a></li>
                    </ul>
                </div>
                <div class="footer_text">&copy; Все права защищены, 2018</div>
            </footer>         
        </div>
    </body>
</html>