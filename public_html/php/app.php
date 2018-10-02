<?php
session_start();
require_once "actions.php";

try {
	if (isset($_POST["type"])) {
		switch ($_POST["type"]) {
			case "session_get":
				echo session_get();
				break;
			case "login":
				echo login($_POST["user"],$_POST["pass"]);
				break;
			case "logout":
				echo logout();
				break;
			default:
				echo "{\"type\":\"error\",\"value\":\"unexpected type\"}";
				break;
		}
	}
	else {
		echo "{\"type\":\"error\",\"value\":\"type is not especified\"}";
	}
}
catch (Exception $error) {
	echo "{\"type\":\"error\",\"value\":\"$error\"}";
}
?>

