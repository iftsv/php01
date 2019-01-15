<?
require_once('../config/config.php');
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Laptops Heaven [LH]</title>
        <link rel="stylesheet" href="../public/css/style.css">
    </head>
    <body>
        <div class="container">
            <header>
                <? include "../template/header.php";?>
            </header>
            <ul class="authpanel">
                <?echo BuildAuthMenu($sqlcon);?>
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
                            <a href="/public/item.php?id=<?=$item['id_item'];?>">
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
                <? include "../template/footer.php";?>
            </footer>
        </div>
    </body>
</html>