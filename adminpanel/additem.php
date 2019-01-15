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
        <title>Добавление товара</title>
        <link rel="stylesheet" href="../public/css/style.css">
        <link rel="stylesheet" href="../public/css/view.css">
        <script type="text/javascript" src="../public/js/view.js"></script>
    </head>
    <body>
<?
if (isset($_POST["item_name"]) && isset($_FILES["item_img"])) {
    # сохраняем фото на сервере
    $file_name = AddNewPhotoToFS($_FILES["item_img"]["tmp_name"],$_FILES["item_img"]["name"]);
    if ($file_name) {
        $img = GetItemImgPath($file_name, "full");
        $img_min = GetItemImgPath($file_name, "min");
        # добавляем фото в БД
        $id_img_item = AddNewPhotoToDB($sqlcon, $img, $img_min);
        if ($id_img_item) {
            # определяем значение checkbox
            if(isset($_POST["item_isarchive"]) && $_POST["item_isarchive"] == 1) {
                $item_isarchive = 1;
            } else {
                $item_isarchive = 0;
            }
            # сохраняем всю информацию в БД их других полей
            if (AddNewItemToDB($sqlcon, trim(strip_tags($_POST["item_name"])), $id_img_item, trim(strip_tags($_POST["item_desc_short"])), trim(strip_tags($_POST["item_desc_full"],"<p>")), trim(strip_tags($_POST["item_price"])), trim(strip_tags($_POST["item_work_time"])), trim(strip_tags($_POST["item_capacity"])), trim(strip_tags($_POST["item_battery_type"])), trim(strip_tags($_POST["item_resolution"])), trim(strip_tags($_POST["item_cpu"])), trim(strip_tags($_POST["item_cpu_freq"])), trim(strip_tags($_POST["item_cpu_core_count"])), trim(strip_tags($_POST["item_gpu_type"])), trim(strip_tags($_POST["item_gpu"])), trim(strip_tags($_POST["item_os"])), trim(strip_tags($_POST["item_hdd_type"])), trim(strip_tags($_POST["item_weight"])), $item_isarchive)) {
                ShowMessage("Информация добавлена в БД");
            } else {
                ShowMessage("Ошибка при сохранении информации в БД. Обратитесь в поддержку");
                exit();
            }

        } else {
            ShowMessage("Ошибка сохранения фото. Попробуйте еще раз или обратитесь в поддержку");
            exit();
        }
    } else {
        ShowMessage("Ошибка загрузки фото. Попробуйте еще раз или обратитесь в поддержку");
        exit();
    }
}
?>


        <div class="container">
            <header>
                <? include "../template/header.php";?>
            </header>
            <ul class="authpanel">
                <?echo BuildAuthMenu($sqlcon);?>
            </ul>
            <ul class="breadcrumb">
                <li><a href="//<?=DOMAIN?>">Главная</a></li>
                <li><a href="//<?=DOMAIN?>/adminpanel">Admin Panel</a></li>
                <li>Добавление товара</li>
            </ul>
            <main class="content">
                <table style="width: 100%;" class="adminpanel-item">
                    <tr>
                        <td style="width: 20%">
                            <p><a href="//lp.test/adminpanel" class="admin_button">Список товаров</a></p>
                            <p><a href="showarchive.php" class="admin_button">Архив</a></p>
                        </td>
                        <td>
                            <form id="form_26367" class="appnitro"  method="POST" action="" enctype="multipart/form-data" accept-charset="utf-8">
                                <ul>
                                    <li id="li_1">
                                        <label class="description" for="element_1">Наименование товара</label>
                                        <div><input id="element_1" name="item_name" class="element text medium" type="text" maxlength="255" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_2">
                                        <label class="description" for="element_2">Короткое описание товара </label><div><textarea id="element_2" name="item_desc_short" class="element textarea small" required autocomplete="on"></textarea></div> 
                                    </li>
                                    <li id="li_4">
                                        <label class="description" for="element_4">Подробное описание товара (можно использовать HTML-тег &lt;p&gt;)</label><div><textarea id="element_4" name="item_desc_full" class="element textarea small" required autocomplete="on"></textarea></div> 
                                    </li>
                                    <li id="li_3">
                                        <label class="description" for="element_3">Цена</label><div><input id="element_3" name="item_price" class="element text small" type="text" maxlength="255" pattern="^\d+(\.|\,)\d{2}$" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_5">
                                        <label class="description" for="element_5">Время работы (часы)</label><div><input id="element_5" name="item_work_time" class="element text small" type="number" min="1" step="1" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_6" >
                                        <label class="description" for="element_6">Емкость аккумулятора (Вт*ч) </label><div><input id="element_6" name="item_capacity" class="element text small" type="text" maxlength="255" value="" required autocomplete="on"/> </div>
                                    </li>
                                    <li id="li_7" >
                                        <label class="description" for="element_7">Тип аккумулятора </label><div><input id="element_7" name="item_battery_type" class="element text small" type="text" maxlength="255" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_8" >
                                        <label class="description" for="element_8">Разрешение экрана </label><div><input id="element_8" name="item_resolution" class="element text small" type="text" maxlength="255" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_10" >
                                        <label class="description" for="element_10">Процессор </label><div><input id="element_10" name="item_cpu" class="element text large" type="text" maxlength="255" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_9" >
                                        <label class="description" for="element_9">Частота процессора (МГц) </label><div><input id="element_9" name="item_cpu_freq" class="element text small" type="number" min="1" step="1" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_11" >
                                        <label class="description" for="element_11">Кол-во ядер процессора </label><div><input id="element_11" name="item_cpu_core_count" class="element text small" type="number" min="1" step="1" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_13" >
                                        <label class="description" for="element_13">Тип видеокарты </label><div><input id="element_13" name="item_gpu_type" class="element text medium" type="text" maxlength="255" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_12" >
                                        <label class="description" for="element_12">Видеокарта </label><div><input id="element_12" name="item_gpu" class="element text large" type="text" maxlength="255" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_14" >
                                        <label class="description" for="element_14">Установленная ОС </label><div><input id="element_14" name="item_os" class="element text large" type="text" maxlength="255" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_15" >
                                        <label class="description" for="element_15">Тип жесткого диска </label><div><input id="element_15" name="item_hdd_type" class="element text medium" type="text" maxlength="255" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_16" >
                                        <label class="description" for="element_16">Вес (кг)</label><div><input id="element_16" name="item_weight" class="element text small" type="text" maxlength="255" value="" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_17" >
                                        <label class="description" for="element_17">Поместить товар в Архив</label><div><input id="element_17" type="checkbox"  name="item_isarchive" value=1/>
                                        </div>
                                    </li>
                                    <li id="li_18" >
                                        <label class="description" for="element_18">Выбрать фото для загрузки (только JPEG)</label><div><input id="element_18" type="file" accept="image/jpeg" name="item_img" required/>
                                        </div>
                                    </li>

                                    <li class="buttons">
                                        <input type="hidden" name="form_id" value="26367" />
                                        <input id="saveForm" class="button_text" type="submit" name="submit" value="Добавить товар в БД" />
                                    </li>
                                </ul>
                            </form>
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