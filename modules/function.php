<?
include_once("config.php");

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
	imagejpeg($destination, DIR_PREVIEW . $file_name, 100);
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
для конвертации русских имен файлов в UTF-8 и хранение
https://stackoverflow.com/questions/22683132/php-cp1252-windows-1252-conversion-to-utf-8
*/
function convert_cp1252_to_utf8($input, $default = '', $replace = array()) {
    if ($input === null || $input == '') {
        return $default;
    }
    $encoding = mb_detect_encoding($input, array('Windows-1252', 'ISO-8859-1'), true);
    if ($encoding == 'ISO-8859-1' || $encoding == 'Windows-1252') {
        /*
         * Use the search/replace arrays if a character needs to be replaced with
         * something other than its Unicode equivalent.
         */ 
        /*
        $replace = array(
            128 => "&#x20AC;",      // http://www.fileformat.info/info/unicode/char/20AC/index.htm EURO SIGN
            129 => "",              // UNDEFINED
            130 => "&#x201A;",      // http://www.fileformat.info/info/unicode/char/201A/index.htm SINGLE LOW-9 QUOTATION MARK
            131 => "&#x0192;",      // http://www.fileformat.info/info/unicode/char/0192/index.htm LATIN SMALL LETTER F WITH HOOK
            132 => "&#x201E;",      // http://www.fileformat.info/info/unicode/char/201e/index.htm DOUBLE LOW-9 QUOTATION MARK
            133 => "&#x2026;",      // http://www.fileformat.info/info/unicode/char/2026/index.htm HORIZONTAL ELLIPSIS
            134 => "&#x2020;",      // http://www.fileformat.info/info/unicode/char/2020/index.htm DAGGER
            135 => "&#x2021;",      // http://www.fileformat.info/info/unicode/char/2021/index.htm DOUBLE DAGGER
            136 => "&#x02C6;",      // http://www.fileformat.info/info/unicode/char/02c6/index.htm MODIFIER LETTER CIRCUMFLEX ACCENT
            137 => "&#x2030;",      // http://www.fileformat.info/info/unicode/char/2030/index.htm PER MILLE SIGN
            138 => "&#x0160;",      // http://www.fileformat.info/info/unicode/char/0160/index.htm LATIN CAPITAL LETTER S WITH CARON
            139 => "&#x2039;",      // http://www.fileformat.info/info/unicode/char/2039/index.htm SINGLE LEFT-POINTING ANGLE QUOTATION MARK
            140 => "&#x0152;",      // http://www.fileformat.info/info/unicode/char/0152/index.htm LATIN CAPITAL LIGATURE OE
            141 => "",              // UNDEFINED
            142 => "&#x017D;",      // http://www.fileformat.info/info/unicode/char/017d/index.htm LATIN CAPITAL LETTER Z WITH CARON 
            143 => "",              // UNDEFINED
            144 => "",              // UNDEFINED
            145 => "&#x2018;",      // http://www.fileformat.info/info/unicode/char/2018/index.htm LEFT SINGLE QUOTATION MARK 
            146 => "&#x2019;",      // http://www.fileformat.info/info/unicode/char/2019/index.htm RIGHT SINGLE QUOTATION MARK
            147 => "&#x201C;",      // http://www.fileformat.info/info/unicode/char/201c/index.htm LEFT DOUBLE QUOTATION MARK
            148 => "&#x201D;",      // http://www.fileformat.info/info/unicode/char/201d/index.htm RIGHT DOUBLE QUOTATION MARK
            149 => "&#x2022;",      // http://www.fileformat.info/info/unicode/char/2022/index.htm BULLET
            150 => "&#x2013;",      // http://www.fileformat.info/info/unicode/char/2013/index.htm EN DASH
            151 => "&#x2014;",      // http://www.fileformat.info/info/unicode/char/2014/index.htm EM DASH
            152 => "&#x02DC;",      // http://www.fileformat.info/info/unicode/char/02DC/index.htm SMALL TILDE
            153 => "&#x2122;",      // http://www.fileformat.info/info/unicode/char/2122/index.htm TRADE MARK SIGN
            154 => "&#x0161;",      // http://www.fileformat.info/info/unicode/char/0161/index.htm LATIN SMALL LETTER S WITH CARON
            155 => "&#x203A;",      // http://www.fileformat.info/info/unicode/char/203A/index.htm SINGLE RIGHT-POINTING ANGLE QUOTATION MARK
            156 => "&#x0153;",      // http://www.fileformat.info/info/unicode/char/0153/index.htm LATIN SMALL LIGATURE OE
            157 => "",              // UNDEFINED
            158 => "&#x017e;",      // http://www.fileformat.info/info/unicode/char/017E/index.htm LATIN SMALL LETTER Z WITH CARON
            159 => "&#x0178;",      // http://www.fileformat.info/info/unicode/char/0178/index.htm LATIN CAPITAL LETTER Y WITH DIAERESIS
        );*/

        if (count($replace) != 0) {
            $find = array();
            foreach (array_keys($replace) as $key) {
                $find[] = chr($key);
            }
            $input = str_replace($find, array_values($replace), $input);
        }
        /*
         * Because ISO-8859-1 and CP1252 are identical except for 0x80 through 0x9F
         * and control characters, always convert from Windows-1252 to UTF-8.
         */
        $input = iconv('Windows-1252', 'UTF-8//IGNORE', $input);
        if (count($replace) != 0) {
            $input = html_entity_decode($input);
        }
    }
    return $input;
}

/*
добавление информации о загружаемой картинке
*/
function addNewFileToDatabase($name_original, 
							  $name_translit, 
							  $path_original, 
							  $path_preview, 
							  $file_size){
	$link = mysqli_connect(SERVER, LOGIN, PASS, DB);
	if ($link) {
		$sql = "INSERT INTO gallery_file (name_original, name_translit, path_original, path_preview, size)
		VALUES('$name_original','$name_translit', '$path_original', '$path_preview', '$file_size')";
		$res = mysqli_query($link, $sql);

		if ($res) {
				echo "<script language=\"javascript\">";
				echo "alert(\"Запись добавлена!\")";
				echo "</script>";
		} else {
				$err = mysqli_error($link);
				echo "<script language=\"javascript\">";
				echo "alert(\"Ошибка! $err\")";
				echo "</script>";
		}
		$file_id = mysqli_insert_id($link);
		$sql = "INSERT INTO gallery_stats (id_file, view_counter) VALUES($file_id, 0)";
		mysqli_query($link, $sql);
		mysqli_close($link);
		return true;
	} else {
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    	echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    	echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
		return false;
	}
};

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


/* функция создаем галлерею из БД */
function createGalleryFromDatabase () {

	$link = mysqli_connect(SERVER, LOGIN, PASS, DB);

	if ($link) {
		$sql = "SELECT gf.`id_file`, gf.`path_original`, gf.`path_preview`, gs.`view_counter` FROM gallery_file gf
		JOIN gallery_stats gs ON gs.`id_file` = gf.`id_file` ORDER BY gs.`view_counter` DESC";
		$res = mysqli_query($link, $sql);

		if ($res) {
			echo "<main class=\"content\"><div class=\"catalog_list\">";
			if(mysqli_num_rows($res) == 0){	
				echo "Каталог с фотографиями пуст. Но Вы можете добавить!";
			} else {
				while($data = mysqli_fetch_assoc($res)) {
					$html = "<div class=\"catalog_item\">";
					$html .= "<a href=\"showphoto.php?id=". $data["id_file"] . "\">";
					$html .= "<img class=\"catalog_img\" src=\"" . $data["path_preview"] . "\">";
					$html .= "<div>Кол-во просмотров:" . $data["view_counter"] . "</div>";
					$html .= "</a></div>";
					echo $html;
				}
			}
			echo "</div></main>";
		} else {
			$err = mysqli_error($link);
			echo "<script language=\"javascript\">";
			echo "alert(\"Ошибка! $err\")";
			echo "</script>";
		}
	} else {
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    	echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    	echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
	}
	mysqli_close($link);
}

/*
обновление счетчика просмотров картинки
*/
function countViews($id_file){
	$link = mysqli_connect(SERVER, LOGIN, PASS, DB);
	$sql = "UPDATE gallery_stats gs SET gs.`view_counter` = gs.`view_counter`+1 WHERE gs.`id_file` = $id_file";
	mysqli_query($link, $sql);
	mysqli_close($link);
}

/* показываем картинку по id */
function showPhoto($id_file) {
	$link = mysqli_connect(SERVER, LOGIN, PASS, DB);
	$sql = "SELECT gf.`id_file`, gf.`path_original`, gs.`view_counter` FROM gallery_file gf
	JOIN gallery_stats gs ON gs.`id_file` = gf.`id_file` WHERE gf.`id_file` = $id_file";
	$res = mysqli_query($link, $sql);
	if(mysqli_num_rows($res) == 0){
		echo "Такой фотографии не существует <br>";
	} else {
		while ($row = mysqli_fetch_assoc($res)) {
        	echo "<img class=\"catalog_img\" src=\"" . $row["path_original"] . "\">";
        	echo "<div>Кол-во просмотров:" . $row["view_counter"] . "</div>";
    	}
    	/*считаем показ фотографии*/
    	countViews($id_file);
	}
	mysqli_close($link);
}