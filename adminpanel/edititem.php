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
        <title>Редактирование товара</title>
        <link rel="stylesheet" href="../public/css/style.css">
        <link rel="stylesheet" href="../public/css/view.css">
        <script type="text/javascript" src="../public/js/view.js"></script>
    </head>
    <body>
<?
# обрабатываем сохранение изменений информации о товаре
if (isset($_POST["item_name"])) {
    # проверяем обновляли ли фото товара
    if (!empty($_FILES["item_img"]["name"])) {
        # добавляем новое фото на сервер
        $file_name = AddNewPhotoToFS($_FILES["item_img"]["tmp_name"], $_FILES["item_img"]["name"]);
        if ($file_name) {
            # удаляем старые фото с сервера
            if (DeletePhotoFromFS($sqlcon, $_GET["id"])) {
                # обновляем инфу о фото в БД
                $img = GetItemImgPath($file_name, "full");
                $img_min = GetItemImgPath($file_name, "min");
                if (!UpdatePhotoInDB($sqlcon, $_GET["id"], $img, $img_min)) {
                    ShowMessage("Ошибка удаления/обновления фото. Попробуйте еще раз или обратитесь в поддержку");
                    echo "<a href='//lp.test/adminpanel/'>Назад</a>";
                    exit();
                }
            } else {
                ShowMessage("Ошибка удаления старого фото. Попробуйте еще раз или обратитесь в поддержку");
                echo "<a href='//lp.test/adminpanel/'>Назад</a>";
                exit();
            }
        } else {
            ShowMessage("Ошибка сохранения фото. Попробуйте еще раз или обратитесь в поддержку");
            echo "<a href='//lp.test/adminpanel/'>Назад</a>";
            exit();
        }
    }

    # обновляем другую информацию по товару
    if (UpdateItemToDB($sqlcon, intval($_GET["id"]), trim(strip_tags($_POST["item_name"])), trim(strip_tags($_POST["item_desc_short"])), trim(strip_tags($_POST["item_desc_full"],"<p>")), floatval($_POST["item_price"]), intval($_POST["item_work_time"]), floatval($_POST["item_capacity"]), trim(strip_tags($_POST["item_battery_type"])), trim(strip_tags($_POST["item_resolution"])), trim(strip_tags($_POST["item_cpu"])),intval($_POST["item_cpu_freq"]), intval($_POST["item_cpu_core_count"]), trim(strip_tags($_POST["item_gpu_type"])), trim(strip_tags($_POST["item_gpu"])), trim(strip_tags($_POST["item_os"])), trim(strip_tags($_POST["item_hdd_type"])), floatval($_POST["item_weight"]))) {
        ShowMessage("Информации о товаре обновлена");
    } else {
        ShowMessage("Ошибка обновления информации о товаре. Попробуйте еще раз или обратитесь в поддержку");
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
                <li><a href="/">Главная</a></li>
                <li><a href="/adminpanel/">Admin Panel</a></li>
                <li>Редактирование товара</li>
            </ul>
            <main class="content">
                <table style="width: 100%;" class="adminpanel-item">
                    <tr>
                        <td style="width: 20%">
                            <p><a href="additem.php" class="admin_button">Добавить новый товар</a></p>
                            <p><a href="showarchive.php" class="admin_button">Архив</a></p>
                        </td>
                        <td>
                            <form id="form_26367" class="appnitro"  method="POST" action="" enctype="multipart/form-data" accept-charset="utf-8">
                            <? if (isset($_GET["id"])) {
                                # получаем информацию о товаре который не в архиве
                                $id_item = (int) $_GET["id"];
                                $item = GetItemInfo($sqlcon, $id_item, 0);
                                if ($item) {
                                # заполняем поля в форме
                            ?>
                                <ul>
                                    <li id="li_1">
                                        <label class="description" for="element_1">Наименование товара</label>
                                        <div><input id="element_1" name="item_name" class="element text medium" type="text" maxlength="255" value="<?=$item['item_name'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_2">
                                        <label class="description" for="element_2">Короткое описание товара </label><div><textarea id="element_2" name="item_desc_short" class="element textarea small" required autocomplete="on"><?=$item['item_desc_short'];?></textarea></div> 
                                    </li>
                                    <li id="li_4">
                                        <label class="description" for="element_4">Подробное описание товара (можно использовать HTML-тег &lt;p&gt;) </label><div><textarea id="element_4" name="item_desc_full" class="element textarea small" required autocomplete="on"><?=$item['item_desc_full'];?></textarea></div> 
                                    </li>
                                    <li id="li_3">
                                        <label class="description" for="element_3">Цена</label><div><input id="element_3" name="item_price" class="element text small" type="text" maxlength="255" pattern="^\d+(\.|\,)\d{2}$" required autocomplete="on" value="<?=$item['item_price'];?>"/></div>
                                    </li>
                                    <li id="li_5">
                                        <label class="description" for="element_5">Время работы (часы)</label><div><input id="element_5" name="item_work_time" class="element text small" type="number" min="1" step="1"  value="<?=$item['item_work_time'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_6" >
                                        <label class="description" for="element_6">Емкость аккумулятора (Вт*ч) </label><div><input id="element_6" name="item_capacity" class="element text small" type="text" maxlength="255"  value="<?=$item['item_capacity'];?>" required autocomplete="on"/> </div>
                                    </li>
                                    <li id="li_7" >
                                        <label class="description" for="element_7">Тип аккумулятора </label><div><input id="element_7" name="item_battery_type" class="element text small" type="text" maxlength="255" value="<?=$item['item_battery_type'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_8" >
                                        <label class="description" for="element_8">Разрешение экрана </label><div><input id="element_8" name="item_resolution" class="element text small" type="text" maxlength="255" value="<?=$item['item_resolution'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_10" >
                                        <label class="description" for="element_10">Процессор </label><div><input id="element_10" name="item_cpu" class="element text large" type="text" maxlength="255" value="<?=$item['item_cpu'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_9" >
                                        <label class="description" for="element_9">Частота процессора (МГц) </label><div><input id="element_9" name="item_cpu_freq" class="element text small" type="number" min="1" step="1" value="<?=$item['item_cpu_freq'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_11" >
                                        <label class="description" for="element_11">Кол-во ядер процессора </label><div><input id="element_11" name="item_cpu_core_count" class="element text small" type="number" min="1" step="1" value="<?=$item['item_cpu_core_count'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_13" >
                                        <label class="description" for="element_13">Тип видеокарты </label><div><input id="element_13" name="item_gpu_type" class="element text medium" type="text" maxlength="255" value="<?=$item['item_gpu_type'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_12" >
                                        <label class="description" for="element_12">Видеокарта </label><div><input id="element_12" name="item_gpu" class="element text large" type="text" maxlength="255"  value="<?=$item['item_gpu'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_14" >
                                        <label class="description" for="element_14">Установленная ОС </label><div><input id="element_14" name="item_os" class="element text large" type="text" maxlength="255" value="<?=$item['item_os'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_15" >
                                        <label class="description" for="element_15">Тип жесткого диска </label><div><input id="element_15" name="item_hdd_type" class="element text medium" type="text" maxlength="255" value="<?=$item['item_hdd_type'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_16" >
                                        <label class="description" for="element_16">Вес (кг)</label><div><input id="element_16" name="item_weight" class="element text small" type="text" maxlength="255" value="<?=$item['item_weight'];?>" required autocomplete="on"/></div>
                                    </li>
                                    <li id="li_17" >
                                        <label class="description" for="element_17">Фотография</label><div><img src="<?=$item['img_min'];?>" style="width:250px;">
                                        </div>
                                    </li>
                                    <li id="li_18" >
                                        <label class="description" for="element_18">Выберите фото для загрузки, чтобы обновить текущее фото (только JPEG)</label><div><input id="element_18" type="file" accept="image/jpeg" name="item_img"/>
                                        </div>
                                    </li>
                                    <li class="buttons">
                                        <input type="hidden" name="form_id" value="26367" />
                                        <input id="saveForm" class="button_text" type="submit" name="submit" value="Обновить информацию в БД" />
                                    </li>
                                </ul>
                            <?
                                } else {
                                    echo "Информации о товаре не обнаружено, либо товар в архиве";
                                }
                            }?>
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