<?
include_once("modules/function.php");
include_once("modules/config.php");

$file_name = $_FILES["photo"]["name"];
#$file_name_unicode = convert_cp1252_to_utf8($file_name);
$file_name_translit = getTranslitedString($file_name);
$file_tmp_name = $_FILES["photo"]["tmp_name"];
$file_size = $_FILES["photo"]["size"];
$file_original_path = DIR_ORIGINAL . $file_name_translit;
$file_preview_path = DIR_PREVIEW . $file_name_translit;

if (move_uploaded_file($file_tmp_name, $file_original_path)) {
	# создаем уменьшенную копию для preview
	createThumbnail($file_name_translit, $file_original_path);
	# записываем данные в БД о добавленном файле
	if (addNewFileToDatabase($file_name, 
							 $file_name_translit, 
							 $file_original_path, 
							 $file_preview_path, 
							 $file_size)) {
		# после успешного создания записи редиректим со статусом ok
		header("Location: index.php?state=ok");
	} else {
		# если не удалось записать в БД редиректим с error
		header("Location: index.php?state=error");
	};
} else {
	# если ошибка, передаем флаг error
	echo "Ошибка загрузки!";
	header("Location: index.php?state=error");
}

