<?php

class HistoasignacionController extends Controller

{
    private function stringConComatoArray($cadena){
        
    }
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
    
       public function actionCrear() {
        $dispositivo = new Dispositivo();
        $empresa = new Empresa();
        $sucursal = new Sucursal();
        $histasignacion = new Histoasignacion();
        
        $array_sucursal = array();
        $array_dispositivo = array();
        
        if (isset($_POST['selectEmpresa'])) {           
            if (isset($_POST['selectDispositivo'])) {
                $histasignacion->attributes = $_POST['Histoasignacion'];
                    $sucursal=Sucursal::model()->findByAttributes(array('id' => $_POST['selectEmpresa'][0]));            
                $histasignacion->id_suc =  $sucursal{'id'};
                    $dispositivo=  Dispositivo::model()->findByAttributes(array('id' => $_POST['selectDispositivo'][0]));            
                $histasignacion->id_dis=$dispositivo{'id'};
                $histasignacion->fechaBaja='1900-01-01';           
                //----------------------------------------------------------                        
                    //Cambio el formato de la fecha.
                    //SQL: yyyy-mm-dd
                    $originalDate = $histasignacion->{'fechaAlta'};
                    $newDate = date("Y-m-d", strtotime($originalDate));
                    $histasignacion->setAttribute('fechaAlta', $newDate);
                //----------------------------------------------------------             
            
                if($histasignacion->validate()){
                    $histasignacion->insert();
                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                                
                }else Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos invalidos o incompletos ");                                                
            }
        }
         
        $sucursal=new Sucursal();
        $dispositivo=new Dispositivo();             
        
        $dataProviderDispositivo = Dispositivo::model()->search();        
        $dataProviderDispositivo->setData(Histoasignacion::model()->getDispositivosDispoibles());                
        
        $this->render('crear', array(
            'dataProviderDispositivo' => $dataProviderDispositivo,                        
            'sucursal'=>$sucursal,
            'dispositivo' =>$dispositivo,
            'histasignacion' => $histasignacion));
    }
    
    public function actionModificar(){
        
        $histoasignacion = new Histoasignacion();
        $dataProvider = Histoasignacion::model()->search();                
        $dataProvider->setData(Histoasignacion::model()->getVigentes());    
        
        $this->render('modificar', array('histoasignacion'=>$histoasignacion, 'dataProvider'=>$dataProvider));
    }
    
    public function actionViewMap(){        
        $array_datos_mapa = array();
        $histoasignacion = Histoasignacion::model()->getDispositivosNODisponibles();
        $array_datos_mapa = Histoasignacion::model()->getDatosMapa();
                
        $this->render('viewmap', array('array_dispo'=>$array_datos_mapa));
    }


    public function actionPrueba(){
        //$histoasignaciones = Histoasignacion::model()->with('empresa')->findAll();
        $histoasignaciones = Histoasignacion::model()->with('dispositivo')->findAll();
        var_dump($histoasignaciones);
        die();
    }
    
    
    public function actionModificarModalEmpresa($id_dis, $id_suc){
        //Se puede cambiar la empresa.Pero la empresa puede como no ya tener un dispositivo. 
        //Unaempresa acepta 1 o mas dispositivos
       date_default_timezone_set('UTC');
        
       $histoasignacion = new Histoasignacion;
        
       $histoasignacion= Histoasignacion::model()->findByAttributes(
               array(
                   'id_dis'=>$id_dis,
                   'id_suc'=>$id_suc,));
       
        //Todas las scursales menos la actual
               
        $criterial = new CDbCriteria();
        $criterial->addCondition("id<>'" . $id_suc . "' " );
        $sucursal = Sucursal::model()->findAll($criterial);
            
        $dataProviderSucursal = Sucursal::model()->search();    
        //$dataProviderSucursal->setData($sucursal);
                
        $array_emprsa=array();
        if (isset($_POST['selectedEmpresa'])) {
            try {
                $histoasignacion->fechaBaja=date("Y" . "-" . "m" . "-" . "d");
                
                $array_empresa = (preg_split("/,/", $_POST['selectedEmpresa'][0]));                        

                $histoasignacionNEW = new Histoasignacion();            
                $histoasignacionNEW->id_dis=$id_dis;
                $histoasignacionNEW->id_suc=$_POST['selectedEmpresa'][0];
                $histoasignacionNEW->fechaAlta=$histoasignacion{'fechaAlta'};
                $histoasignacionNEW->fechaModif=date("Y" . "-" . "m" . "-" . "d");
                $histoasignacionNEW->fechaBaja=date("1900" . "-" . "1" . "-" . "1");
                $histoasignacionNEW->coordLat=$histoasignacion{'coordLat'};
                $histoasignacionNEW->coordLon=$histoasignacion{'coordLon'};            
                $histoasignacionNEW->observacion="Cambio de empresa: ". $_POST['Histoasignacion']['observacion'];

                $histoasignacionNEW->insert();
                $histoasignacion->save();

                $this->redirect(array('modificar'));
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', $ex->getMessage());
            }
            
        }
                   
        $this->render('modificarModalEmpresa',
                array(
                'empresa_original'=>$id_suc,                
                'sucursal'=>new Sucursal(),
                'dataProviderSucursal'=>$dataProviderSucursal,
                'histoasignacion'=>new Histoasignacion())
                );
    }
    
    public function actionModificarModalDispositivo($id_dis, $id_suc){
       date_default_timezone_set('UTC');
        
       $histoasignacion = new Histoasignacion;
        
        $histoasignacion= Histoasignacion::model()->findByAttributes(array('id_dis'=>$id_dis, 'id_suc'=>$id_suc));
        
        $dataProviderDispositivo = Dispositivo::model()->search();        
        $dataProviderDispositivo->setData(Histoasignacion::model()->getDispositivosDispoibles());
        
        if (isset($_POST['selectedDispositivo'])) {
            
            try {
                $histoasignacion->fechaBaja=date("Y" . "-" . "m" . "-" . "d");                
                
                $histoasignacionNEW = new Histoasignacion();            
                $histoasignacionNEW->id_dis=$_POST['selectedDispositivo'][0];                                
                $histoasignacionNEW->id_suc=$histoasignacion{'id_suc'};            
                $histoasignacionNEW->fechaAlta=$histoasignacion{'fechaAlta'};
                $histoasignacionNEW->fechaModif=date("Y" . "-" . "m" . "-" . "d");
                $histoasignacionNEW->fechaBaja=date("1900" . "-" . "1" . "-" . "1");
                $histoasignacionNEW->coordLat=$histoasignacion{'coordLat'};
                $histoasignacionNEW->coordLon=$histoasignacion{'coordLon'};            
                $histoasignacionNEW->observacion="Cambio de dispositivo: " . $_POST['Histoasignacion']['observacion'];                
                
                $histoasignacionNEW->insert();
                $histoasignacion->save();
                 Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Dispositivo modificado ");                                                            
                $this->redirect(array('modificar'));
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', $ex->getMessage());
            }
            
        }
        
        $this->render('modificarModalDispositivo',
                array(
                'dispositivo_original'=>$id_dis,                
                'dispositivo'=>new Dispositivo(),                   
                'dataProviderDispositivo'=>$dataProviderDispositivo,
                'histoasignacion'=>new Histoasignacion())
                );
    }
  
    public function actionEliminar($id_dis, $id_suc){
        date_default_timezone_set('UTC');
        $histoasignacion=new Histoasignacion();
        $newHistoAsignacion=new Histoasignacion();
        $histoasignacion=  Histoasignacion::model()->findByAttributes(array('id_dis'=>$id_dis, 'id_suc'=>$id_suc));        
        try{
            $newHistoAsignacion->fechaAlta=$histoasignacion->fechaAlta;
            $newHistoAsignacion->fechaModif=date("Y" . "-" . "m" . "-" . "d");
            $newHistoAsignacion->fechaBaja=date("Y" . "-" . "m" . "-" . "d");
            $newHistoAsignacion->coordLat = $histoasignacion->coordLat;
            $newHistoAsignacion->coordLon = $histoasignacion->coordLon;
            $newHistoAsignacion->id_dis = $id_dis;
            $newHistoAsignacion->id_suc = $id_suc;
            $newHistoAsignacion->observacion="Registro eliminado";                        
            $histoasignacion->delete();
            $newHistoAsignacion->insert();
            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Registro Eliminado ");                                                            
            $this->redirect(array('modificar'));
            
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error',$ex->getMessage());
        }
    }
    public function actionModal(){
        
        $this->render('modal');
    }
    public function actionList(){
        $histoasignacion = new Histoasignacion();
        
       $this->render('list',
               array(
                'histoasignacion'=>$histoasignacion)                
                );
               
    }

}
