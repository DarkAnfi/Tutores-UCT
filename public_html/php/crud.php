<?php
require_once "user.php";

function crud_get_user($u,$p)
{
	if ($u == "guest" and $p == "12345") {
		return new User($u);
	} else {
		return false;
	}
}
?>

