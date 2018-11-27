<?php 

class Error
{
	function __construct($errno, $errstr)
	{
		$this->errno = $errno;
		$this->errstr = $errstr;
	}

	function getInstance($errno) {
		switch ($errno) {
			case E_USER_ERROR:
				return new Error($errno,"E_USER_ERROR");
				break;
			case E_USER_WARNING:
				return new Error($errno,"E_USER_WARNING");
				break;
			case E_USER_NOTICE:
				return new Error($errno,"E_USER_NOTICE");
				break;
			case 0:
				return new Error($errno,"None is returned");
				break;
			case 1:
				return new Error($errno,"On POST type is not defined");
				break;
			case 2:
				return new Error($errno,"On SESSION user is not defined");
				break;
			case 3:
				return new Error($errno,"None user is returned");
				break;
			case 4:
				return new Error($errno,"Access denied for this user");
				break;
			case 5:
				return new Error($errno,"Unexpected type");
				break;
			case 6:
				return new Error($errno,"A MySQL Exception has occurred");	
				break;
			default:
				return new Error($errno,"Unknow Error");
				break;
		}
	}

	function __toString()
	{
		return "{\"errno\":\"".$this->errno."\",\"errstr\":\"".$this->errstr."\"}";
	}
}

 ?>