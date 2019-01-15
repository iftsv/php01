<?
require_once('../config/config.php');

# обрабатываем команду на создание нового заказа
# пользователь группы администраторов не может создать заказ
if (isset($_SESSION["id_user"]) && !UserIsAdmin() && isset($_GET["action"]) && $_GET["action"] === "create_order") {
	# создаем заказ
	$new_order_id = GetNewOrderID($sqlcon);
	$id_user = $_SESSION["id_user"];

	if ($new_order_id) {
		if (CreateNewOrder($sqlcon, $id_user, $new_order_id)) {
			echo "Заказ # " . $new_order_id . " успешно сформирован";
			exit("<br><a href='//" . DOMAIN . "/order/'>Перейти в Список заказов</a>");
		} else {
			exit("<h3>Ошибка формирования заказа</h3>");
		}
	} else {
		exit("<h3>Ошибка формирования заказа</h3>");
	}
}

# обрабатываем команду на изменение статуса заказа
# изменять статус заказа может только пользователь с ролью администратор
if (isset($_SESSION["id_user"]) && UserIsAdmin() && isset($_GET["action"]) && $_GET["action"] === "update_order" && isset($_GET["id_order_status"]) && isset($_GET["id_order"])) {
	$id_order_status = $_GET["id_order_status"];
	$id_order = $_GET["id_order"];
	UpdateOrderStatus($sqlcon, $id_order, $id_order_status);
}