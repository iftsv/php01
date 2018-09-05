<?
include_once("modules/config.php");
include_once("modules/function.php");

/* функция создаем галлерею из БД */
createGalleryFromDatabase();
/*функция проверяет что не было ошибки при загрузке фотографии*/
checkUploadState();