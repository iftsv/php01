<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>{item_name} | laptops-heaven | </title>
        <link rel="stylesheet" href="../public/css/style.css">
        <script type="text/javascript" src="../public/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../public/js/async.js"></script>
    </head>
    <body>
        <div class="container">
            <header>
                {header}
            </header>
            <ul class="authpanel">
                {auth_menu}
            </ul>
            <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li><a href="catalog.php">Каталог</a></li>
                <li>{item_name}</li>
            </ul>
            <main class="content description">
                <h1>{item_name}</h1>
                <div class="goods_description">
                    <div class="goods_img">
                        <a href="{img}" target="_blank">
                            <img class="goods_img" src="{img_min}" alt="{item_name}">
                        </a>
                    </div>
                    <div class="description_short">
                        <h3 class="headline_for_goods">Описание товара</h3>
                        <p>{item_desc_short}</p>
                        <p class="item_price">Цена: {item_price} ₽</p>
                        {button_buy}
                    </div>
                </div>
                <h3 class="headline_for_goods">Характеристики товара</h3>
                <table>
                    <tr>
                        <td>Время работы</td>
                        <td>{item_work_time}ч</td>
                    </tr>
                    <tr>
                        <td>Емкость аккумулятора (Вт*ч)</td>
                        <td>{item_capacity} Вт·ч</td>
                    </tr>
                    <tr>
                        <td>Тип аккумулятора</td>
                        <td>{item_battery_type}</td>
                    </tr>
                </table>
                <ul class="style_spec">
                    <li>Разрешение экрана</li>
                    <li>
                        <ul class="style_spec_value">
                            <li>{item_resolution}</li>
                        </ul>
                    </li>
                    <li>Процессор</li>
                    <li>
                        <ul class="style_spec_value">
                            <li>{item_cpu}</li>
                        </ul>
                    </li>
                    <li>Частота процессора</li>
                    <li>
                        <ul class="style_spec_value">
                            <li>{item_cpu_freq} МГц</li>
                        </ul>
                    </li>
                    <li>Количество ядер процессора</li>
                    <li>
                        <ul class="style_spec_value">
                            <li>{item_cpu_core_count}</li>
                        </ul>
                    </li>
                    <li>Тип видеокарты</li>
                    <li>
                        <ul class="style_spec_value">
                            <li>{item_gpu_type}</li>
                        </ul>
                    </li>
                    <li>Видеокарта</li>
                    <li>
                        <ul class="style_spec_value">
                            <li>{item_gpu}</li>
                        </ul>
                    </li>
                    <li>Установленная ОС</li>
                    <li>
                        <ul class="style_spec_value">
                            <li>{item_os}</li>
                        </ul>
                    </li>
                    <li>Тип жесткого диска</li>
                    <li>
                        <ul class="style_spec_value">
                            <li>{item_hdd_type}</li>
                        </ul>
                    </li>
                    <li>Вес</li>
                    <li>
                        <ul class="style_spec_value">
                            <li>{item_weight} кг</li>
                        </ul>
                    </li>
                </ul>
                <h3 class="headline_for_goods">Подробное описание товара</h3>
                <p class="description_full">{item_desc_full}</p>
            </main>
            <footer>
                {footer}
            </footer>
        </div>
    </body>
</html>