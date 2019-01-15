<?
require_once('../config/config.php');
if (!UserIsAdmin()) {
    echo "<h3>Access denied!</h3>";
    exit("<a href='//". DOMAIN ."'>Back to Homepage</a>");
}

if (isset($_GET["id_item"]) && isset($_GET["is_archive"])) {
    $id_item = (int) $_GET["id_item"];
    $is_archive = (int) $_GET["is_archive"];
    # если 1 - то помещаем товар в архив
    if ($is_archive === 1) {
		if (UpdateArchiveStatusOfItem($sqlcon, $id_item, $is_archive)) {
        	ShowMessage("Товар перемещен в Архив");
			# редиректим на главную страницу админки
			echo "<script type='text/javascript'>location.href = '//" .DOMAIN . "/adminpanel';</script>";
    	} else {
        	ShowMessage("Ошибка перемещения товара в Архив");
        	echo "<a href='//" . DOMAIN . "/adminpanel/'>Назад к списку товаров</a>";
        	exit();
    	}
    } else {
    # вытаскиваем товар из архива
		if (UpdateArchiveStatusOfItem($sqlcon, $id_item, $is_archive)) {
        	ShowMessage("Товар извлекли из Архива");
			# редиректим на страницу с архивом
			echo "<script type='text/javascript'>location.href = '//" .DOMAIN . "/adminpanel/archive.php';</script>";
    	} else {
        	ShowMessage("Ошибка возвращения товара из Архива");
        	echo "<a href='//" . DOMAIN . "/adminpanel/archive.php'>Назад к списку товаров</a>";
        	exit();
    	}
    }
}
