<?php

class EmpresaController extends Controller
{
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
        $empresa = new Empresa;
        $persona = new Persona;
        $direccion = new Direccion;
        $direccionAUX = new Direccion;
        $localidad = new Localidad;
        
        $lista_localidades = array();        
        $localidades = Localidad::model()->findAll();         
        
        foreach ($localidades as $key => $value) {            
           $lista_localidades2[]= [$value{'id_loc'}=>$value{'nombre'}];
        }  
        foreach ($localidades as $key => $value) {            
           $lista_localidades[]= $value{'nombre'};
        }  
        
        $datos_guardados=false;
        
        if (isset($_POST['Empresa'])) {

            $direccion->altura = $_POST['Direccion']['altura'];
            $direccion->calle = $_POST['Direccion']['calle'];
            $direccion->piso = $_POST['Direccion']['piso'];
            $direccion->depto = $_POST['Direccion']['depto'];
            $localidad_seleccionada = $lista_localidades2[$_POST['Localidad']['id_loc']];
            foreach ($localidad_seleccionada as $key => $value) {
                $direccion->id_loc = $key;
            }

            if ($direccion->validate()) {
                $direccion->insert();
                $direccionAUX = Direccion::getId_dir($direccion{'altura'}, $direccion{'calle'}, $direccion{'piso'}, $direccion{'depto'});
                $persona->dni = $_POST['Persona']['dni'];
                $persona->tipo_dni = $_POST['Persona']['tipo_dni'];
                $persona->nom_ape = $_POST['Persona']['nom_ape'];
                $persona->sexo = $_POST['Persona']['sexo'];
                $persona->cuil = $_POST['Persona']['cuil'];
                $persona->calle_dir = $_POST['Direccion']['calle'];
                $persona->altura_dir = $_POST['Direccion']['altura'];
                $persona->id_dir = $direccionAUX{'id_dir'};

                $empresa->cuit = $_POST['Empresa']['cuit'];
                $empresa->razonsocial = $_POST['Empresa']['razonsocial'];
                $empresa->dni_per = $_POST['Persona']['dni'];
                $empresa->tipo_dni_per = $_POST['Persona']['tipo_dni'];
                $empresa->id_dir_dir = $direccionAUX{'id_dir'};
                $empresa->altura_dir = $_POST['Direccion']['altura'];
                $empresa->calle_dir = $_POST['Direccion']['calle'];

                if ($empresa->validate()) {
                    if ($persona->validate()) {
                        $persona->insert();
                        $empresa->insert();

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
                        header('Refresh:2;url=' . $this->createUrl('Empresa/crear'));
                    } else { //Elimino "direccion" que se creo recientemente                        
                        Direccion::model()->deleteByPk($direccionAUX{'id_dir'});
                    }
                }else { //Elimino "direccion" que se creo recientemente
                    
                }
            }
        }
        $this->render('crear', array(
            'empresa' => $empresa,
            'persona' => $persona,
            'direccion' => $direccion,
            'localidad'=> $localidad,
            'lista_localidades' => $lista_localidades,            
            'datos_guardados' => $datos_guardados,
        ));
    }

}