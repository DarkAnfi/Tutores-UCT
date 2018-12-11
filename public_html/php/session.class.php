<?php 

class Session
{
	
	function __construct($i,$f,$l,$c,$o,$t)
	{
		$this->id = $i;
		$this->fecha = $f;
		$this->lugar = $l;
		$this->contenidos = $c;
		$this->observaciones = $o;
		$this->tutoria = $t;
	}

	function __toString()
	{
		return "{\"id\":\"".$this->id."\",\"fecha\":\"".$this->fecha."\",\"lugar\":\"".$this->lugar."\",\"contenidos\":\"".$this->contenidos."\",\"observaciones\":\"".$this->observaciones."\",\"tutoria\":".$this->tutoria."}";
	}

	function insert($f,$l,$c,$o,$t)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO sesion VALUES(NULL,?,?,?,?,?)";
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
		return execute_query($query,array($f,$l,$c,$o,$t));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$sesion = false;
			$sql = "SELECT * FROM sesion WHERE id = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$f,$l,$c,$o,$t)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($t = Tutoria::select_by_id($t)) {
									$sesion = new Session($i,$f,$l,$c,$o,$t);
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $sesion;
		};
		return execute_query($query,array($i));
	}

	function select_by_tutoria($t)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM sesion WHERE tutoria = ? ORDER BY fecha DESC";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$f,$l,$c,$o,$t)) {
							while (mysqli_stmt_fetch($stmt)) {
								if ($t = Tutoria::select_by_id($t)) {
									array_push($list, new Session($i,$f,$l,$c,$o,$t));
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($t)));
	}

	function select_by_fecha_tutoria($f,$t)
	{
		$query = function($link,$args){
			$sesion = false;
			$sql = "SELECT * FROM sesion WHERE fecha=? AND tutoria=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ss",$args[0],$args[1])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$f,$l,$c,$o,$t)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($t = Tutoria::select_by_id($t)) {
									$sesion = new Session($i,$f,$l,$c,$o,$t);
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $sesion;
		};
		return execute_query($query,array($f,$t));
	}

	function update($i,$f,$l,$c,$o,$t)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE sesion SET fecha=?,lugar=?,contenidos=?,observaciones=?,tutoria=? WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssssss",$args[0],$args[1],$args[2],$args[3],$args[4],$args[5])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($f,$l,$c,$o,$t,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM sesion WHERE id=?";
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
