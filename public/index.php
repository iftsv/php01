<?
require_once('../config/config.php');
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Laptops Heaven [LH]</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <header>
                <a href="/"><img src="img/logo_mini.png" alt="">
                    <h1>Ноутбуки от Laptops Heaven [LH]</h1>
                </a>
                <ul class="style_menu">
                    <li><a href="/">Главная</a></li>
                    <li><a href="pages/catalog.php">Каталог</a></li>
                    <li><a href="pages/contacts.html">Контакты</a></li>
                    <li><a href="pages/feedback.php">Отзывы</a></li>
                </ul>
            </header>
            <ul class="authpanel">
                <?echo BuildAuthMenu();?>
            </ul>
            <main class="content">
                <div class="main_page_welcome">
                    <h2>Добро пожаловать!</h2>
                    <p>Огромный выбор ноутбуков по выгодным ценам! Акции, скидки! Новинки и хиты продаж всегда в наличии. В каталоге большой выбор товаров по доступным ценам с доставкой на дом и самовывоз из магазинов. Возможность оформления онлайн кредита на покупку ноутбука. Гарантия качества!</p>
                </div>
                <div class="main_page_sale">
                    <h2>Внимание! Распродажа! Спешите купить ноутбуки во выгодной цене! Количество товара ограничено</h2>
                    <div class="sale_content">
                        <? $items = ShowSaleItems($sqlcon);
                           if ($items) {
                           foreach ($items as $item) { ?>
                        <div class="catalog_item">
                            <a href="pages/showitem.php?id=<?=$item['id_item'];?>">
                                <img class="catalog_img" src="<?=$item['img_min'];?>" alt="<?=$item['item_name'];?>">
                            </a>
                            <div class="sale_label">РАСПРОДАЖА</div>
                            <div><?=$item['item_name'];?></div>
                            <div>Цена: <?=$item['item_price'];?> ₽</div>
                        </div>
                                <? }
                           } else {
                            echo "<p>На данный момент нет товаров, участвующих в акции</p>";
                        }
                        ?>
                    </div>
                </div>
            </main>
            
            <footer>
                <div class="footer_phone"><a href="tel:88005556677">8 (800) 555 6677</a></div>
                <div class="footer_menu">
                    <ul class="footer_menu">
                        <li><a href="/">ГЛАВНАЯ</a></li>
                        <li><a href="pages/catalog.php">КАТАЛОГ</a></li>
                        <li><a href="pages/contacts.html">КОНТАКТЫ/РЕКВИЗИТЫ</a></li>
                        <li><a href="pages/feedback.php">ОТЗЫВЫ</a></li>
                    </ul>
                </div>
                <div class="footer_text">&copy; Все права защищены, 2018</div>
            </footer>
        </div>
    </body>
</html>