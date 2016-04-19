<?php

class AlarmaController extends Controller
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
            $datos = array();
            $alarma = Alarma::model()->findByAttributes(array('id'=>$id));
            $sucursal = Sucursal::model()->findByAttributes(array('id'=>$alarma{'id_suc'}));
            $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
            $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
            
            
            $date = date_create($alarma{'fecha'});
            $datos['fecha']= date_format($date, 'd-m-Y');
            
            
            $datos['id']= $alarma{'id'};
            $datos['descripcion']= $alarma{'descripcion'};
            $datos['vesperado']=$alarma{'valorEsperado'};
            $datos['vactual']=$alarma{'valorActual'};
//            $datos['fecha']=$alarma{'fecha'};
            $datos['hs']=$alarma{'hs'};
            $datos['sucursal']=$sucursal{'nombre'};
            $datos['empresa']=$empresa{'razonsocial'};
            $datos['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
            
            
            $this->render('view',array(
			'datos'=>$datos,
                        'model'=>$alarma
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Alarma;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Alarma']))
		{
			$model->attributes=$_POST['Alarma'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Alarma']))
		{
			$model->attributes=$_POST['Alarma'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionEliminar($id)
	{
            $alarma = new Alarma();
            $alarma= Alarma::model()->findByAttributes(array('id'=>$id));            
            
            $alarma->delete();
            $this->render('admin',array(
			'model'=>new Alarma(),
		));
		
	}
        
        public function actionEliminarTodo()
	{
            $alarmas = Alarma::model()->findAll();            
            
            foreach ($alarmas as $item=> $alarma){
                 $asignacion = Asignarinspector::model()->findByAttributes(array('id_ala'=>$alarma{'id'}));
                 if($asignacion!=null){
                     $asignacion->delete();
                 }else {
                     $alarma->delete();
                 }
                 
                 
                 
            }
                        
            $this->render('admin',array(
			'model'=>new Alarma(),
		));
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$alarmas = Alarma::model()->findAll();
                
                $rawData=[];
                if(count($alarmas)==0){
                    $DataProviderAlarma=new CArrayDataProvider([], array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                }elseif (count($alarmas)>1) {
                    foreach ($alarmas as $item=>$value){                                      
                        $raw['id']=(int)$value{'id'};
                        $raw['solucionado']=$value{'solucionado'}; 
                           $tipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$value{'id_tipAla'}));
                        $raw['alarma']=$tipoAlarma{'descripcion'};
                        $fechahs=explode(" ", $value['fechahs']);
                        $raw['fecha']=$fechahs[0];  
                        $raw['hs']=$fechahs[1];                          
                        $rawData[]=$raw;                   
                }    

                    $DataProviderAlarma=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                 }else{
                        $value=$alarmas;                                 
                        $raw['id']=(int)$value{'id'};
                        $raw['solucionado']=$value{'solucionado'};                        
                        $raw['alarma']=$tipoAlarma[$value{'id_tipAla'}];
                        $fechahs=explode(" ", $value['fechahs']);
                        $raw['fecha']=$fechahs[0];  
                        $raw['hs']=$fechahs[1];                          
                        $rawData[]=$raw;                   
                   

                    $DataProviderAlarma=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     )); 
                 }
                 
                $this->render('admin',array(
			'DataProviderAlarma'=>$DataProviderAlarma,
		));
                                     
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Alarma the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Alarma::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionSendemail($id_alarma){
            
            $alarma = Alarma::model()->findByAttributes(array('id'=>$id_alarma));
            $sucursal = Sucursal::model()->findByAttributes(array('id'=>$alarma{'id_suc'}));
            $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
            $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
            
            $datos = array();
            $date = date_create($alarma{'fecha'});
            $datos['fecha']= date_format($date, 'd-m-Y');
            
            
            $datos['id']= $alarma{'id'};
            $datos['descripcion']= $alarma{'descripcion'};
            $datos['vesperado']=$alarma{'valorEsperado'};
            $datos['vactual']=$alarma{'valorActual'};
            $datos['hs']=$alarma{'hs'};
            $datos['sucursal']=$sucursal{'nombre'};
            $datos['empresa']=$empresa{'razonsocial'};
            $datos['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
            
            
            $message = new YiiMailMessage;                     
            $message->subject = 'SCRM';
            $message->view ='test';//nombre de la vista q conformara el mail            
            $message->setBody(array('datos'=>$datos),'text/html');//codificar el html de la vista
            $message->from =('SCRM@sistema.com'); // alias del q envia
            $message->setTo('marcosrole@gmail.com'); // a quien se le envia

            if(Yii::app()->mail->send($message)){
                 Yii::app()->user->setFlash('success', "<strong>Enviado!</strong> Mail enviado correctamente ");
            }else  Yii::app()->user->setFlash('error', "<strong>Error!</strong> No se ha enviado el mail ");
            
            $this->redirect('admin');

        }
}
