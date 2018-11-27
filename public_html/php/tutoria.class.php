<?php 

class Tutoria
{
	
	function __construct($id,$nombre,$inscritos,$dia,$hora_inicio,$hora_termino,$tutor,$lugar,$publicado,$cerrado,$fecha_cierre,$servicio,$profesional,$carrera,$semestre,$area,$codigo,$fecha_inicio,$fecha_termino,$fecha_planificado,$comentario,$programacion)
	{
		$this->id = $id;
		$this->nombre = $nombre;
		$this->inscritos = $inscritos;
		$this->dia = $dia;
		$this->hora_inicio = $hora_inicio;
		$this->hora_termino = $hora_termino;
		$this->tutor = $tutor;
		$this->lugar = $lugar;
		$this->publicado = $publicado;
		$this->cerrado = $cerrado;
		$this->fecha_cierre = $fecha_cierre;
		$this->servicio = $servicio;
		$this->profesional = $profesional;
		$this->carrera = $carrera;
		$this->semestre = $semestre;
		$this->area = $area;
		$this->codigo = $codigo;
		$this->fecha_inicio = $fecha_inicio;
		$this->fecha_termino = $fecha_termino;
		$this->fecha_planificado = $fecha_planificado;
		$this->comentario = $comentario;
		$this->programacion = $programacion;
	}

	function __toString()
	{
		return "{\"id\":\"".$this->id."\",\"nombre\":\"".$this->nombre."\",\"inscritos\":".$this->inscritos.",
				 \"dia\":\"".$this->dia."\",\"hora_inicio\":\"".$this->hora_inicio."\",
				 \"hora_termino\":\"".$this->hora_termino."\",\"tutor\":".$this->tutor.",
				 \"lugar\":\"".$this->lugar."\",\"publicado\":".$this->publicado.",\"cerrado\":".$this->cerrado.",
				 \"fecha_cierre\":\"".$this->fecha_cierre."\",\"servicio\":\"".$this->servicio."\",
				 \"profesional\":".$this->profesional.",\"carrera\":\"".$this->carrera."\",
				 \"semestre\":\"".$this->semestre."\",\"area\":\"".$this->area."\",\"codigo\":\"".$this->codigo."\",
				 \"fecha_inicio\":\"".$this->fecha_inicio."\",\"fecha_termino\":\"".$this->fecha_termino."\",
				 \"fecha_planificado\":\"".$this->fecha_planificado."\",\"comentario\":\"".$this->comentario."\",
				 \"programacion\":\"".$this->programacion."\"}";
	}
}

 ?>