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
 * idMenu de la clase Empresa:
 *
 * Define las propiedades id, nombre, descripcion, version, autor, scriptBd, bd, prefijo, idioma, fechaRegistro.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Empresa{

    private $id;
    private $codCiudad;
    private $nit;
    private $razonSocial;
    private $direccion;
    private $url;
    private $email;
    private $bd;
    private $prefijo;
    private $idIdioma;
    private $nivelAuditoria;
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
                    $sql="select id, codCiudad, nit, razonSocial, direccion, url, email, bd, prefijo, ididioma, nivelAuditoria, fechaRegistro from {$P}empresa where $field=$value $filter $order";
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
    	$this->codCiudad=$arreglo['codciudad'];
    	$this->razonSocial=$arreglo['razonsocial'];
    	$this->nivelAuditoria=$arreglo['nivelauditoria'];
    	$this->idIdioma=$arreglo['ididioma'];
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
    public function getCodCiudad()
    {
        return $this->codCiudad;
    }

    /**
     * @param mixed $codCiudad
     */
    public function setCodCiudad($codCiudad)
    {
        $this->codCiudad = $codCiudad;
    }

    /**
     * @return mixed
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @param mixed $nit
     */
    public function setNit($nit)
    {
        $this->nit = $nit;
    }

    /**
     * @return mixed
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * @param mixed $razonSocial
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getBd()
    {
        return $this->bd;
    }

    /**
     * @param mixed $bd
     */
    public function setBd($bd)
    {
        $this->bd = $bd;
    }

    /**
     * @return mixed
     */
    public function getPrefijo()
    {
        return $this->prefijo;
    }

    /**
     * @param mixed $prefijo
     */
    public function setPrefijo($prefijo)
    {
        $this->prefijo = $prefijo;
    }

    /**
     * @return mixed
     */
    public function getIdIdioma()
    {
        return $this->idioma;
    }

    /**
     * @param mixed $ididioma
     */
    public function setIdIdioma($ididioma)
    {
        $this->idIdioma = $ididioma;
    }

    /**
     * @return mixed
     */
    public function getNivelAuditoria()
    {
        return $this->nivelAuditoria;
    }

    /**
     * @param mixed $nivelAuditoria
     */
    public function setNivelAuditoria($nivelAuditoria)
    {
        $this->nivelAuditoria = $nivelAuditoria;
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
        $sql="insert into {$P}empresa (codCiudad, nit, razonSocial, direccion, url, email, bd, prefijo, ididioma, nivelAuditoria, fechaRegistro) values ($this->codCiudad, '$this->nit', '$this->razonSocial', '$this->direccion', '$this->url', '$this->email', '$this->bd', '$this->prefijo', $this->idIdioma, '$this->nivelAuditoria', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function update() {
        global $P, $BD;
        $sql="insert into {$P}empresa set codCiudad=$this->codCiudad, nit='$this->nit', razonSocial='$this->razonSocial', direccion='$this->direccion', url='$this->url', email='$this->email', bd='$this->bd', prefijo='$this->prefijo', ididioma=$this->ididioma, nivelAuditoria='$this->nivelAuditoria' where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function delete() {
        global $P, $BD;
        $sql="delete from {$P}empresa where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getList($filter, $order) {
        global $P, $BD;
        if ($filter!=null) $filter=" where $filter";
        $sql="select id, codCiudad, nit, razonSocial, direccion, url, email, bd, prefijo, ididioma, nivelAuditoria, fechaRegistro from {$P}empresa $filter $order";
        return Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getListInObjects($filter, $order) {
        $data= Empresa::getList($filter, $order);
        $objects=array();
        for ($i = 0; $i < count($data); $i++) {
            $objects[$i]=new Empresa($data[$i], null, null, null);
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
            if ($value!=null) $object=new Empresa($field, $value, $filter, $order);
            else $object=new Empresa(null, null, $filter, $order);
            $JSON=array();
            foreach ($object as $key => $value) $JSON["$key"]=$value;
        } else {
            $data= Empresa::getListInObjects($filter, $order);
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