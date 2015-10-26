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
	/*public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'calibracion'=>$this->loadModel($id),
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

	/**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id_disp) {
        $dispositivo = new Dispositivo();
        $calibracion = new Calibracion();
        if (isset($_POST['Calibracion'])) {
            $calibracion->attributes = $_POST['Calibracion'];
            $calibracion->id_dis=$_GET['id_disp'];            
            $histoasignacion = new Histoasignacion();
            $histoasignacion = Histoasignacion::model()->findAllByAttributes(array('id_dis'=>$_GET['id_disp'],'fechaBaja'=>'1900-01-01'));
            $calibracion->id_suc=$histoasignacion[0]['id_suc'];
            
            
            if(Calibracion::model()->exists('id_dis=' . $calibracion{'id_dis'} . ' AND id_suc=' . $calibracion{'id_suc'} .  ' ' )){
                    $modeloCalibracion = Calibracion::model()->findByAttributes(
                    array(                      
                        'id_dis'=>$calibracion{'id_dis'},
                        'id_suc'=>$calibracion{'id_suc'}));
                    $modeloCalibracion->db_permitido= $calibracion{'db_permitido'};
                    $modeloCalibracion->dist_permitido= $calibracion{'dist_permitido'};
            
                    if($calibracion->validate()){                                
                        if ($modeloCalibracion->save()) $this->redirect(array('view', 'id' => $modeloCalibracion->id));
                    }          
            }else {
                if($calibracion->validate()){                                
                    if ($calibracion->insert())
                        $this->redirect(array('view', 'id' => $calibracion->id));
                }                
            }
                        
        }        
        if ($_GET['id_disp'] != '') { //Si NO viene vacio...
            //Verifico cual es la sucursal en la que se encuentra instalado actualmente
            $histoasignacion = new Histoasignacion();
            $histoasignacion = Histoasignacion::model()->findAllByAttributes(array('id_dis'=>$_GET['id_disp'],'fechaBaja'=>'1900-01-01'));
            $calibracion->id_suc=$histoasignacion[0]['id_suc'];
            
            //Si el dispositivo ya se enceuntra calibrado, cargo los datos actuales.          
            $calibracion_aux=Calibracion::model()->findByAttributes(array('id_suc'=>$calibracion{'id_suc'}));
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
        
        $dataprovieder->setData($array_dispositivos);
        
        $this->render('create', array(
                'calibracion' => $calibracion,
                'dataprovieder' => $dataprovieder,
                'dispositivo' => $dispositivo,
            ));
    }

    /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$calibracion=$this->loadModel($id);
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
        
        /** Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	

	/**
	 * Listar calibraciones realizadas	 
	 */
	public function actionList()
	{
            $this->render('list',array(
                    'calibracion'=>new Calibracion(),
            ));   
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Calibracion the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Calibracion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Calibracion $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='calibracion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
