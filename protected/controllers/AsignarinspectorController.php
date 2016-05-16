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
		$rawData = array();
                $inspectores = Inspector::model()->findAllByAttributes(array('ocupado'=>'0')); //No esta ocupado
                foreach($inspectores as $item=>$inspector){
                    $raw = array();
                    $usuario = Usuario::model()->findByAttributes(array('id'=>$inspector{'id_usr'}));
                    $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));

                        $raw['id']=(int)$inspector{'id'};
                        $raw['matricula']=$inspector{'matricula'};
                        $raw['dni']=$persona{'dni'};
                        $raw['nombre']=$persona{'apellido'} . " " . $persona{'nombre'};
                        $raw['sexo']=$persona{'sexo'};                        
                        $rawData[]=$raw;                                                   
                }
                $DataProviderInspector=new CArrayDataProvider($rawData, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
               ));
               
                //Muestro las sucursales que tienen una alarma
                
                $alarmas = new Alarma();
                
                $criteria=new CDbCriteria(array(
                        
                        'order'=>'fecha DESC, hs DESC'));
                       
                $alarmas=  Alarma::model()->findAll($criteria);
                
                $sucursales = array();
                
                foreach ($alarmas as $item=>$alarma){
                    
                    $sucursal = Sucursal::model()->findByAttributes(array('id'=>$alarma{'id_suc'}));
                    
                    //Verifico si ya se encuentra en la lista de sucursales o si la alarma se encuentra solucionada
                    $flag=true;
                    foreach ($sucursales as $x=>$Itemsucursal){
                        if($Itemsucursal == $sucursal) $flag=false;                                                
                    }                    
                    if($alarma{'solucionada'}==1) $flag=false;
                    if($flag){
                        //Datos: NombreSucrusal NombreEmpresa DireccionSucursal AlarmaDesripcion 
                        $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
                        $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                        
                        $raw['id']=(int)$alarma{'id'};
                        $raw['nombre_suc']=$sucursal{'nombre'};
                        $raw['nombre_emp']=$empresa{'razonsocial'};
                        $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
                        $raw['alarma']=$alarma{'descripcion'};                                                
                        $raw['hs']=$alarma{'hs'};
                        $sucursales[]=$raw; 
                    }                    
                }
                
                $DataProviderSucursales=new CArrayDataProvider($sucursales, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
               )); 
                
                if(isset($_POST['selectInspector']) || isset($_POST['selectAlarma'])){                  
                
                
                $transaction = Yii::app()->db->beginTransaction();
                if (!(isset($_POST['selectInspector']) && !isset($_POST['selectAlarma']))){
                    if (!(!isset($_POST['selectInspector']) && isset($_POST['selectAlarma']))){
                        date_default_timezone_set('America/Buenos_Aires');
                        $alarma = Alarma::model()->findByAttributes(array('id'=>$_POST['selectAlarma'][0]));
                        
                        $asignarInspector = new Asignarinspector();
                        $asignarInspector->hs=date('H:i:s');
                        $asignarInspector->fecha=date("Y-m-d");
                        $asignarInspector->id_ins=$_POST['selectInspector'][0];
                        $asignarInspector->id_ala=$_POST['selectAlarma'][0];

                        if($asignarInspector->insert()){
                            Yii::app()->user->setFlash('success', "<strong>Asignacion correcta!</strong>  ");
                            $inspector->estoyOcupado($asignarInspector{'id_ins'});                                
                            $alarma->setSolucionada($alarma{'id'},'1');
                            $transaction->commit();
                            $this->redirect(array('view', 'id'=>$asignarInspector{'id'}));
                        }  else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "<strong>Error al asignar!</strong>");
                        }                           
                    }else 
                        {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "<strong>Error. Inspector!</strong> Debe Seleccionar un inspector");
                        }
                }else 
                    {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "<strong>Error. Sucursal!</strong> Debe seleccionar una sucursal");
                    }   
                }
                
		$this->render('create',array(
			'dataInspectores'=>$DataProviderInspector,
                        'dataSucursales'=>$DataProviderSucursales,
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
                $sucursal= Sucursal::model()->findByAttributes(array('id'=>$alarma{'id_suc'}));
                $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
                $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                $inspector = Inspector::model()->findByAttributes(array('id'=>$asignacion{'id_ins'}));
                $usuario = Usuario::model()->findByAttributes(array('id'=>$inspector{'id_usr'}));
                $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));

                $raw['id']=(int)$asignacion{'id'};
                $raw['hs']=$asignacion{'hs'};
                $raw['fecha']=$asignacion{'fecha'};
                $raw['alarma']=$alarma{'descripcion'};
                $raw['nombre_suc']=$sucursal{'nombre'};
                $raw['nombre_emp']=$empresa{'razonsocial'};
                $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
                $raw['inspector']=$persona{'apellido'} . " " . $persona{'nombre'};
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
                       $alarma = Alarma::model()->findByAttributes(array('id'=>$asignacion{'id_ala'}));
                       $alarma->setSolucionada($alarma{'id'}, 0);
                       $asignacion->delete();                       
                   }
                }
                
                $asignaciones = Asignarinspector::model()->findAll();
                
                $datos = array();
                foreach ($asignaciones as $item=>$asignacion){                
                    $alarma = Alarma::model()->findByAttributes(array('id'=>$asignacion{'id_ala'}));
                    $sucursal= Sucursal::model()->findByAttributes(array('id'=>$alarma{'id_suc'}));
                    $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
                    $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                    $inspector = Inspector::model()->findByAttributes(array('id'=>$asignacion{'id_ins'}));
                    $usuario = Usuario::model()->findByAttributes(array('id'=>$inspector{'id_usr'}));
                    $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));

                    $raw['id']=(int)$asignacion{'id'};
                    $raw['hs']=$asignacion{'hs'};
                    $raw['fecha']=$asignacion{'fecha'};                    
                    $raw['nombre_suc']=$sucursal{'nombre'};
                    $raw['nombre_emp']=$empresa{'razonsocial'};
                    $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
                    $raw['inspector']=$persona{'apellido'} . " " . $persona{'nombre'};
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
