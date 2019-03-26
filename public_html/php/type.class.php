<?php
class Type
{
	function __construct($i,$n)
	{
		$this->id = $i;
		$this->name = $n;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"name\":\"".$this->name."\"}";
	}

	function insert($n)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO type VALUES(NULL,?)";
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
		return execute_query($query,array($n));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$type = false;
			$sql = "SELECT * FROM type WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$n)) {
							if (mysqli_stmt_fetch($stmt)) {
								$type = new Type($i,$n);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $type;
		};
		return execute_query($query,array($i));
	}

	function update($i,$n)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE type SET name=? WHERE id=?";
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
		return execute_query($query,array($n,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM type WHERE id=?";
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

