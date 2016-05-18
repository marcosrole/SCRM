<?php

class AsignarinspectorController extends Controller
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
	 * Muestra los atributos de una Asignacion hecha.
         * @id Es el ID de la AsignarIsnpector
	 */
	public function actionView($id)
	{
            $rawData = array();
            $asignacionInspector = Asignarinspector::model()->findByAttributes(array('id'=>$id));
            $inspector =  Inspector::model()->findByAttributes(array('id'=>$asignacionInspector{'id_ins'}));
            $usuario = Usuario::model()->findByAttributes(array('id'=>$inspector{'id_usr'}));
            $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));
            $alarma = Alarma::model()->findByAttributes(array('id'=>$asignacionInspector{'id_ala'}));
            $sucursal = Sucursal::model()->findByAttributes(array('id'=>$alarma{'id_suc'}));
            $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
            $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
        
            
            $raw['id']=(int)$asignacionInspector{'id'};
            $raw['fecha']=$asignacionInspector{'fecha'};
            $raw['hs']=$asignacionInspector{'hs'};
            
            $raw['nombre_ins']=$persona{'nombre'} . " " . $persona{'apellido'};
            
            $raw['empresa']=$empresa{'razonsocial'};
            $raw['sucursal']=$sucursal{'nombre'};
            $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
            
            $this->render('view',array(
                    'datos'=>$raw,
            ));
	}

	/**
         * Crear una asignacion de Inspectores. Se asignara un inspector  para resolver determinada alarma
         * para un dispositivo determinado en una sucursal determinada.	 
	 */
	public function actionCreate()
	{
            $alarmas = Alarma::model()->findAllByAttributes(array('solucionado'=>'0', 'preAlarma'=>'0'), array('order'=>'fechahs ASC'));
            
                if(isset($_POST['selectInspector']) || isset($_POST['selectAlarma'])){                  
                $AasignarInspector = new Asignarinspector();
                
                $transaction = Yii::app()->db->beginTransaction();
                if (! (isset($_POST['selectInspector']) && !isset($_POST['selectAlarma']))){
                    if (!(!isset($_POST['selectInspector']) && isset($_POST['selectAlarma']))){
                        
                        date_default_timezone_set('America/Buenos_Aires');
                        $alarma = Alarma::model()->findByAttributes(array('id'=>$_POST['selectAlarma'][0]));
                        
                        $AasignarInspector->fechahsIns=date("Y-m-d H:i:s");
                        $AasignarInspector->id_ins=$_POST['selectInspector'][0];
                        $AasignarInspector->id_ala=$_POST['selectAlarma'][0];
                        $AasignarInspector->observacion=$_POST['Asignarinspector']['observacion'];
//                        var_dump($AasignarInspector); die();
                        $AasignarInspector->insert();
                            $inspector = new Inspector();
                        $inspector->estoyOcupado($AasignarInspector{'id_ins'});                                
                        $alarma->setSolucionada($alarma{'id'});
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "<strong>Asignacion correcta!</strong>  ");
                    }else 
                        {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "<strong>Error. Inspector!</strong> Debe Seleccionar un inspector");
                        }
                }else 
                    {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "<strong>Error.!</strong> Debe seleccionar una alarma a solucionar");
                    }   
                }
                
             $rawData = array();
             
             foreach ($alarmas as $item=>$value){
                 $raw['id']=(int)$value{'id'};
                    $tipoAlaram = Tipoalarma::model()->findByAttributes(array('id'=>$value{'id_tipAla'}));
                 $raw['alarma']=$tipoAlaram{'descripcion'};
                    $fecha = explode(" ",$value{'fechahs'});
                    $aux = new DateTime($fecha[0]);
                        
                 $raw['fecha']=$aux->format('d-m-Y');                       
                 $raw['hs']=$fecha[1];
                    $dispositivo=  Dispositivo::model()->findByAttributes(array('id'=>$value{'id_dis'}));
                    $Histoasig = Histoasignacion::model()->findByAttributes(array('id_dis'=>$dispositivo{'id'}, 'fechaBaja'=>'1900-01-01'));
                    $sucursal = Sucursal::model()->findByAttributes(array('id'=>$Histoasig{'id_suc'}));
                 $raw['sucursal']=$sucursal{'nombre'};
                    $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
                    $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                    $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                 $raw['empresa']=$empresa{'razonsocial'};
                 $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'};
                 $raw['localidad']=$localidad{'nombre'};
                 if($value{'enviarSMS'}==0) $raw['SMSenviado']="NO enviado";
                 else $raw['SMSenviado']="SI enviado";
                 $rawData[]=$raw;                   
             }
             
             $DataProviderAlarmas=new CArrayDataProvider($rawData, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
               ));
                                
            $rawData = array();
                $inspectores = Inspector::model()->findAllByAttributes(array('ocupado'=>'0')); //No esta ocupado
                if(count($inspectores)!=0){
                foreach($inspectores as $item=>$inspector){
                    $raw = array();
                    $usuario = Usuario::model()->findByAttributes(array('id'=>$inspector{'id_usr'}));
                    $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));
                    $zona = Zona::model()->findByAttributes(array('id'=>$inspector{'id_zon'}));
                        $raw['id']=(int)$inspector{'id'};
                        $raw['dni']=$persona{'dni'};
                        $raw['nombre']=$persona{'apellido'} . " " . $persona{'nombre'};
                        $raw['sexo']=$persona{'sexo'};                        
                        $raw['zona']=$zona{'nombre'};
                        $rawData[]=$raw;                                                   
                }
                
                }else $rawData=[];
                $DataProviderInspector=new CArrayDataProvider($rawData, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
               ));
                
                
		$this->render('create',array(
			'DataProviderAlarmas'=>$DataProviderAlarmas,
                        'DataProviderInspector'=>$DataProviderInspector,
                         'AasignarInspector' => new Asignarinspector(),
		));
	}

	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $datos = array();
            $asignaciones= Asignarinspector::model()->findAll();
            
            foreach ($asignaciones as $item=>$asignacion){                
                $alarma = Alarma::model()->findByAttributes(array('id'=>$asignacion{'id_ala'}));
                $tipoAlarma= Tipoalarma::model()->findByAttributes(array('id'=>$alarma{'id_tipAla'}));
                
                $dispositivo = Dispositivo::model()->findByAttributes(array('id'=>$alarma{'id_dis'}));
                $histoAsig = Histoasignacion::model()->findByAttributes(array('id_dis'=>$dispositivo{'id'}));
                $sucursal= Sucursal::model()->findByAttributes(array('id'=>$histoAsig{'id_suc'}));
                $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
                $encargado = Persona::model()->findByAttributes(array('dni'=>$empresa{'dni_per'}));
                $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                $inspector = Inspector::model()->findByAttributes(array('id'=>$asignacion{'id_ins'}));
                $usuario = Usuario::model()->findByAttributes(array('id'=>$inspector{'id_usr'}));
                $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));

                $raw['id']=(int)$asignacion{'id'};
                $raw['fechahsIns']=$asignacion{'fechahsIns'};
                $raw['fechahsDue']=$alarma{'fechahs'};
                $raw['alarma']=$tipoAlarma{'descripcion'};
                $raw['nombre_suc']=$sucursal{'nombre'};
                $raw['nombre_emp']=$empresa{'razonsocial'};
                $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'} . " - Localidad: " . $localidad{'nombre'};
                $raw['inspector']=$persona{'apellido'} . " " . $persona{'nombre'};
                $raw['encargado']=$encargado{'apellido'} . " " . $encargado{'nombre'};
                $datos[]=$raw; 
            }            
	
		$this->render('index',array(
			'datos'=>$datos,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
                if(isset($_POST['selectDeleteInspectores'])){
                   $asingaciones = $_POST['selectDeleteInspectores'];
                   
                   foreach ($asingaciones as $item){   
                       $asignacion = Asignarinspector::model()->findByAttributes(array('id'=>$item));
                       $inspector = Inspector::model()->findByAttributes(array('id'=>$asignacion{'id_ins'}));
                       $inspector->estoyLibre($inspector{'id'});
                       $asignacion->delete(); 
                        Yii::app()->user->setFlash('success', "<strong>Registro !</strong>  ");
                       
                   }
                }
                
                $asignaciones = Asignarinspector::model()->findAll(array('order'=>'fechahsIns DESC'));
                
                $datos = array();
                foreach ($asignaciones as $item=>$asignacion){                
                $alarma = Alarma::model()->findByAttributes(array('id'=>$asignacion{'id_ala'}));
                $tipoAlarma= Tipoalarma::model()->findByAttributes(array('id'=>$alarma{'id_tipAla'}));
                
                $dispositivo = Dispositivo::model()->findByAttributes(array('id'=>$alarma{'id_dis'}));
                $histoAsig = Histoasignacion::model()->findByAttributes(array('id_dis'=>$dispositivo{'id'}));
                $sucursal= Sucursal::model()->findByAttributes(array('id'=>$histoAsig{'id_suc'}));
                $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
                $encargado = Persona::model()->findByAttributes(array('dni'=>$empresa{'dni_per'}));
                $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                $inspector = Inspector::model()->findByAttributes(array('id'=>$asignacion{'id_ins'}));
                $usuario = Usuario::model()->findByAttributes(array('id'=>$inspector{'id_usr'}));
                $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));

                $raw['id']=(int)$asignacion{'id'};
                $raw['fechahsIns']=$asignacion{'fechahsIns'};
                $raw['fechahsDue']=$alarma{'fechahs'};
                $raw['alarma']=$tipoAlarma{'descripcion'};
                $raw['nombre_suc']=$sucursal{'nombre'};
                $raw['nombre_emp']=$empresa{'razonsocial'};
                $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'} . " - Localidad: " . $localidad{'nombre'};
                $raw['inspector']=$persona{'apellido'} . " " . $persona{'nombre'};
                $raw['encargado']=$encargado{'apellido'} . " " . $encargado{'nombre'};
                $datos[]=$raw; 
            }  
                
                
                $DataProvider=new CArrayDataProvider($datos, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
               )); 
                
               
              
               
		$this->render('admin',array(
			'dataProvider'=>$DataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Asignarinspector the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Asignarinspector::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Asignarinspector $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='asignarinspector-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
