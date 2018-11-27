<?php
class Asistencia
{
	function __construct($id,$estudiante,$presente,$sesion)
	{
		$this->id = $id;
		$this->estudiante = $estudiante;
		$this->presente = $presente;
		$this->sesion = $sesion;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"estudiante\":".$this->estudiante.",\"presente\":".$this->presente.",\"sesion\":".$this->sesion."}";
	}
}
?>

