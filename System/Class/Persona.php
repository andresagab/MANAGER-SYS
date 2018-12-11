<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 10/12/2018
 * Time: 13:08
 */

/*
 *
 * Todos los derechos de este archivo pertenecen a KODE colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */

/**
 * Descripcion de la clase Persona:
 *
 * Define las propiedades nombres, apellidos, telefono, email, fechaNacimiento.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Persona {

    private $id;
    private $nombres;
    private $apellidos;
    private $telefono;
    private $email;
    private $fechaNacimiento;
    private $fechaRegistro;

    function __construct($campo, $valor, $filtro, $orden){
        global $BD, $P, $controller;
        if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                if ($controller!=null){
                    if (strtolower($controller)=="pgsql") $this->cargarAtributos($campo);
                }
            } else {
                if ($valor!=null){
                    $sql="select id, nombres, apellidos, telefono, email, fechaNacimiento, fechaRegistro from {$P}persona where $campo=$valor $filtro $orden";
                    $resultado=Conector::ejecutarQuery($sql, $BD);
                    if (count($resultado)>0) {
                        foreach ($resultado[0] as $key => $value) $this->$key=$value;
                        if (strtolower($controller)=="pgsql") $this->cargarAtributos($resultado[0]);
                    }
                } else return null;
            }
        } else return null;
    }

    private function cargarAtributos($arreglo){
        $this->fechaNacimiento=$arreglo['fechanacimiento'];
        $this->fechaRegistro=$arreglo['fecharegistro'];
    }

    function getId() {
        return $this->id;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getEmail() {
        return $this->email;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function add() {
        global $P, $BD;
        $sql="insert into {$P}persona (nombres, apellidos, telefono, email, fechaNacimiento, fechaRegistro) values ('$this->nombres', '$this->apellidos', '$this->telefono', '$this->email', '$this->fechaNacimiento', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, $BD);
        $this->id= Tool::getMaxIdFromTable('persona', null, null);
    }

    public function update() {
        global $P, $BD;
        $sql="update {$P}persona set nombres='$this->nombres', apellidos='$this->apellidos', telefono='$this->telefono', email='$this->email', fechaNacimiento='$this->fechaNacimiento' where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function delete() {
        global $P, $BD;
        $sql="delete from {$P}persona where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }

    public static function getList($filter, $order) {
        global $P, $BD;
        if ($filter!=null) $filter=" where $filter";
        $sql="select id, nombres, apellidos, telefono, email, fechaNacimiento, fechaRegistro from {$P}persona $filter $order";
        return Conector::ejecutarQuery($sql, $BD);
    }

    public static function getListInObjects($filter, $order) {
        $data= Persona::getList($filter, $order);
        $objects=array();
        for ($i = 0; $i < count($data); $i++) {
            $objects[$i]=new Persona($data[$i], null, null, null);
        }
        return $objects;
    }

    public static function getDataJSON($type, $campo, $value, $filter, $order, $extras) {
        /*
         * $type=true => se interpreta que el usuario esta solicitando solo
         * un objeto de esta clase en formato JSON para ello se tienen encuenta
         * todos los parametros.
         *
         * $type=false => se interpreta que el usuario esta solicitando todos
         * los objetos de esta clase en formato JSON, para ello se tienen encuenta
         * los parametros $filter y $order.
         */
        $JSON=array();
        if ($type){
            if ($value!=null) $object=new Persona($campo, $value, $filter, $order);
            else $object=new Persona (null, null, $filter, $order);
            $JSON=array();
            foreach ($object as $key => $value) $JSON["$key"]=$value;
        } else {
            $data= Persona::getListInObjects($filter, $order);
            for ($i = 0; $i < count($data); $i++) {
                $object=$data[$i];
                $array=array();
                foreach ($object as $key => $value) $array["$key"]=$value;
                array_push($JSON, $array);
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

}