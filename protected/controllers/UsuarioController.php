<?php

class UsuarioController extends Controller
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$persona = new Persona();
                $usuario = new Usuario();
                $direccion = new Direccion();
                $localidad = new Localidad;  
                $inspector = new Inspector; 
                $lista_localidades=  Localidad::model()->getListNombre();
                $permisos = Permiso::model()->findAll();

                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if(isset($_POST['Direccion'])){
                    $direccion->attributes=$_POST['Direccion'];                
                    $direccion->calle=  strtoupper($_POST['Direccion']['calle']);
                    $direccion->depto=  strtoupper($_POST['Direccion']['depto']);                
                    /*FK1*/$direccion->id_loc = Localidad::model()->getId($lista_localidades[$_POST['Localidad']['id']])->id;                

                    if ($direccion->validate()){ 
                        //Me fijo si ya existe para no guardar dos veces la misma direccion;
                        $criterial = new CDbCriteria();
                        $criterial->condition="calle='" . $direccion->calle . "' ";
                        $criterial->addCondition(
                                "altura='" . $direccion->altura . "' AND" .
                                " piso='" . $direccion->piso . "' AND" .
                                " depto='" . $direccion->depto . "' AND" .
                                " id_loc='" . $direccion->id_loc . "' "
                                );                    
                        if(! (Direccion::model()->find($criterial))){//Si NO existe => GUARDO
                            $direccion->insert();
                        }                    
                        $persona->attributes=$_POST['Persona'];                                                             
                        $persona->nombre=  strtoupper($persona{'nombre'});
                        $persona->apellido=  strtoupper($persona{'apellido'});                    
                        /*FK1*/ $persona->id_dir = $direccion{'id'};

                        if($persona->validate()){
                            //Me fijo si ya existe para no guardar dos veces la misma persona;                                      
                            if(! (Persona::model()->findByAttributes(array('dni'=>$persona->dni)))){//Si NO existe => GUARDO
                                $persona->insert();
                            }                                                                                     
                            $usuario->attributes=$_POST['Usuario'];
                            /*FK1*/ $usuario->dni_per=$persona{'dni'}; 
                            $usuario->pass=  md5($_POST['Usuario']['pass']);

                            if($usuario->validate()){
                                if(!$usuario->exists("name='" . $usuario{'name'} . "' ")){
                                    $usuario->save();                            
                                    
                                    //SI permiso es 2 : Inspector                                    
                                    if ($usuario{'nivel'}==2){                                                        
                                        $inspector->matricula=$_POST['Inspector']['matricula'];                                        
                                        $inspector->id_usr=$usuario{'id'};                                            
                                        
                                        if ($inspector->validate()){
                                            $inspector->matricula=$_POST['Inspector']['matricula'];
                                            $inspector->ocupado=0;
                                            $inspector->id_usr=$usuario{'id'};                                            
                                            $inspector->insert();
                                            
                                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                            $transaction->commit();                                 
                                            //Generar los permisos por default
                                            $usuario->darPermiso($usuario{'nivel'}, $usuario{'id'});
                                            $this->redirect(Yii::app()->createUrl('usuario/view', array('id'=>$usuario{'id'})));
                                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Matricula de Inspector");}                                                                            
                                    }else{
                                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                        $transaction->commit();                                 
                                        //Generar los permisos por default
                                        $usuario->darPermiso($usuario{'nivel'}, $usuario{'id'});
                                        $this->redirect(Yii::app()->createUrl('usuario/view', array('id'=>$usuario{'id'})));
                                    }                                
                                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Ya existe usuario con el mismo nombre");}                                                                            
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}                                                
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios");}                                                
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}                        
                    }
                    }  
                    catch (Exception $ex) {
                    Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
                }

                $this->render('create',
                        array(
                            'usuario'=>$usuario,
                            'inspector'=>$inspector,
                            'persona'=>$persona,
                            'direccion'=>$direccion,
                            'localidad'=>$localidad,
                            'lista_localidades'=>$lista_localidades,
                            'update'=>false,
                            ));

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$persona = new Persona();
                $usuario = new Usuario();
                $direccion = new Direccion();
                $localidad = new Localidad;  
                $lista_localidades=  Localidad::model()->getListNombre();
                $inspector = new Inspector();
                  
                $usuario = Usuario::model()->findByAttributes(array('id'=>$id));
                $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));
                $direccion = Direccion::model()->findByAttributes(array('id'=>$persona{'id_dir'}));
                $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                $inspector = Inspector::model()->findByAttributes(array('id_usr'=>$id));
                
                if($inspector==null){ //Si no es un Inspector, genero un Model de cero, Sino quedaba en NULL
                    $inspector = new Inspector();
                }
                
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if(isset($_POST['Direccion'])){
                    $direccion->attributes=$_POST['Direccion'];                
                    $direccion->calle=  strtoupper($_POST['Direccion']['calle']);
                    $direccion->depto=  strtoupper($_POST['Direccion']['depto']);                
                    /*FK1*/$direccion->id_loc = Localidad::model()->getId($lista_localidades[$_POST['Localidad']['id']])->id;                
                    
                    if ($direccion->validate()){
                        //Me fijo si ya existe para no guardar dos veces la misma direccion;
                       
                        if( !(Direccion::model()->findByAttributes(array(
                                    'altura'=>$_POST['Direccion']['altura'],
                                    'piso'=>$_POST['Direccion']['piso'],
                                    'depto'=>$_POST['Direccion']['depto'],
                                    'id_loc'=>$direccion{'id_loc'})))){//Si NO existe => GUARDO
                            $direccion->save();
                        }                                            
                        $persona->attributes=$_POST['Persona']; 
                        $persona->nombre=  strtoupper($_POST['Persona']['nombre']);
                        $persona->apellido=  strtoupper(($_POST['Persona']['apellido']));
                        
                        if($persona->validate()){
                            //Me fijo si ya existe para no guardar dos veces la misma persona;                                      
                            if(! (Persona::model()->findByAttributes(array('dni'=>$persona->dni)))){//Si NO existe => GUARDO
                                $persona->insert();
                            }                                                                                     
                            $usuario->attributes=$_POST['Usuario'];
                            /*FK1*/ $usuario->dni_per=$persona{'dni'}; 
                            $usuario->pass=  md5($_POST['Usuario']['pass']);

                            if($usuario->validate()){
                                if(!$usuario->exists("name='" . $usuario{'name'} . "' ")){
                                    $usuario->save();                            
                                    
                                    //SI permiso es 2 : Inspector                                    
                                    if ($usuario{'nivel'}==2){                                                        
                                        $inspector->matricula=$_POST['Inspector']['matricula'];                                        
                                        $inspector->id_usr=$usuario{'id'};                                            
                                        
                                        if ($inspector->validate()){
                                            $inspector->matricula=$_POST['Inspector']['matricula'];
                                            $inspector->ocupado=0;
                                            $inspector->id_usr=$usuario{'id'};                                            
                                            $inspector->insert();
                                            
                                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                            $transaction->commit();                                 
                                            //Generar los permisos por default
                                            $usuario->darPermiso($usuario{'nivel'}, $usuario{'id'});
                                            $this->redirect(Yii::app()->createUrl('usuario/view', array('id'=>$usuario{'id'})));
                                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Matricula de Inspector");}                                                                            
                                    }else{
                                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                        $transaction->commit();                                 
                                        //Generar los permisos por default
                                        $usuario->darPermiso($usuario{'nivel'}, $usuario{'id'});
                                        $this->redirect(Yii::app()->createUrl('usuario/view', array('id'=>$usuario{'id'})));
                                    }                                
                                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Ya existe usuario con el mismo nombre");}                                                                            
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}                                                
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios");}                                                
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}                        
                    }
                    }  
                    catch (Exception $ex) {
                    Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
                }
                
                
                
                                
		$this->render('update',
                        array(
                            'usuario'=>$usuario,
                            'inspector'=>$inspector,
                            'persona'=>$persona,
                            'direccion'=>$direccion,
                            'localidad'=>$localidad,
                            'lista_localidades'=>$lista_localidades,
                            'update'=>true
                            ));
	}
        
        public function actionPassword($id)
	{
                $usuario = new Usuario();
                $usuario = Usuario::model()->findByAttributes(array('id'=>$id));
                $usuario->pass='';
                if(isset($_POST['Usuario'])){
                    $usuario->pass=md5($_POST['Usuario']['pass']);
                    
                    $usuario->save();
                    
                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Contraseña modificada ");                                                                    
                    $this->redirect(Yii::app()->createUrl('usuario/update', array('id'=>$usuario{'id'})));
                }
                
		$this->render('password',
                        array(
                            'usuario'=>$usuario,                            
                            ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionEliminar($id){
            
        $usuario = new Usuario();
        $permisoUsuario = new Permisosusuario();
        try {
             $transaction = Yii::app()->db->beginTransaction();             
             $usuario= Usuario::model()->findByAttributes(array('id'=>$id));
             $permisoUsuario = Permisosusuario::model()->findAllByAttributes(array('id_usr'=>$id));
             $online = Online::model()->findByAttributes(array('id_usr'=>$id));
             
             foreach ($permisoUsuario as $key=>$permisos){
                 $permisos->delete();
             }
             if($usuario{'nivel'}==2){//Inspector
                 $inspector = new Inspector();
                 $inspector=  Inspector::model()->findByAttributes(array('id_usr'=>$id));
                 $inspector->delete();
             }
                 if($usuario->delete()){
                     $transaction->commit();
                     Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Usuario eliminado ");                         
                 }else{
                     $transaction->rollback();
                     Yii::app()->user->setFlash('error', "<strong>Error en la base de datos!</strong> No se pudo eliminar");
                 }
             
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
        }
        
        $this->render('admin',array(
                               'model'=>new Usuario()
                        ));
        
    }


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Usuario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Usuario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Usuario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Usuario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

