<head>
	<meta charset="UTF-8">
</head>
<body>
	<?
	echo "<b>Домашнее задание Урок 3 Задача 5</b><br>";
	echo "Написать функцию, которая заменяет в строке пробелы на подчеркивания и возвращает видоизмененную строчку.<br>";
	echo "<br><b>Решение:</b><br>";
	
	$testString = "The quick brown fox jumps over the lazy dog .";

	function replaceSpaces($str) {
		$arrStr = str_split($str);
		for($i = 0; $i < count($arrStr); $i++) {
			if ($arrStr[$i] == " ") {
				$arrStr[$i] = "_";
			}
		}
		return implode($arrStr);
	}

	echo "<br>Исходная строка: " . $testString . "<br>";
	echo "Измененая строка: " . replaceSpaces($testString) . "<br>";
	?>


</body>