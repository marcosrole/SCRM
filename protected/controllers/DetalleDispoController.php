<?php

class DetalleDispoController extends Controller
{
	
    public function actionDeleteAll(){
        $url_anterior = Yii::app()->user->returnUrl;
        die($url_anterior);
        DetalleDispo::model()->deleteAll();
        //Retorno a la URL 
        Yii::app()->request->redirect($url_anterior);
    }

    public function actionCreate() {  
        try {   
            $model = new DetalleDispo;       
        //Array con todos los dispositivos (id_dispo)        
        $array_dispo = array();        
        $dispositivos = Dispositivo::model()->findAll();         
        
        foreach ($dispositivos as $key => $value) {            
           $array_dispo[]= $value{'id'};
        }       
        $transaction = Yii::app()->db->beginTransaction();
        //Verifico que se hayan pasado parametros por la URL
        if (isset($_GET['id']) && isset($_GET['db']) && isset($_GET['dist']) && isset($_GET['fecha']) && isset($_GET['hs'])) {
            //Cargo los datos al modelo                        
            $model->setAttribute('id_dis', $_GET['id']);
            $model->setAttribute('db', $_GET['db']);
            $model->setAttribute('distancia', $_GET['dist']);
            $model->setAttribute('fecha', $_GET['fecha']);
            $model->setAttribute('hs', $_GET['hs']);
                        
            if ($model->validate()) {
                if ($model->insert()) { //Si se guardo Correctamente.. insert() devuelve un boolean 
                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> El registro del dispositivo: " . $_GET['id'] . " se guardo corectamente");                                                
                    $transaction->commit();
                }
            } else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios");}
        }
        
        //Se pregunta si el formulario ha sido enviado
        if (isset($_POST['DetalleDispo'])) {
            $model->attributes = $_POST['DetalleDispo'];
            $id_dispo_aux = $_POST['DetalleDispo']['id'];
            $model->id_dis=$array_dispo[$id_dispo_aux];
            
            if ($model->validate()) {
                //----------------------------------------------------------                        
                //Cambio el formato de la fecha.
                //SQL: yyyy-mm-dd
                $originalDate = $model->{'fecha'};
                $newDate = date("Y-m-d", strtotime($originalDate));
                $model->setAttribute('fecha', $newDate);
                //----------------------------------------------------------                                                
                $model->save();
                $transaction->commit();
                Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}
        }
            
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error',$ex->getMessage());
        }
        
        $this->render('create', array('model' => $model, 'array_dispo' => $array_dispo));
    }

    public function actionVerDetalle($id){
                       
        $model = new DetalleDispo('search');
        $model->unsetAttributes();  // clear any default values
        
        $criteria=new CDbCriteria(array(
                        'select'=>array('db',
                                        'distancia',
                                        'fecha',
                                        'hs',                                        
                                        ),
                        'order'=>'fecha DESC',                       
                       'condition'=>'id_dis=:id',
                       'params'=>array(':id'=> $id),
        ));
        
        $detalles = DetalleDispo::model()->findAll($criteria);
        $dataProvider = DetalleDispo::model()->search();
        $dataProvider->setData($detalles);
        
        
//        
//        $condition = new CDbCriteria();        
//        $condition->condition= "id_dispo='" . $id_dispo . "'";
//        $model = DetalleDispo::model()->findAll($condition);
                
        $this->render('list',array(
            'dataProvider'=>$dataProvider,
            'id_dis' => $id
                ));
        
    }
    
    public function actionView(){
        $this->render('create', array('model' => $model, 'array_dispo' => $array_dispo)); 
    }
}