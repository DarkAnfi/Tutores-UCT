<?php
class Login
{
	function __construct($i,$e)
	{
		$this->id = $i;
		$this->email = $e;

	}

	function fromJSON($json)
	{
		$json = json_decode($json);
		return new Login($json->id,$json->email);
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"email\":\"".$this->email."\"}";
	}

	function insert($e,$p)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO login VALUES(NULL,?,MD5(?))";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ss",$args[0],$args[1])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($e,$p));
	}

	function select_by_email_password($e,$p)
	{
		$query = function($link,$args){
			$login = false;
			$sql = "SELECT id,email FROM login WHERE email=? AND password=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ss",$args[0],md5($args[1]))) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$e)) {
							if (mysqli_stmt_fetch($stmt)) {
								$login = new Login($i,$e);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $login;
		};
		return execute_query($query,array($e,$p));
	}

	function update($i,$e,$p)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE login SET email=?,password=MD5(?) WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"sss",$args[0],$args[1],$args[2])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($e,$p,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM login WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($i));
	}
}
?>
