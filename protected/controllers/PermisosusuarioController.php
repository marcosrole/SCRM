<?php

class PermisosusuarioController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
        public function actionCrear($name)
	{
//            ************NO FUNCIONA**************
//            AL MOMENTO DE ELIMINAR TODOS LOS PERMISOS DE UN USUARIO, NO LOS ELIMINA
        
            $permisosUsuario = new Permisosusuario();            
            $permisosDelUsuario = new Permisosusuario();
            
            $usuario = Usuario::model()->findAllByAttributes(array('name'=>$_GET['name']));            
            $permisosDelUsuario=$permisosDelUsuario->findAllByAttributes(array('id_usr'=>$usuario[0]['id']));           
            $array_prmisoDelUsuario=array();
            foreach ($permisosDelUsuario as $key=>$value){
                $array_prmisoDelUsuario[]=(int)$value{'id_per'};
            }
            
            $permisosUsuario->id_per=$array_prmisoDelUsuario;
            $permisosUsuario->id_usr=$usuario[0]['id'];
           
            $array_permisos=$permisosUsuario->getPermisos();            
            $array_usuarios=  Usuario::model()->getArrayUsuarios();
            $transaction = Yii::app()->db->beginTransaction();
            if(isset($_POST['Permisosusuario'])){                
               //Elimino todos los permisos del Usuario                                             
                $permisoUsuario = new Permisosusuario();
                foreach ($permisosDelUsuario as $key=>$value){
                    $permisoUsuario=$value;
                    $permisoUsuario->delete();
                }
               
               //Genero los nuevos permisos para el Usuario
               foreach ($_POST['Permisosusuario']['id_per'] as $key=>$value){                           
                   Permisosusuario::model()->GenerarPermiso($usuario[0]['id'], $value);
               }
               $transaction->commit();
               Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Permisos modificados con exito");                                                
               $this->redirect(Yii::app()->createUrl("permisosusuario/crear?name=" . $_GET['name']));
                
            }
            $usuario_seleccionado = $_GET['name'];            
            $this->render('view', array(
                'permisosUsuario' => $permisosUsuario,
                'array_permiso' => $array_permisos,
                'array_usuarios' => $array_usuarios,
                'usuario_seleccionado'=>$usuario_seleccionado,
            ));
	}
        
}
