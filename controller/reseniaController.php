<?php


class ReseniaController {

    $private $view;
    $private $model;

    function __construct() {
        $this->view = new ReseniaView();
        $this->model = new ReseniaModel();
    }

    private function chequearLogueo(){
        session_start();
        if (!isset($_SESSION["EMAIL"])) {
            header("Location: ". LOGOUT);
            die();
        }
    }

    function insertarResenia() {
        //CHEQUEO QUE EL USUARIO ESTE LOGUEADO
        $this->chequearLogueo();

        //CHEQUEO QUE LOS VALORES QUE LLEGAN DEL FORM ESTEN SETEADOS Y NO ESTEN VACIOS
        if (isset($_POST['id_empresa']) && isset($_POST['id_usuario']) && isset($_POST['valoracion']) && isset($_POST['resenia']) && isset($_POST['inadecuada'])
            !empty($_POST['id_empresa']) && !empty($_POST['id_usuario']) && !empty($_POST['valoracion']) && !empty($_POST['resenia']) && !empty($_POST['inadecuada'])) {
            
                //CONSULTO SI EL USUARIO YA RESENIO LA EMPRESA
             $yaReseniado = $this->model->usuario_resenia_empresa($_POST['id_empresa'],$_POST['id_usuario']);    
                //CONSULTO SI EL USUARIO YA COMPRO EN LA EMPRESA
             $usuarioCompro = $this->model->usuario_compro($_POST['id_empresa'],$_POST['id_usuario']);  
             if (!$yaReseniado && $usuarioCompro) {
                 if ($_POST['valoracion']) > 0 && $_POST['valoracion']) <= 5) {
                    $resultado = $this->model->guardarResenia($_POST['id_empresa']),$_POST['id_usuario']),$_POST['valoracion']),$_POST['resenia']),$_POST['inadecuada']));
                     if ($resultado) {
                              $this->view->MostrarHome("La resenia se ha guardado con exito"):
                     } else {
                               $this->view->MostrarHome("La resenia no se ha podido guardar"):
                     }
                 } else {
                    $this->view->MostrarHome("Error: La valoracion debe ser del 1 al 5"):
                 }
                
             }
        }

    }


    //PUNTO 3 AUDITORIA DE RESENIAS

    function generarTablaReseniasInadecuadas(){
        $this->chequearLogueo();

        if ($_SESSION['IS_ADMIN'] == true) {

            $resenias = $this->model->getResumenResenias();
            foreach ($resenias as $resenia) {
                $resenia->resenias = $this->model->getReseniasInadecuadasUsuario($resenia->id_usuario);
            }
            $this->view->mostrarResumenResenias($resenias);
        }


    }



}



?>