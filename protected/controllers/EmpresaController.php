<?php

class EmpresaController extends Controller {

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
        $empresa = new Empresa();
        $persona = new Persona();
        $direccion = new Direccion();
        $direccionAUX = new Direccion();
        $localidad = new Localidad();
        $sucursal = new Sucursal();

        $lista_localidades = Localidad::model()->getListNombre();

        $datos_guardados = false;
        $transaction = Yii::app()->db->beginTransaction();
        if (isset($_POST['Empresa'])) {
            try {
                $direccion->attributes = $_POST['Direccion'];
                $localidad_seleccionada = $lista_localidades[$_POST['Localidad']['id']];
                $direccion->id_loc = Localidad::model()->getId($localidad_seleccionada)->id;

                if ($direccion->validate()) {
                    $direccion->insert();
                    $persona->attributes = $_POST['Persona'];
                    $persona->id_dir = $direccion{'id'};

                    $empresa->attributes = $_POST['Empresa'];
                    $empresa->dni_per = $_POST['Persona']['dni'];

                    if ($empresa->validate()) {
                        if ($persona->validate()) {
                            $persona->insert();
                            $empresa->insert();
                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");
                            $transaction->commit();
                            $this->redirect('crear');
                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', "<strong>Error. Datos Peronales!</strong> Campos vacios o incorrectos");
                        }
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "<strong>Error. Empresa!</strong> Campos vacios o incorrectos");
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "<strong>Error. Direccion!</strong> Campos vacios o incorrectos");
                }
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', $ex->getMessage());
            }
        }
        $this->render('crear', array(
            'empresa' => $empresa,
            'persona' => $persona,
            'direccion' => $direccion,
            'localidad' => $localidad,
            'lista_localidades' => $lista_localidades,
            'datos_guardados' => $datos_guardados,
            'sucursal' => $sucursal,
        ));
    }

//    ESTA FUNCION NO BORRAR, PORQUE ACA SE MUESTRA COMO HACER UNA DATAPROVIEDE A PATA
//    public function actionModificar(){
//        $rawData = array();
//        $empresas = Empresa::model()->findAll();
//        foreach($empresas as $item=>$empresa){
//            $raw = array();
//            $sucursales = Sucursal::model()->findAllByAttributes(array('cuit_emp'=>$empresa{'cuit'}));
//            
//            if(count($sucursales) > 1){
//                foreach ($sucursales as $item2=>$sucursal){                                       
//                    $raw['id']=(int)$sucursal{'id'};
//                    $raw['cuit']=$empresa{'cuit'};
//                    $raw['razonsocial']=$empresa{'razonsocial'};                    
//                    $raw['sucursal']=$sucursal{'nombre'};
//                    $rawData[]=$raw;            
//                }
//            }else{
//                $raw['id']=(int)$sucursal{'id'};
//                $raw['cuit']=$empresa{'cuit'};
//                $raw['razonsocial']=$empresa{'razonsocial'};                
//                $raw['sucursal']=$sucursales{'nombre'};
//                $rawData[]=$raw;            
//            }                      
//        }
//        $arrayDataProvider=new CArrayDataProvider($rawData, array(
//           'id'=>'id',
//           'pagination'=>array(
//               'pageSize'=>10,
//           ),
//       ));
//        
//        
//        $this->render('modificar', array(
//            'empresa'=>new Empresa(),
//            /*'arrayDataProvider'=>$arrayDataProvider*/));
//    }
    public function actionModificar() {
        $this->render('modificar', array(
            'empresa' => new Empresa(),
        ));
    }

    public function actionList() {
        $this->render('list');
    }

    public function actionUpdate($cuit, $razonsocial) {

        if (!((($_POST['Empresa']['cuit']) == '') && (($_POST['Empresa']['razonsocial']) == ''))) {

            try {
                $transaction = Yii::app()->db->beginTransaction();

                $empresa = Empresa::model()->findByAttributes(array('cuit' => $cuit));

                $empresa->cuit = $_POST['Empresa']['cuit'];
                $empresa->razonsocial = $_POST['Empresa']['razonsocial'];

                if ($empresa->validate()) {
                    $empresa->save();
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Datos actualizados ");
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos ");
                }
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', "<strong>Error!</strong> " . $ex->getMessage());
            }
        }

        $empresa = new Empresa();

        if (Yii::app()->request->isAjaxRequest) {
            $empresa = Empresa::model()->findByAttributes(array('cuit' => $cuit));

            $this->renderPartial('_ModalModificar', array(
                'empresa' => $empresa,
                    ), false, true);
        } else {
            $this->render('modificar', array(
                'empresa' => $empresa
            ));
        }
    }

    public function actionListSucursal($cuit) {

        $sucursal = new Sucursal();
        $dataProvider = $sucursal->search();

        if (Yii::app()->request->isAjaxRequest) {

            die();
            $this->renderPartial('_ModalListSucursal', false, true);
        } else {
            $this->render('modificar', array(
                'empresa' => new Empresa(),
            ));
        }
    }

    public function actionDelete($cuit) {

        try {
            $transaction = Yii::app()->db->beginTransaction();
            $sucursal = Sucursal::model()->findByAttributes(array('cuit_emp' => $cuit));
            if (Histoasignacion::model()->deleteAllByAttributes(array('id_suc' => $sucursal{'id'}))) {
                if (Sucursal::model()->deleteAllByAttributes(array('cuit_emp' => $cuit))) {
                    if (Empresa::model()->deleteAllByAttributes(array('cuit' => $cuit))) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Se han eliminado todas las sucursales ");
                        $this->redirect(array('modificar'));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', "<strong>Error!</strong> Al elimiar ");
                    }
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "<strong>Error!</strong> Al elimiar ");
                }
            } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "<strong>Error!</strong> Al elimiar ");
            }
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error', $ex->getMessage());
        }
        var_dump($ex->getMessage());
        die();
        $this->render('modificar');
    }

}
