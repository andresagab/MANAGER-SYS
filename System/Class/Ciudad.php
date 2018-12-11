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
 * idMenu de la clase Ciudad:
 *
 * Define las propiedades codigo, codDepartamento, nombre, fechaRegistro.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Ciudad{

    private $codigo;
    private $codDepartamento;
    private $nombre;
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
                    $sql="select codigo, codDepartamento, nombre, fechaRegistro from {$P}ciudad where $field=$value $filter $order";
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
    	$this->codDepartamento=$arreglo['coddepartamento'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getCodDepartamento()
    {
        return $this->codDepartamento;
    }

    /**
     * @param mixed $codDepartamento
     */
    public function setCodDepartamento($codDepartamento)
    {
        $this->codDepartamento = $codDepartamento;
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

    public function getDepartamento(){
        if ($this->codDepartamento!=null) return new Departamento('codigo', $this->codDepartamento, null, null);
        else return new Departamento(null, null, null, null);
    }

    public function add() {
        global $P, $BD;
        $sql="insert into {$P}ciudad (codigo, codDepartamento, nombre, fechaRegistro) values ($this->codigo, $this->codDepartamento, '$this->nombre', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function update($pastCode) {
        global $P, $BD;
        $sql="insert into {$P}ciudad set codigo=$this->codigo, codDepartamento=$this->codDepartamento, nombre='$this->nombre' where codigo=$pastCode";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function delete() {
        global $P, $BD;
        $sql="delete from {$P}ciudad where codigo=$this->c";
        Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getList($filter, $order) {
        global $P, $BD;
        if ($filter!=null) $filter=" where $filter";
        $sql="select codigo, codDepartamento, nombre, fechaRegistro from {$P}ciudad $filter $order";
        return Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getListInObjects($filter, $order) {
        $data= Ciudad::getList($filter, $order);
        $objects=array();
        for ($i = 0; $i < count($data); $i++) {
            $objects[$i]=new Ciudad($data[$i], null, null, null);
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
            if ($value!=null) $object=new Ciudad($field, $value, $filter, $order);
            else $object=new Ciudad(null, null, $filter, $order);
            $JSON=array();
            foreach ($object as $key => $value) $JSON["$key"]=$value;
        } else {
            $data= Ciudad::getListInObjects($filter, $order);
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