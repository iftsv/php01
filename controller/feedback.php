<?
require_once('../config/config.php');

$html_template = file_get_contents('../template/feedback.tpl');
$header = file_get_contents('../template/header.php');
$footer = file_get_contents('../template/footer.php');
$feedback_msg = GetFeedbackMsg($sqlcon);
$auth_menu = BuildAuthMenu($sqlcon);

$patterns = array('/{header}/', '/{feedback_msg}/', '/{auth_menu}/', '/{footer}/');
$replace = array($header, $feedback_msg, $auth_menu, $footer);
# выводим заполненный шаблон на страницу
echo preg_replace($patterns, $replace, $html_template);

# обрабатываем получения отзыва
if (isset($_POST['author_name']) && isset($_POST['author_email']) && isset($_POST['author_message'])) {
    # вызываем функцию сохранения отзыва
    SaveFeedbackMsg($sqlcon);
}