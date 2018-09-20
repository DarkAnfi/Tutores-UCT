<?php
try {
	if (isset($_POST["type"])) {
		switch ($_POST["type"]) {
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