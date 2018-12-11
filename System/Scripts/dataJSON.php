<?php
/**
 * Created by PhpStorm.
 * User: Andres Geovanny Angulo Botina
 * Date: 15/03/2018
 * Time: 01:23
 *
 * value of request http response
 *
 * UR => UNKNOW REQUEST
 * ID => INCOMPLETE DATA
 * NR => NO REQUEST
 * [] => JSON NULL
 *
 */

date_default_timezone_set("America/Bogota");
require_once dirname(__FILE__) . "/../Tools/Conector.php";
require_once dirname(__FILE__) . "/../Tools/Tool.php";
require_once dirname(__FILE__) . "/../Class/Pais.php";
require_once dirname(__FILE__) . "/../Class/Departamento.php";
require_once dirname(__FILE__) . "/../Class/Persona.php";
require_once dirname(__FILE__) . "/../Class/Perfil.php";
require_once dirname(__FILE__) . "/../Class/Opcion.php";
require_once dirname(__FILE__) . "/../Class/PerfilAcceso.php";
require_once dirname(__FILE__) . "/../Class/Empresa.php";
@require_once dirname(__FILE__) . "/../Class/Usuario.php";
@require_once dirname(__FILE__) . "/../Class/Preferencia.php";

include_once dirname(__FILE__) . "/globalFunctions.php";

global $P, $BD, $controller;
$controller = Tool::getControllerBD();

foreach ($_POST as $key => $val) ${$key}=$val;
foreach ($_GET as $key => $val) ${$key}=$val;
if (isset($metod)){
    switch ($metod){
        case 'logIn':
            foreach (parseDataHttpRequest() as $key => $val) ${$key}=$val;
            if (isset($usuario) && isset($clave)) echo Usuario::validLogIn($usuario, $clave, true);
            else echo 'ID';
            break;
        case 'getAccesos':
            if (isset($idPerfil)){
                echo Opcion::getDataJSON(false, null, null, "id in (select idopcion from {$P}perfilacceso where idperfil=$idPerfil)", null, false);
            } else echo '[]';
            break;
        case 'getPreferencias':
            if (isset($usuario)) echo Preferencia::getDataJSON(true, "usuario", "'$usuario'", null, null, false);
            else echo '[]';
            break;
        case 'getPaisesJSON':
            echo Pais::getDataJSON(false, null, null, null, 'order by nombre asc', false);
            break;
        case 'getPaisJSON':
            echo Pais::getDataJSON(true, 'codigo', $code, null, null, false);
            break;
        case 'getDepartamentosPaisJSON':
            echo Departamento::getDataJSON(false, null, null, "codPais=$codePais", null, false);
            break;
        default:
            echo 'UR';
            break;
    }
} else echo 'NR';