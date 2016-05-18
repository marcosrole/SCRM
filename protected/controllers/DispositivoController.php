<?php

class DispositivoController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
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

    
          
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }
    public function actionHabilitarDispositivo($id=NULL) {
        $lista = Dispositivo::getListado();     
        if($id!=NULL){
            $Dispo =  Dispositivo::model()->findByAttributes(array('id'=>$id));
            if($Dispo{'funciona'}){
                $Dispo{'funciona'}=0;
            }else $Dispo{'funciona'}=1;
            $Dispo->save();
        }
        $this->render('HabilitarDispositivo', array('dispositivos'=>$lista));
    }
    
     public function actionModificar($id,$mac,$modelo,$version,$funciona){
         
        if (isset($_POST['Dispositivo'])) {
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $criterial = new CDbCriteria();
                $criterial->addCondition("id='".$id."'");
                $dispositivo = Dispositivo::model()->find($criterial);                               
                $dispositivo->attributes=$_POST['Dispositivo'];
                $dispositivo->modelo=$_POST['Dispositivo']['modelo'];;
                $dispositivo->version=$_POST['Dispositivo']['version'];
                $dispositivo->funciona=$_POST['Dispositivo']['funciona'];                
                
                if($dispositivo->validate()){
                    $dispositivo->save();
                    $transaction->commit(); 
                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Datos actualizados ");                                                
                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos ");}
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
            }
        }
              
        $dispositivo = new Dispositivo();
        
        if( Yii::app()->request->isAjaxRequest )
            {
            $criterial =new CDbCriteria();
            $criterial->condition="id='" . $id . "' ";
            $dispositivo= Dispositivo::model()->find($criterial);

            $this->renderPartial('_ModalModificar',array(
                'dispositivo'=>$dispositivo,
            ), false, true);
        }
        else
        {
            $this->render('admin',array(
                'dispositivo'=>$dispositivo
            ));
        }
    }
    
    public function action_ModalModificar()
    {   
        $this->render('_ModalModificar');
    }
    
    public function actionAsignar() {
        $model = new Dispositivo;
        $model->unsetAttributes();
        
        //Verifico que se hayan pasado parametros por la URL
        if (isset($_GET['id_dispositivo']) && isset($_GET['ubic']) && isset($_GET['lat']) && isset($_GET['lon'])){            
            //Cargo los datos al modelo
            $model->setAttribute('id_dispositivo', $_GET['id_dispositivo']);
            $model->setAttribute('ubicacion', $_GET['ubic']);
            $model->setAttribute('coord_lat', $_GET['lat']);
            $model->setAttribute('coord_lon', $_GET['lon']);
            
            //Verifico que el id NO EXISTA, y si es asi, guardo.!
            $criterial = new CDbCriteria;
            $criterial->condition = "id_dispositivo='" . $model->{'id_dispositivo'} . "'";
            if (!$model->find($criterial)) {
                if ($model->validate()) {
                    if ($model->insert()) { //Si se guardo Correctamente.. insert() devuelve un boolean 
                        echo "El dispositivo: ". $_GET['id_dispositivo'] . " se guardo corectamente";
                    }
                }else echo "ERROR: Datos incorrectos";
            }else echo "ERROR: El dispositivo: ". $_GET['id_dispositivo'] . " ya se encuentra almacenado";                    
            
        }elseif (isset($_POST['Dispositivo'])) {
            $model->attributes = $_POST['Dispositivo'];
            $criterial = new CDbCriteria;
            $criterial->condition = "id_dispositivo='" . $model->{'id_dispositivo'} . "'";
            if (!$model->find($criterial)) {
                if ($model->validate()) {
                    if ($model->insert()) { //Si se guardo Correctamente.. insert() devuelve un boolean                            
                        $user = Yii::app()->getComponent('user');
                        $user->setFlash('success', "<strong>Guardado!</strong> Se ha almacenado correctamente.");
                        $this->widget('booster.widgets.TbAlert', array(
                            'fade' => true,
                            'closeText' => '&times;', // false equals no close link
                            'events' => array(),
                            'htmlOptions' => array(),
                            'userComponentId' => 'user',
                            'alerts' => array(// configurations per alert type
                                // success, info, warning, error or danger
                                'success' => array('closeText' => '&times;'),
                            ),
                        ));
                        header('Refresh:2;url=' . $this->createUrl('Dispositivo/create'));
                    }
                }
            } else { //Muestro msj
                echo "Id ya existe";
                header('Refresh:2;url=' . $this->createUrl('Dispositivo/create'));
            }
        }
        
//        echo $_GET[$param_id_dispositivo];
//           die();
//        //Pregunto si viene algo por parametro
//        if($_GET[$param_id_dispositivo]!=''){
//           echo $_GET[$param_id_dispositivo];
//           die();
//        }

        $this->render('asignar', array(
            'model' => $model,
        ));
        
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    
   
    
    public function actionCreate() {
    try {
        $transaction = Yii::app()->db->beginTransaction();
        $model = new Dispositivo;
        $model->unsetAttributes();
        if (isset($_POST['Dispositivo'])) {
            $model->setAttribute('id', rand(1, 1000));
            $model->setAttribute('mac', strtoupper($_POST['Dispositivo']['mac']));
            $model->setAttribute('modelo', strtoupper($_POST['Dispositivo']['modelo']));
            $model->setAttribute('version', strtoupper($_POST['Dispositivo']['version']));
            $model->setAttribute('funciona', 0);
            $model->setAttribute('tiempo', $_POST['Dispositivo']['tiempo']);
            
            if ($model->validate()) {
                $validacion=true;
                while ($validacion) {
                    if (Dispositivo::exitsMAC($model->{'mac'})) {
                        $validacion = false;
                    }elseif (Dispositivo::exitsid($model->{'id'})) {
                        $model->setAttribute('id', rand(1, 1000));
                    }else $validacion=false;
                }
                if (Dispositivo::exitsMAC($model->{'mac'})){
                    {Yii::app()->user->setFlash('info', "<strong>Advertencia!</strong> Ya existe un dispositivo con la misma MAC ");}
                }elseif ($model->insert()) { //Si se guardo Correctamente.. insert() devuelve un boolean                            
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Datos guardados ");                                                
                    Yii::app()->user->setFlash('info', "<strong>Número de Identificación: </strong> <FONT SIZE=6>" . $model{'id'} . "</FONT> ");                                                
                }
            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos ");}
        }
        } catch (Exception $ex) {
             Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
        }
        
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    
    public function actionList(){
        $lista = Dispositivo::getListado();                
        $this->render('list', array('dispositivos'=>$lista));
    }
    
    public function actionDeleteAll() {
        $url_anterior = Yii::app()->user->returnUrl;
        //Elimino todas las tablas relacionadas con Dispositivo        
        DetalleDispo::model()->deleteAll();
        //Elimino todos los dispositivos       
        Dispositivo::model()->deleteAll();
        //Retorno a la URL 
        Yii::app()->request->redirect($this->createUrl('Dispositivo/admin'));
    }

    public function actionUpdate($id) {  
        $dispositivo = new Dispositivo();
        $condition = new CDbCriteria();
        $condition = "id='" . $id . "' ";
        $dispositivo = Dispositivo::model()->find($condition);
                
        $this->render('update', array(
            'dispositivo' => new Dispositivo(),
            'id_dis' => $id,
        ));
       
    }
    public function actionEliminar($id) {
        try {
            $transaction = Yii::app()->db->beginTransaction();
            $condition = new CDbCriteria();
            $condition = "id='" . $id . "' ";
            DetalleDispo::model()->deleteAll($condition);
            Histoasignacion::model()->deleteAllByAttributes(array('id_dis'=>$id));
                $condition = "id='" . $id . "' ";
                if(Dispositivo::model()->deleteAll($condition)){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Datos eliminados ");  
                    $this->redirect(array('admin'));
                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Al elimiar ");}
           
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error',$ex->getMessage());
        }
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Dispositivo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {        
        $this->render('admin', array(
            'dispositivo' => new Dispositivo(),
        ));
    }

    public function loadModel($id) {
        $model = Dispositivo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Dispositivo $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dispositivo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
