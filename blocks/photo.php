<?
include_once("modules/config.php");
include_once("modules/function.php");

if (isset($_GET["id"])) {
	
	$id_file = $_GET["id"];
	/* показываем картинку по id */
	showPhoto($id_file);
}