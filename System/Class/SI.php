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
 * idMenu de la clase Si:
 *
 * Define las propiedades id, nombre, descripcion, version, autor, scriptBd, bd, prefijo, idioma, fechaRegistro.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class SI{

    private $id;
    private $nombre;
    private $descripcion;
    private $version;
    private $autor;
    private $scriptBD;
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
                    $sql="select id, nombre, descripcion, version, autor, scriptBD, fechaRegistro from {$P}si where $field=$value $filter $order";
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
    	$this->scriptBD=$arreglo['scriptbd'];
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
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
    }

    /**
     * @return mixed
     */
    public function getScriptBD()
    {
        return $this->scriptBD;
    }

    /**
     * @param mixed $scriptBD
     */
    public function setScriptBD($scriptBD)
    {
        $this->scriptBD = $scriptBD;
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

    public function add() {
        global $P, $BD;
        $sql="insert into {$P}si (nombre, descripcion, version, autor, scriptBD, fechaRegistro) values ('$this->nombre', '$this->descripcion', $this->version, '$this->autor', '$this->scriptBD', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function update() {
        global $P, $BD;
        $sql="update {$P}si set nombre='$this->nombre', descripcion='$this->descripcion', version=$this->version, autor='$this->autor', scriptBD='$this->scriptBD' where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function delete() {
        global $P, $BD;
        $sql="delete from {$P}si where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getList($filter, $order) {
        global $P, $BD;
        if ($filter!=null) $filter=" where $filter";
        $sql="select id, nombre, descripcion, version, autor, scriptBD, fechaRegistro from {$P}si $filter $order";
        return Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getListInObjects($filter, $order) {
        $data= SI::getList($filter, $order);
        $objects=array();
        for ($i = 0; $i < count($data); $i++) {
            $objects[$i]=new SI($data[$i], null, null, null);
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
            if ($value!=null) $object=new SI($field, $value, $filter, $order);
            else $object=new SI(null, null, $filter, $order);
            $JSON=array();
            foreach ($object as $key => $value) $JSON["$key"]=$value;
        } else {
            $data= Si::getListInObjects($filter, $order);
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