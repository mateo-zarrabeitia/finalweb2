<?php


class EmpresaController {

    $private $view;
    $private $model;

    function __construct() {
        $this->view = new EmpresaView();
        $this->model = new EmpresaModel();
    }

    private function chequearLogueo(){
        session_start();
        if (!isset($_SESSION["EMAIL"])) {
            header("Location: ". LOGOUT);
            die();
        }
    }

    function marcarPremium() {
        //CHEQUEO QUE EL USUARIO ESTE LOGUEADO
        $this->chequearLogueo();

        if ($_SESSION['IS_ADMIN'] == true && $_POST['valoracion'] >=0) {
           
            $valoraciones = $this->model->getValoracionesPromedio();
           
            foreach ($valoraciones as $valoracion) {
               if ($valoracion->promedio > $_POST['valoracion']) {
                   $this->model->setEmpresaPremium($valoracion->id_empresa);
               }
            }
        }
     

    }



}



?>