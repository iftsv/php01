<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Отзывы</title>
        <link rel="stylesheet" href="../public/css/style.css">
    </head>
    <body>
        <div class="container">
            <header>
                {header}
            </header>
            <ul class="authpanel">
                {auth_menu}
            </ul>
            <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li>Отзывы</li>
            </ul>
            <main class="content">
                <div class="feedback_form">
                    <h3>Оставить комментарий</h3>
                    <form action="" method="POST">
                        <p><input class="style_input" type="text" placeholder="Ваше имя" required autocomplete="on" name="author_name"/></p>
                        <p><input class="style_input" type="email" placeholder="Ваш Email" required autocomplete="on" name="author_email"/></p>
                        <p><textarea class="style_input" rows="5" placeholder="Текст сообщения" required name="author_message"></textarea></p>
                        <p><input type="submit" value="Отправить"/></p>
                    </form>
                    <hr><hr>
                    <h3>Сообщения:</h3>
                    {feedback_msg}
                </div>
            </main>
            <footer>
                {footer}
            </footer>
        </div>
    </body>
</html>