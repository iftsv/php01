<?
require_once('../config/config.php');
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Каталог</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="container">
            <header>
                <a href="/"><img src="../img/logo_mini.png" alt="">
                    <h1>Ноутбуки от Laptops Heaven [LH]</h1>
                </a>
                <ul class="style_menu">
                    <li><a href="/">Главная</a></li>
                    <li><a href="catalog.php">Каталог</a></li>
                    <li><a href="contacts.html">Контакты</a></li>
                    <li><a href="feedback.php">Отзывы</a></li>
                </ul>
            </header>
            <ul class="authpanel">
                <?echo BuildAuthMenu();?>
            </ul>
            <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li>Каталог</li>
            </ul>
            <main class="content">
                <p>Выберите интересующий вас товар:</p>
                <div class="catalog_list">
                    <? $items = ShowAllItems($sqlcon, 0);
                    if ($items) {
                        foreach ($items as $item) {?>
                    <div class="catalog_item">
                        <a href="showitem.php?id=<?=$item['id_item'];?>">
                            <img class="catalog_img" src="<?=$item['img_min'];?>" alt="<?=$item['item_name'];?>">
                        </a>
                        <div><?=$item['item_name'];?></div>
                        <div>Цена: <?=$item['item_price'];?> ₽</div>
                    </div>
                    <? }
                    } else {
                        echo "<p>Нет товаров, либо все товары в Архиве</p>";
                    }
                    ?>
                </div>
            </main>
            <footer>
                <div class="footer_phone"><a href="tel:88005556677">8 (800) 555 6677</a></div>
                <div class="footer_menu">
                    <ul class="footer_menu">
                        <li><a href="//lp.test">ГЛАВНАЯ</a></li>
                        <li><a href="catalog.php">КАТАЛОГ</a></li>
                        <li><a href="contacts.html">КОНТАКТЫ</a></li>
                    </ul>
                </div>
                <div class="footer_text">&copy; Все права защищены, 2018</div>
            </footer>         
        </div>
    </body>
</html>