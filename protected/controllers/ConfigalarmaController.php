<?php

class ConfigalarmaController extends Controller
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
		$model=new Configalarma;
                $model = Configalarma::model()->find();
                
                $minutosDisponibles=['1','3','5','10','30','60','120','180','300','1440','2880'];
                $porcentajeAceptacion=['10%','20%','30%','40%','50%','60%','70%','80%','90%','100%'];

		
		if(isset($_POST['Configalarma']))
		{
			$model->attributes=$_POST['Configalarma'];
                        
                        $model{'segCont'}=$minutosDisponibles[$_POST['Configalarma']['segCont']]*60;
                        $model{'porcCont'}=(int)str_replace('%', '', $porcentajeAceptacion[$_POST['Configalarma']['porcCont']])/100.0;
                        $model{'recibirAlaContinuo'}=$minutosDisponibles[$_POST['Configalarma']['recibirAlaContinuo']]*60;
                        
                        $model{'segInt'}=$minutosDisponibles[$_POST['Configalarma']['segInt']]*60;
                        $model{'porcInt'}=(int)str_replace('%', '', $porcentajeAceptacion[$_POST['Configalarma']['porcInt']])/100.0;
                        $model{'recibirAlaIntermitente'}=$minutosDisponibles[$_POST['Configalarma']['recibirAlaIntermitente']]*60;
                        
                        $model{'segDis'}=$minutosDisponibles[$_POST['Configalarma']['segDis']]*60;
                        $model{'porcDis'}=(int)str_replace('%', '', $porcentajeAceptacion[$_POST['Configalarma']['porcDis']])/100.0;
                        $model{'recibirAlaDistancia'}=$minutosDisponibles[$_POST['Configalarma']['recibirAlaDistancia']]*60;
                        
                        $model{'segMuerto'}=$minutosDisponibles[$_POST['Configalarma']['segMuerto']]*60;
                        $model{'recibirAlaMuerto'}=$minutosDisponibles[$_POST['Configalarma']['recibirAlaMuerto']]*60;
                        
                        $model{'tolResponsable'}=$minutosDisponibles[$_POST['Configalarma']['tolResponsable']]*60;
                        
                                                
			if($model->save())
				 Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Datos actualizados ");   
		}
                 $model->segCont=array_search((string)$model{'segCont'}/60,$minutosDisponibles);
                $model->porcCont=array_search((string)$model{'porcCont'}*100 . "%", $porcentajeAceptacion);
                $model->recibirAlaContinuo=array_search((string)$model{'recibirAlaContinuo'}/60,$minutosDisponibles);
                
                $model->segInt=array_search((string)$model{'segInt'}/60,$minutosDisponibles);
                $model->porcInt=array_search((string)$model{'porcInt'}*100 . "%", $porcentajeAceptacion);
                $model->recibirAlaIntermitente=array_search((string)$model{'recibirAlaIntermitente'}/60,$minutosDisponibles);
                
                $model->segDis=array_search((string)$model{'segDis'}/60,$minutosDisponibles);
                $model->porcDis=array_search((string)$model{'porcDis'}*100 . "%", $porcentajeAceptacion);
                $model->recibirAlaDistancia=array_search((string)$model{'recibirAlaDistancia'}/60,$minutosDisponibles);
                
                $model->segMuerto=array_search((string)$model{'segMuerto'}/60,$minutosDisponibles);
                $model->recibirAlaMuerto=array_search((string)$model{'recibirAlaMuerto'}/60,$minutosDisponibles);
                
                $model->tolResponsable=array_search((string)$model{'tolResponsable'}/60,$minutosDisponibles);

		$this->render('create',array(
			'model'=>$model,
                        'minutosDisponibles'=>$minutosDisponibles,
                        'porcentajeAceptacion'=>$porcentajeAceptacion,
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

		if(isset($_POST['Configalarma']))
		{
			$model->attributes=$_POST['Configalarma'];
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
		$dataProvider=  Configalarma::model()->search();
                $this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Configalarma();                
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Configalarma']))
			$model->attributes=$_GET['Configalarma'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Configalarma the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Configalarma::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Configalarma $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='configalarma-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
