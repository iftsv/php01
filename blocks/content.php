<?
/*функция создает галлерею*/
function createGallery ($dir_thumbs, $dir_original) {
	$img_list = scandir($dir_thumbs);
	$count_photo = count($img_list) - 2;

	echo "<main class=\"content\"><div class=\"catalog_list\">";
	if ($count_photo == 0) {
		echo "Каталог с фотографиями пуст. Но Вы можете добавить!";
	} else {
		for($i = 2; $i <= $count_photo + 1; $i++) {
			$html = "<div class=\"catalog_item\">";
			$html .= "<a href=\"$dir_original/$img_list[$i]\" target=\"_blank\">";
			$html .= "<img class=\"catalog_img\" src=\"$dir_thumbs/$img_list[$i]\" alt=\"$img_list[$i]\"";
			$html .= "</a></div>";
			echo $html;
		}
	}
echo "</div></main>";
}

/*функция проверяет что не было ошибки при загрузке фотографии*/
function checkUploadState(){
	if (isset($_GET["state"])) {
		switch ($_GET["state"]) {
			case 'ok':
				echo "<script language=\"javascript\">";
				echo "alert(\"Фото успешно загружено!\")";
				echo "</script>";
				break;
			case 'error':
				echo "<script language=\"javascript\">";
				echo "alert(\"Ошибка при загрузке фото! Попробуйте еще раз\")";
				echo "</script>";
				break;
		}
	}
}

createGallery("img_thumbs","img_original");
checkUploadState();