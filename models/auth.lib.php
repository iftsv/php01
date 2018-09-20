<?
/*
отвечает за авторизационную логику
*/
# проверяем состояние авторизации (вошли или нет под пользователем)
function IsAuthUser() {
	if (isset($_SESSION["id_user"]) && $_SESSION["id_user"] > 0)
	{
		return true;
	} else {
		return false;
	}
}

# проверяем является ли пользователем админом
function UserIsAdmin() {
	if ($_SESSION["user_role_name"] === "admin") {
		return true;
	} else {
		return false;
	}
}

# проверяем существует ли пользователь
function UserExists($sqlcon, $email) {
	$email = strip_tags($email);

	$sql_str = "SELECT * FROM user WHERE user_email = '%s'";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $email));
	$result = mysqli_query($sqlcon, $sql);

	if (mysqli_num_rows($result) > 0) {
		return true;
	} else {
		return false;
	}
}
# строим меню для страницы
function BuildAuthMenu() {
	$auth_menu = "";
	if (isset($_SESSION["id_user"])) {
		if($_SESSION["user_role_name"] === "admin") {
			$auth_menu = "<li><a href='//" . DOMAIN . "/adminpanel'>[Admin Panel]&nbsp</a></li>";
			$auth_menu .= "<li><a href='//" . DOMAIN . "/public/login.php?logout=1'>[Выход&nbsp". $_SESSION["user_email"] . "]</a></li>";
			return $auth_menu;
		} else {
			$auth_menu = "<li><a href='//" . DOMAIN. "/basket/'>[Моя Корзина] &nbsp</a></li>";
			$auth_menu .= "<li><a href='//" . DOMAIN. "/order/'>[Мои заказы] &nbsp</a></li>";
			$auth_menu .= "<li><a href='//" . DOMAIN. "/public/login.php?logout=1'>[Выход&nbsp". $_SESSION["user_email"] . " ]&nbsp</a></li>";
			return $auth_menu;
		}
	} else {
		$auth_menu = "<li><a href='//" . DOMAIN."/public/login.php'>[Вход]&nbsp</a></li>";
		return $auth_menu;
	}
}

# функция для выхода из пользователя
function UserLogout() {
	unset($_SESSION["user_email"]);
	unset($_SESSION["id_user"]);
	unset($_SESSION["user_role_name"]);
	session_destroy();
}

/*если приходят авторизационные данные, то проверяем их
- если есть такой пользователь, то создаем сессию и редиректим на главную страницу
- если пользователя нет, то выводим сообщение

*/
if(isset($_POST["email"]) && isset($_POST["password"])) {
	$login = strip_tags($_POST[email]);
	$pass = strip_tags($_POST[password]);

	$sql_str = "SELECT * FROM user JOIN user_role ON id_user_role = id_role
				WHERE user_isactive = 1 AND user_email = '%s' AND user_pass='%s'";
	$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $login), hash(sha512, mysqli_real_escape_string($sqlcon, $pass . USER_SALT)));
	$result = mysqli_query($sqlcon, $sql);

	if(mysqli_num_rows($result) == 1) {
		# пользователь существует, создаем переменные с его данными
		$user_info = mysqli_fetch_assoc($result);
		$_SESSION["user_email"] = $user_info["user_email"];
		$_SESSION["id_user"] = $user_info["id_user"];
		$_SESSION["user_role_name"] = $user_info["user_role_name"];
		# редиректим на главную страницу
		echo "<script type='text/javascript'>location.href = '//" .DOMAIN . "';</script>";
	} else {
		echo "<script>alert('Такого пользователя не существует. Либо пользователь заблокирован. Обратитесь в поддержку')</script>";
		# редиректим на страницу входа
		echo "<script type='text/javascript'>location.href = '//" .DOMAIN . "/public/login.php';</script>";
	}
}

/*
если приходят данные на регистрацию - регистрируем пользователя
*/
if(isset($_POST["reg_email"]) && isset($_POST["reg_password"])) {
	$login = strip_tags($_POST[reg_email]);
	$pass = strip_tags($_POST[reg_password]);

	if (UserExists($sqlcon, $login)) {
		echo "<script>alert('Учетная запись с таким E-mail существует!')</script>";
		# редиректим на страницу входа
		echo "<script type='text/javascript'>location.href = '//" .DOMAIN . "/public/registration.php';</script>";
	} else {
		# создаем пользователя
		$sql_str = "INSERT INTO user (user_email, user_pass, user_date_created, user_date_modify, id_role, user_isactive) VALUES ('%s', '%s', NOW(), NOW(), 2, 1)";
		$sql = sprintf($sql_str, mysqli_real_escape_string($sqlcon, $login), hash(sha512, mysqli_real_escape_string($sqlcon, $pass . USER_SALT)));
		$result = mysqli_query($sqlcon, $sql);
		if($result) {
			echo "<script>alert('Учетная запись создана!')</script>";
			# редиректим на страницу входа
			echo "<script type='text/javascript'>location.href = '//" .DOMAIN . "/public/login.php';</script>";
		} else {
			echo "<script>alert('Учетная запись не создана. Попробуйте еще раз или обратитесь в поддержку')</script>";
			echo "<script type='text/javascript'>location.href = '//" .DOMAIN . "/public/registration.php';</script>";
		}
	}
}


/* если пришла команда на выход из магазина
- очищаем функцию для очистки авторизационных данных
- редиректим на главную страницу
*/
if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
	UserLogout();
	# редиректим на главную страницу
	header("Location: //" . DOMAIN);
}

if (isset($_SESSION["id_user"])) {
	if (strpos($_SERVER["REQUEST_URI"], "login.php") != 0) {
		echo "<h3>Вы уже вошли в систему</h3>";
		echo "<br><a href='//" . DOMAIN . "/login.php?logout=1'>Выход из системы</a>";
		exit("<br><a href='//" . DOMAIN . "'>На главную страницу</a>");
	}
}