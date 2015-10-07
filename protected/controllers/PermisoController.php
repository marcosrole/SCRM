<?php

class PermisoController extends Controller
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

	public function actionList()
	{            
            $permiso = new Permiso();                       
            $datos = $permiso->search(); 
            $this->render('view', array(
                'datos'=>$datos,
                'permiso' => $permiso,                
            ));
	}
        public function actionListByUsr($id_usr)
	{            
            $permiso = new Permiso();          
            $datos = $permiso->search();
            
            $permisoDelUsuario=$permiso->findAllByAttributes(array('id_usr'=>$id_usr));
            $datos->setData($permisoDelUsuario);
            
            $this->render('view', array(
                'datos'=>$datos,
                'permiso' => $permiso,                
            ));
	}
}
