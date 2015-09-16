<?php

class UsuarioController extends Controller
{
	public function actionCrear()
	{
            $persona = new Persona();
            $usuario = new Usuario();
            $direccion = new Direccion();
            $localidad = new Localidad;  
            
            $lista_localidades=  Localidad::model()->getListNombre();
            
            try {
                if(isset($_POST['Direccion'])){
                $direccion->attributes=$_POST['Direccion'];                
                /*FK1*/$direccion->id_loc = Localidad::model()->getId($lista_localidades[$_POST['Localidad']['id']])->id;
              
                if ($direccion->validate()){
                    //$direccion->insert();                    
                    $persona->attributes=$_POST['Persona'];                                         
                    /*FK1*/ $persona->id_dir = Direccion::model()->getId_dir($direccion{'altura'}, $direccion{'calle'}, $direccion{'piso'}, $direccion{'depto'})->id;
                    
                    if($persona->validate()){
                        //$persona->insert();                        
                        $usuario->attributes=$_POST['Usuario'];
                        /*FK1*/ $usuario->dni_per=$persona{'dni'};
                        $usuario->insert();
                        
                        
                        $this->render('crear',
                        array(
                            'usuario'=>new Usuario(),
                            'persona'=>new Persona(),
                            'direccion'=>new Direccion(),
                            'localidad'=>new Localidad(),
                            'lista_localidades'=>$lista_localidades,
                        ));                        
                    }
                } 
            }
                
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', $ex->getMessage());
            }
            
            $this->render('crear',
                    array(
                        'usuario'=>$usuario,
                        'persona'=>$persona,
                        'direccion'=>$direccion,
                        'localidad'=>$localidad,
                        'lista_localidades'=>$lista_localidades,
                        ));
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
}