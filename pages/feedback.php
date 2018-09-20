<?
require_once('../config/config.php');

$html_template = file_get_contents('feedback.template');
$feedback_msg = GetFeedbackMsg($sqlcon);
$auth_menu = BuildAuthMenu();

$patterns = array('/{feedback_msg}/', '/{auth_menu}/');
$replace = array($feedback_msg, $auth_menu);
# выводим заполненный шаблон на страницу
echo preg_replace($patterns, $replace, $html_template);

# обрабатываем получения отзыва
if (isset($_POST['author_name']) && isset($_POST['author_email']) && isset($_POST['author_message'])) {
    $author_name = mysqli_real_escape_string($sqlcon, (string)htmlspecialchars(strip_tags($_POST['author_name'])));
    $author_email = mysqli_real_escape_string($sqlcon, (string)htmlspecialchars(strip_tags($_POST['author_email'])));
    $author_message = mysqli_real_escape_string($sqlcon, (string)htmlspecialchars(strip_tags($_POST['author_message'])));
    $feedback_datetime = date("Y-m-d H:i:s");

    $sql = "INSERT INTO feedback (author_name, author_email, author_message, feedback_datetime) 
            VALUES ('$author_name', '$author_email', '$author_message', '$feedback_datetime')";
    $sql_result = mysqli_query($sqlcon, $sql);
    if (!$sql_result) {
        exit("Ошибка работы с БД " . mysqli_error($sqlcon) . " Пожалуйста обратитесь в поддержку");
    }
    header("Location: //" . DOMAIN . "/pages/feedback.php");
}