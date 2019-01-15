<?
/*
создает подключение к БД, переменная $sqlcon
*/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$sqlcon = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($sqlcon, "utf8");
if (!$sqlcon) {
    echo "Ошибка: Невозможно установить соединение с MySQL<br>";
    echo "<br>Код ошибки errno: " . mysqli_connect_errno();
    echo "<br>Текст ошибки error: " . mysqli_connect_error();
    exit;
}

?>