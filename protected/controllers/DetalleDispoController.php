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
        $model = new DetalleDispo;       
        //Array con todos los dispositivos (id_dispo)        
        $array_dispo = array();        
        $dispositivos = Dispositivo::model()->findAll();         
        
        foreach ($dispositivos as $key => $value) {            
           $array_dispo[]= $value{'id_dis'};
        }       
        
        //Verifico que se hayan pasado parametros por la URL
        if (isset($_GET['mac']) && isset($_GET['db']) && isset($_GET['dist']) && isset($_GET['fecha']) && isset($_GET['hs'])) {
            //Cargo los datos al modelo            
            $model->setAttribute('mac_dis', $_GET['mac']);
            $model->setAttribute('id_dis', Dispositivo::getid_dis($_GET['mac']));
            $model->setAttribute('db', $_GET['db']);
            $model->setAttribute('distancia', $_GET['dist']);
            $model->setAttribute('fecha', $_GET['fecha']);
            $model->setAttribute('hs', $_GET['hs']);
                        
            if ($model->validate()) {
                if ($model->insert()) { //Si se guardo Correctamente.. insert() devuelve un boolean 
                    echo "El registro del dispositivo: " . $_GET['mac'] . " se guardo corectamente";
                }
            } else
                echo "ERROR: Datos incorrectos";
        }
        
        //Se pregunta si el formulario ha sido enviado
        if (isset($_POST['DetalleDispo'])) {
            $model->attributes = $_POST['DetalleDispo'];
            $id_dispo_aux = $_POST['DetalleDispo']['id_dis'];
            $model->id_dis=$array_dispo[$id_dispo_aux];
            
            if ($model->validate()) {

                //----------------------------------------------------------                        
                //Cambio el formato de la fecha.
                //SQL: yyyy-mm-dd
                $originalDate = $model->{'fecha'};
                $newDate = date("Y-m-d", strtotime($originalDate));
                $model->setAttribute('fecha', $newDate);
                //----------------------------------------------------------                                                

                if ($model->save()) { //Si se guardo Correctamente.. insert() devuelve un boolean                            
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
                    header('Refresh:2;url=' . $this->createUrl('DetalleDispo/create'));
                } else {
                    $user = Yii::app()->getComponent('user');
                    $user->setFlash('wrong', "<strong>Error!</strong> Se haproducido un error.");
                    header('Refresh:2;url=' . $this->createUrl('DetalleDispo/create'));
                }
            }
        }
        
        $this->render('create', array('model' => $model, 'array_dispo' => $array_dispo));
    }

    public function actionViewbyPk(){
        $id_dispo=$_GET['id_dispo'];
               
        $model = new DetalleDispo('search');
        $model->unsetAttributes();  // clear any default values
        
        $criteria=new CDbCriteria(array(
                        'select'=>array('s_db',
                                        's_dist',
                                        'fecha',
                                        'hs',                                        
                                        ),
                        'order'=>'fecha DESC',                       
                       'condition'=>'id_dispo=:id',
                       'params'=>array(':id'=> $id_dispo),
        ));
        
        $dataProvider=new CActiveDataProvider('DetalleDispo', array(
            'criteria'=>$criteria,             
            ));
        
//        
//        $condition = new CDbCriteria();        
//        $condition->condition= "id_dispo='" . $id_dispo . "'";
//        $model = DetalleDispo::model()->findAll($condition);
                
        $this->render('list',array(
            'dataProvider'=>$dataProvider,
            'id_dispo' => $id_dispo
                ));
        
    }
    
    public function actionView(){
        $this->render('create', array('model' => $model, 'array_dispo' => $array_dispo)); 
    }
}