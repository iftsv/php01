<?
echo "<b>Домашнее задание Урок 3 Задача 2</b><br>";
echo "С помощью цикла do…while написать функцию для вывода чисел от 0 до 10, чтобы результат выглядел так:<br>0 – это ноль.<br>1 – нечётное число.<br>2 – чётное число.<br>";
echo "<br><b>Решение:</b><br>";

function checkParity($value){
	$verdict = "не поддерживаемое значение.";
	if ($value == 0) {
		return "это ноль";
	}
	if ($value % 2 == 0) {
		$verdict = "чётное число";
	} else {
		$verdict = "нечётное число";
	}

	return $verdict;
}

$i = 0;
do {
	echo "$i - " . checkParity($i) . ".<br>";
	$i++;
} while ($i <= 10);
