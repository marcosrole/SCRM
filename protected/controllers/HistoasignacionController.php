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
            
            $histasignacion->cuit_emp=(int)$array_empresa[0];
            $histasignacion->razonsocial_emp=$array_empresa[1];
            $histasignacion->mac_dis=$array_dispositivo[0];
            $histasignacion->id_dis=(int)$array_dispositivo[1];
            
            if($histasignacion->validate()){
                echo "TODO OK";
            }
        }

        $this->render('crear', array(
            'dispositivo' => $dispositivo,
            'empresa' => $empresa,
            'histasignacion' => $histasignacion));
    }

}
