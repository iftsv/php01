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
                <li>Admin Panel</li>
            </ul>
            <main class="content">
                <table style="width: 100%;" class="adminpanel-item">
                    <tr>
                        <td style="width: 20%">
                            <p><a href="additem.php" class="admin_button">Добавить новый товар</a></p>
                            <p><a href="showarchive.php" class="admin_button">Архив</a></p>
                            <p><a href="../order/" class="admin_button">Заказы</a></p>
                            <p><a href="user.php" class="admin_button">Пользователи</a></p>
                        </td>
                        <td>
                            <? $items = ShowAllItems($sqlcon, 0);
                            if ($items) {?>
                                <div class="catalog_list">
                                <?foreach ($items as $item) {?>
                                    <div class="catalog_item">
                                    <img class="catalog_img" src="<?=$item['img_min'];?>" alt="<?=$item['item_name'];?>">
                                    <div><?=$item['item_name'];?></div>
                                    <div>Цена: <?=$item['item_price'];?> ₽</div>
                                    <div><a href="edititem.php?id=<?=$item['id_item'];?>" class="admin_button_op">Редактировать</a></div>
                                    <br>
                                    <div><a href="archiveitem.php?id=<?=$item['id_item'];?>" class="admin_button_op">Убрать в архив</a></div>
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