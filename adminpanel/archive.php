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
        <title>Архив товаров</title>
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
                <li><a href="//lp.test/adminpanel">Admin Panel</a></li>
                <li>Архив товаров</li>
            </ul>
            <main class="content">
                <table style="width: 100%;" class="adminpanel-item">
                    <tr>
                        <td style="width: 20%">
                            <p><a href="//lp.test/adminpanel" class="admin_button">Список товаров</a></p>
                            <p><a href="additem.php" class="admin_button">Добавить новый товар</a></p>
                        </td>
                        <td>
                            <? $items = ShowAllItems($sqlcon, 1);
                            if ($items) {?>
                                <div class="admin_catalog_list">
                                <?foreach ($items as $item) {?>
                                    <div class="catalog_item">
                                    <img class="catalog_img" src="<?=$item['img_min'];?>" alt="<?=$item['item_name'];?>">
                                    <div><?=$item['item_name'];?></div>
                                    <div>Цена: <?=$item['item_price'];?> ₽</div>
                                    <div><a href="#" onclick="update_archive_status_of_item(<?=$item['id_item'];?>, 0);" class="admin_button_op">Убрать из Архива</a></div>
                                    </div>
                                <?
                                }
                                ?>
                                </div>
                            <? 
                            } else {
                                echo "<p>Нет товаров в Архиве</p>";
                            }
                            ?>
                        </td>
                    </tr>

                </table>
            </main>
            <footer>
                <? include "../template/footer.php";?>>
            </footer>
        </div>
    </body>
</html>