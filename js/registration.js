function CheckPasswordFields(){
	if($("input#element_2").val() == $("input#element_3").val()){
		$("input#element_2").css("border", "5px solid green");
		$("input#element_3").css("border", "5px solid green");
	} else {
		alert("Введеные пароли не совпадают!");
		$("input#element_2").val("");
		$("input#element_3").val("");
	}
}