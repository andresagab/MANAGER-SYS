<?php
date_default_timezone_set('America/Bogota');
require_once dirname(__FILE__).'/./Conector.php';
require_once dirname(__FILE__).'/../Clases/Usuario.php';
$P='';
$BD='panam';
$usuario=$_POST['usuario'];
$clave=$_POST['clave'];
if (Usuario::validar($usuario, $clave)){
    session_start();
    $usuario=new Usuario('usuario', "'$usuario'", null, null);
    $_SESSION['usuario']= serialize($usuario);
    header('Location: ../../principal.php?CON=system/Pages/inicio.php');
} else {
    $mensaje='Este usuario esta bloqueado o el nombre y/o contraseña son incorrectos';
    header("Location: ../../index.php?mjs=$mensaje");
}
