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

	function insert($u,$p,$n,$l)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO usuario VALUES(?,MD5(?),?,?)";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssss",$args[0],$args[1],$args[2],$args[3])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($u,$p,$n,$l));
	}

	function select_by_user($u)
	{
		$query = function($link,$args){
			$user = false;
			$sql = "SELECT user,name,level FROM usuario WHERE user=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$u,$n,$l)) {
							if (mysqli_stmt_fetch($stmt)) {
								$user = new User($u,$n,$l);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $user;
		};
		return execute_query($query,array($u));
	}

	function select_by_user_pass($u,$p)
	{
		$query = function($link,$args){
			$user = false;
			$sql = "SELECT user,name,level FROM usuario WHERE user=? AND pass=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ss",$args[0],md5($args[1]))) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$u,$n,$l)) {
							if (mysqli_stmt_fetch($stmt)) {
								$user = new User($u,$n,$l);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $user;
		};
		return execute_query($query,array($u,$p));
	}

	function select_by_name($n)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT user,name,level FROM usuario WHERE name = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$u,$n,$l)) {
							while (mysqli_stmt_fetch($stmt)) {
								array_push($list, new User($u,$n,$l));
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($n)));
	}

	function update($u,$p,$n,$l)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE usuario SET pass=MD5(?),name=?,level=? WHERE user=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssss",$args[0],$args[1],$args[2],$args[3])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($p,$n,$l,$u));
	}

	function delete($u)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM usuario WHERE user=?";
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
		return execute_query($query,array($u));
	}
}
?>
