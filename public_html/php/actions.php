<?php
require_once "crud.php";

function session_get()
{
	if (isset($_SESSION["user"])) {
		$user = $_SESSION["user"];
		return "{\"type\":\"user\",\"value\":$user}";
	} else {
		return "{\"type\":\"error\",\"value\":\"none user is returned\"}";
	}
}

function login($u,$p)
{
	if (isset($_SESSION["user"])) {
		$user = $_SESSION["user"];
		return "{\"type\":\"user\",\"value\":$user}";
	} elseif ($user = crud_get_user($u,$p)) {
		$_SESSION["user"] = $user."";
		return "{\"type\":\"user\",\"value\":$user}";
	} else {
		return "{\"type\":\"error\",\"value\":\"none user is returned\"}";
	}
}

function logout()
{
	if (isset($_SESSION["user"])) {
		session_unset();
		return "{\"type\":\"success\",\"value\":\"logout successful\"}";
	} else {
		return "{\"type\":\"error\",\"value\":\"session does not exist\"}";
	}
}
?>

