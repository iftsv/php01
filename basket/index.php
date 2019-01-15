<?
/*
страница для работы с корзиной
*/

# проверяем что пользователь зашел в систему
require_once('../config/config.php');
if (!IsAuthUser()) {
    echo "<h3>Для работы с корзиной, необходимо войти в систему</h3>";
    exit("<a href='//". DOMAIN ."/public/login.php'>Log In</a>");
}

$id_user = $_SESSION["id_user"];

?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Корзина</title>
        <link rel="stylesheet" href="../public/css/style.css">
        <script type="text/javascript" src="../public/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../public/js/async.js"></script>
    </head>
    <body>
        <div class="container">
            <header>
                <? include "../template/header.php";?>
            </header>
            <ul class="authpanel">
                <?echo BuildAuthMenu($sqlcon);?>
            </ul>
            <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li>Корзина</li>
            </ul>
            <main class="content">
                <table style="width: 100%;" class="adminpanel-item">
                    <tr>
                        <td style="width: 20%">
                            <p><a href="#" onclick="clear_basket();" class="admin_button">Очистить Корзину</a></p>
                            <p><a href="#" onclick="create_new_order();" class="admin_button">Оформить Заказ</a></p>
                        </td>
                        <td class="basket_form_info">
                            <?echo GetBasketFormByIdUser($sqlcon, $id_user);?>
                        </td>
                    </tr>
                </table>
            </main>
            <footer>
                <? include "../template/footer.php";?>
            </footer>
        </div>
    </body>
</html>

