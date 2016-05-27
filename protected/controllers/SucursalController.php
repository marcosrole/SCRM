<?php

class SucursalController extends Controller
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
                 $arr[]='view';
                 $arr[]='update';
                 $arr[]='delete';
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
            $sucursal = Sucursal::model()->findByAttributes(array('id'=>$id));
            $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
            $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
            $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
            $zona = Zona::model()->findByAttributes(array('id'=>$sucursal{'id_zon'}));
                        
            $datos['empresa']=$empresa{'razonsocial'};
            $datos['cuit']=$empresa{'cuit'};
            $datos['sucursal']=$sucursal{'nombre'};
            $datos['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
            $datos['localidad']=  strtoupper($localidad{'nombre'});            
            $datos['zona']=$zona{'nombre'};
            
            
            
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                    'datos'=>$datos,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($checked = FALSE)
	{
		$sucursal = new Sucursal();
                $direccion = new Direccion();
                $empresa = new Empresa();
                $localidad = new Localidad();
                $localidadPER = new Localidad();
                $persona = new Persona();
                
                
                $zona = new Zona(); 
                 if (isset($_POST['Persona'])){
                    if(strlen($_POST['Persona']['dni'])!=0){
                          $personaAux = Persona::model()->findByAttributes(array('dni'=>$_POST['Persona']['dni']));
                            if($personaAux){
                                $checked=true;
                                $persona=$personaAux;                              
                           }else{$checked=true; $persona->attributes=$_POST['Persona'];}                         
                    }
                }
                
                
                $lista_localidades= CHtml::listData($localidad->findAll(), 'id', 'nombre');
                $transaction = Yii::app()->db->beginTransaction();             
                 try { 
                     if ( isset($_POST['Sucursal'])  ){
                         if(isset($_POST['selectEmpresa']) || ( isset($_POST['Direccion']) ) ){
                             
                         }
                        $direccion->attributes = $_POST['Direccion'];
                        $direccion->calle=  strtoupper($_POST['Direccion']['calle']);

                        $localidad_seleccionada = $lista_localidades[$_POST['Localidad']['id']];            
                        $direccion->id_loc = Localidad::model()->getId($localidad_seleccionada)->id;

                        if($direccion->validate()){
                            $direccion->insert();
                            $sucursal->attributes=$_POST['Sucursal'];
                            $sucursal->nombre=  strtoupper($_POST['Sucursal']['nombre']);
                            $sucursal->dni_per=$_POST['Persona']['dni'];

                                if(isset($_POST['selectEmpresa'])){
                                    $sucursal->id_dir=$direccion{'id'};
                                    $sucursal->cuit_emp=$_POST['selectEmpresa'][0];
                                    
                                    $zona=  Zona::model()->findByAttributes(array('id'=>$_POST['Zona']['id']));
                                    
                                    $sucursal->id_zon = $zona{'id'};                                        
                                    if($sucursal->validate()){                                                                                                         
                                       
                                        $persona->attributes=$_POST['Persona'];
                                        if($persona->validate()){
                                            $persona->apellido = strtoupper($_POST['Persona']['apellido']);
                                            $persona->nombre = strtoupper($_POST['Persona']['nombre']);
                                            $persona->tipo_dni = strtoupper($_POST['Persona']['tipo_dni']);
                                            $persona->cuil = strtoupper($_POST['Persona']['cuil']);
                                            $persona->dni = strtoupper($_POST['Persona']['dni']);
                                            $persona->sexo = strtoupper($_POST['Persona']['sexo']);
                                            $persona->email = ($_POST['Persona']['email']);
                                            $persona->telefono = strtoupper($_POST['Persona']['telefono']);
                                            $persona->celular = strtoupper($_POST['Persona']['celular']);
                                            
                                       
                                            $persona->insert();
                                             $sucursal->insert();
                                        
                                            $transaction->commit();                        
                                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                            $this->redirect('create');
                                        }else {$transaction->rollback (); Yii::app()->user->setFlash('warning', "Asegure de completar todos los datos para el Responsable");}
                                    }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Falta completar datos");}
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Seleccione una empresa");}
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}                
                    }                 
                 } catch (Exception $ex) {
                     Yii::app()->user->setFlash('error',$ex->getMessage());
                 }
                 
                $this->render(
                        'create',
                        array(
                            'sucursal'=>$sucursal,
                            'direccion'=>$direccion,
                            'empresa' => $empresa,
                            'localidad' => $localidad, 
                            'zona'=>$zona,
                            'checked' => $checked,
                            'persona' => $persona,
                            'listZona'=>  CHtml::listData($zona->findAll(), 'id', 'nombre'),
                            'lista_localidades' => $lista_localidades,
                        ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$sucursal = Sucursal::model()->findByAttributes(array('id'=>$id));
                $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
                $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                $lista_localidades= CHtml::listData(Localidad::model()->findAll(), 'id', 'nombre');
                $zona = new Zona();
                $persona = Persona::model()->findByAttributes(array('dni'=>$sucursal{'dni_per'}));
                

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$transaction = Yii::app()->db->beginTransaction();             
                 try {
                     if (isset($_POST['selectEmpresa']) || (isset($_POST['Sucursal']) ) || ( isset($_POST['Direccion']) ) ) {
                        $direccion->attributes = $_POST['Direccion'];
                        $direccion->calle=  strtoupper($_POST['Direccion']['calle']);
                        $localidad_seleccionada = $lista_localidades[$_POST['Localidad']['id']];                                    
                        $direccion->id_loc = $_POST['Localidad']['id'];
                       
                        if($direccion->validate()){
                            $direccion->save();
                            $sucursal->attributes=$_POST['Sucursal'];
                            $sucursal->nombre=  strtoupper($_POST['Sucursal']['nombre']);
                            if(isset($_POST['selectEmpresa'])){
                                $sucursal->cuit_emp=$_POST['selectEmpresa'][0];
                                if($sucursal->validate()){
                                    $sucursal->save();
                                    $persona->attributes=$_POST['Persona'];                                    
                                    if($persona->validate()){
                                        $persona->apellido = strtoupper($_POST['Persona']['apellido']);
                                        $persona->nombre = strtoupper($_POST['Persona']['nombre']);
                                        $persona->tipo_dni = strtoupper($_POST['Persona']['tipo_dni']);
                                        $persona->cuil = strtoupper($_POST['Persona']['cuil']);
                                        $persona->dni = strtoupper($_POST['Persona']['dni']);
                                        $persona->sexo = strtoupper($_POST['Persona']['sexo']);
                                        $persona->email = strtolower($_POST['Persona']['email']);
                                        $persona->telefono = strtoupper($_POST['Persona']['telefono']);
                                        $persona->celular = strtoupper($_POST['Persona']['celular']);
                                        $persona->save();
                                        
                                        $transaction->commit();
                                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                        $this->redirect('admin');
                                        
                                    }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Datos del Responsables incompletos");}                          
                                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Seleccione una empresa");}                          
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Seleccione una empresa");} 
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}                
                    }
                 } catch (Exception $ex) {
                     Yii::app()->user->setFlash('error',$ex->getMessage());
                 }

		$this->render(
                        'update',
                        array(
                            'sucursal'=>$sucursal,
                            'direccion'=>$direccion,
                            'empresa' => new Empresa(),
                            'empresaSelec'=>$empresa,
                            'localidad' => $localidad, 
                            'persona'=>$persona,
                            'checked'=>true,
                            'zona'=>$zona,
                            'listZona'=>  CHtml::listData($zona->findAll(), 'id', 'nombre'),
                            'lista_localidades' => $lista_localidades,
                        ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id_zon=NULL)
	{
		//Listo todas las Sucursales:
//            SUCURSAL - EMPRESA - DIRECCION - LOCALIDAD - ZONA
            $zona = NEW Zona();
            
            if ($id_zon==NULL){
                $ListSucursal = Sucursal::model()->findAll();
                foreach ($ListSucursal as $key=>$value){                    
                        $raw['id']=(int)$value{'id'};
                        $raw['nombre']=$value{'nombre'};
                            $aux=  Empresa::model()->findByAttributes(array('cuit'=>$value{'cuit_emp'}));
                        $raw['empresa']=  $aux{'razonsocial'};
                            $aux= Direccion::model()->findByAttributes(array('id'=>$value{'id_dir'}));
                        $raw['direccion']=$aux{'calle'} . " " . $aux{'altura'};
                            $aux2= Localidad::model()->findByAttributes(array('id'=>$aux{'id_loc'}));
                        $raw['localidad']=$aux2{'nombre'};
                            $aux=  Zona::model()->findByAttributes(array('id'=>$value{'id_zon'}));
                        $raw['zona']=  $aux{'nombre'};                        
                        $rawData[]=$raw;                   
                    }
                    $DataProviderSucursales=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                    
                    
                
            }else{
                $ListSucursal = Sucursal::model()->findAllByAttributes(array('id_zon'=>$id_zon));
                if(count($ListSucursal)==0){
                   $DataProviderSucursales=new CArrayDataProvider([], array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     )); 
                }else{
                   foreach ($ListSucursal as $key=>$value){                    
                        $raw['id']=(int)$value{'id'};
                        $raw['nombre']=$value{'nombre'};
                            $aux=  Empresa::model()->findByAttributes(array('cuit'=>$value{'cuit_emp'}));
                        $raw['empresa']=  $aux{'razonsocial'};
                            $aux= Direccion::model()->findByAttributes(array('id'=>$value{'id_dir'}));
                        $raw['direccion']=$aux{'calle'} . " " . $aux{'altura'};
                            $aux2= Localidad::model()->findByAttributes(array('id'=>$aux{'id_loc'}));
                        $raw['localidad']=$aux2{'nombre'};
                            $aux=  Zona::model()->findByAttributes(array('id'=>$value{'id_zon'}));
                        $raw['zona']=  $aux{'nombre'};                        
                        $rawData[]=$raw;                   
                    }
                    $DataProviderSucursales=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     )); 
                }
                
                    
            }
            
            $this->render('index',array(
			'DataProviderSucursales'=>$DataProviderSucursales,                        
                        'zona'=>$zona,
                        'listZona' => CHtml::listData($zona->findAll(), 'id', 'nombre')                        
		));
                        
		
	}
        
        public function actionIndexZona($zona)
	{
            
		$dataProvider=new CActiveDataProvider('Sucursal');
                               
                $grupoSucural = Gruposucursal::model()->findByAttributes(array('zona'=>$zona));
                $sucursales = Sucursal::model()->findAllByAttributes(array('id_zon'=>$grupoSucural{'id'}));
                
                $array_zonas=[];
                $grupoSucural = Gruposucursal::model()->findAll();
                foreach ($grupoSucural as $item=>$zonaaa){
                    $array_zonas[]=$zonaaa{'zona'};
                }
                
                $dataProvider->setData($sucursales);
                
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
                        'array_zonas'=>$array_zonas,
                        'grupoSucursal'=>new Gruposucursal(),
		));
//                $this->render('prueba');
	}
        

	/**
	 * Manages all models.
	 */
	public function actionAdmin($cuit=null)
	{
                $empresa = New Empresa();
                $sucursal = New Sucursal();
                $data = $sucursal->search();
                
                if($cuit==null){
                    $this->render('admin',array(
                       'empresa'=>$empresa,
                        'data'=>$data,
                        'sucursal_visible'=>false,
                       ));
                }else {
                    $sucursal=  Sucursal::model()->findAllByAttributes(array('cuit_emp'=>$cuit));                    
                    $data->setData($sucursal);        
                    $this->render('admin',array(
                       'empresa'=>$empresa,
                        'data'=>$data,
                        'sucursal_visible'=>true,
                        'empresa_seleccionada'=>  Empresa::model()->findByAttributes(array('cuit'=>$cuit)),
                       ));
                }
                
               
                
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Sucursal the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Sucursal::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Sucursal $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sucursal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        public function actionVer($cuit_emp=null)
            {
                $model=new Empresa('search');
                $model->unsetAttributes();  // clear any default values

                if($cuit_emp != null)
                    $model->cuit=$cuit_emp;

                $this->render('admin',array(
                   'empresa'=>$model,
                ));
            }
}
