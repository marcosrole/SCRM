<?php

class AsignarpermisoController extends Controller
{
	public function actionCrear($name)
	{
            
            $asignarpermiso = new Asignarpermiso();
            $permisosDelUsuario = new Asignarpermiso();
            
            $usuario = Usuario::model()->findAllByAttributes(array('name'=>$_GET['name']));            
            $permisosDelUsuario=$permisosDelUsuario->findAllByAttributes(array('id_usr'=>$usuario[0]['id']));           
            $array_prmisoDelUsuario=array();
            foreach ($permisosDelUsuario as $key=>$value){
                $array_prmisoDelUsuario[]=(int)$value{'id_per'}-1;
            }
            
            $asignarpermiso->id_per=$array_prmisoDelUsuario;
            $asignarpermiso->id_usr=$usuario[0]['id'];
           
            $array_permisos=$asignarpermiso->getPermisos();            
            $array_usuarios=  Usuario::model()->getArrayUsuarios();
            if(isset($_POST['Asignarpermiso'])){
               // $asignarpermisosa = Asignarpermiso::model()->findAllByAttributes(array('id_usr'=>$usuario[0]['id']));

//                NO FUNCIONA.... ME DA ERROR PARA INSTANCIAR LA CLASE.

                var_dump(Asignarpermiso::model()->find());
                die();
                        
//                var_dump(Asignarpermiso::model()->findAllByAttributes(array('id_usr'=>$usuario[0]['id'])));
            }
            $usuario_seleccionado = $_GET['name'];            
            $this->render('crear', array(
                'asignarpermiso' => $asignarpermiso,
                'array_permiso' => $array_permisos,
                'array_usuarios' => $array_usuarios,
                'usuario_seleccionado'=>$usuario_seleccionado,
            ));
	}
        
        public function actionVer()
	{            
            $asignarpermiso = new Asignarpermiso();                       
            $array_permisos=$asignarpermiso->getPermisos();            
            $array_usuarios=  Usuario::model()->getArrayUsuarios();
            if(isset($_POST['Asignarpermiso'])){
                var_dump($_POST['Asignarpermiso']);
            }
             
            $this->render('crear', array(
                'asignarpermiso' => $asignarpermiso,
                'array_permiso' => $array_permisos,
                'array_usuarios' => $array_usuarios,
            ));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}