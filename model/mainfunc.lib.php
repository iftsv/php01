<?
/*
основные функции по работе с БД и интерфейсами
*/

#показываем сообщение с помощью JS alert на странице
function ShowMessage($message){
	echo "<script>alert('$message')</script>";
}

/*
функция для добавления нового товара
- в случае ошибки возвращает 0
- в случае успеха возвращает 1
*/
function AddNewItemToDB($sqlcon, $item_name, $id_img_item, $item_desc_short, $item_desc_full, $item_price, $item_work_time, $item_capacity, $item_battery_type, $item_resolution, $item_cpu, $item_cpu_freq, $item_cpu_core_count, $item_gpu_type, $item_gpu, $item_os, $item_hdd_type, $item_weight, $item_isarchive) {

	$sql_str = "INSERT INTO item (item_name, id_img_item, item_desc_short, item_desc_full, item_price, item_work_time, item_capacity, item_battery_type, item_resolution, item_cpu, item_cpu_freq, item_cpu_core_count, item_gpu_type, item_gpu, item_os, item_hdd_type, item_weight, item_isarchive) VALUES ('%s', %d, '%s', '%s', %f, %d, %f, '%s', '%s', '%s', %d, %d, '%s', '%s', '%s', '%s', %f, %d)";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $item_name), $id_img_item, mysqli_real_escape_string($sqlcon, $item_desc_short), mysqli_real_escape_string($sqlcon, $item_desc_full), $item_price, $item_work_time, $item_capacity, mysqli_real_escape_string($sqlcon, $item_battery_type), mysqli_real_escape_string($sqlcon, $item_resolution), mysqli_real_escape_string($sqlcon, $item_cpu), $item_cpu_freq, $item_cpu_core_count, mysqli_real_escape_string($sqlcon, $item_gpu_type), mysqli_real_escape_string($sqlcon, $item_gpu), mysqli_real_escape_string($sqlcon, $item_os), mysqli_real_escape_string($sqlcon, $item_hdd_type), $item_weight, $item_isarchive);
	$sql_result = mysqli_query($sqlcon, $sql);
	if (sql_result) {
		return 1;
	} else {
		return 0;
		exit();
	}
}

/*
функция возвращает путь к фото товара с учетом транслитерации имени
параметр min - вернет для уменьшеной фотографии
параметр full - вернет путь для обычной фотографии
*/
function GetItemImgPath($file_name, $type) {
	$file_name = getTranslitedString($file_name);
	switch ($type) {
		case 'full':
			return IMG_DIR . $file_name;
			break;
		case 'min':
			return IMG_DIR . pathinfo($file_name, PATHINFO_FILENAME) . "_min." . pathinfo($file_name, PATHINFO_EXTENSION);
			break;
		default:
			ShowMessage("Ошибка! Неверный вызов функции GetItemImgPath()");
			exit();
			break;
}

}
/*
функция добавляет фото в хранилище
- в случае ошибки возвращает 0
- в случае успеха возвращает 1
*/
function AddNewPhotoToFS($tmp_file_path, $file_name) {
	# добавляем случайное число в имя файла, чтобы можно было хранить несколько файлов с одним именем
	$file_name = pathinfo($file_name, PATHINFO_FILENAME) . "_" . rand(10000, 110000) . "." . pathinfo($file_name, PATHINFO_EXTENSION);
	$file_path = GetItemImgPath($file_name, 'full');
	if (move_uploaded_file($tmp_file_path, $file_path)) {
		# создаем уменьшенную копию для preview
		if (createPreview($file_name)) {
			return $file_name;
		} else {
			return 0;
		}
	} else {
		ShowMessage("Ошибка сохранения фото на сервер $file_name и $file_path");
		return 0;
	}
}

/*
добавление фото в БД
- в случае ошибки возвращает 0
- в случае успеха возвращает ID фотографии
*/
function AddNewPhotoToDB($sqlcon, $img, $img_min) {
	$sql_str = "INSERT INTO item_img (img, img_min) VALUES ('%s', '%s')";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $img), mysqli_real_escape_string($sqlcon, $img_min));
	$sql_result = mysqli_query($sqlcon, $sql);
	if (sql_result) {
		return mysqli_insert_id($sqlcon);
	} else {
		return 0;
		exit(mysqli_error($sqlcon));
	}
}

/*
функция для обновления фотографии товара
*/
function UpdatePhotoInDB($sqlcon, $id_item, $img, $img_min) {
	$sql_str = "UPDATE item_img JOIN item ON item.`id_img_item` = item_img.`id_img_item`
	SET img='%s', img_min = '%s' WHERE id_item = %d";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $img), mysqli_real_escape_string($sqlcon, $img_min), intval($id_item));
	$sql_result = mysqli_query($sqlcon, $sql);
	if (sql_result) {
		return 1;
	} else {
		return 0;
		exit(mysqli_error($sqlcon));
	}
}

/*
функция уменьшает в 5 раз ширину/высоту фотографии
*/
function createPreview($file_name){
	$file_path = GetItemImgPath($file_name, 'full');
	$source = imagecreatefromjpeg($file_path);
	list($width, $height) = getimagesize($file_path);
	$newwidth = $width/5;
	$newheight = $height/5;
	$destination = imagecreatetruecolor($newwidth, $newheight);
	imagecopyresampled($destination, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	$img_min = GetItemImgPath($file_name, 'min');
	if (imagejpeg($destination, $img_min, 100)) {
		return 1;
	} else {
		ShowMessage("Ошибка создания превью фото товара");
		return 0;
	}
}
/*
функция для удаления фото с сервера
*/
function DeletePhotoFromFS($sqlcon, $id_item) {
	$sql_str = "SELECT * FROM item_img JOIN item ON item.`id_img_item` = item_img.`id_img_item`
				WHERE id_item = $id_item";
	$result = mysqli_query($sqlcon, $sql_str);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		if (unlink($row["img"]) && unlink($row["img_min"])) {
			return 1;
		} else {
			return 0;
		}
	} else {
		ShowMessage("Ошибка получения информации из БД: " . mysqli_error($sqlcon));
		return 0;
	}


}
/*
функция для транслитерации русских имен файлов
*/
function getTranslitedString($str) {
	$translitTable = ["а" => "a","б" => "b","в" => "v","г" => "g","д" => "d","е" => "e","ё" => "yo","ж" => "zh",
	"з" => "z","и" => "i","й" => "y","к" => "k","л" => "l","м" => "m","н" => "n","о" => "o","п" => "p",
	"р" => "r","с" => "s","т" => "t","у" => "u","ф" => "f","х" => "kh","ц" => "ts","ч" => "ch","ш" => "sh",
	"щ" => "shch","ъ" => "","ы" => "y","ь" => "","э" => "e","ю" => "yu","я" => "ya"," " => "_"];
	$str = mb_strtolower($str);
	$res = strtr($str, $translitTable);
	return $res;
}

/*
функция вовзращает массив товаров
если item_isarchive = 0 то массив содержит только активные товары
если item_isarchive = 1 то массив содержит только товары в архиве
*/
function ShowAllItems($sqlcon, $item_isarchive) {
	$sql_str = "SELECT * FROM item JOIN item_img ON item_img.`id_img_item` = item.`id_img_item` 
				WHERE item.`item_isarchive` = $item_isarchive";
	$result = mysqli_query($sqlcon, $sql_str);
	if ($result) {
		$n = mysqli_num_rows($result);
		$items = [];
		for($i = 0; $i < $n; $i++) {
			$row = mysqli_fetch_assoc($result);
			$items[] = $row;
		}
		return $items;
	} else {
		ShowMessage("Ошибка получения списка товаров: " . mysqli_error($sqlcon));
		exit();
	}
}

/*
Получаем информацию о товаре по его ID
*/
function GetItemInfo($sqlcon, $id_item, $item_isarchive) {
	$sql_str = "SELECT * FROM item JOIN item_img ON item_img.`id_img_item` = item.`id_img_item` 
				WHERE item.`id_item` = $id_item AND item.`item_isarchive` = $item_isarchive";
	$result = mysqli_query($sqlcon, $sql_str);
	if ($result) {
		$n = mysqli_num_rows($result);
		$item = [];
		for($i = 0; $i < $n; $i++) {
			$row = mysqli_fetch_assoc($result);
			$item = $row;
		}
		return $item;
	} else {
		ShowMessage("Ошибка получения информации о товаре: " . mysqli_error($sqlcon));
		exit();
	}
}

/*
функция для обновления информации о товаре
- в случае ошибки возвращает 0
- в случае успеха возвращает 1
*/
function UpdateItemToDB($sqlcon, $id_item, $item_name, $item_desc_short, $item_desc_full, $item_price, $item_work_time, $item_capacity, $item_battery_type, $item_resolution, $item_cpu, $item_cpu_freq, $item_cpu_core_count, $item_gpu_type, $item_gpu, $item_os, $item_hdd_type, $item_weight) {

	$sql_str = "UPDATE item SET item.`item_name` = '%s', item.`item_desc_short` = '%s', item.`item_desc_full` = '%s', item.`item_price` = %f, item.`item_work_time` = %d, item.`item_capacity` = %f, item.`item_battery_type` = '%s', item.`item_resolution` = '%s', item.`item_cpu` = '%s', item.`item_cpu_freq` = %d, item.`item_cpu_core_count` = %d, item.`item_gpu_type` = '%s', item.`item_gpu` = '%s', item.`item_os` = '%s', item.`item_hdd_type` = '%s', item.`item_weight` = %f WHERE item.`id_item` = %d";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $item_name), mysqli_real_escape_string($sqlcon, $item_desc_short), mysqli_real_escape_string($sqlcon, $item_desc_full), $item_price, $item_work_time, $item_capacity, mysqli_real_escape_string($sqlcon, $item_battery_type), mysqli_real_escape_string($sqlcon, $item_resolution), mysqli_real_escape_string($sqlcon, $item_cpu), $item_cpu_freq, $item_cpu_core_count, mysqli_real_escape_string($sqlcon, $item_gpu_type), mysqli_real_escape_string($sqlcon, $item_gpu), mysqli_real_escape_string($sqlcon, $item_os), mysqli_real_escape_string($sqlcon, $item_hdd_type), $item_weight, $id_item);
	$sql_result = mysqli_query($sqlcon, $sql);
	if (sql_result) {
		return 1;
	} else {
		return 0;
		exit();
	}
}

/*
функция для добавления/удаления товара в/из архив
- в случае ошибки возвращает 0
- в случае успеха возвращает 1
$item_isarchive - значение 1 для помещения в архив, 0 - для удаления из архива
*/
function UpdateArchiveStatusOfItem($sqlcon, $id_item, $item_isarchive) {
	$sql_str = "UPDATE item SET item.`item_isarchive` = %d WHERE item.`id_item` = %d";
	$sql = sprintf($sql_str, $item_isarchive, $id_item);
	$result = mysqli_query($sqlcon, $sql);
	if ($result) {
		return 1;
	} else {
		return 0;
	}
}

/*
показываем товар, который участвует в акции на главной странице
*/
function ShowSaleItems($sqlcon) {
	$sql_str = "SELECT * FROM item JOIN item_img ON item_img.`id_img_item` = item.`id_img_item` 
				WHERE item.`item_isarchive` = 0 AND item.`item_issale` = 1";
	$result = mysqli_query($sqlcon, $sql_str);
	if ($result) {
		$n = mysqli_num_rows($result);
		$items = [];
		for($i = 0; $i < $n; $i++) {
			$row = mysqli_fetch_assoc($result);
			$items[] = $row;
		}
		return $items;
	} else {
		ShowMessage("Обратитесь в службу поддержки либо зайдите на сайт немного позже" . mysqli_error($sqlcon));
		exit();
	}
}