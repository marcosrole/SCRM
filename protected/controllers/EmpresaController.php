<?php

class EmpresaController extends Controller
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
//                                
//                if(Yii::app()->user->getState('roles') == 0){//Administrador
//                    $action = ['create','update','view','delete','list','admin'];
//                }
//                if(Yii::app()->user->getState('roles') == 1){//Jefe Inspectores
//                    $action = ['create'];
//                }
//                if(Yii::app()->user->getState('roles') == 2){//Inspectores
//                    $action = ['create'];
//                }                    
//		return array(                    
//			array('allow',  // Permitir todos los usaurios logeados
//				'actions'=>$action,
//				'users'=>array('@'),
//			),
//                        array('deny',  // deny all users
//                                'users'=>array('*'),
//                        ),
//		);
//	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($cuit)
	{
            $rawData = array();
            $sucursales = Sucursal::model()->findAllByAttributes(array('cuit_emp'=>$cuit));
            foreach($sucursales as $item=>$sucursal){
                $raw = array();                
                $raw['id']=(int)$sucursal{'id'};
                $raw['nombre']=$sucursal{'nombre'};
                
                $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                
                $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
                $rawData[]=$raw;            
            }                       
		$this->render('view',array(
			'model'=>  Empresa::model()->findByAttributes(array('cuit'=>$cuit)),
                        'rawData'=>  $rawData
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($checked = FALSE)
	{
		$empresa = new Empresa();
                $persona = new Persona();
                $direccion = new Direccion();
                $direccionAUX = new Direccion();
                $localidad = new Localidad();
                
                if (isset($_POST['Persona'])){
                    if(strlen($_POST['Persona']['dni'])!=0){
                        if (!isset($_POST['Direccion'])){
                          $personaAux = Persona::model()->findByAttributes(array('dni'=>$_POST['Persona']['dni']));
                            if($personaAux){
                                $checked=true;
                                $persona=$personaAux;
                                $direccion=  Direccion::model()->findByAttributes(array('id'=>$persona{'id_dir'})); 
                                $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                           }else{$checked=true;} 
                        }
                    }
                }
                $lista_localidades = CHtml::listData(Localidad::model()->findAll(),'id', 'nombre');
                $transaction = Yii::app()->db->beginTransaction();
                if (isset($_POST['Empresa'])) {
                        try {
                            $empresa->attributes = $_POST['Empresa'];
                            $persona->attributes = $_POST['Persona'];
                            if (isset($_POST['Direccion'])) {
                               $direccion->attributes = $_POST['Direccion'];
                               
                                $direccion->calle=  strtoupper($_POST['Direccion']['calle']);                        
                                $direccion->id_loc = $_POST['Localidad']['id'];
                                
                                if ($direccion->validate()) {
                                    $direccion->save();
                                     $personaAux = Persona::model()->findByAttributes(array('dni'=>$_POST['Persona']['dni']));
                                     if($personaAux){
                                        $persona=$personaAux;
                                        $persona->apellido = strtoupper($_POST['Persona']['apellido']);
                                        $persona->nombre = strtoupper($_POST['Persona']['nombre']);
                                        $persona->tipo_dni = strtoupper($_POST['Persona']['tipo_dni']);
                                        $persona->cuil = strtoupper($_POST['Persona']['cuil']);
                                        $persona->sexo = strtoupper($_POST['Persona']['sexo']);
                                        $persona->email = strtoupper($_POST['Persona']['email']);
                                        $persona->telefono = strtoupper($_POST['Persona']['telefono']);
                                        $persona->celular = strtoupper($_POST['Persona']['celular']);
                                     }else{
                                        $persona->attributes = $_POST['Persona'];
                                        $persona->apellido = strtoupper($_POST['Persona']['apellido']);
                                        $persona->nombre = strtoupper($_POST['Persona']['nombre']);
                                     }
                                    
                                    $empresa->attributes = $_POST['Empresa'];
                                    $empresa->razonsocial = strtoupper($_POST['Empresa']['razonsocial']);

                                    $empresa->dni_per = $_POST['Persona']['dni'];
                                    
                                    if ($empresa->validate()) {
                                        if ($persona->validate()) {
                                            $persona->save();
                                            $empresa->save();
                                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Se ha generado la empresa");
                                            $transaction->commit();
                                            $this->redirect(array('sucursal/create'));
                                        } else {
                                            $transaction->rollback();
                                            Yii::app()->user->setFlash('error', "<strong>Error. Datos Peronales!</strong> Campos vacios o incorrectos");
                                        }
                                    } else {
                                        $transaction->rollback();
                                        Yii::app()->user->setFlash('error', "<strong>Error. Empresa!</strong> Campos vacios o incorrectos");
                                    }
                                } else {
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('error', "<strong>Error. Direccion!</strong> Campos vacios o incorrectos");
                                } 
                             }                            
                        } catch (Exception $ex) {
                            Yii::app()->user->setFlash('error', $ex->getMessage());
                        }
                    }
                    $this->render('create', array(
                        'empresa' => $empresa,
                        'persona' => $persona,
                        'direccion' => $direccion,
                        'localidad' => $localidad,
                        'lista_localidades' => $lista_localidades,                    
                        'checked' => $checked, 
                    ));
                
                
                    
        }
                    
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($cuit)
	{
		$empresa= Empresa::model()->findByAttributes(array('cuit'=>$cuit));
                $persona=  Persona::model()->findByAttributes(array('dni'=>$empresa{'dni_per'}));                
                $direccion=  Direccion::model()->findByAttributes(array('id'=>$persona{'id_dir'}));
                $localidad=  Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                $lista_localidades = CHtml::listData(Localidad::model()->findAll(), 'id', 'nombre');
                $transaction = Yii::app()->db->beginTransaction();
                if (isset($_POST['Empresa'])) {
                    try {
                        
                        //Direccion
                        $direccion->altura= $_POST['Direccion']['altura'];
                        $direccion->calle=  strtoupper($_POST['Direccion']['calle']);
                        $direccion->depto= $_POST['Direccion']['depto'];
                        $direccion->piso= $_POST['Direccion']['piso'];
                        $direccion->id_loc = $_POST['Localidad']['id'];
                        
                        //Persona
                        $persona->attributes = $_POST['Persona'];
                        $persona->apellido = strtoupper($_POST['Persona']['apellido']);
                        $persona->nombre = strtoupper($_POST['Persona']['nombre']);
                        $persona->id_dir = $direccion{'id'};

                        //Empresa
                        $empresa->attributes = $_POST['Empresa'];
                        $empresa->razonsocial = strtoupper($_POST['Empresa']['razonsocial']);
                        $empresa->dni_per = $_POST['Persona']['dni'];                        
                        
                        if ($direccion->validate() && $persona->validate() && $empresa->validate()) {
                            $empresa->save();
                            $persona->save();
                            $direccion->save();
                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");
                            $transaction->commit();
                            $this->redirect('list');                            
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "<strong>Error. Direccion!</strong> Campos vacios o incorrectos");
                        }
                    } catch (Exception $ex) {
                        Yii::app()->user->setFlash('error', $ex->getMessage());
                    }
                }
                
		$this->render('update', array(
                    'empresa' => $empresa,
                    'persona' => $persona,
                    'direccion' => $direccion,
                    'localidad' => $localidad,
                    'lista_localidades' => $lista_localidades,                    
                    'checked'=>true,
                ));
	}
        
        public function actionCheckPersona($dni)
	{
		$persona = new Persona();
                $direccion = new Direccion();
                $localidad = new Localidad();
                $empresa = new Empresa();
                $lista_localidades = CHtml::listData(Localidad::model()->findAll(),'id', 'nombre');
                $empresa->attributes = $_POST['Empresa'];
                
                if(Persona::model()->findByAttributes(array('dni'=>$dni))){
                    $persona=  Persona::model()->findByAttributes(array('dni'=>$dni));                
                    $direccion=  Direccion::model()->findByAttributes(array('id'=>$persona{'id_dir'}));
                    $localidad=  Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                }else{
                    $persona->attributes=$_POST['Persona'];
                }
                
                 $this->render('create', array(
                    'empresa' => $empresa,
                    'persona' => $persona,
                    'direccion' => $direccion,
                    'localidad' => $localidad,
                    'lista_localidades' => $lista_localidades,                    
                ));
                
                
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($cuit)
	{
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $sucursal = Sucursal::model()->findByAttributes(array('cuit_emp' => $cuit));
                if (Histoasignacion::model()->deleteAllByAttributes(array('id_suc' => $sucursal{'id'}))) {
                    if (Calibracion::model()->deleteAllByAttributes(array('id_suc'=>$sucursal{'id'}))) {
                        if (Sucursal::model()->deleteAllByAttributes(array('cuit_emp' => $cuit))) {
                        if (Empresa::model()->deleteAllByAttributes(array('cuit' => $cuit))) {
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Se han eliminado todas las sucursales ");
                            $this->redirect(array('modificar'));
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "<strong>Error!</strong> Al elimiar ");
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "<strong>Error!</strong> Al elimiar ");
                    }                        
                }else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "<strong>Error!</strong> Al elimiar ");
                }                    
            } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "<strong>Error!</strong> Al elimiar ");
            }
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', $ex->getMessage());
            }            
            $this->render('admin', array('model'=>new Empresa()));
        }


	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		
		$this->render('list',array(
			'empresa'=>new Empresa(),
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Empresa('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Empresa']))
			$model->attributes=$_GET['Empresa'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Empresa the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Empresa::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Empresa $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='empresa-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
}
