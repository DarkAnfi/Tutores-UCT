<?php
class Data
{
	function __construct($i,$n,$l,$p)
	{
		$this->id = $i;
		$this->name = $n;
		$this->lastname = $l;
		$this->phone = $p;

	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"name\":\"".$this->name."\",\"lastname\":\"".$this->lastname."\",\"phone\":\"".$this->phone."\"}";
	}

	function insert($i,$n,$l,$p)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO data VALUES(?,?,?,?)";
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
		return execute_query($query,array($i,$n,$l,$p));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$data = false;
			$sql = "SELECT * FROM data WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$n,$l,$p)) {
							if (mysqli_stmt_fetch($stmt)) {
								$data = new Data($i,$n,$l,$p);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $data;
		};
		return execute_query($query,array($i));
	}

	function update($i,$n,$l,$p)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE data SET name=?,lastname=?,phone=? WHERE id=?";
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
		return execute_query($query,array($n,$l,$p,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM data WHERE id=?";
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
