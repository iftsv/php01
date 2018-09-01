<?
$file_name = $_FILES["photo"]["name"];
$file_tmp_name = $_FILES["photo"]["tmp_name"];
$file_original_path ="img_original/" . $_FILES["photo"]["name"];

if (move_uploaded_file($file_tmp_name, $file_original_path)) {
	echo "Файл " . $file_name . " успешно загружен";
	# создаем уменьшенную копию для preview
	createThumbnail($file_name, $file_original_path);
	# после загрузки редиректим на страницу галлереи
	header("Location: index.php?state=ok");
} else {
	# если ошибка, передаем флаг error
	echo "Ошибка загрузки!";
	header("Location: index.php?state=error");
}

/*
функция уменьшает в 5 раз ширину/высоту фотографии
*/
function createThumbnail($file_name, $file_path){
	$source = imagecreatefromjpeg($file_path);
	list($width, $height) = getimagesize($file_path);
	$newwidth = $width/5;
	$newheight = $height/5;
	$destination = imagecreatetruecolor($newwidth, $newheight);
	imagecopyresampled($destination, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	imagejpeg($destination, "img_thumbs/" . $file_name, 100);
}