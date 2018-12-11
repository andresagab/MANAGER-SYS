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
 * idMenu de la clase Pais:
 *
 * Define las propiedades codigo, nombre, fechaRegistro.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Preferencia{

    private $id;
    private $usuario;
    private $data;
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
                    $sql="select id, usuario, data, fechaRegistro from {$P}preferencia where $field=$value $filter $order";
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
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
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

    public function getObjectUsuario(){
        if ($this->usuario!=null) return new Usuario('usuario', "'$this->usuario'", null, null);
        else return new Usuario(null, null, null, null);
    }

    public function add() {
        global $P, $BD;
        $sql="insert into {$P}preferencia (usuario, data, fechaRegistro) values ('$this->usuario', '$this->data', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function update() {
        global $P, $BD;
        $sql="update {$P}preferencia set usuario='$this->usuario', data='$this->data' where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function delete() {
        global $P, $BD;
        $sql="delete from {$P}preferencia where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getList($filter, $order) {
        global $P, $BD;
        if ($filter!=null) $filter=" where $filter";
        $sql="select id, usuario, data, fechaRegistro from {$P}preferencia $filter $order";
        return Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getListInObjects($filter, $order) {
        $data= Preferencia::getList($filter, $order);
        $objects=array();
        for ($i = 0; $i < count($data); $i++) {
            $objects[$i]=new Preferencia($data[$i], null, null, null);
        }
        return $objects;
    }
    
    public static function getDataJSON($type, $field, $value, $filter, $order, $extra) {
        /*
         * $type=true => se interpreta que el cliente esta solicitando solo
         * un objeto de esta clase en formato JSON para ello se tienen encuenta
         * todos los parametros.
         * 
         * $type=false => se interpreta que el cliente esta solicitando todos
         * los objetos de esta clase en formato JSON, para ello se tienen encuenta
         * los parametros $filter y $order.
         *
         */
        $JSON=array();
        if ($type){
            if ($field!=null & $value!=null) $object=new Preferencia($field, $value, $filter, $order);
            else $object=new Preferencia(null, null, $filter, $order);
            $JSON=array();
            foreach ($object as $key => $value) $JSON["$key"]=$value;
            if ($extra) $JSON["objectUsuario"]=json_encode(Usuario::getDataJSON(true, 'usuario', "'{$object->getUsuario()}'", null, null));
        } else {
            $data= Preferencia::getListInObjects($filter, $order);
            for ($i = 0; $i < count($data); $i++) {
                $object=$data[$i];
                $array=array();
                foreach ($object as $key => $value) $array["$key"]=$value;
                if ($extra) $array["objectUsuario"]=json_encode(Usuario::getDataJSON(true, 'usuario', "'{$object->getUsuario()}'", null, null));
                array_push($JSON, $array);
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}