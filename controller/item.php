<?
require_once('../config/config.php');
/*
контроллер для отображения характеристик товара по его ID
используется шаблон ../template/item.tpl.php
*/

$html_template = file_get_contents('../template/item.tpl');
$header = file_get_contents('../template/header.php');
$footer = file_get_contents('../template/footer.php');

if (isset($_GET["id"])) {
    $id_item = (int) $_GET["id"];
    $item = GetItemInfo($sqlcon, $id_item, 0);
    if ($item) {
        # получаем информацию о товаре
        $item_name = $item["item_name"];
        $item_desc_short = $item["item_desc_short"];
        $item_desc_full = $item["item_desc_full"];
        $img = $item["img"];
        $img_min = $item["img_min"];
        $item_price = $item["item_price"];
        $item_work_time = $item["item_work_time"];
        $item_capacity = $item["item_capacity"];
        $item_battery_type = $item["item_battery_type"];
        $item_resolution = $item["item_resolution"];
        $item_cpu = $item["item_cpu"];
        $item_cpu_freq = $item["item_cpu_freq"];
        $item_cpu_core_count = $item["item_cpu_core_count"];
        $item_gpu_type = $item["item_gpu_type"];
        $item_gpu = $item["item_gpu"];
        $item_os = $item["item_os"];
        $item_hdd_type = $item["item_hdd_type"];
        $item_weight = $item["item_weight"];
        $auth_menu = BuildAuthMenu($sqlcon);
        if (IsAuthUser()) {
            if (UserIsAdmin()) {
                $button_buy = "<input type='button' class='button_buy' disabled='on' value='В корзину'/><br><a href='//" .DOMAIN . "/public/login.php'>Для добавления товара в Корзину необходимо войти под простой учетной записью. Под администратором товар в корзину добавить нельзя</a>";
            } else {
                $button_buy = "<input type='button' class='button_buy' onclick='increment_count_item_into_basket(".$id_item.")' value='В корзину'/>";
            }

        } else {
            $button_buy = "<input type='button' class='button_buy' disabled='on' value='В корзину'/><br><a href='//" .DOMAIN . "/public/login.php'>Для добавления товара в Корзину необходимо войти на сайт</a>";
        }
        # заполняем массив и делаем замены в шаблоне
        $patterns = array('/{item_name}/', '/{header}/', '/{item_desc_short}/', '/{item_price}/' ,'/{item_work_time}/', '/{item_capacity}/', '/{item_battery_type}/', '/{item_resolution}/', '/{item_cpu}/','/{item_cpu_freq}/', '/{item_cpu_core_count}/', '/{item_gpu_type}/', '/{item_gpu}/', '/{item_os}/', '/{item_hdd_type}/', '/{item_weight}/','/{item_desc_full}/', '/{img}/', '/{img_min}/', '/{auth_menu}/', '/{button_buy}/', '/{footer}/');
        $replace = array($item_name, $header, $item_desc_short, $item_price, $item_work_time, $item_capacity, $item_battery_type, $item_resolution, $item_cpu, $item_cpu_freq, $item_cpu_core_count, $item_gpu_type, $item_gpu, $item_os, $item_hdd_type, $item_weight, $item_desc_full, $img, $img_min, $auth_menu, $button_buy, $footer);
        # выводим заполненный шаблон на страницу
        echo preg_replace($patterns, $replace, $html_template);
    } else {
        echo "<h3>Товар не найден, либо находится в Архиве</h3>";
        echo "<br><a href='catalog.php'>Назад в каталог</a>";
    }
}
