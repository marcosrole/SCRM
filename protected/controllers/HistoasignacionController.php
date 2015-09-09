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

        $this->render('crear', array(
            'dispositivo' => $dispositivo,
            'empresa' => $empresa,
            'histasignacion' => $histasignacion));
    }
    
    public function actionModificar(){
        $histoasignacion = new Histoasignacion();
        $this->render('modificar', array('histoasignacion'=>$histoasignacion));
    }
    
    /* Busca los dispositivos disponibles*/
    private function DispositivosDisponibles(){
        
    }


    public function actionPrueba(){
        //$histoasignaciones = Histoasignacion::model()->with('empresa')->findAll();
        $histoasignaciones = Histoasignacion::model()->with('dispositivo')->findAll();
        var_dump($histoasignaciones);
        die();
    }
    
    
    public function actionModificarModal($id_dis, $razonsocial){
        
        $dataProviderEmpresas = Empresa::model()->search();        
        $dataProviderEmpresas->setData(Histoasignacion::model()->getEmpresaDispoibles());
        
        $dataProviderDispositivos = Dispositivo::model()->search();        
        $dataProviderDispositivos->setData(Histoasignacion::model()->getDispositivosDispoibles());
        
        
        
        $histoasignacion = new Histoasignacion;
        $this->render('modificarModal',
                array('empresa_original'=>$razonsocial,
                'dispositivo_original'=>$id_dis,                
                'dataProviderDispositivos'=>$dataProviderDispositivos,             
                'dataProviderEmpresas'=>$dataProviderEmpresas,
                'histoasignacion'=>$histoasignacion)
                );
    }
  
    public function actionModal(){
        
        $this->render('modal');
    }

}
