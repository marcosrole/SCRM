<?php

class SucursalController extends Controller
{

    public function actionList($cuit){
        $sucursal = new Sucursal();
        $sucursales = Sucursal::model()->findAllByAttributes(array('cuit_emp'=>$cuit));
        $dataProvieder = $sucursal->search();
        $dataProvieder->setData($sucursales);
        
        $this->render('list', array(
            'dataProvieder' => $dataProvieder,
        ));        
    }
    
    public function actionModificar($cuit){
        
        $sucursal = new Sucursal();
        $sucursales = Sucursal::model()->findAllByAttributes(array('cuit_emp'=>$cuit));
        $dataProvieder = $sucursal->search();
        $dataProvieder->setData($sucursales);
        
        $this->render('modificar', array(
            'dataProvieder' => $dataProvieder,
        ));        
    }


    public function actionCrear()
	{
            $sucursal = new Sucursal();
            $direccion = new Direccion();
            $empresa = new Empresa();
            $localidad = new Localidad();
            $lista_localidades=  Localidad::model()->getListNombre();
            $transaction = Yii::app()->db->beginTransaction();             
             try {
                 if (isset($_POST['selectEmpresa']) || (isset($_POST['Sucursal']) ) || ( isset($_POST['Direccion']) ) ) {
                    $direccion->attributes = $_POST['Direccion'];
                    $localidad_seleccionada = $lista_localidades[$_POST['Localidad']['id']];            
                    $direccion->id_loc = Localidad::model()->getId($localidad_seleccionada)->id;
                    var_dump($direccion);
                    if($direccion->validate()){
                        $direccion->insert();
                        $sucursal->attributes=$_POST['Sucursal'];
                        $sucursal->id_dir=$direccion{'id'};
                        $sucursal->cuit_emp=$_POST['selectEmpresa'][0];
                        var_dump($sucursal);
                        if($sucursal->validate()){
                            $sucursal->insert();
                            $transaction->commit();                        
                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}
                    }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}                
                }                 
             } catch (Exception $ex) {
                 Yii::app()->user->setFlash('error',$ex->getMessage());
             }
            
            $this->render(
                    'crear',
                    array(
                        'sucursal'=>$sucursal,
                        'direccion'=>$direccion,
                        'empresa' => $empresa,
                        'localidad' => $localidad,                        
                        'lista_localidades' => $lista_localidades,
                    ));
	}
        
        public function actionUpdate($id){
        
            $sucursal = new Sucursal();
            
        if( ! (($_POST['Sucursal']['id'])=='') ) {             
           try {
                $transaction = Yii::app()->db->beginTransaction();               
                $sucursal = Sucursal::model()->findByAttributes(array('id'=>$id));    
                $sucursal->nombre=$_POST['Sucursal']['nombre'];
                if($sucursal->validate()){
                    $sucursal->save();
                    $transaction->commit(); 
                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Datos actualizados ");                                                
                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos ");}
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
            }
    }
              
        
        
        if( Yii::app()->request->isAjaxRequest )
            {
            $sucursal= Sucursal::model()->findByAttributes(array('id'=>$id));
            
            $this->renderPartial('_ModalModificar',array(
                'sucursal'=>$sucursal,
            ), false, true);
        }
        else
        {
            $this->redirect(Yii::app()->createUrl("sucursal/modificar", array('cuit'=>$sucursal{'cuit_emp'})));
        }
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