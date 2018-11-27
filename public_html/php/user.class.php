<?php
class User
{
	function __construct($u,$n,$l)
	{
		$this->user = $u;
		$this->name = $n;
		$this->level = $l;

	}

	function fromJSON($json)
	{
		$json = json_decode($json);
		return new User($json->user,$json->name,$json->level);
	}

	function __toString()
	{
		return "{\"user\":\"".$this->user."\",\"name\":\"".$this->name."\",\"level\":".$this->level."}";
	}
}
?>

