<?php
class Area
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
			$sql = "INSERT INTO area VALUES(NULL,?)";
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
			$area = false;
			$sql = "SELECT * FROM area WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$n)) {
							if (mysqli_stmt_fetch($stmt)) {
								$area = new Area($i,$n);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $area;
		};
		return execute_query($query,array($i));
	}

	function update($i,$n)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE area SET name=? WHERE id=?";
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
			$sql = "DELETE FROM area WHERE id=?";
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

