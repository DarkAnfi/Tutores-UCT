<?php
class User
{
	function __construct($u)
	{
		$this->user = $u;
	}

	function __toString()
	{
		return "{\"user\":\"".$this->user."\"}";
	}
}
?>

