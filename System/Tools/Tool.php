<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a KODE colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 * 
 * Copyright Todos los derechos reservados
 *
 */

/**
 * Description of Tool:
 * 
 * 
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 */
abstract class Tool {
    
    public static function getControllerBD(){
        $controller = 'unknow';
        $file = dirname(__FILE__) . "/configuracion.ini";
        if (file_exists($file)){
            if (!$params=parse_ini_file($file, true)){
                echo "No se pudo leer el archivo $file";
                die();
            } else $controller = $params['BaseDatos']['controlador'];
        }
        return $controller;
    }
    
    public static function getMaxIdFromTable($table, $filter, $order) {
        global $P, $BD;
        $result = null;
        if ($filter!=null) $filter = "where $filter";
        $sql = "select max(id) as result from {$P}$table $filter, $order";
        $r = Conector::ejecutarQuery($sql, $BD);
        if ($r!=null){
            if ($r[0]['result']!=null) $result = $r[0]['result'];
        }
        return $result;
    }
    
    public static function getLogInJSON($login, $user, $error) {
        /*
         * $error=0 => Ususuario incorrecto.
         * $error=1 => Password incorrecto.
         */
        $JSON=array();
        $JSON['logIn']=false;
        $JSON['user']=null;
        $JSON['preferences']=null;
        $JSON['error']= null;
        $JSON['message']=null;
        if ($login){
            $JSON['logIn']=true;
            $JSON['user']= json_decode($user);
            $JSON['preferences']= json_decode(Preferencia::getDataJSON(true, 'usuario', "'" . json_decode($user)->usuario . "'", null, null, false));
        } else {
            $JSON['user']= json_decode($user);
            //$JSON['preferences']= json_decode(Preferencia::getDataJSON(true, 'usuario', "'" . json_decode($user)->usuario . "'", null, null, false));
        }
        if ($error>=0){
            $JSON['error']= $error;
            if ($error==0) $JSON['message']="El usuario es incorrecto y/o no existe";
            else if ($error==1) $JSON['message']="la contrase&ntilde;a es incorrecta";
        } else $JSON['error']=$error;
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
}
