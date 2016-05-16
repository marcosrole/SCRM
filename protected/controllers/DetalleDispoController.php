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
            //Si no está calibrado, NO SE PUEDE SEGUIR
            
            if (Calibracion::model()->findByAttributes(array('id_dis'=>$_GET['id'])) === null){
                $transaction->rollback ();                 
                Yii::app()->user->setFlash('error', "<strong>El dispositivo no se encuentra calibrado!</strong> <a href=" . "SCRM/calibracion/create?id_disp'" . ">Click para Calibrar Dispositivo</a>");
            }else{
                //Cargo los datos al modelo   
                DetalleDispo::model()->validarDatos($_GET['id']);

                $model->setAttribute('id_dis', $_GET['id']);
                $model->setAttribute('db', $_GET['db']);
                $model->setAttribute('distancia', $_GET['dist']);
                $model->setAttribute('fecha', $_GET['fecha']);
                $model->setAttribute('hs', $_GET['hs']);

                if ($model->validate()) {
                    if ($model->insert()) { //Si se guardo Correctamente.. insert() devuelve un boolean 
                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> El registro del dispositivo: " . $_GET['id'] . " se guardo corectamente");                                                
                        $transaction->commit();

                        //Cargo la table ACCESO DISPOSITIVO
                        $AccesoDispo = new Accesodispositivo();
                        Accesodispositivo::model()->deleteAllByAttributes(array('id_dis_detDis'=>$_GET['id']));
                        $AccesoDispo->fechaUltimo=$_GET['fecha'];
                        $AccesoDispo->hsUltimo=$_GET['hs'];
                        $AccesoDispo->id_detDis=$model{'id'};
                        $AccesoDispo->id_dis_detDis=$_GET['id'];

                        $AccesoDispo->insert();

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
                        'order'=>'fecha DESC, hs DESC',                       
                       'condition'=>'id_dis=:id',
                       'params'=>array(':id'=> $id),
        ));
        
        $detalles = DetalleDispo::model()->findAll($criteria);
        $dataProvider = DetalleDispo::model()->search();
        $dataProvider->setData($detalles);
        
        
        //Genero un array con los ultimos 10 datos sensados
        //array[[hs][db]];
        
        $datos_grafico = array();
        $datos_db = array();
        $datos_hs = array();
        $datos_db_permitido=array();
        $datos_dist = array();
        $datos_dist_permitido=array();
        
        $cant = 10; //Cantidad de datos para mostrar en el grafico
        
        //Genero una linea para determinar los limites del dispositivo.
        $calibracion = Calibracion::model()->findByAttributes(array('id_dis'=>$id));
        $db_limite = (int)$calibracion{'db_permitido'};        
        $dist_limite = (int)$calibracion{'dist_permitido'};        
        
        foreach ($detalles as $modelo){            
            if($cant!=0){
                $datos_db[]=(int)$modelo{'db'};
                $datos_dist[]=(int)$modelo{'distancia'};
                $datos_hs[]=$modelo{'hs'};
                $datos_db_permitido[]=$db_limite;
                $datos_dist_permitido[]=$dist_limite;
                $cant=$cant-1;
            }else                break;            
        }
            
        
        $datos_grafico['db']=$datos_db;
        $datos_grafico['dist']=$datos_dist;
        $datos_grafico['hs']=$datos_hs;
        $datos_grafico['db_permitido']=$datos_db_permitido;
        $datos_grafico['dist_permitido']=$datos_dist_permitido;
        
          
    
                
        $this->render('list',array(
            'dataProvider'=>$dataProvider,
            'datos_grafico'=>$datos_grafico,
            'id_dis' => $id
                ));
        
    }
    
    public function actionView(){
        $this->render('create', array('model' => $model, 'array_dispo' => $array_dispo)); 
    }
    
    
}