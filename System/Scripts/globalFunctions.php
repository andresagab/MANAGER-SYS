<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 15/03/2018
 * Time: 01:31
 */

header("Access-control-Allow-Origin: *");
header("Access-control-Allow-Methods: GET, POST");
header("Access-control-Allow-Headers: X-Requested-with");
header("Content-type: text/html; charset=utf-8");

date_default_timezone_set("America/Bogota");

function validValue($value){
    $valid = false;
    if ($value!=null && $value!='' && $value!=' ') $valid = true;
    return $valid;
}

function parseDataHttpRequest(){
    return json_decode(file_get_contents("php://input"));
}

function getNowDate($date, $hour){
    if ($date){
        if ($hour) return date('Y-m-d H:i:s');
        else return date('Y-m-d');
    } else {
        //if ($hour) return date('Y-m-d H:i:s');
        if ($hour) return date('H:i:s');
        else return date('Y-m-d');
    }
}

function validAdd($identifier, $table, $field, $value, $filter, $order, $P, $BD){
    global $P, $BD;
    $valid = false;
    if ($value!=null) $condition = "where $field=$value";
    else $condition = '';
    if ($filter!=null) {
        if ($condition!=null) $filter=" and $filter";
        else $filter="where $filter";
    }
    $sql = "select $identifier as result from {$P}$table $condition $filter $order";
    $result = Conector::ejecutarQuery($sql, $BD);
    if ($result!=null){
        if ($result[0]['result']!=null) $valid = true;
    }
    return $valid;
}

function parseResultCrud($message, $json){
    $array=array();
    $array['message'] = $message;
    $array['data'] = json_decode($json);
    return json_encode($array, JSON_UNESCAPED_UNICODE);
}