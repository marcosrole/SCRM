<?php

class UsuarioController extends Controller
{
    public function actionList(){
     $usuario = new Usuario();     
     $this->render('view', array('usuario'=>$usuario));
    }  
    
    public function actionAdminUsuarios(){
     $usuario = new Usuario();     
     $this->render('adminusuarios', array('usuario'=>$usuario));
    }  
    
    public function actionUpdate($id)
    {
        $usuario = new Usuario();
        $usuario=  Usuario::model()->findByAttributes(array('id'=>$id));        
        if (isset($_POST['Usuario'])){
            $usuario->attributes=$_POST['Usuario'];           
            $usuario->save();
            Yii::app()->user->setFlash('success', "<strong>Acualización!</strong> Contraseña modificada "); 
            
            $this->redirect('list',array('usuario'=>new Usuario()));
        }
        
        $usuario=  Usuario::model()->findByAttributes(array('id'=>$id));        
        $this->render('update',array(
            'usuario'=>$usuario
        ));
        
    }
    
    public function action_ModalModificar()
    {   
        $this->render('_ModalModificar');
    }
    
    public function actionEliminar($name){
        $usuario = new Usuario();
        try {
             $transaction = Yii::app()->db->beginTransaction();
             $criterial =new CDbCriteria();
             $criterial->condition="name='" . $name . "' ";             
             $usuario= Usuario::model()->find($criterial);
             $usuario->delete();
             $transaction->commit();
             Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Usuario eliminado "); 
                         
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
        }
        $this->render('list',array(
                'usuario'=>new Usuario()
            ));
    }


    public function actionCreate()
	{
            
            $persona = new Persona();
            $usuario = new Usuario();
            $direccion = new Direccion();
            $localidad = new Localidad;  
            $lista_localidades=  Localidad::model()->getListNombre();
            $permisos = Permiso::model()->findAll();
                                                  
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if(isset($_POST['Direccion'])){
                $direccion->attributes=$_POST['Direccion'];                
                $direccion->calle=  strtoupper($_POST['Direccion']['calle']);
                $direccion->depto=  strtoupper($_POST['Direccion']['depto']);                
                /*FK1*/$direccion->id_loc = Localidad::model()->getId($lista_localidades[$_POST['Localidad']['id']])->id;                
                
                if ($direccion->validate()){ 
                    //Me fijo si ya existe para no guardar dos veces la misma direccion;
                    $criterial = new CDbCriteria();
                    $criterial->condition="calle='" . $direccion->calle . "' ";
                    $criterial->addCondition(
                            "altura='" . $direccion->altura . "' AND" .
                            " piso='" . $direccion->piso . "' AND" .
                            " depto='" . $direccion->depto . "' AND" .
                            " id_loc='" . $direccion->id_loc . "' "
                            );                    
                    if(! (Direccion::model()->find($criterial))){//Si NO existe => GUARDO
                        $direccion->insert();
                    }                    
                    $persona->attributes=$_POST['Persona'];                                                             
                    $persona->nombre=  strtoupper($persona{'nombre'});
                    $persona->apellido=  strtoupper($persona{'apellido'});                    
                    /*FK1*/ $persona->id_dir = $direccion{'id'};
                    
                    if($persona->validate()){
                        //Me fijo si ya existe para no guardar dos veces la misma direccion;
                        $criterial = new CDbCriteria();
                        $criterial->condition="dni='" . $persona->dni . "' ";                        
                        if(! (Persona::model()->find($criterial))){//Si NO existe => GUARDO
                            $persona->insert();
                        }                                                             
                        
                        $usuario->attributes=$_POST['Usuario'];
                        /*FK1*/ $usuario->dni_per=$persona{'dni'};                                           
                                        
                        if($usuario->validate()){
                            if(!$usuario->exists("name='" . $usuario{'name'} . "' ")){
                                $usuario->save();                            
                                Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                $transaction->commit(); 
                                //Generar los permisos por default
                                $usuario->darPermiso($usuario{'nivel'}, $usuario{'id'});                               
                                
                                $this->redirect('create');
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Ya existe usuario con el mismo nombre");}                                                                            
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}                                                
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios");}                                                
                    }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}                        
                }
                }  
                catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
            }
            
            $this->render('create',
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