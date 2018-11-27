<?php 

class Response
{
	function __construct($type,$value)
	{
		$this->type = $type;
		$this->value = $value;
	}

	function __toString()
	{
		if ($this->type == "string") {
			return str_replace("\\", "\\\\", "{\"type\":\"string\",\"value\":\"".$this->value."\"}");
		} else {
			return str_replace("\\", "\\\\", "{\"type\":\"".$this->type."\",\"value\":".$this->value."}");
		}
	}
}

 ?>