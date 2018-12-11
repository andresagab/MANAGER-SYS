<?php

date_default_timezone_set('America/Bogota');

require_once dirname(__FILE__).'/./Conector.php';
require_once dirname(__FILE__).'/./Tool.php';
require_once dirname(__FILE__).'/../Class/Persona.php';
@require_once dirname(__FILE__).'/../Class/Usuario.php';

foreach ($_GET as $key => $val) ${$key}=$val;
foreach ($_POST as $key => $val) ${$key}=$val;

$P = 'sys_';
$BD = null;
$controller = Tool::getControllerBD();

session_start();
$user = new Usuario('usuario', "'$user'", null, null);
$_SESSION['USER'] = serialize($user);
header("Location: ../../home.php");
