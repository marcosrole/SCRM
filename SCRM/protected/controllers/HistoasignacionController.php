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
        $histasignacion = new Histoasignacion();
        
        $array_empresa = array();
        $array_dispositivo = array();
        
        if (isset($_POST['selectedIds1'])) {

            $array_empresa = (preg_split("/,/", $_POST['selectedIds1'][0]));

            if (isset($_POST['selectedIds2'])) {
                $array_dispositivo = (preg_split("/,/", $_POST['selectedIds2'][0]));

                $histasignacion->attributes = $_POST['Histoasignacion'];
            }
            
            $histasignacion->cuit_emp=$array_empresa[0];
            $histasignacion->razonsocial_emp=$array_empresa[1];
            $histasignacion->mac_dis=$array_dispositivo[1];
            $histasignacion->id_dis=$array_dispositivo[0];
            $histasignacion->fecha_baja='1900-01-01';
            
            //----------------------------------------------------------                        
                //Cambio el formato de la fecha.
                //SQL: yyyy-mm-dd
                $originalDate = $histasignacion->{'fecha_alta'};
                $newDate = date("Y-m-d", strtotime($originalDate));
                $histasignacion->setAttribute('fecha_alta', $newDate);
            //---------------------------------------------------------- 
           
            
            if($histasignacion->validate()){
                if($histasignacion->insert()){
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
                        header('Refresh:2;url=' . $this->createUrl('histoasignacion/crear'));
                }
            }
        }
        
        
        $dataProviderDispositivo = Dispositivo::model()->search();        
        $dataProviderDispositivo->setData(Histoasignacion::model()->getDispositivosDispoibles());        
        $dataProviderEmpresas = Empresa::model()->search();          
        $dataProviderEmpresas->setData(Histoasignacion::model()->getEmpresaDispoibles());        
        
        $this->render('crear', array(
            'dataProviderDispositivo' => $dataProviderDispositivo,
            'dataProviderEmpresas' => $dataProviderEmpresas,
            'empresa'=>$empresa,
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
    
    
    public function actionModificarModalEmpresa($id_dis, $razonsocial){
        //Se puede cambiar la empresa.Pero la empresa puede como no ya tener un dispositivo. 
       date_default_timezone_set('UTC');
        
       $histoasignacion = new Histoasignacion;
        
       $condition = new CDbCriteria();
       $condition->addCondition("id_dis='" . $id_dis . "' "); 
        $condition->addCondition("razonsocial_emp='" . $razonsocial . "' ");        
       $histoasignacion= Histoasignacion::model()->find($condition);
       
        
        $dataProviderEmpresas = Empresa::model()->search();        
        $dataProviderEmpresas->setData(Histoasignacion::model()->getEmpresaDispoibles());
        
        $array_emprsa=array();
        if (isset($_POST['selectedEmpresa'])) {
            try {
                $histoasignacion->fecha_baja=date("Y" . "-" . "m" . "-" . "d");
                
                $array_empresa = (preg_split("/,/", $_POST['selectedEmpresa'][0]));                        

                $histoasignacionNEW = new Histoasignacion();            
                $histoasignacionNEW->id_dis=$id_dis;
                $histoasignacionNEW->mac_dis=$histoasignacion{'mac_dis'};
                $histoasignacionNEW->razonsocial_emp=$array_empresa[1];            
                $histoasignacionNEW->cuit_emp=$array_empresa[0];
                $histoasignacionNEW->fecha_alta=$histoasignacion{'fecha_alta'};
                $histoasignacionNEW->fecha_modif=date("Y" . "-" . "m" . "-" . "d");
                $histoasignacionNEW->fecha_baja=date("1900" . "-" . "1" . "-" . "1");
                $histoasignacionNEW->coord_lat=$histoasignacion{'coord_lat'};
                $histoasignacionNEW->coord_lon=$histoasignacion{'coord_lon'};            
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
                'empresa_original'=>$razonsocial,                
                'empresa'=>new Empresa(),                   
                'dataProviderEmpresas'=>$dataProviderEmpresas,
                'histoasignacion'=>$histoasignacion)
                );
    }
    
    public function actionModificarModalDispositivo($id_dis, $razonsocial){
       date_default_timezone_set('UTC');
        
       $histoasignacion = new Histoasignacion;
        
        $condition = new CDbCriteria();       
        $condition->addCondition("id_dis='" . $id_dis . "' "); 
        $condition->addCondition("razonsocial_emp='" . $razonsocial . "' ");        
        $histoasignacion= Histoasignacion::model()->find($condition);
        
        $dataProviderDispositivo = Dispositivo::model()->search();        
        $dataProviderDispositivo->setData(Histoasignacion::model()->getDispositivosDispoibles());
        
        if (isset($_POST['selectedDispositivo'])) {
            try {
                $histoasignacion->fecha_baja=date("Y" . "-" . "m" . "-" . "d");
                

                $array_dispositivo = (preg_split("/,/", $_POST['selectedDispositivo'][0]));                        
               
                $histoasignacionNEW = new Histoasignacion();            
                $histoasignacionNEW->id_dis=$array_dispositivo[0];
                $histoasignacionNEW->mac_dis=$array_dispositivo[1];            
                $histoasignacionNEW->razonsocial_emp=$histoasignacion{'razonsocial_emp'};            
                $histoasignacionNEW->cuit_emp=$histoasignacion{'cuit_emp'};            
                $histoasignacionNEW->fecha_alta=$histoasignacion{'fecha_alta'};
                $histoasignacionNEW->fecha_modif=date("Y" . "-" . "m" . "-" . "d");
                $histoasignacionNEW->fecha_baja=date("1900" . "-" . "1" . "-" . "1");
                $histoasignacionNEW->coord_lat=$histoasignacion{'coord_lat'};
                $histoasignacionNEW->coord_lon=$histoasignacion{'coord_lon'};            
                $histoasignacionNEW->observacion="Cambio de dispositivo: " . $_POST['Histoasignacion']['observacion'];
                
                $histoasignacionNEW->insert();
                $histoasignacion->save();

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
                'histoasignacion'=>$histoasignacion)
                );
    }
  
    public function actionEliminar($id, $razonsocial){
        
        $histoasignacion=new Histoasignacion();
        $condition = new CDbCriteria();
        $condition->addCondition("id_dis='" . $id . "' "); 
        $condition->addCondition("razonsocial_emp='" . $razonsocial . "' ");  
        $histoasignacion=  Histoasignacion::model()->find($condition);
        try{
            $histoasignacion->fecha_baja=date("Y" . "-" . "m" . "-" . "d");
            $histoasignacion->fecha_modif=date("Y" . "-" . "m" . "-" . "d");
            $histoasignacion->observacion="Registro eliminado";
            $histoasignacion->save();
            
            $this->redirect(array('modificar'));
            
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error',$ex->getMessage());
        }
    }
    public function actionModal(){
        
        $this->render('modal');
    }
    public function actionList(){
       $this->render('list',
               array(
                'histoasignacion'=>new Histoasignacion())                
                );
               
    }

}
