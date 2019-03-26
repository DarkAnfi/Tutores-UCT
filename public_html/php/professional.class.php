<?php
class Professional
{
	function __construct($i,$d,$a)
	{
		$this->id = $i;
		$this->data = $d;
		$this->area = $a;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"data\":".$this->data.",\"area\":".$this->area."}";
	}

	function insert($d,$a)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO professional VALUES(NULL,?,?)";
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
		return execute_query($query,array($d,$a));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$professional = false;
			$sql = "SELECT * FROM professional WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$d,$a)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($d = Data::select_by_id($d)) {
									if ($a = Area::select_by_id($a)) {
										$professional = new Professional($i,$d,$a);
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $professional;
		};
		return execute_query($query,array($i));
	}

	function select_by_data($d)
	{
		$query = function($link,$args){
			$professional = false;
			$sql = "SELECT * FROM professional WHERE data=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$d,$a)) {
							if (mysqli_stmt_fetch($stmt)) {
								$professional = new Professional($i,$d,$a);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $professional;
		};
		return execute_query($query,array($d));
	}

	function update($i,$d,$a)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE professional SET data=?,area=? WHERE id=?";
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
		return execute_query($query,array($d,$a,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM professional WHERE id=?";
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

