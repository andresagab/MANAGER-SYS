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
 * Descripcion de la clase Perfil:
 *
 * Define las propiedades id, nombre, descripcion, fechaRegistro.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Perfil{

    private $id;
    private $nombre;
    private $descripcion;
    private $fechaRegistro;

    function __construct($camp, $value, $filter, $order){
        global $BD, $P, $controller;
    	if ($camp!=null) {
            if (is_array($camp)){
                foreach ($camp as $key => $value) $this->$key=$value;
                if ($controller!=null){
                    if (strtolower($controller)=="pgsql") $this->cargarAtributos($camp);
                }
            } else {
                if ($value!=null){
                    $sql="select id, nombre, descripcion, fechaRegistro from {$P}perfil where $camp=$value $filter $order";
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
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion(){
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
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

    public function add() {
        global $P, $BD;
        $sql="insert into {$P}perfil (nombre, descripcion, fechaRegistro) values ('$this->nombre', '$this->descripcion', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function update() {
        global $P, $BD;
        $sql="update {$P}perfil set nombre='$this->nombre', descripcion='$this->descripcion' where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }

    public function delete() {
        global $P, $BD;
        $sql="delete from {$P}perfil where id=$this->id";
        Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getList($filter, $order) {
        global $P, $BD;
        if ($filter!=null) $filter=" where $filter";
        $sql="select id, nombre, descripcion, fechaRegistro from {$P}perfil $filter $order";
        return Conector::ejecutarQuery($sql, $BD);
    }
    
    public static function getListInObjects($filter, $order) {
        $data= Perfil::getList($filter, $order);
        $objects=array();
        for ($i = 0; $i < count($data); $i++) {
            $objects[$i]=new Perfil($data[$i], null, null, null);
        }
        return $objects;
    }
    
    public static function getDataJSON($type, $field, $value, $filter, $order) {
        /*
         * $type=true => se interpreta que el perfil esta solicitando solo
         * un objeto de esta clase en formato JSON para ello se tienen encuenta
         * todos los parametros.
         * 
         * $type=false => se interpreta que el perfil esta solicitando todos 
         * los objetos de esta clase en formato JSON, para ello se tienen encuenta
         * los parametros $filter y $order.
         */
        $JSON=array();
        if ($type){
            if ($value!=null) $object=new Perfil($field, $value, $filter, $order);
            else $object=new Perfil(null, null, $filter, $order);
            $JSON=array();
            foreach ($object as $key => $value) $JSON["$key"]=$value;
        } else {
            $data= Perfil::getListInObjects($filter, $order);
            for ($i = 0; $i < count($data); $i++) {
                $object=$data[$i];
                $array=array();
                foreach ($object as $key => $value) $array["$key"]=$value;
                array_push($JSON, $array);
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public function updateAccess($options){
        global $P, $BD;
        $sql="delete from {$P}perfilAcceso where idPerfil=$this->id";
        Conector::ejecutarQuery($sql, $BD);
        for ($i=0; $i<count($options); $i++){
            $object=new PerfilAcceso(null, null, null, null);
            $object->setIdPerfil($this->id);
            $object->setIdOpcion($options[$i]);
            $object->setFechaRegistro("now()");
            $object->add();
        }
    }

    public function getAccess(){
        if ($this->id!=null){
            global $P, $BD;
            $sql="select o.id, nombre, descripcion, ruta, path, controll, idSi, idmenu, o.fechaRegistro from {$P}opcion as o, {$P}perfilAcceso as pa where o.id=idopcion and idperfil=$this->id order by idmenu";
            return Conector::ejecutarQuery($sql, $BD);
        } else return null;
    }

    public function getAccessInObjects(){
        $data=$this->getAccess();
        $objects=array();
        for ($i=0; $i<count($data); $i++){
            $objects[$i]=new Opcion($data[$i], null, null, null);
        }
        return $objects;
    }

    public function getAccessJSON(){
        $JSON=array();
        $data=$this->getAccessInObjects();
        for ($i=0; $i<count($data); $i++){
            $object=$data[$i];
            $array=array();
            foreach ($object as $key => $value) $array["$key"]=$value;
            array_push($JSON, $array);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public function getControllers(){
        $controllers='';
        if ($this->id!=null){
            $data=$this->getAccessInObjects();
            for ($i=0; $i<count($data); $i++){
                if ($data[$i]->getControll()!=null) $controllers.="<script src='Lib/Controllers/{$data[$i]->getControll()}.js'></script>\n";
            }
        }
        return $controllers;
    }

    public function getMenu($user){
        $menu=null;
        $options=$this->getAccessInObjects();
        $idMenu=0;
        $menu="";
        for ($i=0; $i<count($options); $i++){
            $option=$options[$i];
            if ($option->getIdMenu()!=$idMenu){
                if ($option->getIdMenu()!=null){
                    if ($idMenu!=0) {
                        $menu.="
                            </md-menu-content>
                                </md-menu>
                            </md-menu-bar>
                        ";
                    }
                    $menuObjectOption=$option->getMenu();
                    $menu.="
                    <md-menu-bar class='btn-block' style='text-align: -webkit-center'>
                        <md-menu>
                            <md-button ng-click=" . '$mdMenu.open()' . " class='md-accent'>
                                <span>{$menuObjectOption->getNombre()}</span>
                                <md-tooltip md-visible='false' md-direction='auto'>{$menuObjectOption->getDescripcion()}</md-tooltip>
                            </md-button>
                            <md-menu-content>
                    ";
                } else {
                    $menu.="
                        </md-menu-content>
                            </md-menu>
                        </md-menu-bar>
                    ";
                }
                $idMenu=$option->getIdMenu();
            }
            if ($option->getIdMenu()!=null && $option->getRuta()!=null && strpos($option->getPath(), ":")==null){
                $menu.="
                    <md-menu-item>
                        <md-button ng-href='#/{$option->getPath()}' class='md-primary'>
                            <span>{$option->getNombre()}</span>
                            <md-tooltip md-visible='false' md-direction='auto'>{$option->getDescripcion()}</md-tooltip>
                        </md-button>
                    </md-menu-item>
                ";
            } else {
                if ($option->getPath()!=null && strpos($option->getPath(), ":")==null){
                    $menu.="
                    <md-button ng-href='#/{$option->getPath()}' class='md-accent'>
                        <span>{$option->getNombre()}</span>
                        <md-tooltip md-visible='false' md-direction='auto'>{$option->getDescripcion()}</md-tooltip>
                    </md-button>";
                }
            }
        }
        return $menu;
    }

}