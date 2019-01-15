<?
require_once('../config/config.php');

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Заказы</title>
        <link rel="stylesheet" href="../public/css/style.css">
        <link rel="stylesheet" href="../public/css/view.css">
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
                <li><a href="//lp.test">Главная</a></li>
                <li>Заказы</li>
            </ul>
            <main class="content">
                <table style="width: 100%;" class="adminpanel-item">
                    <tr>
                        <td style="width: 20%">
                            <p><a href="#" class="admin_button" onclick="document.location.reload(true);">Обновить статус</a></p>
                        </td>
                        <td class="order_form_info">
                            <? 
                                echo FillOutOrderForm($sqlcon);
                            ?>
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