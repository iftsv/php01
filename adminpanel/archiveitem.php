<?
require_once('../config/config.php');
if (!UserIsAdmin()) {
    echo "<h3>Access denied!</h3>";
    exit("<a href='//". DOMAIN ."'>Back to Homepage</a>");
}
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Добавление в архив</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>

<?
require_once('../config/config.php');

if (isset($_GET["id"])) {
    if (WorkWithArchive($sqlcon, $_GET["id"], 1)) {
        ShowMessage("Товар перемещен в Архив");
        echo "<a href='//lp.test/adminpanel/'>Назад к списку товаров</a>";
    } else {
        ShowMessage("Ошибка перемещения товара в Архив");
        echo "<a href='//lp.test/adminpanel/'>Назад к списку товаров</a>";
        exit();
    }
}
?>


    </body>
</html>