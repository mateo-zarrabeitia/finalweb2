<?php

class ReseniaModel {

    $private $db;

    function __construct(){
        $this-db = new PDO('mysql:host=localhost;'.'dbname=db_teneloya; charset=utf8','root','');

    }

    function usuario_resenia_empresa($id_empresa,$id_usuario){
        $sentencia = $this->db->prepare('SELECT * FROM VALORACION WHERE id_usuario = ? AND id_empresa = ?');
        $sentencia->execute(array($id_usuario,$id_empresa));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    function usuario_compro($id_empresa, $id_usuario){
        $sentencia = $this->db->prepare('SELECT * FROM PEDIDO WHERE id_usuario = ? AND id_empresa = ? LIMIT 1');
        $sentencia->execute(array($id_usuario,$id_empresa));
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    
    function guardarResenia($id_empresa, $id_usuario,$valoracion,$resenia,$inadecuada){
        $sentencia = $this->db->prepare('INSERT INTO VALORACION (id_empresa,id_usuario,valoracion,resena,inadecuada) VALUES (?,?,?,?,?) ');
        $sentencia->execute(array($id_usuario,$id_empresa,$valoracion,$resenia,$inadecuada));
        return $this->db->lastInsertId();
    }


    function getResumenResenias(){
        //NO ESTOY SEGURO SI LA CONSULTA ESTA CORRECTA
        $sentencia = $this->db->prepare('SELECT u.nombre , SUM (v.id) as total_resenias,
        SUM (inadecuadas) as inadecuadas, v.id_usuario
        FROM VALORACION v JOIN USUARIO u ON v.id_usuario = u.id
        GROUP BY u.id');
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    function getReseniasInadecuadasUsuario($id_usuario){
        $sentencia = $this->db->prepare('SELECT e.nombre, v.valoracion, v.resena
        FROM VALORACION v JOIN USUARIO u ON v.id_usuario = u.id
        JOIN EMPRESA e ON v.id_empresa = e.id
        WHERE inadecuada = true AND v.id_usuario = ? ');
        $sentencia->execute(array($id_usuario));
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }


    }

}

?>