<?php 

class Tutoria
{
	
	function __construct($id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog)
	{
		$this->id = $id;
		$this->nombre = $n;
		$this->inscritos = $in;
		$this->dia = $d;
		$this->hora_inicio = $hi;
		$this->hora_termino = $ht;
		$this->tutor = $t;
		$this->lugar = $l;
		$this->publicado = $publ;
		$this->cerrado = $cer;
		$this->fecha_cierre = $fc;
		$this->servicio = $ser;
		$this->profesional = $prof;
		$this->carrera = $car;
		$this->semestre = $sem;
		$this->area = $a;
		$this->codigo = $cod;
		$this->fecha_inicio = $fi;
		$this->fecha_termino = $ft;
		$this->fecha_planificado = $fp;
		$this->comentario = $com;
		$this->programacion = $prog;
	}

	function __toString()
	{
		return "{\"id\":\"".$this->id."\",\"nombre\":\"".$this->nombre."\",\"inscritos\":".$this->inscritos.",\"dia\":\"".$this->dia."\",\"hora_inicio\":\"".$this->hora_inicio."\",\"hora_termino\":\"".$this->hora_termino."\",\"tutor\":".$this->tutor.",\"lugar\":\"".$this->lugar."\",\"publicado\":".$this->publicado.",\"cerrado\":".$this->cerrado.",\"fecha_cierre\":\"".$this->fecha_cierre."\",\"servicio\":\"".$this->servicio."\",\"profesional\":".$this->profesional.",\"carrera\":\"".$this->carrera."\",\"semestre\":\"".$this->semestre."\",\"area\":\"".$this->area."\",\"codigo\":\"".$this->codigo."\",\"fecha_inicio\":\"".$this->fecha_inicio."\",\"fecha_termino\":\"".$this->fecha_termino."\",\"fecha_planificado\":\"".$this->fecha_planificado."\",\"comentario\":\"".$this->comentario."\",\"programacion\":\"".$this->programacion."\"}";
	}

	function insert($id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO tutoria VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssssssssssssssssssssss",$args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15],$args[16],$args[17],$args[18],$args[19],$args[20],$args[21])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog));
	}

	function reinsert($u,$p,$n,$l)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO tutoria VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE nombre=VALUES(nombre),inscritos=VALUES(inscritos),dia=VALUES(dia),hora_inicio=VALUES(hora_inicio),hora_termino=VALUES(hora_termino),tutor=VALUES(tutor),lugar=VALUES(lugar),publicado=VALUES(publicado),cerrado=VALUES(cerrado),fecha_cierre=VALUES(fecha_cierre),servicio=VALUES(servicio),profesional=VALUES(profesional),carrera=VALUES(carrera),semestre=VALUES(semestre),area=VALUES(area),codigo=VALUES(codigo),fecha_inicio=VALUES(fecha_inicio),fecha_termino=VALUES(fecha_termino),fecha_planificado=VALUES(fecha_planificado),comentario=VALUES(comentario),programacion=VALUES(programacion)";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssssssssssssssssssssss",$args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15],$args[16],$args[17],$args[18],$args[19],$args[20],$args[21])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog));
	}

	function select_by_id($id)
	{
		$query = function($link,$args){
			$tutoria = false;
			$sql = "SELECT * FROM tutoria WHERE id = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($t = User::select_by_user($t)) {
									if ($prof = User::select_by_user($prof)) {
										$tutoria = new Tutoria($id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog);
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $tutoria;
		};
		return execute_query($query,array($id));
	}

	function select_by_tutor($t)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM tutoria WHERE tutor = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog)) {
							while (mysqli_stmt_fetch($stmt)) {
								if ($t = User::select_by_user($t)) {
									if ($prof = User::select_by_user($prof)) {
										array_push($list, new Tutoria($id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog));
									}
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

	function select_by_profesional($prof)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM tutoria WHERE profesional = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog)) {
							while (mysqli_stmt_fetch($stmt)) {
								if ($t = User::select_by_user($t)) {
									if ($prof = User::select_by_user($prof)) {
										array_push($list, new Tutoria($id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog));
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($prof)));
	}

	function update($id,$n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE tutoria SET nombre=?,inscritos=?,dia=?,hora_inicio=?,hora_termino=?,tutor=?,lugar=?,publicado=?,cerrado=?,fecha_cierre=?,servicio=?,profesional=?,carrera=?,semestre=?,area=?,codigo=?,fecha_inicio=?,fecha_termino=?,fecha_planificado=?,comentario=?,programacion=? WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssssssssssssssssssssss",$args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15],$args[16],$args[17],$args[18],$args[19],$args[20],$args[21])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($n,$in,$d,$hi,$ht,$t,$l,$publ,$cer,$fc,$ser,$prof,$car,$sem,$a,$cod,$fi,$ft,$fp,$com,$prog,$id));
	}

	function delete($id)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM tutoria WHERE id=?";
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
		return execute_query($query,array($id));
	}
}

?>
