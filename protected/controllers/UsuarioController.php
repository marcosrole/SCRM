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
        
         public function accessRules()
	{
		 $funcionesAxu = new funcionesAux();
                 $funcionesAxu->obtenerActionsPermitidas(Yii::app()->user->getState("Menu"), Yii::app()->controller->id);
                 
                 $arr =$funcionesAxu->actiones;  // give all access to admin
                 if(count($arr)!=0){
                        return array(                    
                            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                    'actions'=>$arr,                             
                                    'users'=>array('@'),
                            ),
                            array('deny',  // deny all users
                                    'users'=>array('*'),
                                    'deniedCallback' => function() { 
                                            Yii::app()->user->setFlash('error', "Usted no tiene permiso para relizar la acción solicitada. Inicie sesión con el usuario correspondiente ");  
    //                                        Yii::app()->controller->redirect(array ('/site/index'));
                                            Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);                                        
                                            }
                            ),
                            );
                 }else{
                     return array(
                            array('deny',  // deny all users
                                    'users'=>array('*'),
                                    'deniedCallback' => function() { 
                                            Yii::app()->user->setFlash('error', "Usted no tiene permiso para relizar la acción solicitada. Inicie sesión con el usuario correspondiente ");  
    //                                        Yii::app()->controller->redirect(array ('/site/index'));
                                            Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);                                        
                                            }
                            ),
                            );
                 }
                
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            
            $usuario = Usuario::model()->findByAttributes(array('id'=>$id));
            
            $usuarioRol = Usuariorol::model()->findAllByAttributes(array('id_usr'=>$id));
            $roles = array();
            foreach ($usuarioRol as $key=>$usuRol){
                $roles[]=Rol::model()->findByAttributes(array('id'=>$usuRol{'id_rol'}));
            }
            
            $string_roles="";
            foreach ($roles as $key){                                
                $string_roles=$string_roles . " - " . $key{'nombre'};
            }
            
            $usuario->roles=$string_roles;
                        
		$this->render('view',array(
			'model'=>$usuario,
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
                $rol = new Rol();                
                
                $transaction = Yii::app()->db->beginTransaction();
                try {                                  
                    if(isset($_POST['Usuario'])) $usuario->attributes=$_POST['Usuario'];
                    if(isset($_POST['Direccion'])) $direccion->attributes=$_POST['Direccion'];
                    if(isset($_POST['Persona'])){ $persona->attributes=$_POST['Persona']; $persona->celular="+54" . $_POST['Persona']['celular'];}
                    if(isset($_POST['Localidad'])) $localidad->attributes=$_POST['Localidad'];
                    if(isset($_POST['Rol'])) $rol->attributes=$_POST['Rol'];


                    if(isset($_POST['Direccion'])){                        
                           
                    $direccion->attributes=$_POST['Direccion'];                
                    $direccion->calle=  strtoupper($_POST['Direccion']['calle']);
                    $direccion->depto=  strtoupper($_POST['Direccion']['depto']);                
                    /*FK1*/$direccion->id_loc = (int)$_POST['Localidad']['id']+1;
                            if($direccion{'piso'}=='') $direccion{'piso'}=null;
                            if($direccion{'depto'}=='') $direccion{'depto'}=null;
                 
                    if ($direccion->validate()){ 
                        //Me fijo si ya existe para no guardar dos veces la misma direccion;
                        $direccion_aux = Direccion::model()->findByAttributes(array(//Si NO existe => GUARDO
                            'altura'=>$direccion{'altura'},
                            'calle'=>$direccion{'calle'},
                            'piso'=>$direccion{'piso'},
                            'depto'=>$direccion{'depto'},
                        ));   
                        
                        if($direccion_aux==null){$direccion->save();                          
                        }  else {$direccion=$direccion_aux;}
                        
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
//                            $usuario->pass=  md5($_POST['Usuario']['pass']);
                             $usuario->pass= $_POST['Usuario']['pass'];
                             $usuario->name= strtoupper($_POST['Usuario']['name']);
                            
                            if($usuario->validate()){  
                                $aux = Usuario::model()->findByAttributes(array('name'=>$usuario{'name'}));                                
                                if( ($aux == NULL)){
                                    $usuario->insert(); 
  
                                    if( ((int)($_POST['Rol']['id'])) != 0 ){
                                        
                                        //Asigno el ROL del Usuario
                                        $i = count(($_POST['Rol']['id']));
                                        
                                        for ($j=0; $j<$i; $j++ ){
                                            if($_POST['Rol']['id'][$j]==2){ //INSPECTOR
                                                $inspector = new Inspector();
                                                $inspector->ocupado=0;
                                                /*FK1*/ $inspector->id_rol=2;
                                                /*FK2*/ $inspector->id_zon=1;
                                                /*FK3*/ $inspector->id_usr=$usuario{'id'};
                                                $inspector->save();
                                                
                                                $UsuarioRol = new Usuariorol();
                                                $UsuarioRol->id_rol=2;
                                                $UsuarioRol->id_usr=$usuario{'id'};
                                                $UsuarioRol->save();                                            
                                            }
                                            $UsuarioRol = new Usuariorol();
                                            $UsuarioRol->id_rol=$_POST['Rol']['id'][$j];
                                            $UsuarioRol->id_usr=$usuario{'id'};
                                            $UsuarioRol->save();                                            
                                        }                                                                                
                                            /*
                                        //Generar los permisos por default
                                        $usuario->darPermiso($usuario{'id_niv'}, $usuario{'id'});                                    
                                         */
                                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                        $transaction->commit();  
                                        $this->redirect(Yii::app()->createUrl('usuario/view', array('id'=>$usuario{'id'})));
                                    }  else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error. Rol de Usuario!</strong> Debe asignarle un rol al Usuario");}
                                    
                                    
                                }else {      die("existe")                              ;
                                    $transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Ya existe usuario con el mismo nombre");
                                }                                                                       
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
                            'persona'=>$persona,
                            'direccion'=>$direccion,
                            'localidad'=>$localidad,
                            'array_rol'=> CHtml::listData(Rol::model()->findAll(), 'id', 'nombre'),
                            'rol'=>$rol,
                            'lista_localidades'=>CHtml::listData(Localidad::model()->findAll(),'id', 'nombre'),
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
                $inspector = new Inspector();
                $rol = new Rol();                
                  
                $usuario = Usuario::model()->findByAttributes(array('id'=>$id));
                $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));
                $direccion = Direccion::model()->findByAttributes(array('id'=>$persona{'id_dir'}));
                $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                $UsuarioRol = Usuariorol::model()->findAllByAttributes(array('id_usr'=>$usuario{'id'}));
                
                $array_rol=array();

                foreach ($UsuarioRol as $key=>$value){
                    $array_rol[]=$value{'id_rol'};                        
                }
                $rol['id']=$array_rol;

                
                
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if(isset($_POST['Direccion'])){
                        
                    $direccion->attributes=$_POST['Direccion'];
                    $direccion->calle=  strtoupper($_POST['Direccion']['calle']);
                    $direccion->depto=  strtoupper($_POST['Direccion']['depto']);
                    /*FK1*/$direccion->id_loc = $_POST['Localidad']['id'];
                    
                    
                    if ($direccion->validate()){
                        //Me fijo si ya existe para no guardar dos veces la misma direccion;
                       
                        if( !(Direccion::model()->findByAttributes(array(
                                    'altura'=>$_POST['Direccion']['altura'],
                                    'piso'=>$_POST['Direccion']['piso'],
                                    'depto'=>$_POST['Direccion']['depto'],
                                    'id_loc'=>$direccion{'id_loc'})))){//Si NO existe => GUARDO
                            $direccion->save();
                            $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                        }                                            
                        
                        $persona->attributes=$_POST['Persona']; 
                        $persona->nombre=  strtoupper($_POST['Persona']['nombre']);
                        $persona->apellido=  strtoupper(($_POST['Persona']['apellido']));
                        
                        if($persona->validate()){
                            //Me fijo si ya existe para no guardar dos veces la misma persona;                                      
//                            if(! (Persona::model()->findByAttributes(array('dni'=>$persona->dni)))){//Si NO existe => GUARDO
                                $persona->save();
//                            }
                            
                            $usuario->attributes=$_POST['Usuario'];
                            /*FK1*/ $usuario->dni_per=$persona{'dni'}; 
                                $aux = Usuario::model()->findByAttributes(array('name'=>$usuario{'id'}));

                            if($usuario->validate()){
//                                if(!$usuario->exists("name='" . $usuario{'name'} . "' ")){
                                    $usuario->save();                                             
                                    if( ((int)($_POST['Rol']['id'])) != 0 ){
                                        
                                        //Asigno el ROL del Usuario
                                        $i = count(($_POST['Rol']['id']));
                                        
                                        //Borro los UsuarioRol e Inpesvores del USUARIO
                                        Usuariorol::model()->deleteAllByAttributes(array('id_usr'=>$usuario{'id'}));
                                        Inspector::model()->deleteAllByAttributes(array('id_usr'=>$usuario{'id'}));
                                        
                                        for ($j=0; $j<$i; $j++ ){
                                            if($_POST['Rol']['id'][$j]==2){ //INSPECTOR
                                                $inspector = new Inspector();
                                                $inspector->ocupado=0;
                                                /*FK1*/ $inspector->id_rol=2;
                                                /*FK2*/ $inspector->id_zon=1;
                                                /*FK3*/ $inspector->id_usr=$usuario{'id'};
                                                $inspector->save();
                                                
                                                $UsuarioRol = new Usuariorol();
                                                $UsuarioRol->id_rol=2;
                                                $UsuarioRol->id_usr=$usuario{'id'};
                                                $UsuarioRol->save();                                            
                                            }
                                            $UsuarioRol = new Usuariorol();
                                            $UsuarioRol->id_rol=$_POST['Rol']['id'][$j];
                                            $UsuarioRol->id_usr=$usuario{'id'};
                                            $UsuarioRol->save();                                            
                                        }                                                                                
                                            /*
                                        //Generar los permisos por default
                                        $usuario->darPermiso($usuario{'id_niv'}, $usuario{'id'});                                    
                                         */
                                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han actualizado ");                                                
                                        $transaction->commit();  
                                        $this->redirect(Yii::app()->createUrl('usuario/view', array('id'=>$usuario{'id'})));
                                    }  else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error. Rol de Usuario!</strong> Debe asignarle un rol al Usuario");}
                                    
//                                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Ya existe usuario con el mismo nombre");}                                                                            
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
                            'persona'=>$persona,                            
                            'direccion'=>$direccion,
                            'localidad'=>$localidad,
                            'array_rol'=> CHtml::listData(Rol::model()->findAll(), 'id', 'nombre'),
                            'rol'=>$rol,
                            'lista_localidades'=>CHtml::listData(Localidad::model()->findAll(),'id', 'nombre'),
                            'update'=>true,
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
        
        try {
             $transaction = Yii::app()->db->beginTransaction();             
             //POR EL MOMENTO NO SE PUEDEN ELIMINAR INSPECTORES.
             
             if(!Inspector::model()->findByAttributes(array('id_usr'=>$id))){
                 Usuarionivacc::model()->deleteAllByAttributes(array('id_usr'=>$id));
                 Usuariorol::model()->deleteAllByAttributes(array('id_usr'=>$id));
                 Usuario::model()->deleteAllByAttributes(array('id'=>$id));
                 $transaction->commit();
                 Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Usuario eliminado ");                         
                 $this->redirect(Yii::app()->createUrl('usuario/admin'));
             }else{
                     $transaction->rollback();
                     Yii::app()->user->setFlash('error', "<strong> El usuario es un Inspector!</strong> Por el momento el sistema no permite eliminar un Inspector");
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
	public function actionIndex($rol=null)
	{
            $rawData=array();
            $roles = Rol::model()->findAll();
            $usuario=array();
            $modelRol = new Rol();
            if($rol!=null){
                if($rol==0){//Son todos los usuarios
                    $usuario = Usuario::model()->findAll();                    
                }else{
                    $modelRol = Rol::model()->findByAttributes(array('id'=>$rol));
                    //Todos los usuarios con el rol: $rol
                    $UsuarioRol = Usuariorol::model()->findAllByAttributes(array('id_rol'=>$modelRol{'id'}));                                
                    $usuario=[];
                    foreach ($UsuarioRol as $key=>$valor){
                        $usuario[]=Usuario::model()->findByAttributes(array('id'=>$valor{'id_usr'}));
                    }
                }                
                if(count($usuario)!=0){                    
                    foreach ($usuario as $key){
                    $persona=Persona::model()->findByAttributes(array('dni'=>$key{'dni_per'}));                     
                    $key->nombre = $persona{'nombre'};
                    $key->apellido = $persona{'apellido'};
                    if($rol!=0) $key->roles=$modelRol{'nombre'};                    
                    }                
                    
                    foreach ($usuario as $key){                    
                        $raw['id']=(int)$key{'id'};
                        $raw['name']=$key{'name'};
                        $raw['nombre']=$key{'nombre'};
                        $raw['apellido']=$key{'apellido'};
                        if($rol!=0) $raw['roles']=$key{'roles'};
                        else $raw['roles']="Todos";
                        $rawData[]=$raw;                   
                    }

                    $DataProviderUsuario=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                }else{
                    $raw['id']=1;
                    $raw['name']="";
                    $raw['nombre']="";
                    $raw['apellido']="";
                    $raw['roles']="";
                    $rawData[]=null;                   
                    $DataProviderUsuario=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                }
                
                
                 
            }else{
                $raw['id']=1;
                $raw['name']="";
                $raw['nombre']="";
                $raw['apellido']="";
                $raw['roles']="";
                $rawData[]=null;                   
                $DataProviderUsuario=new CArrayDataProvider($rawData, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
                 ));
                
            }
            
            $list_roles = CHtml::listData($roles, 'id', 'nombre');
            array_unshift($list_roles, 'Todos');            
            $rol = new Rol();
            $this->render('index',array( 
                    'DataProviderUsuario'=>$DataProviderUsuario,
                    'usuario'=>new Usuario(),
                    'rol'=>$modelRol,
                    'roles'=>  $list_roles,
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

