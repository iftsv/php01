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
    </head>
    <body>
        <div class="container">
            <header>
                <? include "../template/header.php";?>
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
                <? include "../template/footer.php";?>
            </footer>
        </div>
    </body>
</html>