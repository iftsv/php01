<?
include_once("../sqlconnect.php");

if (isset($_POST['author_name']) && isset($_POST['author_email']) && isset($_POST['author_message'])) {
    $author_name = mysqli_real_escape_string($sqlcon, (string)htmlspecialchars(strip_tags($_POST['author_name'])));
    $author_email = mysqli_real_escape_string($sqlcon, (string)htmlspecialchars(strip_tags($_POST['author_email'])));
    $author_message = mysqli_real_escape_string($sqlcon, (string)htmlspecialchars(strip_tags($_POST['author_message'])));
    $feedback_datetime = date("Y-m-d H:i:s");

    $sqlfeedback = "INSERT INTO feedback (author_name, author_email, author_message, feedback_datetime) 
            VALUES ('$author_name', '$author_email', '$author_message', '$feedback_datetime')";
    $sql_result = mysqli_query($sqlcon, $sqlfeedback);
    echo mysqli_error($sqlcon);
    header("Location: feedback.php");
}
