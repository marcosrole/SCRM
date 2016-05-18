<?php

class HistoasignacionController extends Controller

{
    /**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
        

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
        
       public function accessRules()
	{
		 $funcionesAxu = new funcionesAux();
                 $funcionesAxu->obtenerActionsPermitidas(Yii::app()->user->getState("Menu"), Yii::app()->controller->id);
                 
                 $arr =$funcionesAxu->actiones;  // give all access to admin
                 if(count($arr)!=0){
                        return array(   
                            
                            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                    'actions'=>array('ModificarModalDispositivo','ModificarModalEmpresa','ModalUpdateCoordenadas'),                             
                                    'users'=>array('*'),
                            ),
                            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                    'actions'=>$arr,                             
                                    'users'=>array('@'),
                            ),
                            array('deny',  // deny all users
                                    'users'=>array('*'),
                                    'deniedCallback' => function() { 
                                            Yii::app()->user->setFlash('error', "Usted no tiene permiso para relizar la acción solicitada. Inicie sesión con el usuario correspondiente ");  
    //                                        Yii::app()->controller->redirect(array ('/site/index'));
                                            Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);                                        
                                            }
                            ),
                            );
                 }else{
                     return array(
                            array('deny',  // deny all users
                                    'users'=>array('*'),
                                    'deniedCallback' => function() { 
                                            Yii::app()->user->setFlash('error', "Usted no tiene permiso para relizar la acción solicitada. Inicie sesión con el usuario correspondiente ");  
    //                                        Yii::app()->controller->redirect(array ('/site/index'));
                                            Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);                                        
                                            }
                            ),
                            );
                 }
                
	}
    
       public function actionCreate() {
        
        $dispositivo = new Dispositivo();
        $empresa = new Empresa();
        $sucursal = new Sucursal();
        $histasignacion = new Histoasignacion();
        
        date_default_timezone_set('UTC');
        $histasignacion->fechaAlta = date("Y-m-d");
        
        
        $array_sucursal = array();
        $array_dispositivo = array();
        $transaction = Yii::app()->db->beginTransaction();             
        try{
            if (isset($_POST['selectSucursal']) || isset($_POST['Empresa']) || isset($_POST['Sucursal']) || isset($_POST['Histoasignacion'])) {           
                if(isset($_POST['selectSucursal'])){
                    if(isset($_POST['selectDispositivo'])){
                        $sucursal=Sucursal::model()->findByAttributes(array('id' => $_POST['selectSucursal'][0]));            
                        $dispositivo=  Dispositivo::model()->findByAttributes(array('id' => $_POST['selectDispositivo'][0]));            
                         
                        $histasignacion->attributes = $_POST['Histoasignacion'];                
                        $histasignacion->fechaAlta = $_POST['Histoasignacion']['fechaAlta'];
                        $histasignacion->coordLat = $_POST['Histoasignacion']['coordLat'];
                        $histasignacion->coordLon = $_POST['Histoasignacion']['coordLon'];
                        /*FK1*/ $histasignacion->id_suc =  $sucursal{'id'};
                        /*FK2*/ $histasignacion->id_dis=$dispositivo{'id'};
                        $histasignacion->fechaBaja='1900-01-01'; 
                        $histasignacion->observacion="Nueva asignacion realizada";
                        //----------------------------------------------------------                        
                            //Cambio el formato de la fecha.
                            //SQL: yyyy-mm-dd
                            $originalDate = $histasignacion->{'fechaAlta'};
                            $newDate = date("Y-m-d", strtotime($originalDate));
                            $histasignacion->setAttribute('fechaAlta', $newDate);
                        //----------------------------------------------------------             
                        
                        if($histasignacion->validate()){
                           
                            $histasignacion->insert();
                            $transaction->commit();                        
                            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                                
                            $this->redirect(array('view',"id_suc"=>$sucursal{'id'}));
//                           
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos incompletos");}                                   
                    }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Seleccione una dispositivo");}                                   
                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Seleccione una Empresa");}                                
            }
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error',$ex->getMessage());
        }
        
        $sucursal=new Sucursal();
        $dispositivo=new Dispositivo();   
        
        $ListSucursal = Sucursal::model()->findAll();
                foreach ($ListSucursal as $key=>$value){                    
                        $raw['id']=(int)$value{'id'};
                        $raw['nombre']=$value{'nombre'};
                            $aux=  Empresa::model()->findByAttributes(array('cuit'=>$value{'cuit_emp'}));
                        $raw['empresa']=  $aux{'razonsocial'};
                            $aux= Direccion::model()->findByAttributes(array('id'=>$value{'id_dir'}));
                        $raw['direccion']=$aux{'calle'} . " " . $aux{'altura'};
                            $aux2= Localidad::model()->findByAttributes(array('id'=>$aux{'id_loc'}));
                        $raw['localidad']=$aux2{'nombre'};
                            $aux=  Zona::model()->findByAttributes(array('id'=>$value{'id_zon'}));
                        $raw['zona']=  $aux{'nombre'};                        
                        $rawData[]=$raw;                   
                    }
                    $DataProviderSucursales=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
        
        $dataProviderDispositivo = Dispositivo::model()->search();        
        $dataProviderDispositivo->setData(Histoasignacion::model()->getDispositivosDispoibles());                
        
        $this->render('create', array(
            'dataProviderDispositivo' => $dataProviderDispositivo,                        
            'DataProviderSucursales' => $DataProviderSucursales,
            'sucursal'=>$sucursal,
            'dispositivo' =>$dispositivo,
            'histasignacion' => $histasignacion));
    }
    
    public function actionView($id_suc){
        $sucursal = Sucursal::model()->findByAttributes(array('id'=>$id_suc));
        
        $dispoAsinados = Histoasignacion::model()->findAllByAttributes(array('id_suc'=>$sucursal{'id'}, 'fechaBaja'=>'1900-01-01'));
        
        if(count($dispoAsinados)>1){
                foreach ($dispoAsinados as $key=>$value){                    
                        $raw['id']=(int)$value{'id'};
                        $raw['dispositivo']=$value{'id_dis'};                            
                        $raw['fechaAlta']= $value{'fechaAlta'};                            
                            
                        $rawData[]=$raw;                   
                    }
                    $DataProviderDispositivos=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
        }else{
            
            $raw['id']=(int)$dispoAsinados[0]{'id'};
            $raw['dispositivo']=$dispoAsinados[0]{'id_dis'};                            
            $raw['fechaAlta']= $dispoAsinados[0]{'fechaAlta'};                            

            $rawData[]=$raw; 
            
            $DataProviderDispositivos=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
        }
            
        
        $this->render('view', array(
            'sucursal'=> $sucursal,
            'empresa'=>  Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'})),
            'DataProviderDispositivos'=> $DataProviderDispositivos,
            ));
         
    }
    
    public function actionUpdate(){
        
        
        $histoasignacion = new Histoasignacion();
        $histoasignacion = Histoasignacion::model()->findAllByAttributes(array('fechaBaja'=>'1900-01-01'));
     
        if(count($histoasignacion)>1){
                foreach ($histoasignacion as $key=>$value){                    
                        $raw['id']=(int)$value{'id'};
                        $raw['dispositivo']=$value{'id_dis'};                            
                            $aux=  Sucursal::model()->findByAttributes(array('id'=>$value{'id_suc'}));
                        $raw['sucursal']= $aux{'nombre'};                            
                            $aux= Empresa::model()->findByAttributes(array('cuit'=>$aux{'cuit_emp'}));
                        $raw['empresa']= $aux{'razonsocial'};                            
                        $raw['fechaAlta']= $value{'fechaAlta'};                            
                        $rawData[]=$raw;                   
                    }
                    $DataProviderHistoAsig=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
        }elseif(count($histoasignacion) == 0){
                           
                    
            $DataProviderHistoAsig=new CArrayDataProvider([], array(
               'id'=>'id',
               'pagination'=>array(
                   'pageSize'=>10,
               ),
             ));
        }else{
            
            $raw['id']=(int)$histoasignacion[0]{'id'};
            $raw['dispositivo']=$histoasignacion[0]{'id_dis'};                            
                $aux=  Sucursal::model()->findByAttributes(array('id'=>$histoasignacion[0]{'id_suc'}));
            $raw['sucursal']= $aux{'nombre'};                            
                $aux= Empresa::model()->findByAttributes(array('cuit'=>$aux{'cuit_emp'}));
            $raw['empresa']= $aux{'razonsocial'};                            
            $raw['fechaAlta']= $histoasignacion[0]{'fechaAlta'};                            
            $rawData[]=$raw;                   
                    
            $DataProviderHistoAsig=new CArrayDataProvider($rawData, array(
               'id'=>'id',
               'pagination'=>array(
                   'pageSize'=>10,
               ),
             ));
        }
              
        
        $this->render('update', array('DataProviderHistoAsig'=>$DataProviderHistoAsig));
    }
    
    public function actionViewMap(){        
        $array_datos_mapa = array();
        $histoasignacion = Histoasignacion::model()->with('dispositivo')->findAllByAttributes(array('fechaBaja'=>'1900-01-01'));
        $array_datos_mapa = Histoasignacion::model()->getDatosMapa();
       
        $rawData = array();
        foreach($histoasignacion as $item=>$asignacion){            
                $raw = array();                
                $raw['id']=(int)$asignacion{'id_dis'};
                $raw['fechaAlta']=$asignacion{'fechaAlta'};                
                        $sucural = Sucursal::model()->findByAttributes(array('id'=>$asignacion{'id_suc'}));
                $raw['sucursal']=$sucural{'nombre'};                
                        $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucural{'cuit_emp'}));
                $raw['empresa']=$empresa{'razonsocial'};                
                        $direccion = Direccion::model()->findByAttributes(array('id'=>$sucural{'id_dir'})); 
                        $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " - " . $localidad{'nombre'};
                        $alarma = Alarma::model()->findByAttributes(array('id_dis'=>$asignacion{'id_dis'}));
                        $tipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$alarma{'id_tipAla'}));
                $raw['alarma']=$tipoAlarma{'descripcion'};
                $rawData[]=$raw;            
            }  
             
        $this->render('viewmap', array('array_dispo'=>$array_datos_mapa, 'rawData'=>$rawData));
    }


    public function actionPrueba(){
        //$histoasignaciones = Histoasignacion::model()->with('empresa')->findAll();
        $histoasignaciones = Histoasignacion::model()->with('dispositivo')->findAll();
        var_dump($histoasignaciones);
        die();
    }
    
    public function actionModalUpdateCoordenadas($id){
        $histoAsif = new Histoasignacion();
        $histoAsif = Histoasignacion::model()->findByAttributes(array('id'=>$id));
        
        if (isset($_POST['Histoasignacion'])) {
            
            $histoAsif->coordLat=$_POST['Histoasignacion']['coordLat'];
            $histoAsif->coordLon=$_POST['Histoasignacion']['coordLon'];
            
            $histoAsif->save();
            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Coordenadas modificadas ");                                                                
            $this->redirect(array('update'));
        }
        
        if( Yii::app()->request->isAjaxRequest )
        {
            $this->renderPartial('ModalUpdateCoordenadas',array(
                'histoAsif'=>$histoAsif,
            ), false, true);
        }
        else
        {
            $this->render('ModalUpdateCoordenadas',array(
                'histoAsif'=>$histoAsif,
            ));
        }
    }
    
    
    public function actionModificarModalEmpresa($id){
        //Se puede cambiar la empresa.Pero la empresa puede como no ya tener un dispositivo. 
        //Unaempresa acepta 1 o mas dispositivos
       date_default_timezone_set('UTC');
        
       $histoasignacion = new Histoasignacion;
        
       $histoasignacion= Histoasignacion::model()->findByAttributes(array('id'=>$id));
       
        //Todas las scursales menos la actual
               
        $criterial = new CDbCriteria();
        $criterial->addCondition("id<>'" . $histoasignacion{'id_suc'} . "' " );
        $sucursal = Sucursal::model()->findAll($criterial);
            
         
        foreach($sucursal as $item=>$valor){            
                $raw = array();                
                $raw['id']=(int)$valor{'id'};                
                $raw['nombre']=$valor{'nombre'};                
                        $empresa = Empresa::model()->findByAttributes(array('cuit'=>$valor{'cuit_emp'}));
                $raw['empresa']=$empresa{'razonsocial'};                
                        $direccion = Direccion::model()->findByAttributes(array('id'=>$valor{'id_dir'}));                
                $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
                    $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                $raw['localidad']=$localidad{'nombre'};                        
                $rawData[]=$raw; 
                
        }
        
        
                $dataProviderSucursal=new CArrayDataProvider($rawData, array(
               'id'=>'id',
               'pagination'=>array(
                   'pageSize'=>10,
               ),
             ));
        
                
        
        
        if (isset($_POST['selectedEmpresa'])) {
            
            try {
                $histoasignacion->fechaBaja=date("Y" . "-" . "m" . "-" . "d");
                $histoasignacionNEW = new Histoasignacion();            
                $histoasignacionNEW->id_dis=$histoasignacion{'id_dis'};
                $histoasignacionNEW->id_suc=$_POST['selectedEmpresa'][0];
                $histoasignacionNEW->fechaAlta=$histoasignacion{'fechaAlta'};
                $histoasignacionNEW->fechaModif=date("Y" . "-" . "m" . "-" . "d");
                $histoasignacionNEW->fechaBaja=date("1900" . "-" . "1" . "-" . "1");
                $histoasignacionNEW->coordLat=$histoasignacion{'coordLat'};
                $histoasignacionNEW->coordLon=$histoasignacion{'coordLon'};            
                $histoasignacionNEW->observacion="Cambio de Sucursal. ". $_POST['Histoasignacion']['observacion'];
               
                $histoasignacionNEW->insert();
                $histoasignacion->save();

                $this->redirect(array('update'));
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', $ex->getMessage());
            }
            
        }
        
        if( Yii::app()->request->isAjaxRequest )
        {
            $this->renderPartial('modificarModalEmpresa',array(
                'empresa_original'=>$histoasignacion{'id_suc'}, 
                'dataProviderSucursal'=>$dataProviderSucursal,
                'histoasignacion'=>new Histoasignacion()
            ), false, true);
        }
        else
        {
            $this->render('modificarModalEmpresa',array(
                'empresa_original'=>$histoasignacion{'id_suc'},                
                'sucursal'=>new Sucursal(),
                'dataProviderSucursal'=>$dataProviderSucursal,
                'histoasignacion'=>new Histoasignacion()
            ));
        }
        
        
    }
    
    public function actionModificarModalDispositivo($id){
       date_default_timezone_set('UTC');
       
       $histoasignacion = new Histoasignacion;
        
        $histoasignacion= Histoasignacion::model()->findByAttributes(array('id'=>$id));
        
        
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
                if($_POST['Histoasignacion']['observacion']==""){
                    $histoasignacionNEW->observacion="Cambio de dispositivo: BAJA: " .  $histoasignacion{'id_dis'} . " - ALTA: " . $_POST['selectedDispositivo'][0];
                }else {$histoasignacionNEW->observacion="Cambio de dispositivo: BAJA: " .  $histoasignacion{'id_dis'} . " - ALTA: " . $_POST['selectedDispositivo'][0] . ". NOTA: " . $_POST['Histoasignacion']['observacion'];}
                
                
                $histoasignacionNEW->insert();
                $histoasignacion->save();
                 Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Dispositivo modificado ");                                                            
                $this->redirect(array('update'));
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', $ex->getMessage());
            }
            
        }
        
        if( Yii::app()->request->isAjaxRequest )
        {
            $this->renderPartial('modificarModalDispositivo',array(
                'dispositivo_original'=>$histoasignacion{'id_dis'},                
                'dispositivo'=>new Dispositivo(),                   
                'dataProviderDispositivo'=>$dataProviderDispositivo,
                'histoasignacion'=>new Histoasignacion(),
            ), false, true);
        }
        else
        {
            $this->render('modificarModalDispositivo',array(
                'dispositivo_original'=>$histoasignacion{'id_dis'},                
                'dispositivo'=>new Dispositivo(),                   
                'dataProviderDispositivo'=>$dataProviderDispositivo,
                'histoasignacion'=>new Histoasignacion()
            ));
        }
        
       
    }
  
    public function actionDelete($id){
        
        date_default_timezone_set('UTC');
        $histoasignacion=new Histoasignacion();
        $newHistoAsignacion=new Histoasignacion();
        
        $histoasignacion=  Histoasignacion::model()->findByAttributes(array('id'=>$id));
        
        try{
            $newHistoAsignacion->fechaAlta=$histoasignacion->fechaAlta;
            $newHistoAsignacion->fechaModif=date("Y" . "-" . "m" . "-" . "d");
            $newHistoAsignacion->fechaBaja=date("Y" . "-" . "m" . "-" . "d");
            $newHistoAsignacion->coordLat = $histoasignacion->coordLat;
            $newHistoAsignacion->coordLon = $histoasignacion->coordLon;
            $newHistoAsignacion->id_dis = $histoasignacion->id_dis;
            $newHistoAsignacion->id_suc = $histoasignacion->id_suc;
            $newHistoAsignacion->observacion="Registro eliminado";   
            $Calibracion = Calibracion::model()->findByAttributes(array('id_AsiDis'=>$histoasignacion{'id'}));
            if($Calibracion!=null)$Calibracion->delete();
            
            $histoasignacion->delete();
            
            $newHistoAsignacion->insert();
            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Registro Eliminado ");                                                            
            $this->redirect(array('update'));
            
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error',$ex->getMessage());
        }
        $this->redirect(array('update'));
    }
    public function actionModal(){
        
        $this->render('modal');
    }
    public function actionList(){
        $histoasignacion = Histoasignacion::model()->findAll();
        
        foreach($histoasignacion as $item=>$valor){            
                $raw = array();                
                $raw['id']=(int)$valor{'id'}; 
                    $sucursal = Sucursal::model()->findByAttributes(array('id'=>$valor{'id_suc'}));
                $raw['sucursal']=$sucursal{'nombre'};                
                        $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
                $raw['empresa']=$empresa{'razonsocial'};                
                        $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));                
                $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
                    $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                $raw['localidad']=$localidad{'nombre'}; 
                $raw['fechaAlta']=$valor{'fechaAlta'}; 
                $raw['fechaBaja']=$valor{'fechaBaja'}; 
                $raw['fechaModif']=$valor{'fechaModif'}; 
                $raw['observacion']=$valor{'observacion'}; 
                $raw['dispositivo']=$valor{'id_dis'}; 
                
                $rawData[]=$raw; 
                
        }
               
                $dataProviderHistoAsig=new CArrayDataProvider($rawData, array(
               'id'=>'id',
               'pagination'=>array(
                   'pageSize'=>10,
               ),
             ));
                
             $this->render('list',array(
                'dataProviderHistoAsig'=>$dataProviderHistoAsig, 
            ));
                
    }
    

}
