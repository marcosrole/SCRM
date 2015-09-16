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
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(isset($_POST['Direccion'])){
                $direccion->attributes=$_POST['Direccion'];                
                /*FK1*/$direccion->id_loc = Localidad::model()->getId($lista_localidades[$_POST['Localidad']['id']])->id;
                
                if ($direccion->validate()){                    
                    $direccion->save();                    
                    $persona->attributes=$_POST['Persona'];                                                             
                    $persona->altura_dir=$direccion{'altura'};
                    $persona->calle_dir=$direccion{'calle'};
                    /*FK1*/ $persona->id_dir = Direccion::model()->getId_dir($direccion{'altura'}, $direccion{'calle'}, $direccion{'piso'}, $direccion{'depto'})->id;
                    
                    if($persona->validate() && !$persona->exists("dni='" . $persona{'dni'} . "'")){                        
                        $persona->save(); 
                        
                        $usuario->attributes=$_POST['Usuario'];
                        /*FK1*/ $usuario->dni_per=$persona{'dni'};
                        
                        if($usuario->validate() && !$usuario->exists("name='" . $usuario{'name'} . "' ")){
                            $usuario->save();
                            
                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                            $transaction->commit(); 
                           // sleep(18000);
                            $this->redirect('crear');
                            
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o Usuario ya existente ");}
                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o Persona ya existente ");}                                                
                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios ");}                                                
            }
                
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
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