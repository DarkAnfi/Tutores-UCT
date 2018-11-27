<?php 

class Inscrito
{
	
	function __construct($id,$estudiante,$tutoria)
	{
		$this->id = $id;
		$this->estudiante = $estudiante;
		$this->tutoria = $tutoria;
	}

	function __toString()
	{
		return "{\"id\":\"".$this->id."\",\"estudiante\":".$this->estudiante.",\"tutoria\":".$this->tutoria."}";
	}
}

 ?>