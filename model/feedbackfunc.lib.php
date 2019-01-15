<?
/*
отвечает за работу с отзывами DOMAIN/public/feedback.php
DOMAIN/controller/feedback.php
*/

# функция возвращает список отзывов
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

# функция сохраняет список отзывов
function SaveFeedbackMsg($sqlcon) {
    $author_name = mysqli_real_escape_string($sqlcon, (string)htmlspecialchars(strip_tags($_POST['author_name'])));
    $author_email = mysqli_real_escape_string($sqlcon, (string)htmlspecialchars(strip_tags($_POST['author_email'])));
    $author_message = mysqli_real_escape_string($sqlcon, (string)htmlspecialchars(strip_tags($_POST['author_message'])));
    $feedback_datetime = date("Y-m-d H:i:s");

    $sql = "INSERT INTO feedback (author_name, author_email, author_message, feedback_datetime) 
            VALUES ('$author_name', '$author_email', '$author_message', '$feedback_datetime')";
    $sql_result = mysqli_query($sqlcon, $sql);
    if (!$sql_result) {
        ShowMessage("Ошибка работы с БД " . mysqli_error($sqlcon) . " Пожалуйста обратитесь в поддержку");
        return false;
    }
    # если комментарий сохранился, то редиректим обратно к отызывам
    echo "<script type='text/javascript'>location.href = '//" .DOMAIN . "/public/feedback.php';</script>";
    return true;
}