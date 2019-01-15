<?
require_once('../config/config.php');
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Каталог</title>
        <link rel="stylesheet" href="./css/style.css">
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
                <li>Каталог</li>
            </ul>
            <main class="content">
                <p>Выберите интересующий вас товар:</p>
                <div class="catalog_list">
                    <? $items = ShowAllItems($sqlcon, 0);
                    if ($items) {
                        foreach ($items as $item) {?>
                    <div class="catalog_item">
                        <a href="item.php?id=<?=$item['id_item'];?>">
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
                <? include "../template/footer.php";?>
            </footer>
        </div>
    </body>
</html>