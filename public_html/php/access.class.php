<?php
class Access
{
	function __construct($i,$l)
	{
		$this->id = $i;
		$this->level = $l;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"level\":".$this->level."}";
	}

	function insert($i,$l)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO access VALUES(?,?)";
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
		return execute_query($query,array($i,$l));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$access = false;
			$sql = "SELECT * FROM access WHERE id = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$l)) {
							if (mysqli_stmt_fetch($stmt)) {
								$access = new Access($i,$l);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $access;
		};
		return execute_query($query,array($i));
	}

	function update($i,$l)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE access SET level=? WHERE id=?";
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
		return execute_query($query,array($l,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM access WHERE id=?";
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

