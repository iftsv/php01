<?
/*
отвечает за работу с отзывами DOMAIN/pages/feedback.php 
*/
function GetFeedbackMsg($sqlcon) {

    $sql = "SELECT * FROM feedback";
    $sql_result = mysqli_query($sqlcon, $sql);
    $msg = "";

    if (mysqli_num_rows($sql_result) == 0) {
        $msg = "Сообщений нет<br>";
    } else {
        while($row = mysqli_fetch_assoc($sql_result)) {
            $msg .= "<table class='feedback_message'><tr>";
            $msg .= "<td><b>Имя:</b> " . $row['author_name'] . "</td></tr><tr>";
            $msg .= "<td><b>Дата:</b> " . $row['feedback_datetime'] ."</td></tr><tr>";
            $msg .= "<td>" . $row['author_message'] . "</td></tr></table><hr>";
        }
    }
    return $msg;
}