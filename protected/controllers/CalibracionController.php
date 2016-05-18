<?php

class CalibracionController extends Controller
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

	public function actionView($id)
	{
            $calibracion = Calibracion::model()->findByAttributes(array('id'=>$id));
            $histoasignacion = Histoasignacion::model()->findByAttributes(array('id'=>$calibracion{'id_AsiDis'}, 'fechaBaja'=>'1900-01-01'));
            
            $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoasignacion{'id_suc'}));
            $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
            
            $datos['id']=$calibracion{'id'};
            $datos['db']=$calibracion{'db_permitido'};
            $datos['dist']=$calibracion{'dist_permitido'};
            $datos['sucursal']=$sucursal{'nombre'};
            $datos['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
            
            
		$this->render('view',array(
			'datos'=>$datos,
		));
	}
        public function actionEliminar($id)
	{            
            $calibracion=$this->loadModel($id);
            $calibracion->delete();

            $this->render('list',array(
                'calibracion'=>new Calibracion(),
                )); 
	}
        public function actionCreate($id_disp) {
         date_default_timezone_set('America/Buenos_Aires');
         
        $dispositivo = new Dispositivo();
        $calibracion = new Calibracion();
        if (isset($_POST['Calibracion'])) {
            
            $calibracion->attributes = $_POST['Calibracion'];
            $calibracion->fecha=date("Y-m-d");            
            $histoasignacion = new Histoasignacion();
            $histoasignacion = Histoasignacion::model()->findAllByAttributes(array('id_dis'=>$_GET['id_disp'],'fechaBaja'=>'1900-01-01'));
            $calibracion->id_AsiDis=$histoasignacion[0]['id'];
            
            if(!Calibracion::model()->findByAttributes(
                    array(
                        'db_permitido'=>$calibracion{'db_permitido'},
                        'dist_permitido'=>$calibracion{'dist_permitido'},
                        'fecha'=>$calibracion{'fecha'},
                        'id_AsiDis'=>$calibracion{'id_AsiDis'},
                                ))){
                            if ($calibracion->save())  $this->redirect(array('view', 'id' => $calibracion->id));
            }            
            
        }                      
                   
        if ($_GET['id_disp'] != '') { //Si NO viene vacio...
            //Muestro cuales son los datos de calibracion(si es que los tiene)
            $histoasignacion = new Histoasignacion();
            $histoasignacion = Histoasignacion::model()->findAllByAttributes(array('id_dis'=>$_GET['id_disp'],'fechaBaja'=>'1900-01-01'));
            
            //Si el dispositivo ya se enceuntra calibrado, cargo los datos actuales.          
            $calibracion_aux=Calibracion::model()->findByAttributes(array('id_AsiDis'=>$histoasignacion[0]{'id'}));
            
            if ($calibracion_aux){                
                $calibracion->db_permitido=$calibracion_aux{'db_permitido'};
                $calibracion->dist_permitido=$calibracion_aux{'dist_permitido'};
            }
            
            Yii::app()->user->setFlash('info', "<strong>Dispositivo seleccionado:</strong> " .  $_GET['id_disp']);                                                           
        }
        
        //Listo todos los dispisitivos que estan asigandos actualmente
        $dataprovieder = Dispositivo::model()->search();
        $array_dispositivos = array();
        foreach (Histoasignacion::model()->getDispositivosNODisponibles() as $key=>$value){
            $array_dispositivos[]=Dispositivo::model()->findByAttributes(array('id'=>$value->id_dis));            
        }       
        if(count($array_dispositivos)==0){
            $DataProviderCalibracion=new CArrayDataProvider([], array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
        }elseif(count($array_dispositivos)>1){
                foreach($array_dispositivos as $item=>$value){
                    
                    $raw = array();                
                    $raw['id']=(int)$value{'id'};
                    $raw['mac']=$value{'mac'};
                        $histoAsign = Histoasignacion::model()->findByAttributes(array('id_dis'=>$value{'id'}, 'fechaBaja'=>'1900-01-01'));
                        $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoAsign{'id_suc'}));
                    $raw['sucursal']=$sucursal{'nombre'};                
                if(Calibracion::model()->findByAttributes(array('id_AsiDis'=>$histoAsign{'id'}))){
                    $raw['calibrado']='Calibrado';
                }else $raw['calibrado']='NO Calibrado';              
                    
                    $rawData[]=$raw;  
                    
                    $DataProviderCalibracion=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                }     
            }else{
                
                $raw = array();                
                $raw['id']=(int)$array_dispositivos[0]{'id'};
                $raw['mac']=$array_dispositivos[0]{'mac'};
                    $histoAsign = Histoasignacion::model()->findByAttributes(array('id_dis'=>$array_dispositivos[0]{'id'}, 'fechaBaja'=>'1900-01-01'));
                    $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoAsign{'id_suc'}));
                $raw['sucursal']=$sucursal{'nombre'};                
                if(Calibracion::model()->findByAttributes(array('id_AsiDis'=>$histoAsign{'id'}))){
                    $raw['calibrado']='Calibrado';
                }else $raw['calibrado']='NO Calibrado';              
                    
                $rawData[]=$raw;  

                $DataProviderCalibracion=new CArrayDataProvider($rawData, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
                 ));
                
            }
            
          
            
        $dataprovieder->setData($array_dispositivos);
        
        if( Yii::app()->request->isAjaxRequest )
        {
            
            $this->renderPartial('_modalCalibrar', array(
                'calibracion' => $calibracion,
                'dispositivo' => Dispositivo::model()->findByAttributes(array('id'=>$id_disp)),
            ), false, true);
        }
        else
        {
            $this->render('create', array(
                'calibracion' => $calibracion,
                'dataprovieder' => $dataprovieder,
                'dispositivo' => $dispositivo,
                'DataProviderCalibracion' => $DataProviderCalibracion,
            ));
        }
        
        
    }
	public function actionUpdate($id)
	{
		$calibracion=  Calibracion::model()->findByAttributes(array('id'=>$id));
                $model = new Calibracion();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Calibracion']))
		{
                    $model->attributes=$_POST['Calibracion'];
                    
                    $calibracion->db_permitido=$model{'db_permitido'};
                    $calibracion->dist_permitido=$model{'dist_permitido'};
                    if($calibracion->validate()){
                        if($calibracion->save())
                            $this->redirect(array('view','id'=>$calibracion->id));
                    }                    
		}

		$this->render('update',array(
			'calibracion'=>$calibracion,
		));
	}  
	public function actionList()
	{
            $calibraciones = Calibracion::model()->findAll();
            if(count($calibraciones)>1){
                foreach($calibraciones as $item=>$value){
                    $raw = array();                
                    $raw['id']=(int)$value{'id'};
                    $raw['db_permitido']=$value{'db_permitido'};
                    $raw['dist_permitido']=$value{'dist_permitido'};
                    $raw['fecha']=$value{'fecha'};
                        $histoAsign = Histoasignacion::model()->findByAttributes(array('id'=>$value{'id_AsiDis'}));
                        $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoAsign{'id_suc'}));
                    $raw['id_dis']=$histoAsign{'id_dis'};
                    $raw['sucursal']=$sucursal{'nombre'};                
                        $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));                
                    $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
                    $rawData[]=$raw;  
                    
                    $DataProviderCalibracion=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                }     
            }else{
               
                $raw = array();                
                $raw['id']=(int)$calibraciones[0]{'id'};
                $raw['db_permitido']=$calibraciones[0]{'db_permitido'};
                $raw['dist_permitido']=$calibraciones[0]{'dist_permitido'};
                $raw['fecha']=$calibraciones[0]{'fecha'};
               
                    $histoAsign = Histoasignacion::model()->findByAttributes(array('id'=>$calibraciones[0]{'id_AsiDis'}));
                    $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoAsign{'id_suc'}));
                $raw['id_dis']=$histoAsign{'id_dis'};
                $raw['sucursal']=$sucursal{'nombre'};                
                    $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));                
                $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
                $rawData[]=$raw;
                
                $DataProviderCalibracion=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                
            }
            
            
            $this->render('list',array(
                    'DataProviderCalibracion'=>$DataProviderCalibracion,
            ));   
	}
        public function loadModel($id)
	{
		$model=Asignarinspector::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='asignarinspector-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
