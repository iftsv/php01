<?
require_once('../config/config.php');
/*
контроллер для работы с содержимым корзины
используется шаблон ../template/basket.tpl
*/

# добавляем товар в корзину и возвращаем содержимое корзины для обновления на странице
if (isset($_SESSION["id_user"]) && isset($_GET["id_item"]) && isset($_GET["action"]) && $_GET["action"] === "inc_item") {
	$id_user = $_SESSION["id_user"];
	$id_item = (int) $_GET["id_item"];
	if (!IncrementCountItemIntoBasket($sqlcon, $id_user, $id_item)) {
		ShowMessage("Ошибка добавления товара в Корзину!");
	}
	echo GetBasketFormByIdUser($sqlcon, $id_user);
}

# удаляем товар из корзины по 1 штуке и возвращаем содержимое корзины для обновления на странице
if (isset($_SESSION["id_user"]) && isset($_GET["id_item"]) && isset($_GET["action"]) && $_GET["action"] === "dec_item") {
	$id_user = $_SESSION["id_user"];
	$id_item = (int) $_GET["id_item"];
	if (!DecrementCountItemIntoBasket($sqlcon, $id_user, $id_item)) {
		ShowMessage("Ошибка удаления товара из Корзины!");
	}
	echo GetBasketFormByIdUser($sqlcon, $id_user);
}

# удаляем товар из корзины ПОЛНОСТЬЮ и возвращаем содержимое корзины для обновления на странице
if (isset($_SESSION["id_user"]) && isset($_GET["id_item"]) && isset($_GET["action"]) && $_GET["action"] === "remove_item") {
	$id_user = $_SESSION["id_user"];
	$id_item = (int) $_GET["id_item"];
	if (RemoveItemFromBasket($sqlcon, $id_user, $id_item)) {
		ShowMessage("Товар удален из Корзины!");
	} else {
		ShowMessage("Ошибка удаления товара из Корзины!");
	}
	echo GetBasketFormByIdUser($sqlcon, $id_user);
}

# очищаем Корзину
if (isset($_SESSION["id_user"]) && isset($_GET["action"]) && $_GET["action"] === "clear_basket") {
	$id_user = $_SESSION["id_user"];
	if (ClearBasket($sqlcon, $id_user)) {
		ShowMessage("Корзина успешно очищена!");
	} else {
		ShowMessage("Ошибка очистки Корзины!");
	}
	echo GetBasketFormByIdUser($sqlcon, $id_user);
}