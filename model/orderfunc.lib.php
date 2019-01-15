<?
/*
получаем ID для формирования нового заказа
*/
function GetNewOrderID($sqlcon) {
	$sql = "SELECT IFNULL(MAX(id_order),0)+1 AS new_id_order FROM `orders`";
	$result = mysqli_query($sqlcon, $sql);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		return $row["new_id_order"];
	} else {
		return 0;
	}
}

/*
создаем заказ с использованием транзакций.
если все ОК - возвращаем номер заказа, иначе откатываем все изменения в БД
*/
function CreateNewOrder($sqlcon, $id_user, $id_order) {
    $isOK = false;
    $isEmptyBasket = false;
    # для оформления заказа необходим минимум один товар в корзине
    $sql_str = "SELECT * FROM basket b WHERE b.`id_user` = %d AND b.`id_order` IS NULL";
    $sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user));
    ShowMessage($sql);
    $result = mysqli_query($sqlcon, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        # стартуем транзакцию
        mysqli_begin_transaction($sqlcon, MYSQLI_TRANS_START_READ_WRITE);
        $sql_str = "UPDATE basket SET id_order = %d WHERE id_order IS NULL AND id_user = %d";
        $sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_order), mysqli_real_escape_string($sqlcon, $id_user));
        $result = mysqli_query($sqlcon, $sql);

        if ($result) {
            $sql_str = "INSERT INTO orders (id_order, id_order_status, id_user) VALUES (%d, 1, %d)";
            $sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_order), mysqli_real_escape_string($sqlcon, $id_user));
            $result = mysqli_query($sqlcon, $sql);
            if ($result) {
                # сохраняем все в таблицы
                mysqli_commit($sqlcon);
                $isOK = true;
            }
        }
    } else {
        $isEmptyBasket = true;
    }

    if ($isOK) {
        return $id_order;
    } else {
        if ($isEmptyBasket) {
            ShowMessage("Ошибка оформления заказа! Перед оформлением заказа, пожалуйста убедитесь что в Корзине присутствует товар.");
            mysqli_rollback($sqlcon);
            return 0;
        } else {
            ShowMessage("Ошибка оформления заказа! Пожалуйста, обратитесь в поддержку!");
            mysqli_rollback($sqlcon);
            return 0;
        }
    }
}

# получаем информацию по заказу для вывода на форму
function GetOrderFormByIdUser($sqlcon, $id_user) {
    # получаем список статусов заказов по юзеру
    $sql_str = "SELECT os.`order_status`, os.`id_status` FROM `orders` o JOIN order_status os ON os.`id_status` = o.`id_order_status` WHERE o.`id_user` = %d GROUP BY os.`order_status`, os.`id_status` ORDER BY os.`id_status` ASC";
    $sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user));
    # сохраняем список всех статусов заказов по юзеру
    $result_order_status = mysqli_query($sqlcon, $sql);

    # получаем список заказов для юзера
    $sql_str = "SELECT o.`id_order`, os.`id_status`, o.`create_date`, o.`modify_date`, SUM(item_count) AS total_item_count, SUM(b.`price`) AS total_price FROM `orders` o JOIN basket b ON b.`id_order` = o.`id_order` JOIN order_status os ON os.`id_status` = o.`id_order_status` WHERE o.`id_user` = %d GROUP BY o.`id_order`, os.`id_status`, o.`create_date`, o.`modify_date` ORDER BY os.`id_status`, o.`id_order` ASC";
    $sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user));
    # сохраняем список заказов по юзеру
    $result_order = mysqli_query($sqlcon, $sql);

    # получаем список деталей по каждому заказу
    $sql_str = "SELECT o.`id_order`, o.`id_user`, o.`create_date`, o.`modify_date`, i.`id_item`, i.`item_name`, i.`item_price`, b.`id_basket`, b.`item_count`, b.`price`, os.`order_status`, os.`id_status` FROM `orders` o JOIN basket b ON b.`id_order` = o.`id_order` JOIN item i ON i.`id_item` = b.`id_item` JOIN order_status os ON os.`id_status` = o.`id_order_status` WHERE o.`id_user` = %d ORDER BY os.`id_status`, o.`id_order` ASC";
    $sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user));
    $result_order_detail = mysqli_query($sqlcon, $sql);
    $order_form = "";

    if (mysqli_num_rows($result_order_status) == 0) {
        $order_form = "Нет заказов";
    } else {
        # группировка по статусу заказа
        while($row_order_status = mysqli_fetch_assoc($result_order_status)) {
            $order_form .= "<h2> Статус заказа: ". $row_order_status["order_status"] . "</h2>";
            # группировка по номеру заказа - вывод общей инфы по заказу
            mysqli_data_seek($result_order, 0);
            while($row_order = mysqli_fetch_assoc($result_order)) {
                if($row_order["id_status"] == $row_order_status["id_status"]) {
                    $order_form .= "<button class='collapsible'>Заказ # " . $row_order["id_order"] . "<br> Дата оформления: " . $row_order["create_date"] . "<br> Кол-во товара: " . $row_order["total_item_count"] . "<br> Итого: " . $row_order["total_price"] . "</button>";
                    # выводим детализацию по каждому заказу
                    $order_form .= "<div class='content_order'>";
                    $order_form .= "<table class='order_info'><tr>";
                    $order_form .= "<th>Наименование товара</th><th>Стоимость 1 шт.</th><th>Кол-во товара</th><th>Сумма</th>";
                    $order_form .= "</tr>";
                    $total_order_sum = 0;
                    mysqli_data_seek($result_order_detail, 0);
                    while ($row_order_detail = mysqli_fetch_assoc($result_order_detail)) {
                        if ($row_order_detail["id_order"] === $row_order["id_order"]){
                            $order_form .= "<tr>";
                            $order_form .= "<td>" . $row_order_detail["item_name"] . "</td>";
                            $order_form .= "<td>" . $row_order_detail["item_price"] . "</td>";
                            $order_form .= "<td>" . $row_order_detail["item_count"] . "</td>";
                            $order_form .= "<td>" . $row_order_detail["price"] . "</td>";
                            $order_form .= "</tr>";
                            $total_order_sum = $total_order_sum + $row_order_detail["price"];
                        }
                    }
                    $order_form .= "</table>";
                    $order_form .= "<h3> Итого: " . $total_order_sum . " руб.</h3>";
                    $order_form .= "</div>";
                }
            }
        }
    }
    return $order_form;
}


# получаем информацию по заказу для вывода на форму для администратора системы
function AdminGetOrderForm($sqlcon) {
    # получаем список статусов уже существующих заказов
    $sql_str = "SELECT os.`order_status`, os.`id_status` FROM `orders` o JOIN order_status os ON os.`id_status` = o.`id_order_status` GROUP BY os.`order_status`, os.`id_status` ORDER BY os.`id_status` ASC";
    # сохраняем список всех статусов заказов по юзеру
    $result_order_status = mysqli_query($sqlcon, $sql_str);

    # получаем список заказов
    $sql_str = "SELECT u.`user_email`, ur.`user_role_name`, o.`id_order`, os.`id_status`, o.`create_date`, o.`modify_date`, SUM(item_count) AS total_item_count, SUM(b.`price`) AS total_price FROM `orders` o JOIN basket b ON b.`id_order` = o.`id_order` JOIN order_status os ON os.`id_status` = o.`id_order_status` JOIN user u ON u.`id_user` = o.`id_user` JOIN user_role ur ON ur.`id_user_role` = u.`id_role` GROUP BY o.`id_order`, os.`id_status`, o.`create_date`, o.`modify_date` ORDER BY os.`id_status`, o.`id_order` ASC";
    # сохраняем список заказов по юзеру
    $result_order = mysqli_query($sqlcon, $sql_str);

    # получаем список всех возможных статусов
    $sql_str = "SELECT id_status, order_status FROM order_status ORDER BY id_status ASC";
    # сохраняем список всех статусов заказов по юзеру
    $result_all_order_status = mysqli_query($sqlcon, $sql_str);


/*
    # получаем список деталей по каждому заказу
    $sql_str = "SELECT o.`id_order`, o.`id_user`, o.`create_date`, o.`modify_date`, i.`id_item`, i.`item_name`, i.`item_price`, b.`id_basket`, b.`item_count`, b.`price`, os.`order_status`, os.`id_status` FROM `orders` o JOIN basket b ON b.`id_order` = o.`id_order` JOIN item i ON i.`id_item` = b.`id_item` JOIN order_status os ON os.`id_status` = o.`id_order_status` WHERE o.`id_user` = %d ORDER BY os.`id_status`, o.`id_order` ASC";
    $sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user));
    $result_order_detail = mysqli_query($sqlcon, $sql);
*/
    $order_form = "";

    if (mysqli_num_rows($result_order_status) == 0) {
        $order_form = "Нет заказов";
    } else {
        # группировка по статусу заказа
        while($row_order_status = mysqli_fetch_assoc($result_order_status)) {
            $order_form .= "<h2 class='admin_order_status'> Статус заказа: ". $row_order_status["order_status"] . "</h2>";
            # группировка по номеру заказа - вывод общей инфы по заказу
            mysqli_data_seek($result_order, 0);
            while($row_order = mysqli_fetch_assoc($result_order)) {
                if($row_order["id_status"] == $row_order_status["id_status"]) {
                    # listbox для управления статусом заказа
                    $order_status_list = "<select id='order_" . $row_order["id_order"] . "' class='order_status'>";
                    mysqli_data_seek($result_all_order_status, 0);
                    while($row = mysqli_fetch_assoc($result_all_order_status)) {
                        $order_status_list .= "<option value='" . $row["id_status"] ."'" . ($row["id_status"] == $row_order["id_status"] ? "selected='selected'" : "") . ">" . $row["order_status"] . "</option>";
                    }
                    $order_status_list .= "</select></div>";

                    $order_form .= "<div class='admin_order_list'>Заказ # " . $row_order["id_order"] . "<br> Дата оформления: " . $row_order["create_date"] . "<br>Пользователь: " . $row_order["user_email"] . "<br>Кол-во товара: " . $row_order["total_item_count"] . "<br> Итого: " . $row_order["total_price"] ."<br>". $order_status_list . "<button onclick='update_status_order(".$row_order["id_order"].", document.getElementById(\"order_" . $row_order["id_order"] ."\").selectedIndex+1)'>Применить</button>";
/*
                    # выводим детализацию по каждому заказу
                    $order_form .= "<div class='content_order'>";
                    $order_form .= "<table class='order_info'><tr>";
                    $order_form .= "<th>Наименование товара</th><th>Стоимость 1 шт.</th><th>Кол-во товара</th><th>Сумма</th>";
                    $order_form .= "</tr>";
                    $total_order_sum = 0;
                    mysqli_data_seek($result_order_detail, 0);
                    while ($row_order_detail = mysqli_fetch_assoc($result_order_detail)) {
                        if ($row_order_detail["id_order"] === $row_order["id_order"]){
                            $order_form .= "<tr>";
                            $order_form .= "<td>" . $row_order_detail["item_name"] . "</td>";
                            $order_form .= "<td>" . $row_order_detail["item_price"] . "</td>";
                            $order_form .= "<td>" . $row_order_detail["item_count"] . "</td>";
                            $order_form .= "<td>" . $row_order_detail["price"] . "</td>";
                            $order_form .= "</tr>";
                            $total_order_sum = $total_order_sum + $row_order_detail["price"];
                        }
                    }
                    $order_form .= "</table>";
                    $order_form .= "<h3> Итого: " . $total_order_sum . " руб.</h3>";
                    $order_form .= "</div>";
*/
                }
            }
        }
    }
    return $order_form;
}

# метод для заполнения формы с заказами
function FillOutOrderForm($sqlcon) {
    if (isset($_SESSION["id_user"])) {
        $id_user = (int) $_SESSION["id_user"];
        if (UserIsAdmin()) {
            # вызываем метод который выводи информацию по всем пользователям
            echo AdminGetOrderForm($sqlcon);
        } else {
            # вызываем метод, который отдает информацию только для текущего пользователя
            echo GetOrderFormByIdUser($sqlcon, $id_user);
            echo "<script type='text/javascript' src='../public/js/collapse.js'></script>";
        }
    }
}

# обновляем статус для заказа. может делать только администратор
# 0 - статус не обновлен, 1 - статус заказа успешно обновлен
function UpdateOrderStatus($sqlcon, $id_order, $id_order_status) {
    $result = false;
    if (UserIsAdmin()) {
        $sql_str = "UPDATE orders SET id_order_status = %d WHERE id_order = %d";
        $sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_order_status), mysqli_real_escape_string($sqlcon, $id_order));
        $result = mysqli_query($sqlcon, $sql);
    }
    return $result;
}