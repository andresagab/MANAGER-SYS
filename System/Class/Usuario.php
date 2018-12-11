<?php
/**
 *
 * Created by PhpStorm.
 * User: Andres
 * Date: 10/12/2018
 * Time: 13:02
 *
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
 * Descripcion de la clase Usuario:
 *
 * Define las propiedades clave, estado, idPersona, idPerfil, idEmpresa.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Usuario extends Persona {

    private $usuario;
    private $clave;
    private $estado;
    private $idPersona;
    private $idPerfil;
    private $idEmpresa;
    private $fechaRegistro;
    
    function __construct($field, $value, $filter, $order){
        global $BD, $P, $controller;
        if ($field!=null) {
            if (is_array($field)){
                foreach ($field as $key => $value) $this->$key = $value;
                if ($controller!=null){
                    if (strtolower($controller)=="pgsql") $this->cargarAtributos($field);
                    $this->setClave($this->clave);
                    parent::__construct('id', $this->idPersona, $filter, $order);
                }
            } else {
                if ($value!=null){
                    $sql="select usuario, clave, estado, idPersona, idPerfil, idEmpresa, fechaRegistro from {$P}usuario where $field=$value $filter $order";
                    $resultado = Conector::ejecutarQuery($sql, $BD);
                    if (count($resultado)>0) {
                        foreach ($resultado[0] as $key => $value) $this->$key = $value;
                        if (strtolower($controller)=="pgsql") $this->cargarAtributos($resultado[0]);
                        parent::__construct('id', $this->idPersona, $filter, $order);
                    }
                } else return null;
            }
        } else return null;
    }

    private function cargarAtributos($arreglo){
        $this->idPersona=$arreglo['idpersona'];
        $this->idPerfil=$arreglo['idperfil'];
        $this->idEmpresa=$arreglo['idempresa'];
        $this->fechaRegistro=$arreglo['fecharegistro'];
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getClave() {
        return $this->clave;
    }

    function getEstado() {
        return $this->estado;
    }

    function getIdPersona() {
        return $this->idPersona;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }

    function getIdEmpresa() {
        return $this->idEmpresa;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setClave($clave) {
        if (strlen($clave)<=30) $clave = md5($clave);
        $this->clave = $clave;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setIdPersona($idPersona) {
        $this->idPersona = $idPersona;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function getPersona() {
        if ($this->idPersona!=null) return new Persona ('id', $this->idPersona, null, null);
        else return new Persona (null, null, null, null);
    }

    function getPerfil() {
        if ($this->idPerfil!=null) return new Perfil ('id', $this->idPerfil, null, null);
        else return new Perfil (null, null, null, null);
    }

    function getEmpresa() {
        if ($this->idEmpresa!=null) return new Empresa ('id', $this->idEmpresa, null, null);
        else return new Empresa (null, null, null, null);
    }

    public function add() {
        global $P, $BD;
        parent::add();
        $this->idPersona= parent::getId();
        $sql="insert into {$P}usuario (usuario, clave, estado, idPersona, idPerfil, idEmpresa, fechaRegistro) values ('$this->usuario', '$this->clave', $this->estado, $this->idPersona, $this->idPerfil, $this->idEmpresa, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function update($usuarioAnterior) {
        global $P, $BD;
        parent::update();
        $sql="update {$P}usuario set usuario='$this->usuario', clave='$this->clave', estado='$this->estado', idPersona='$this->idPersona', idPerfil='$this->idPerfil', idEmpresa='$this->idEmpresa' where usuario='$usuarioAnterior'";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function updatePassword(){
        global $P, $BD;
        $sql="update {$P}usuario set clave='$this->clave' where usuario='$this->usuario'";
        $r=Conector::ejecutarQuery($sql, $BD);
        if ($r!=null) return true;
        else return false;
    }

    public function delete() {
        global $P, $BD;
        $sql="delete from {$P}usuario where usuario='$this->usuario'";
        Conector::ejecutarQuery($sql, $BD);
        parent::delete();
    }

    public static function getList($filter, $order) {
        global $P, $BD;
        if ($filter!=null) $filter=" where $filter";
        $sql="select usuario, clave, estado, idPersona, idPerfil, idEmpresa, fechaRegistro from {$P}usuario $filter $order";
        return Conector::ejecutarQuery($sql, $BD);
    }

    public static function getListInObjects($filter, $order) {
        $data= Usuario::getList($filter, $order);
        $objects=array();
        for ($i = 0; $i < count($data); $i++) {
            $objects[$i]=new Usuario($data[$i], null, null, null);
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
            if ($value!=null) $object=new Usuario($campo, $value, $filter, $order);
            else $object=new Usuario (null, null, $filter, $order);
            $JSON=array();
            foreach ($object as $key => $value) $JSON["$key"]=$value;
            if ($extras) {
                $JSON['Empresa'] = json_decode(Empresa::getDataJSON(true, 'id', $object->getIdEmpresa(), null, null, true));
            }
        } else {
            $data= Usuario::getListInObjects($filter, $order);
            for ($i = 0; $i < count($data); $i++) {
                $object=$data[$i];
                $array=array();
                foreach ($object as $key => $value) $array["$key"]=$value;
                if ($extras) {
                    $JSON['Empresa'] = json_decode(Empresa::getDataJSON(true, 'id', $object->getIdEmpresa(), null, null, true));
                }
                array_push($JSON, $array);
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function validLogIn($user, $password, $json) {
        $valid=false;
        $JSON=null;
        $object=new Usuario("usuario", "'$user'", null, null);
        if ($object->getFechaRegistro()!=null){
            if ($object->getClave()== md5($password)){
                if ($json) $JSON=Tool::getLogInJSON (true, Usuario::getDataJSON (true, 'usuario', "'$user'", null, null, true), -1);
                else $valid=true;
            } else $JSON= Tool::getLogInJSON (false, Usuario::getDataJSON (true, 'usuario', "'$user'", null, null, true), 1);
        } else $JSON= Tool::getLogInJSON (false, Usuario::getDataJSON (true, null, null, null, null, true), 0);
        if ($json) return $JSON;
        else return $valid;
    }

}