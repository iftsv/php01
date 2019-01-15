<?
/*
проверяем, что товар уже есть в корзине
возвращает > 0, если товар уже есть в корзине
возвращает 0, если товара нет в корзине
*/
function GetItemCountInBasket($sqlcon, $id_user, $id_item) {
	$sql_str = "SELECT item_count FROM basket WHERE id_user = %d AND id_item = %d AND id_order IS NULL";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user), mysqli_real_escape_string($sqlcon, $id_item));
	$result = mysqli_query($sqlcon, $sql);
	$row = mysqli_fetch_assoc($result);
	if ($result) {
		return $row["item_count"];
	} else {
		return 0;
	}
}

/*
получаем цену товара по его ID
*/
function GetItemPriceById($sqlcon, $id_item) {
	$sql_str = "SELECT * FROM item WHERE id_item = %d";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_item));
	$result = mysqli_query($sqlcon, $sql);

	if ($result) {
		$row = mysqli_fetch_assoc($result);
		return $row["item_price"];
	} else {
		return 0;
	}
}


/*
добавляем товар в Корзину, увеличивая кол-во на 1
*/
function IncrementCountItemIntoBasket($sqlcon, $id_user, $id_item) {
	# проверяем что товар добавляется в корзину впервые
	$item_count = GetItemCountInBasket($sqlcon, $id_user, $id_item);
	$item_price = GetItemPriceById($sqlcon, $id_item);
	$result = false;
	if ($item_count) {
		# если товар был ранее добавлен, то делаем UPDATE
		$sql_str = "UPDATE basket SET item_count = item_count + 1, price = %d * %f WHERE id_user = %d AND id_item = %d AND id_order IS NULL";
		$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $item_count + 1), $item_price, mysqli_real_escape_string($sqlcon, $id_user), mysqli_real_escape_string($sqlcon, $id_item));
		$result = mysqli_query($sqlcon, $sql);
	} else {
		# если товар добавлен впервые, делаем INSERT
		$sql_str = "INSERT INTO basket (id_user, id_item, item_count, price) VALUES ('%d', '%d', 1, '%f')";
		$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user), mysqli_real_escape_string($sqlcon, $id_item), $item_price);
		$result = mysqli_query($sqlcon, $sql);
	}
	return $result;
}

/*
убираем товар из Корзину, уменьшая кол-во на 1
*/
function DecrementCountItemIntoBasket($sqlcon, $id_user, $id_item) {
	# проверяем что товар добавляется в корзину впервые
	$item_count = GetItemCountInBasket($sqlcon, $id_user, $id_item);
	$item_price = GetItemPriceById($sqlcon, $id_item);
	$result = false;
	if ($item_count > 1) {
		# если товар был ранее добавлен, то делаем UPDATE
		$sql_str = "UPDATE basket SET item_count = item_count - 1, price = %d * %f WHERE id_user = %d AND id_item = %d AND id_order IS NULL";
		$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $item_count - 1), $item_price, mysqli_real_escape_string($sqlcon, $id_user), mysqli_real_escape_string($sqlcon, $id_item));
		$result = mysqli_query($sqlcon, $sql);
	}
	return $result;
}

/*
убираем товар из корзины полностью,т.е. все количество товара
*/
function RemoveItemFromBasket($sqlcon, $id_user, $id_item) {
	$sql_str = "DELETE FROM basket WHERE id_user = %d AND id_item = %d AND id_order IS NULL";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user), mysqli_real_escape_string($sqlcon, $id_item));
	$result = mysqli_query($sqlcon, $sql);
	if ($result) {
		return 1;
	} else {
		return 0;
	}
}

/*
очищаем корзину, удаляя все товары из корзины
*/
function ClearBasket($sqlcon, $id_user){
	$sql_str = "DELETE FROM basket WHERE id_user = %d AND id_order IS NULL";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user));
	$result = mysqli_query($sqlcon, $sql);
	if ($result) {
		return 1;
	} else {
		return 0;
	}
}

/*
количество уникальных товаров в корзине
*/
function GetBasketInfo($sqlcon, $id_user) {
	$sql_str = "SELECT  IFNULL(SUM(item_count),0) AS uniq_item_count, IFNULL(SUM(price),0) AS `sum` FROM basket WHERE id_user = %d AND id_order IS NULL";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user));
	$result = mysqli_query($sqlcon, $sql);
	$row = mysqli_fetch_assoc($result);
	if ($result) {
		$basket_info = "[Корзина: кол-во товара " . $row["uniq_item_count"] . ", сумма " . $row["sum"] . " руб. ]";
		return "<a id='basket_info' href='//" . DOMAIN. "/basket/'>" . $basket_info . "&nbsp</a>";
	} else {
		$basket_info = "[Корзина: пусто ]";
		return "<a id='basket_info' href='//" . DOMAIN. "/basket/'>" . $basket_info . "&nbsp</a>";
	}
}


# получаем информацию по корзине
function GetBasketFormByIdUser($sqlcon, $id_user) {
    $sql_str = "SELECT * FROM basket JOIN item ON item.id_item = basket.id_item WHERE id_user = %d AND id_order IS NULL";
    $sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $id_user));
    $result = mysqli_query($sqlcon, $sql);
    $basket_form = "";
    $total_sum = 0;
    if (mysqli_num_rows($result) == 0) {
        $basket_form = "Ваша Корзина пуста";
    } else {
    	$basket_form .= "<table class='basket_info'><tr>";
    	$basket_form .= "<th>Наименование товара</th><th>Стоимость 1 шт.</th><th>Кол-во товара</th><th>Сумма</th><th></th>";
    	$basket_form .= "</tr>";
        while($row = mysqli_fetch_assoc($result)) {
        	$basket_form .= "<tr>";
            $basket_form .= "<td>" . $row["item_name"] . "</td>";
            $basket_form .= "<td>" . $row["item_price"] . "</td>";
            $basket_form .= "<td>" . $row["item_count"] . "</td>";
            $basket_form .= "<td>" . $row["price"] . "</td>";
            $basket_form .= "<td><a href='#' onclick='remove_item_from_basket(" . $row["id_item"] . ")'>Убрать</a></td>";
            $basket_form .= "</tr>";
            $total_sum = $total_sum + $row["price"];
        }
        $basket_form .= "</table>";
        $basket_form .= "<h3> Итого: " . $total_sum . " руб.</h3>";
    }
    return $basket_form;
}