<?
require_once('../config/config.php');
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Вход в магазин</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/view.css">
        <script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="./js/registration.js"></script>
    </head>
    <body>
        <div class="container">
            <header>
                <? include "../template/header.php";?>
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
                <? include "../template/footer.php";?>
            </footer>
        </div>
    </body>
</html>