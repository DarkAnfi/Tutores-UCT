<?php 
require_once 'user.class.php';
require_once 'response.class.php';

class jsonList
{
	
	function __construct($content)
	{
		$this->content = $content;
	}

	function __toString()
	{
		$s = "[";
		for ($i=0; $i < count($this->content); $i++) { 
			$s .= $this->content[$i];
			if(($i+1) < count($this->content)) {
				$s .= ",";
			}
		}
		$s .= "]";
		return $s;
	}
}

?>