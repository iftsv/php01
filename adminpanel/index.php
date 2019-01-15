<?
require_once('../config/config.php');
if (!UserIsAdmin()) {
    echo "<h3>Access denied!</h3>";
    exit("<a href='//". DOMAIN ."'>Back to Homepage</a>");
}
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Admin Panel</title>
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
                <li><a href="//lp.test">Главная</a></li>
                <li>Admin Panel</li>
            </ul>
            <main class="content">
                <table style="width: 100%;" class="adminpanel-item">
                    <tr>
                        <td style="width: 20%">
                            <p><a href="additem.php" class="admin_button">Добавить новый товар</a></p>
                            <p><a href="archive.php" class="admin_button">Архив</a></p>
                            <p><a href="../order/" class="admin_button">Заказы</a></p>
                            <p><a href="user.php" class="admin_button">Пользователи</a></p>
                        </td>
                        <td>
                            <? $items = ShowAllItems($sqlcon, 0);
                            if ($items) {?>
                                <div class="admin_catalog_list">
                                <?foreach ($items as $item) {?>
                                    <div class="catalog_item">
                                    <img class="catalog_img" src="<?=$item['img_min'];?>" alt="<?=$item['item_name'];?>">
                                    <div><?=$item['item_name'];?></div>
                                    <div>Цена: <?=$item['item_price'];?> ₽</div>
                                    <div><a href="edititem.php?id=<?=$item['id_item'];?>" class="admin_button_op">Редактировать</a></div>
                                    <br>
                                    <div><a href="#" onclick="update_archive_status_of_item(<?=$item['id_item'];?>, 1);" class="admin_button_op">Убрать в архив</a></div>
                                    </div>
                                <?
                                }
                                ?>
                                </div>
                            <? 
                            } else {
                                echo "<p>Нет товаров, либо все товары в Архиве</p>";
                            }
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