<?
/*
навешиваем создание сессии
*/
session_start();

/*http path config*/
define('SITE_ROOT', "../");
define('WWW_ROOT', SITE_ROOT . '/public');
define("DOMAIN", "lp.test");

/*DB config*/
define("DB_SERVER","localhost");
define("DB_USER", "root");
define("DB_PASS","");
define("DB_NAME","laptopsheaven_shop");

/*FS config*/
define("IMG_DIR", "../item_img/");
define('LIB_DIR', SITE_ROOT . 'models');

/*Security config*/
define("USER_SALT", "12345");

require_once(LIB_DIR . '/lib_load.php');