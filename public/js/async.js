/*
работаем с корзиной
*/
function update_archive_status_of_item(id_item, is_archive){
    $.ajax({
        type: 'GET',
        url: '../controller/archive.php',
        data: 'id_item=' + id_item + '&is_archive=' + is_archive,
        success: function(data){
            $(".admin_catalog_list").html(data);
        }
    });
}

function increment_count_item_into_basket(id_item){
    $.ajax({
        type: 'GET',
        url: '../controller/basket.php',
        data: 'id_item=' + id_item + '&action=inc_item',
        success: function(data){
        	alert("Товар добавлен в Корзину");
            $("td.basket_form_info").html(data);
            document.location.reload(true);
        }
    });
}

function decrement_count_item_into_basket(id_item){
    $.ajax({
        type: 'GET',
        url: '../controller/basket.php',
        data: 'id_item=' + id_item + '&action=dec_item',
        success: function(data){
            $("td.basket_form_info").html(data);
            document.location.reload(true);
        }
    });
}

function remove_item_from_basket(id_item){
    $.ajax({
        type: 'GET',
        url: '../controller/basket.php',
        data: 'id_item=' + id_item + '&action=remove_item',
        success: function(data){
            $("td.basket_form_info").html(data);
            document.location.reload(true);
        }
    });
}

function clear_basket(){
    $.ajax({
        type: 'GET',
        url: '../controller/basket.php',
        data: 'action=clear_basket',
        success: function(data){
            $("td.basket_form_info").html(data);
            document.location.reload(true);
        }
    });
}

/*
работаем с заказами
*/
function create_new_order() {
    $.ajax({
        type: 'GET',
        url: '../controller/order.php',
        data: 'action=create_order',
        success: function(data){
            $("td.basket_form_info").html(data);
        }
    });
}

function update_status_order(id_order, id_order_status) {
    $.ajax({
        type: 'GET',
        url: '../controller/order.php',
        data: 'id_order='+id_order+'&id_order_status='+id_order_status+'&action=update_order',
        success: function(data){
            document.location.reload(true);
        }
    });
}