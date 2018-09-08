<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "laptopsheaven_shop";

$sqlcon = mysqli_connect($server, $user, $pass, $db);
mysqli_set_charset($sqlcon, "utf8");
if (!$sqlcon) {
    echo "Ошибка: Невозможно установить соединение с MySQL<br>";
    echo "<br>Код ошибки errno: " . mysqli_connect_errno();
    echo "<br>Текст ошибки error: " . mysqli_connect_error();
    exit;
}

?>