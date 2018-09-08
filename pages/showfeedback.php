<?
include_once("../sqlconnect.php");
$sql = "SELECT * FROM feedback";
$sql_result = mysqli_query($sqlcon, $sql);

if (mysqli_num_rows($sql_result) == 0) {
    echo "Сообщений нет<br>";
} else {
    while($row = mysqli_fetch_assoc($sql_result)) {
        echo "<table class=\"feedback_message\">";
        echo "<tr>";
        echo "<td> <b>Имя:</b> " . $row['author_name'] . " <b>Дата:</b> " . $row['feedback_datetime'] ."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>" . $row['author_message'] . "</td>";
        echo "</tr>";
        echo "</table>";
    }
}