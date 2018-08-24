<html>
<head>
	<meta charset="UTF-8">
	<title>Домашние задание Урок 2</title>
</head>
<body>
	<h1>Домашнее задание Урок 2</h1>
	<br><b>Задача 1</b>
	<br>Объявить две целочисленные переменные $a и $b и задать им произвольные начальные значения.
	<br>Затем написать скрипт, который работает по следующему принципу:
	<br>a. Если $a и $b положительные, вывести их разность.
	<br>b. Если $а и $b отрицательные, вывести их произведение.
	<br>c. Если $а и $b разных знаков, вывести их сумму
	<br>Ноль можно считать положительным числом.
	<br><br><b>Решение:</b><br>
	<?
		$a = -12;
		$b = 5;
		echo "a = $a, b = $b <br>";
		if ($a >= 0 && $b >= 0){
			$result = $a - $b;
			echo "a и b положительные, результат = $result <br>";
		}
		elseif ($a < 0 && $b < 0){
			$result = $a * $b;
			echo "a и b отрицательные, результат = $result <br>";
		}
		else
		{
			$result = $a + $b;
			echo "a и b разных знаков, результат = $result <br>";	
		}
	?>
	<br><b>Задача 2</b>
	<br>Присвоить переменной $а значение в промежутке [0..15]. С помощью оператора switch организовать вывод чисел от $a до 15.
	<br><br><b>Решение:</b><br>
	<?
		$a = 8;
		switch ($a){
			case 0:
				echo "0 ";
			case 1:
				echo "1 ";
			case 2:
				echo "2 ";
			case 3:
				echo "3 ";
			case 4:
				echo "4 ";
			case 5:
				echo "5 ";
			case 6:
				echo "6 ";
			case 7:
				echo "7 ";
			case 8:
				echo "8 ";
			case 9:
				echo "9 ";
			case 10:
				echo "10 ";
			case 11:
				echo "11 ";
			case 12:
				echo "12 ";
			case 13:
				echo "13 ";
			case 14:
				echo "14 ";
			case 15:
				echo "15 ";
				break;
			default:
				echo "Введите значение в промежутке [0..15]";
		}
	?>
	<br><br><b>Задача 3</b>
	<br>Реализовать основные 4 арифметические операции в виде функций с двумя параметрами. Обязательно использовать оператор return.
	<br><br><b>Решение:</b><br>
	<?
		$a = 4;
		$b = 3;
		echo "a = $a, b = $b <br>";
		function sum($a=0, $b=0){
			return $a + $b;
		}

		function sub($a=0, $b=0){
			return $a - $b;
		}

		function mul($a=0, $b=0){
			return $a * $b;
		}

		function div($a=0, $b=1){
			return $a / $b;
		}

		echo "$a + $b = " . sum($a, $b) . "<br>";
		echo "$a - $b = " . sub($a, $b) . "<br>";
		echo "$a * $b = " . mul($a, $b) . "<br>";
		echo "$a / $b = " . div($a, $b) . "<br>";
	?>
	<br><br><b>Задача 4</b>
	<br>Реализовать функцию с тремя параметрами: function mathOperation($arg1, $arg2, $operation), где $arg1, $arg2 – значения аргументов, $operation – строка с названием операции.
	<br>В зависимости от переданного значения операции выполнить одну из арифметических операций (использовать функции из пункта 3) и вернуть полученное значение (использовать switch).
	<br><br><b>Решение:</b><br>
	<?
		function mathOperation($arg1, $arg2, $operation){
			switch ($operation) {
				case '+':
					$result = sum($arg1, $arg2);
					break;
				case '-':
					$result = sub($arg1, $arg2);
					break;
				case '*':
					$result = mul($arg1, $arg2);
					break;
				case '/':
					$result = div($arg1, $arg2);
					break;
				default:
					$result = "операция $operation не поддерживается";
					break;
			}
			return $result;
		}

		echo "$a + $b = " . mathOperation($a, $b,"+") . "<br>";
		echo "$a - $b = " . mathOperation($a, $b,"-") . "<br>";
		echo "$a * $b = " . mathOperation($a, $b,"*") . "<br>";
		echo "$a / $b = " . mathOperation($a, $b,"/") . "<br>";
	?>
	<br><br><b>Задача 5</b>
	<br>Посмотреть на встроенные функции PHP. Используя имеющийся HTML шаблон, вывести текущий год в подвале при помощи встроенных функций PHP.
	<br><br><b>Решение:</b><br>
	<?
		$php_gen_year = date("Y");
		echo "Текущий год: $php_gen_year <br>";
		echo "Использовать встроенную функцию date с параметром Y<br>";
	?>
	<br><br><b>Задача 6</b>
	<br>С помощью рекурсии организовать функцию возведения числа в степень. Формат: function power($val, $pow), где $val – заданное число, $pow – степень.
	<br><br><b>Решение:</b><br>
	<?
		$val = 2;
		$pow = 5;
		function power($val, $pow){
			if ($pow < 0) {
				return "отрицательная степень не поддерживается";
			}
			if ($pow == 0) {
				return 1;
			}
			return $val*=power($val, $pow-1);
		}
		echo "$val в степени $pow = " . power($val, $pow) . "<br>";
	?>
	<br><br><b>Задача 7</b>
	<br>Написать функцию, которая вычисляет текущее время и возвращает его в формате с правильными склонениями, например: 22 часа 15 минут, 21 час 43 минуты.
	<br><br><b>Решение:</b><br>
	<?
		date_default_timezone_set('Europe/Moscow');
		echo "Установлен часовой пояс по-умолчанию: " . date_default_timezone_get() . "<br>";
		function getCurrentTime (){
			$current_hour = date("H");
			$current_minute = date("i");

			switch ($current_hour % 20) {
				case 1:
					$current_time = $current_hour . " час ";
					break;
				case 2:
				case 3:
				case 4:
					$current_time = $current_hour . " часа ";
					break;	
				default:
					$current_time = $current_hour . " часов ";
					break;
			}
			if ($current_minute >= 11 && $current_minute <= 14) {
				$current_time .= $current_minute . " минут ";
			} else {
				switch ($current_minute % 10) {
					case 1:
						$current_time .= $current_minute . " минута ";
						break;
					case 2:
					case 3:
					case 4:
						$current_time .= $current_minute . " минуты ";
						break;	
					default:
						$current_time .= $current_minute . " минут ";
						break;
				}
			}
			return $current_time;
		}
		
		echo "Московское время: " . getCurrentTime();
	?>
</body>
</html>