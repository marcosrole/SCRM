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
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('view'),
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
		$sucursal = new Sucursal();
                $direccion = new Direccion();
                $empresa = new Empresa();
                $localidad = new Localidad();
                $lista_localidades=  Localidad::model()->getListNombre();
                $transaction = Yii::app()->db->beginTransaction();             
                 try {
                     if (isset($_POST['selectEmpresa']) || (isset($_POST['Sucursal']) ) || ( isset($_POST['Direccion']) ) ) {
                        $direccion->attributes = $_POST['Direccion'];
                        $direccion->calle=  strtoupper($_POST['Direccion']['calle']);

                        $localidad_seleccionada = $lista_localidades[$_POST['Localidad']['id']];            
                        $direccion->id_loc = Localidad::model()->getId($localidad_seleccionada)->id;

                        if($direccion->validate()){
                            $direccion->insert();
                            $sucursal->attributes=$_POST['Sucursal'];
                            $sucursal->nombre=  strtoupper($_POST['Sucursal']['nombre']);

                                if(isset($_POST['selectEmpresa'])){
                                    $sucursal->id_dir=$direccion{'id'};
                                    $sucursal->cuit_emp=$_POST['selectEmpresa'][0];

                                    if($sucursal->validate()){
                                    $sucursal->insert();
                                    $transaction->commit();                        
                                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Complete el nombre de la sucursal");}
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sucursal']))
		{
			$model->attributes=$_POST['Sucursal'];
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Sucursal');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$rawData = array();
                $empresas = Empresa::model()->findAll();
                $sucursales = Sucursal::model()->findAll();
                foreach($sucursales as $item=>$sucursal){
                    $raw = array();
                    $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
                    $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                    $raw['id']=(int)$sucursal{'id'};
                    $raw['nombre']=$sucursal{'nombre'};
                    $raw['cuit']=$empresa{'cuit'};
                    $raw['razonsocial']=$empresa{'razonsocial'};                                    
                    $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " " . $direccion{'piso'} . " " . $direccion{'depto'};
                    $rawData[]=$raw;            
                                          
                }
                $arrayDataProvider=new CArrayDataProvider($rawData, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
               ));
                
                if (isset($_POST['Sucursal']) || isset($_POST['Empresa'])){                    
                                        
                }
               
               $this->render('admin',array(
                   'dataProvider'=>$arrayDataProvider,
                   'empresa'=>$empresa,
                   'sucursal'=>$sucursal,
                   ));
                
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
}
