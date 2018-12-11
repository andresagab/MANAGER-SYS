<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a KODE colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */

/**
 * idOpcion de la clase PerfilAcceso:
 *
 * Define las propiedades id, idPerfil, idOpcion, fechaRegistro.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class PerfilAcceso{

    private $id;
    private $idPerfil;
    private $idOpcion;
    private $fechaRegistro;

    function __construct($field, $value, $filter, $order){
        global $BD, $P, $controller;
    	if ($field!=null) {
            if (is_array($field)){
                foreach ($field as $key => $value) $this->$key=$value;
                if ($controller!=null){
                    if (strtolower($controller)=="pgsql") $this->cargarAtributos($field);
                }
            } else {
                if ($value!=null){
                    $sql="select id, idPerfil, idOpcion, fechaRegistro from {$P}perfilacceso where $field=$value $filter $order";
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
    	$this->idPerfil=$arreglo['idperfil'];
    	$this->idOpcion=$arreglo['idopcion'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdPerfil(){
        return $this->idPerfil;
    }

    /**
     * @param mixed $idPerfil
     */
    public function setIdPerfil($idPerfil){
        $this->idPerfil = $idPerfil;
    }

    /**
     * @return mixed
     */
    public function getIdOpcion(){
        return $this->idOpcion;
    }

    /**
     * @param mixed $idOpcion
     */
    public function setIdOpcion($idOpcion){
        $this->idOpcion = $idOpcion;
    }

    /**
     * @return mixed
     */
    public function getFechaRegistro(){
        return $this->fechaRegistro;
    }

    /**
     * @param mixed $fechaRegistro
     */
    public function setFechaRegistro($fechaRegistro){
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getPerfil(){
        if ($this->idPerfil!=null) return new Perfil('id', $this->idPerfil, null, null);
        else return new Perfil(null, null, null, null);
    }

    public function getOpcion(){
        if ($this->idOpcion!=null) return new Opcion('id', $this->idOpcion, null, null);
        else return new Opcion(null, null, null, null);
    }

    public function add() {
        global $P, $BD;
        $sql="insert into {$P}perfilacceso (idPerfil, idOpcion, fechaRegistro) values ($this->idPerfil, $this->idOpcion, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function update() {
        global $P, $BD;
        $sql="update {$P}perfilacceso set idPerfil=$this->idPerfil, idOpcion=$this->idOpcion where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function delete() {
        global $P, $BD;
        $sql="delete from {$P}perfilacceso where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getList($filter, $order) {
        global $P, $BD;
        if ($filter!=null) $filter=" where $filter";
        $sql="select id, idPerfil, idOpcion, fechaRegistro from {$P}perfilacceso $filter $order";
        return Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getListInObjects($filter, $order) {
        $data= PerfilAcceso::getList($filter, $order);
        $objects=array();
        for ($i = 0; $i < count($data); $i++) {
            $objects[$i]=new PerfilAcceso($data[$i], null, null, null);
        }
        return $objects;
    }
    
    public static function getDataJSON($type, $field, $value, $filter, $order, $extras) {
        /*
         * $type=true => se interpreta que el cliente esta solicitando solo
         * un objeto de esta clase en formato JSON para ello se tienen encuenta
         * todos los parametros.
         * 
         * $type=false => se interpreta que el perfil esta solicitando todos 
         * los objetos de esta clase en formato JSON, para ello se tienen encuenta
         * los parametros $filter y $order.
         */
        $JSON=array();
        if ($type){
            if ($value!=null) $object=new PerfilAcceso($field, $value, $filter, $order);
            else $object=new PerfilAcceso(null, null, $filter, $order);
            $JSON=array();
            foreach ($object as $key => $value) $JSON["$key"]=$value;
        } else {
            $data= PerfilAcceso::getListInObjects($filter, $order);
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