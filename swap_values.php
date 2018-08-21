<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title>Урок 1. Задача 5</title>
	</head>
	<body>
		<?php
			$a = 100;
			$b = 200;
			echo "a = " . $a . "<br>";
			echo "b = " . $b . "<br>";
			echo "<br> swapping... <br>";
			$a = $a + $b;
			$b = $a - $b;
			$a = $a - $b;
			echo "a = " . $a . "<br>";
			echo "b = " . $b . "<br>";
			echo "swapping is done!";			
		?>
	</body>
</html>