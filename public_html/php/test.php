<pre>
<?php
include_once 'conf.php';
include_once 'response.class.php';
include_once 'error.class.php';
include_once 'user.class.php';
include_once 'list.class.php';
include_once 'tutoria.class.php';
include_once 'session.class.php';
require_once 'crud.php';

var_dump(crud_get_session_tutoria(["BACH1107-1"]));

?>
</pre>
