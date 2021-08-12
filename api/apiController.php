<?php

class ApiReseniaController{

    // A. SE DEBERIA CREAR EL ROUTER API , Y LUEGO LOS METODOS EN EL MODELO PARA 
    //    PODER REALIZAR LO QUE LA API REQUIERE Y LOS METODOS DEL CONTROLADOR DE LA API

    // B. www.localhost.com/api/resenias
    //
    //    I. $router->addRoute('resenias','GET', 'ApiReseniaController', 'insertarReseniaEmpresa')
    //    II. $router->addRoute('resenias/:ID', 'PUT', 'ApiReseniaController' , 'editarResenia') 
    //    III. $router->addRoute('resenias', 'POST', 'ApiReseniaController', 'agregarResenia')   
    //    III. $router->addRoute('resenias/:ID', 'DELETE' , 'ApiReseniaController' ,'eliminarResenia')
    
    
    
    function $__construct(){
        $this->view = new ApiView();
        $this->model = new ReseniaModel();
    }

    function getReseniasEmpresa($params = null){
        $id_empresa = $params['id_empresa'];
        $resenias = $this->model->getReseniasEmpresa($id_empresa);
        $this->view->response($resenias,200);
    }

    function insertarReseniaEmpresa($params = null){
        $id_empresa = $params['id_empresa'];
        $body = json_decode(file_get_contents('php://input'));

        if ($body->valoracion >0 && $body->valoracion <=5 ) {
            $resultado = $this->model->insertarResenia($id_empresa,$body->id_usuario,$body->valoracion, $body->resenia,$body->inadecuada)

              if (!empty($resultado)) {
                     $this->view->response("La resenia se ha guardado con exito",201); 
               } else {
                     $this->view->response("La resenia no se ha podido guardar",404); 
               }
        } else {
            $this->view->response("La valoracion debe ser entre 1 y 5",404); 

        }
        
    }


}

?>