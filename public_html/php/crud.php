<?php
include_once 'mysql_connector.php';

function crud_get_user($args)
{
    $query = function($link,$args){
        $sql = "SELECT user,name,level FROM usuario WHERE user = ? AND pass = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"ss",$args[0],md5($args[1]));
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$_user,$_name,$_level);
            mysqli_stmt_fetch($stmt);
            if (!is_null($_user) and !is_null($_name) and !is_null($_level)) {
                $user = new User($_user,$_name,$_level);
            } else {
                $user = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $user = false;
        }
        return $user;
    };
    return execute_query($query,$args);
}

function crud_get_user_user($args)
{
    $query = function ($link,$args) {
        $sql = "SELECT user,name,level FROM usuario WHERE user = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$args[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$_user,$_name,$_level);
            mysqli_stmt_fetch($stmt);
            if (!is_null($_user) and !is_null($_name) and !is_null($_level)) {
                $user = new User($_user,$_name,$_level);
            } else {
                $user = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $user = false;
        }
        return $user;
    };
    return execute_query($query,$args);
}

function crud_get_user_name($args)
{
    $query = function ($link,$args) {
        $sql = "SELECT user FROM usuario WHERE name = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$args[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$_user);
            mysqli_stmt_fetch($stmt);
            if (!is_null($_user)) {
                $user = $_user;
            } else {
                $user = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $user = false;
        }
        return $user;
    };
    return execute_query($query,$args);
}

function crud_get_date_format($_d)
{
    if ($_d != "") {
        $search = array("ene","abr","ago","dic","de Enero","de Febrero","de Marzo","de Abril","de Mayo","de Junio","de Julio",
            "de Agosto","de Septiembre","de Octubre","de Noviembre","de Diciembre");
        $replace = array("jan","apr","aug","dec","jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec");
        $_d = str_replace($search, $replace, $_d);
        if ($format = date_create_from_format("j M Y",$_d)) {
            $_d = date_format($format,"Y-m-d");
        } elseif ($format = date_create_from_format("j/m/Y",$_d)) {
            $_d = date_format($format,"Y-m-d");
        } elseif ($format = date_create_from_format("j-m-Y",$_d)) {
            $_d = date_format($format,"Y-m-d");
        } else {
            $_d = null;
        }
    } else {
        $_d = null;
    }
    return $_d;
}

function crud_update_tutoria()
{
    $a = array();
    $regs = json_decode(file_get_contents(DRIVE.DOCUMENT.constant("MATEMÁTICAS").HEADER),true)['feed']['entry'];
    foreach ($regs as $reg) {
        if ( $reg['gsx$id']['$t'] != '') {
            if ($tutor = crud_get_user_name(array($reg['gsx$tutorresponsable']['$t']))) {
                if ($prof = crud_get_user_name(array($reg['gsx$profesionalresponsable']['$t']))) {
                    $r = array();
                    array_push($r,$reg['gsx$id']['$t']);
                    array_push($r,$reg['gsx$nombreasignatura']['$t']);
                    array_push($r,$reg['gsx$cantidaddeinscritos']['$t']);
                    array_push($r,$reg['gsx$díasemana']['$t']);
                    array_push($r,$reg['gsx$horainicio']['$t'].":00");
                    array_push($r,$reg['gsx$horatérmino']['$t'].":00");
                    array_push($r,$tutor);
                    array_push($r,$reg['gsx$lugar']['$t']);
                    if ($reg['gsx$publicadoenlaweb']['$t'] == "0") {
                        $publicado = 0;
                    } else {
                        $publicado = 1;
                    }
                    if ($reg['gsx$tutoriacerrada']['$t'] == "") {
                        $cerrado = 0;
                    } else {
                        $cerrado = 1;
                    }
                    array_push($r,$publicado);
                    array_push($r,$cerrado);
                    array_push($r,crud_get_date_format($reg['gsx$fechadecierre']['$t']));
                    array_push($r,$reg['gsx$tiposervicio']['$t']);
                    array_push($r,$prof);
                    array_push($r,$reg['gsx$carreradelaasignatura']['$t']);
                    array_push($r,$reg['gsx$semestre']['$t']);
                    array_push($r,$reg['gsx$área']['$t']);
                    array_push($r,$reg['gsx$códigoasignatura']['$t']);
                    array_push($r,crud_get_date_format($reg['gsx$fechainicioacompañamiento']['$t']));
                    array_push($r,crud_get_date_format($reg['gsx$fechafinacompañamiento']['$t']));
                    array_push($r,crud_get_date_format($reg['gsx$fechaplanificada']['$t']));
                    array_push($r,$reg['gsx$comentario']['$t']);
                    array_push($r,$reg['gsx$programacion']['$t']);
                    array_push($a, $r);
                }
            }
        }
    }
    $query = function ($link,$args) {
        $sql = "INSERT INTO tutoria 
                    (id, nombre, inscritos, dia, hora_inicio, hora_termino, tutor, lugar, publicado, cerrado, fecha_cierre, servicio,
                     profesional, carrera, semestre, area, codigo, fecha_inicio, fecha_termino, fecha_planificado, comentario, 
                     programacion)
                VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    nombre=VALUES(nombre),
                    inscritos=VALUES(inscritos),
                    dia=VALUES(dia),
                    hora_inicio=VALUES(hora_inicio),
                    hora_termino=VALUES(hora_termino),
                    tutor=VALUES(tutor),
                    lugar=VALUES(lugar),
                    publicado=VALUES(publicado),
                    cerrado=VALUES(cerrado),
                    fecha_cierre=VALUES(fecha_cierre),
                    servicio=VALUES(servicio),
                    profesional=VALUES(profesional),
                    carrera=VALUES(carrera),
                    semestre=VALUES(semestre),
                    area=VALUES(area),
                    codigo=VALUES(codigo),
                    fecha_inicio=VALUES(fecha_inicio),
                    fecha_termino=VALUES(fecha_termino),
                    fecha_planificado=VALUES(fecha_planificado),
                    comentario=VALUES(comentario),
                    programacion=VALUES(programacion)";
        foreach ($args as $r) {
            if ($stmt = mysqli_prepare($link,$sql)) {
                mysqli_stmt_bind_param($stmt,"ssssssssssssssssssssss",$r[0],$r[1],$r[2],$r[3],$r[4],$r[5],$r[6],$r[7],$r[8],
                    $r[9],$r[10],$r[11],$r[12],$r[13],$r[14],$r[15],$r[16],$r[17],$r[18],$r[19],$r[20],$r[21]);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                
            }
        }
    };
    execute_query($query,$a);
}

function crud_get_tutoria_tutor($args)
{
    $query = function ($link, $args) {
        $list = array();
        $sql = "SELECT * FROM tutoria WHERE tutor = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$args[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$id,$nombre,$inscritos,$dia,$hora_inicio,$hora_termino,$tutor,$lugar,$publicado,$cerrado,
                $fecha_cierre,$servicio,$profesional,$carrera,$semestre,$area,$codigo,$fecha_inicio,$fecha_termino,
                $fecha_planificado,$comentario,$programacion);
            while (mysqli_stmt_fetch($stmt)) {
                if ($tutor = crud_get_user_user(array($tutor))) {
                    if ($profesional = crud_get_user_user(array($profesional))) {
                        array_push($list, new Tutoria($id,$nombre,$inscritos,$dia,$hora_inicio,$hora_termino,$tutor,$lugar,$publicado,
                            $cerrado,$fecha_cierre,$servicio,$profesional,$carrera,$semestre,$area,$codigo,$fecha_inicio,$fecha_termino,
                            $fecha_planificado,$comentario,$programacion));
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $list;
    };
    return (new jsonList(execute_query($query,$args)));
}

function crud_get_tutoria_id($args)
{
    $query = function ($link, $args) {
        $sql = "SELECT * FROM tutoria WHERE id = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$args[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$id,$nombre,$inscritos,$dia,$hora_inicio,$hora_termino,$tutor,$lugar,$publicado,$cerrado,
                $fecha_cierre,$servicio,$profesional,$carrera,$semestre,$area,$codigo,$fecha_inicio,$fecha_termino,
                $fecha_planificado,$comentario,$programacion);
            if (mysqli_stmt_fetch($stmt)) {
                if ($tutor = crud_get_user_user(array($tutor))) {
                    if ($profesional = crud_get_user_user(array($profesional))) {
                        $tuto = new Tutoria($id,$nombre,$inscritos,$dia,$hora_inicio,$hora_termino,$tutor,$lugar,$publicado,
                            $cerrado,$fecha_cierre,$servicio,$profesional,$carrera,$semestre,$area,$codigo,$fecha_inicio,$fecha_termino,
                            $fecha_planificado,$comentario,$programacion);
                    } else {
                        $tuto = false;
                    }
                } else {
                    $tuto = false;
                }
            } else {
                $tuto = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $tuto = false;
        }
        return $tuto;
    };
    return (execute_query($query,$args));
}

function crud_get_session_tutoria($args)
{
    $query = function ($link, $args) {
        $list = array();
        $sql = "SELECT * FROM sesion WHERE tutoria = ? ORDER BY fecha DESC";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$args[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$id,$fecha,$lugar,$contenidos,$observaciones,$tutoria);
            while (mysqli_stmt_fetch($stmt)) {
                if ($tutoria = crud_get_tutoria_id(array($tutoria))) {
                    array_push($list, new Session($id,$fecha,$lugar,$contenidos,$observaciones,$tutoria));
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $list;
    };
    return (new jsonList(execute_query($query,$args)));
}

function crud_get_inscrito_tutoria($args)
{
    $query = function ($link, $args) {
        $list = array();
        $sql = "SELECT * FROM inscrito WHERE tutoria = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$args[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$id,$estudiante,$tutoria);
            while (mysqli_stmt_fetch($stmt)) {
                if ($estudiante = crud_get_estudiante_rut(array($estudiante))) {
                    if ($tutoria = crud_get_tutoria_id(array($tutoria))) {
                        array_push($list, new Inscrito($id,$estudiante,$tutoria));
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $list;
    };
    return (new jsonList(execute_query($query,$args)));
}

function crud_get_estudiante_rut($args) 
{
    $query = function ($link,$args) {
        $sql = "SELECT * FROM estudiante WHERE rut = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$args[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$rut,$dv,$nombre,$cod_carrera,$nom_carrera,$cohorte,$fono,$email);
            mysqli_stmt_fetch($stmt);
            if (!is_null($rut)) {
                $estudiante = new Estudiante($rut,$dv,$nombre,$cod_carrera,$nom_carrera,$cohorte,$fono,$email);
            } else {
                $estudiante = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $estudiante = false;
        }
        return $estudiante;
    };
    return execute_query($query,$args);
}

function crud_get_sesion_id($args) 
{
    $query = function ($link,$args) {
        $sql = "SELECT * FROM sesion WHERE id = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$args[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$id,$fecha,$lugar,$contenidos,$observaciones,$tutoria);
            mysqli_stmt_fetch($stmt);
            if (!is_null($id)) {
                if ($tutoria = crud_get_tutoria_id(array($tutoria))) {
                    $sesion = new Session($id,$fecha,$lugar,$contenidos,$observaciones,$tutoria);
                }
            } else {
                $sesion = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $sesion = false;
        }
        return $sesion;
    };
    return execute_query($query,$args);
}

function crud_add_session($args)
{
    $query = function ($link, $args) {
        $sql = "INSERT INTO sesion VALUES(NULL,?,\"\",\"\",\"\",?)";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"ss",$args[0],$args[1]);
            $bool = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            $bool = false;
        }
        return $bool;
    };
    if ($bool = execute_query($query, $args)) {
        if ($sesion = crud_get_sesion_fecha_tutoria($args)) {
            if ($list = crud_get_inscrito_tutoria(array($sesion->tutoria->id))) {
                for ($i=0; $i < count($list->content); $i++) { 
                    $inscrito = $list->content[$i];
                    if(!($bool = crud_add_asistencia(array($inscrito->estudiante->rut,'0',$sesion->id)))) {
                        break;
                    }
                }
            } else {
                $bool = false;
            }
        } else {
            $bool = false;
        }
    }
    return $bool;
}

function crud_add_asistencia($args)
{
    $query = function ($link, $args) {
        $sql = "INSERT INTO asistencia VALUES(NULL,?,?,?)";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"sss",$args[0],$args[1],$args[2]);
            $bool = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            $bool = false;
        }
        return $bool;
    };
    return execute_query($query, $args);
}

function crud_get_sesion_fecha_tutoria($args)
{
    $query = function ($link,$args) {
        $sql = "SELECT * FROM sesion WHERE fecha = ? AND tutoria = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"ss",$args[0],$args[1]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$id,$fecha,$lugar,$contenidos,$observaciones,$tutoria);
            mysqli_stmt_fetch($stmt);
            if (!is_null($id)) {
                if ($tutoria = crud_get_tutoria_id(array($tutoria))) {
                    $sesion = new Session($id,$fecha,$lugar,$contenidos,$observaciones,$tutoria);
                }
            } else {
                $sesion = false;
            }
            mysqli_stmt_close($stmt);
        } else {
            $sesion = false;
        }
        return $sesion;
    };
    return execute_query($query,$args);
}

function crud_get_asistencia_sesion($args)
{
    $query = function ($link,$args) {
        $list = array();
        $sql = "SELECT * FROM asistencia WHERE sesion = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$args[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$id,$estudiante,$presente,$sesion);
            while (mysqli_stmt_fetch($stmt)) {
                if ($estudiante = crud_get_estudiante_rut(array($estudiante))) {
                    if ($sesion = crud_get_sesion_id(array($sesion))) {
                        array_push($list, new Asistencia($id,$estudiante,$presente,$sesion));
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $list;
    };
    return (new jsonList(execute_query($query,$args)));
}

function crud_update_sesion($args)
{
    $query = function ($link,$args) {
        $sql = "UPDATE sesion SET lugar = ?, contenidos = ?, observaciones = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($link,$sql)) {
            mysqli_stmt_bind_param($stmt,"ssss",$args[1],$args[2],$args[4],$args[0]);
            $bool = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        else {
            $bool = false;
        }
        return $bool;
    };
    if ($bool = execute_query($query,$args)) {
        if ($args[3] != "") {
            $estudiantes = split(",", $args[3]);
        } else {
            $estudiantes = array();
        }
        $query = function ($link,$args) {
            $sql = "UPDATE asistencia SET presente = ? WHERE sesion = ? AND estudiante = ?";
            if ($stmt = mysqli_prepare($link,$sql)) {
                mysqli_stmt_bind_param($stmt,"sss",$args[0],$args[1],$args[2]);
                $bool = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            else {
                $bool = false;
            }
            return $bool;
        };
        for ($i=0; $i < count($estudiantes); $i++) { 
            $estudiante = split("-", $estudiantes[$i]);
            if ($estudiante[1] == "true") {
                $estudiante[1] = '1';
            } else {
                $estudiante[1] = '0';
            }
            if (!($bool = execute_query($query,array($estudiante[1],$args[0],$estudiante[0])))) {
                break;
            }
        }
    }
    return $bool;
}

?>