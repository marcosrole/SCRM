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
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view','list','prueba',
                    'create', 'update','read','deleteall','viewmap',
                    'admin', 'delete','eliminar', 'asignar', 'listar'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    
    public function actionRead(){
        echo $this->createUrl('dispositivo/create',array('txt'=>'Hola','id'=>'1212'));
    }
          


    public function actionView($id) {
        
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
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
        $model = new Dispositivo;
        $model->unsetAttributes();
        if (isset($_POST['Dispositivo'])) {
            $model->setAttribute('id_dis', rand(1, 1000));
            $model->setAttribute('mac', $_POST['Dispositivo']['mac']);
            $model->setAttribute('modelo', $_POST['Dispositivo']['modelo']);
            $model->setAttribute('version', $_POST['Dispositivo']['version']);
            $model->setAttribute('funciona', true);
            
            if ($model->validate()) {
                
                $validacion=true;
                
                while ($validacion) {
                    if (Dispositivo::exitsMAC($model->{'mac'})) {
                        $validacion = false;
                    }elseif (Dispositivo::exitsid($model->{'id_dis'})) {
                        $model->setAttribute('id_dis', rand(1, 1000));
                    }else $validacion=false;
                }
                
                if (Dispositivo::exitsMAC($model->{'mac'})){
                    echo 'Existe MAC';
                    header('Refresh:2;url=' . $this->createUrl('Dispositivo/create'));
                }elseif ($model->insert()) { //Si se guardo Correctamente.. insert() devuelve un boolean                            
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
    
    public function actionViewMap(){
        $dispositivos = new Dispositivo;
        $dispositivos = Dispositivo::model()->findAll();
        
        $array_dispo = array();
        
        foreach ($dispositivos as $key => $value) {
            $array_dispo[] = [$value{'id_dispositivo'}, $value{'coord_lat'},$value{'coord_lon'}, $value{'ubicacion'}];
        }
        $this->render('viewmap', array('array_dispo'=>$array_dispo));
    }
    
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

    public function actionUpdate() {
        var_dump($_GET['id_dis']);
        die();
        $model = $this->loadModel($id);

        if (isset($_POST['Dispositivo'])) {
            $model->attributes = $_POST['Dispositivo'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_dispositivo));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionEliminar($id) {
        
       $condition = new CDbCriteria();
       $condition = "id_dis='" . $id . "' ";
       DetalleDispo::model()->deleteAll($condition);
       
       $condition = "id_dis='" . $id . "' ";
       Dispositivo::model()->deleteAll($condition);    
       
       $this->redirect(array('admin'));
       
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Dispositivo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Dispositivo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Dispositivo']))
            $model->attributes = $_GET['Dispositivo'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Dispositivo the loaded model
     * @throws CHttpException
     */
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
