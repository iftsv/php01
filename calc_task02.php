<html>
<head>
	<meta charset="UTF-8">
	<title>My Calculator ver 0.2</title>
</head>
<body>
	<?
	function calculate($v1, $v2, $op){
		switch ($op) {
			case '+':
				return $v1 + $v2;
				break;
			case '--':
				return $v1 - $v2;
				break;
			case '*':
				return $v1 * $v2;
				break;
			case '/':
				if ($v2 == 0) {
					return "Ошибка! Деление на ноль";
				} else {
					return $v1 / $v2;
				}
				break;
			default:
				return "Операция не поддерживается";
				break;
		}
	}

	if (isset($_POST['val1']) && isset($_POST['val2'])){
		$v1 = (int) $_POST['val1'];
		$v2 = (int) $_POST['val2'];
		$result = calculate($v1, $v2, $_POST['op'][0]);
	}
?>

	<form action="" method="POST">
		<p>1) Введите значения</p>
		<label for="val1">Первый операнд</label>
		<input id="val1" name="val1" type="text" size="10" value="<?=empty($_POST['val1']) ? 0 :$_POST['val1'];?>"><br><br>
		<label for="val2">Второй операнд</label>
		<input id="val2" name="val2" type="text" size="10" value="<?=empty($_POST['val2']) ? 0 :$_POST['val2'];?>"><br>
		<p>2) Выберите операцию</p>
		<input type="submit" value="+" name="op[]"><br>
		<input type="submit" value="--" name="op[]"><br>
		<input type="submit" value="*" name="op[]"><br>
		<input type="submit" value="/" name ="op[]"><br>
		<label for="result">Результат</label>
		<input id="result" type="text" size="25" value="<?=empty($result) ? 0 :$result;?>">

	</form>

</body>
</html>