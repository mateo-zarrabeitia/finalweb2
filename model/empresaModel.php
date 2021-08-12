<?php

class EmpresaModel {

    $private $db;

    function __construct(){
        $this-db = new PDO('mysql:host=localhost;'.'dbname=db_teneloya; charset=utf8','root','');

    }

    function getValoracionesPromedio(){
        $sentencia = $this->db->prepare('SELECT *, AVG(valoracion) AS promedio FROM VALORACION GROUP BY id_empresa');
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    
    function setEmpresaPremium($id_empresa){
        $sentencia = $this->db->prepare('UPDATE EMPRESA SET premium = true WHERE id_empresa');
        $sentencia->execute(array($id_empresa));
        return $this->db->lastInsertId();
    }

}

?>