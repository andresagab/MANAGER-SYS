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
 * idMenu de la clase Opcion:
 *
 * Define las propiedades id, nombre, descripcion, ruta, idSi, idMenu, fechaRegistro.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Opcion{

    private $id;
    private $nombre;
    private $descripcion;
    private $ruta;
    private $path;
    private $controll;
    private $idSi;
    private $idMenu;
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
                    $sql="select id, nombre, descripcion, ruta, path, controll, idSi, idMenu, fechaRegistro from {$P}opcion where $field=$value $filter $order";
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
    	$this->idSi=$arreglo['idsi'];
    	$this->idMenu=$arreglo['idmenu'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * @param mixed $ruta
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getControll()
    {
        return $this->controll;
    }

    /**
     * @param mixed $controll
     */
    public function setControll($controll)
    {
        $this->controll = $controll;
    }

    /**
     * @return mixed
     */
    public function getIdSi()
    {
        return $this->idSi;
    }

    /**
     * @param mixed $idSi
     */
    public function setIdSi($idSi)
    {
        $this->idSi = $idSi;
    }

    /**
     * @return mixed
     */
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    /**
     * @param mixed $idMenu
     */
    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;
    }

    /**
     * @return mixed
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * @param mixed $fechaRegistro
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getSI(){
        if ($this->idSi!=null) return new SI('id', $this->idSi, null, null);
        else return new SI(null, null, null, null);
    }

    public function getMenu(){
        if ($this->idMenu!=null) return new Opcion('id', $this->idMenu, null, null);
        else return new Opcion(null, null, null, null);
    }

    public function add() {
        global $P, $BD;
        $sql="insert into {$P}opcion (nombre, descripcion, ruta, path, controll, idSi, idMenu, fechaRegistro) values ('$this->nombre', '$this->descripcion', '$this->ruta', '$this->path', '$this->controll', $this->idSi, $this->idMenu, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function update() {
        global $P, $BD;
        $sql="update {$P}opcion set nombre='$this->nombre', descripcion='$this->descripcion', ruta='$this->ruta', path='$this->path', controll='$this->controll', idSi=$this->idSi, idMenu=$this->idMenu where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function delete() {
        global $P, $BD;
        $sql="delete from {$P}opcion where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getList($filter, $order) {
        global $P, $BD;
        if ($filter!=null) $filter=" where $filter";
        $sql="select id, nombre, descripcion, ruta, path, controll, idSi, idMenu, fechaRegistro from {$P}opcion $filter $order";
        return Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getListInObjects($filter, $order) {
        $data= Opcion::getList($filter, $order);
        $objects=array();
        for ($i = 0; $i < count($data); $i++) {
            $objects[$i]=new Opcion($data[$i], null, null, null);
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
            if ($value!=null) $object=new Opcion($field, $value, $filter, $order);
            else $object=new Opcion(null, null, $filter, $order);
            $JSON=array();
            foreach ($object as $key => $value) $JSON["$key"]=$value;
        } else {
            $data= Opcion::getListInObjects($filter, $order);
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