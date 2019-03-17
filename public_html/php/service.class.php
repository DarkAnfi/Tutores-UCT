<?php
class Service
{
	function __construct($id,$n,$i,$u,$l)
	{
		$this->id = $id;
		$this->name = $n;
		$this->image = $i;
		$this->url = $u;
		$this->level = $l;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"name\":\"".$this->name."\",\"image\":\"".$this->image."\",\"url\":\"".$this->url."\",\"level\":".$this->level."}";
	}

	function insert($n,$i,$u,$l)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO service VALUES(NULL,?,?,?,?)";
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
		return execute_query($query,array($n,$i,$u,$l));
	}

	function select_by_level($l)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM service WHERE level <= ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$id,$n,$i,$u,$l)) {
							while (mysqli_stmt_fetch($stmt)) {
								array_push($list, new Service($id,$n,$i,$u,$l));
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($l)));
	}

	function update($id,$n,$i,$u,$l)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE service SET name=?,image=?,url=?,level=? WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"sssss",$args[0],$args[1],$args[2],$args[3],$args[4])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($n,$i,$u,$l,$id));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM service WHERE id=?";
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

