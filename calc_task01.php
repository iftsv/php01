<html>
<head>
	<meta charset="UTF-8">
	<title>My Calculator ver 0.1</title>
</head>
<body>

	<form action="" method="POST">
		<p>Введите значения и выберите операцию</p>
		<input name="val1" type="text" size="10" value="<?=empty($_POST['val1']) ? 0 :$_POST['val1'];?>">
		<select name="op" id="op">
			<option>+</option>
			<option>--</option>
			<option>*</option>
			<option>/</option>
		</select>
		<input name="val2" type="text" size="10" value="<?=empty($_POST['val2']) ? 0 :$_POST['val2'];?>">
		<input type="submit" value="Вычислить">
	</form>

	<script type="text/javascript">
  		document.getElementById('op').value = "<?=empty($_POST['op']) ? '+' :$_POST['op'];?>";
	</script>

<?
	function calculate($v1, $v2, $op){
		switch ($op) {
			case '+':
				$result = $v1 + $v2;
				return "$v1 + $v2 = " . $result . "<br>";
				break;
			case '--':
				$result = $v1 - $v2;
				return "$v1 -- $v2 = " . $result . "<br>";
				break;
			case '*':
				$result = $v1 * $v2;
				return "$v1 * $v2 = " . $result . "<br>";
				break;
			case '/':
				if ($v2 == 0) {
					return "Ошибка! Деление на ноль<br>";
				} else {
					$result = $v1 / $v2;
					return "$v1 / $v2 = " . $result . "<br>";
				}
				break;
			default:
				return "Операция не поддерживается<br>";
				break;
		}
	}

	if (isset($_POST['val1']) && isset($_POST['val2']) && isset($_POST['op'])){
		$v1 = (int) $_POST['val1'];
		$v2 = (int) $_POST['val2'];
		$op = (string) $_POST['op'];
		echo calculate($v1, $v2, $op);
	} else {
		echo "Необходимо заполнить все поля!<br>";
	}
?>

</body>
</html>