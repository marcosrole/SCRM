<?php

class DetalleDispoController extends Controller
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
        
       /* public function accessRules()
	{
		 $funcionesAxu = new funcionesAux();
                 $funcionesAxu->obtenerActionsPermitidas(Yii::app()->user->getState("Menu"), Yii::app()->controller->id);
                 
                 $arr =$funcionesAxu->actiones;  // give all access to admin
                 if(count($arr)!=0){
                        return array(                    
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
                
	}*/
        
    public function actionDeleteAll(){
        $url_anterior = Yii::app()->user->returnUrl;
        die($url_anterior);
        DetalleDispo::model()->deleteAll();
        //Retorno a la URL 
        Yii::app()->request->redirect($url_anterior);
    }

    public function actionCreate() {
        date_default_timezone_set('America/Buenos_Aires');
            $hoy = getdate();
            $fechahoy=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];
            $hshoy=$hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds'];
        try {   
            $model = new DetalleDispo;       
        //Array con todos los dispositivos (id_dispo)        
        $array_dispo = array();        
        $dispositivos = Dispositivo::model()->findAll();         
        
        foreach ($dispositivos as $key => $value) {            
           $array_dispo[]= $value{'id'};
        }   
        
        $transaction = Yii::app()->db->beginTransaction();
        //Verifico que se hayan pasado parametros por la URL
        if (isset($_GET['id']) && isset($_GET['db']) && isset($_GET['dist']) && isset($_GET['fecha']) && isset($_GET['hs'])) {
            //Si no está calibrado, NO SE PUEDE SEGUIR
            
            $HistoAsig = Histoasignacion::model()->findByAttributes(array('id_dis'=>$_GET['id'], 'fechaBaja'=>'1900-01-01'));           
            if (Calibracion::model()->findByAttributes(array('id_AsiDis'=>$HistoAsig{'id'})) === null){
                $transaction->rollback ();                 
                Yii::app()->user->setFlash('error', "<strong>El dispositivo no se encuentra calibrado!</strong> <a href=" . "SCRM/calibracion/create?id_disp'" . ">Click para Calibrar Dispositivo</a>");
            }else{
                //Cargo los datos al modelo   
//                DetalleDispo::model()->validarDatos($_GET['id']);
                
                $model->setAttribute('id_dis', $_GET['id']);
                $model->setAttribute('db', $_GET['db']);
                $model->setAttribute('distancia', $_GET['dist']);
                //$fechahs = $_GET['fecha'] . " " . $_GET['hs'];
                $fechahs = $fechahoy . " " . $hshoy;
                $model->setAttribute('fechahs', $fechahs);
                
                $dispositivos = Dispositivo::model()->findByAttributes(array('id'=>$_GET['id']));
                
                if ($model->validate() && $dispositivos{'funciona'}) {
                    if ($model->insert()) { //Si se guardo Correctamente.. insert() devuelve un boolean 
                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> El registro del dispositivo: " . $_GET['id'] . " se guardo corectamente");                                                
                        $transaction->commit();
                        //Cargo la table ACCESO DISPOSITIVO
                         
                        $AccesoDispo = new Accesodispositivo();
                        Accesodispositivo::model()->deleteAllByAttributes(array('id_dis_detDis'=>$_GET['id']));
                        $AccesoDispo->fechaUltimo=$fechahoy;
                        $AccesoDispo->hsUltimo=$hshoy;
                        $AccesoDispo->id_detDis=$model{'id'};
                        $AccesoDispo->id_dis_detDis=$_GET['id'];

                        $AccesoDispo->insert();
//             *****************************************************
////                        VERIFICAR ALARMAS
//             *****************************************************
                        if(true){//VERIFICO ALARMA
                            $alarmaDetectada=false;
                            $ConfigAlarma = Configalarma::model()->findAllByAttributes(array('id'=>'1'));
                            $ConfigAlarma = $ConfigAlarma[0];
                            $Calibracion = Calibracion::model()->findByAttributes(array('id_AsiDis'=>$HistoAsig{'id'}));
                            $HistoAsignacion = Histoasignacion::model()->findByAttributes(array('id_dis'=> $_GET['id'], 'fechaBaja'=>'1900-01-01'));
                            $Sucursal = Sucursal::model()->findByAttributes(array('id'=>$HistoAsignacion{'id_suc'}));
                            $direccion = Direccion::model()->findByAttributes(array('id'=>$Sucursal{'id_dir'}));
                            $mensaje= "SCRM: Se ha detectado un inconveniente en " . $Sucursal{'nombre'} . ", " . $direccion{'calle'} . " " . $direccion{'altura'} . ", debido a: ";
                           
                            $id_alaRC=$this->VerificarRuidoContinua($_GET['id'], $Calibracion{'db_permitido'},$ConfigAlarma{'segCont'},20, $ConfigAlarma{'porcCont'}, $ConfigAlarma{'recibirAlaContinuo'},1);
                            if($id_alaRC=='-1'){       
                                        $id_alaRI =$this->VerificarRuidoIntermedio($_GET['id'],$Calibracion{'db_permitido'},$ConfigAlarma{'segInt'},20,$ConfigAlarma{'porcInt'}, $ConfigAlarma{'division'}, $ConfigAlarma{'recibirAlaIntermitente'}, 1);
                                        if($id_alaRI!='-1'){
                                                    $alarmaDetectada=true;
                                                    $this->EnviarSMSEncargado($id_alaRI, $mensaje . "Ruidos Molestos" . ". Por favor solucione el inconveniente durante los proximos " . round($ConfigAlarma{'tolResponsable'}/60) . "minutos. ");
                                        }             
                            }else{$alarmaDetectada=true; $this->EnviarSMSEncargado($id_alaRC, $mensaje . "Ruidos Molestos" . ". Por favor solucione el inconveniente durante los proximos " . round($ConfigAlarma{'tolResponsable'}/60) . "minutos. "); }
                            
                            $id_alaD=$this->VerificarDistancia($_GET['id'], $Calibracion{'dist_permitido'},$ConfigAlarma{'segDis'},20,$ConfigAlarma{'porcDis'},$ConfigAlarma{'recibirAlaDistancia'},1);
                            
                            if($id_alaD!='-1'){$alarmaDetectada=true; $this->EnviarSMSEncargado($id_alaD, $mensaje . "El dispositivo ha sido obstruido" . ". Por favor solucione el inconveniente durante los proximos " . round($ConfigAlarma{'tolResponsable'}/60) . "minutos. ");}
                        }
                    }
                } else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Dispositivo deshabilitado");}
            }

//            //Se pregunta si el formulario ha sido enviado
//            if (isset($_POST['DetalleDispo'])) {
//                $model->attributes = $_POST['DetalleDispo'];
//                $id_dispo_aux = $_POST['DetalleDispo']['id'];
//                $model->id_dis=$array_dispo[$id_dispo_aux];
//
//                if ($model->validate()) {
//                    //----------------------------------------------------------                        
//                    //Cambio el formato de la fecha.
//                    //SQL: yyyy-mm-dd
//                    $originalDate = $model->{'fecha'};
//                    $newDate = date("Y-m-d", strtotime($originalDate));
//                    $model->setAttribute('fecha', $newDate);
//                    //----------------------------------------------------------                                                
//                    $model->save();
//                    $transaction->commit();
//                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
//                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}
//            }
            }           
            
            
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error',$ex->getMessage());
        }
        
        $this->render('create', array('model' => $model, 'array_dispo' => $array_dispo));
    }
    
    public function EnviarSMSEncargado($id_ala, $mensaje){
        //Busco el nro del encargado de la sucursal afectada.
        $Alarma = Alarma::model()->findByAttributes(array('id'=>$id_ala));
        $HistoAsignacion = Histoasignacion::model()->findByAttributes(array('id_dis'=>$Alarma{'id_dis'}, 'fechaBaja'=>'1900-01-01'));
        $Sucural = Sucursal::model()->findByAttributes(array('id'=>$HistoAsignacion{'id_suc'}));
        $Empresa = Empresa::model()->findByAttributes(array('cuit'=>$Sucural{'cuit_emp'}));
        $Persona = Persona::model()->findByAttributes(array('dni'=>$Sucural{'dni_per'})); 
        
        if(0) $this->SendSMS($Persona{'celular'}, $mensaje);               
        if(0) $this->Sendemail($Alarma{'id'},$Persona{'email'});
    }

    public function actionVerDetalle($id){
                       
        $model = new DetalleDispo();
        $model->unsetAttributes();  // clear any default values
        
        $criteria=new CDbCriteria;        
        $criteria->order = 'fechahs DESC';
        
        $detalles = DetalleDispo::model()->findAllByAttributes(array('id_dis'=>$id), $criteria);
        if(count($detalles)>=1){
            foreach ($detalles as $item=>$value){
                $raw['id']=(int)$value{'id'};
                $raw['db']=$value{'db'};      
                $fechahs=explode(" ", $value['fechahs']);
                $raw['fecha']=$fechahs[0];  
                $raw['hs']=$fechahs[1];                          
                $rawData[]=$raw; 
            }
            $DataProviderDetalles=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>20,
                       ),
                     ));
        }else{
            $DataProviderDetalles=new CArrayDataProvider([], array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
        }
        
        $HistoAsign = Histoasignacion::model()->findByAttributes(array('id_dis'=>$id, 'fechaBaja'=>'1900-01-01'));
        
        //Genero un array con los ultimos 10 datos sensados
        //array[[hs][db]];
        
        $datos_grafico = array();
        $datos_db = array();
        $datos_hs = array();
        $datos_db_permitido=array();
        $datos_dist = array();
        $datos_dist_permitido=array();
        
        $cant = 10; //Cantidad de datos para mostrar en el grafico
        
        //Genero una linea para determinar los limites del dispositivo.
        $calibracion = Calibracion::model()->findByAttributes(array('id_AsiDis'=>$HistoAsign{'id'}));
        $db_limite = (int)$calibracion{'db_permitido'};        
        $dist_limite = (int)$calibracion{'dist_permitido'};        
        
        foreach ($detalles as $modelo){            
            if($cant!=0){
                $datos_db[]=(int)$modelo{'db'};
                $datos_dist[]=(int)$modelo{'distancia'};
                    $fechahs=explode(" ", $modelo['fechahs']);
                $datos_hs[]=$fechahs[1];
                $datos_db_permitido[]=$db_limite;
                $datos_dist_permitido[]=$dist_limite;
                $cant=$cant-1;
            }else                break;            
        }
        $datos_db=array_reverse($datos_db);
        $datos_hs=array_reverse($datos_hs);
        $datos_dist=array_reverse($datos_dist);
        
//        //del Arrary de HS, solamente dejo 3 elementos (para una mejor visaulizacion en el grafico
//        $ultimoEle = count($datos_hs)-1;
//        $mitadEle = round(count($datos_hs)/2);
//        for($i=1; $i<count($datos_hs); $i++){
//            if($i!=$ultimoEle){
//                if($i!=$mitadEle){
//                    $datos_hs[$i]="";
//                }                
//            }
//        }
            
        
        $datos_grafico['db']=$datos_db;
        $datos_grafico['dist']=$datos_dist;
        $datos_grafico['hs']=$datos_hs;
        $datos_grafico['db_permitido']=$datos_db_permitido;
        $datos_grafico['dist_permitido']=$datos_dist_permitido;
      
        
                
        $this->render('list',array(
            'dataProvider'=>$DataProviderDetalles,
            'datos_grafico'=>$datos_grafico,
            'id_dis' => $id
                ));
        
    }
    
    public function actionView(){
        $this->render('create', array('model' => $model, 'array_dispo' => $array_dispo)); 
    }
    
    public function VerificarRuidoIntermedio($id_dis, $dbPermitido, $segInter, $envioDatos, $porcInt, $divisiones, $tolRuidoIntermedio,$preAlarma, $id_ala=null)
{
    if($id_ala==NULL)$id_ala=-1;
//    $segInter = 600; //Definicion de un ruido Intermedio (debe existir durante -ej-, 600 seg. = 10 min)
//    $envioDatos = 20; //segundos. Cada cuanto envia datos el dispositivo.
//    $porcInt = 0.5; //Tolerancia al momento de comparar el promedio de todos los registros
    $cantDetalleDispo = round($segInter/$envioDatos);
//    $divisiones = 4; // Numero de subconjuntos a dividir
    
    
      
    $LisDetalleDispo = DetalleDispo::model()->findAllByAttributes(array('id_dis'=>$id_dis));
    $genererRuidoIntermedio = false;
     
     if(count($LisDetalleDispo)>$cantDetalleDispo){
           $LisDetalleDispo = array_slice($LisDetalleDispo, -$cantDetalleDispo, $cantDetalleDispo); //Ya tengo la cantidad de DetalleDispò necesario    
            if(count($LisDetalleDispo)==$cantDetalleDispo){
                $subConjunto= array_chunk($LisDetalleDispo, $divisiones);

                $ListaPorcentajes=array();
                $contador=0;
                $cantSobrepasado=0;
                for($i=0; $i<count($subConjunto); $i++){            
                    for($j=0; $j<count($subConjunto[$i]); $j++){
                        if($subConjunto[$i][$j]{'db'}>$dbPermitido) $cantSobrepasado++;
                    }
                    $ListaPorcentajes[]=$cantSobrepasado/count($subConjunto[$i]);
                    $contador=0;
                }

                

                for($i; $i<count($ListaPorcentajes); $i++){
                    if($LisDetalleDispo[$i]>$porcInt) $genererRuidoIntermedio=true;
                }

                if($id_ala!=null){
                    $alarma = Alarma::model()->findByAttributes(array('id'=>$id_ala));
                    if($genererRuidoIntermedio){
                        if($this->PermitirGenerarAlarma($id_dis, 4, $tolRuidoIntermedio,$preAlarma,$alarma{'id'})){//ALARMA INTERMITENTE   18000seg=5 mintos
                            $id_ala=$this->GenerarAlarmaContinua($_GET['id'], 4,$preAlarma,$id_ala);
                        }
                    }
                }else{
                    if($genererRuidoIntermedio){
                        if($this->PermitirGenerarAlarma($id_dis, 4, $tolRuidoIntermedio,$preAlarma)){//ALARMA INTERMITENTE   18000seg=5 mintos
                            $id_ala=$this->GenerarAlarmaContinua($_GET['id'], 4,$preAlarma);
                        }
                    }
                }
            }
     }
    
    
    
    RETURN $genererRuidoIntermedio;    
}

    public function VerificarRuidoContinua($id_dis, $db_permitido,$segCont, $envioDatos, $porcCont, $recibirAlaContinua, $preAlarma, $id_ala=NULL){
        
        if($id_ala==NULL)$id_ala=-1;
//        ********** ALARMA CONTINUA ****************
        //Determino cuantos detalleDispo necesito:
        $existeRuidoContinuo=false;
//        $segCont = 200; //Cuantos segundos "definimos" a un ruido continuo
//        $envioDatos = 20; //segundos. Cada cuanto envia datos el dispositivo.
//        $porcCont = 0.8;// Porcentaje de aceptacion 
        $cantDetalleDispo = round($segCont/$envioDatos);
        $disSelec=$id_dis; //Dispositivo
        $ListDetalleDispo = DetalleDispo::model()->findAllByAttributes(array('id_dis'=>$id_dis));
        $ListDetalleDispo = array_slice($ListDetalleDispo, -$cantDetalleDispo, $cantDetalleDispo); //Ya tengo la cantidad de DetalleDispò necesario
       
        //Ahora analizo la tolerancia de Continuuidad
        $contadorLimite=0;
        foreach ($ListDetalleDispo as $item=>$value){
            //Cuento cuantos registros se pasaron del limite de aceptacion
            if($value{'db'}>=$db_permitido) $contadorLimite++;
        }
       
        //Determino porcentaje de aceptacion
        if($contadorLimite/$cantDetalleDispo>=$porcCont){
            //GENERO ALARMA CONTINUA
//                ********************************
             if($id_ala!=null){
                $alarma = Alarma::model()->findByAttributes(array('id'=>$id_ala));
                if($this->PermitirGenerarAlarma($id_dis, 3, $recibirAlaContinua,$preAlarma,$alarma{'id'})){//ALARMA CONTINUA   18000seg=5 mintos
                    $id_ala=$this->GenerarAlarmaContinua($id_dis,3,$preAlarma,$alarma{'id'});
                    $existeRuidoContinuo=true;
               }
            }else{
                if($this->PermitirGenerarAlarma($id_dis, 3, $recibirAlaContinua,$preAlarma)){//ALARMA CONTINUA   18000seg=5 mintos
                    $id_ala=$this->GenerarAlarmaContinua($id_dis,3,$preAlarma);
                    $existeRuidoContinuo=true;
               }
            }
            
        }else{//Si la alarma se ha solucionado por el propio dueño. ELIMMINO LA PRE ALARMA
            if($id_ala!=null){                
                Alarma::model()->setSolucionada($id_ala);
            }
        }
        
        return $id_ala;
    }
    
     public function VerificarDistancia($id_dis, $dist_permitido, $segDis, $envioDatos, $porcDis, $recibirAlaDistancia, $preAlarma, $id_ala=null ){
         
         if($id_ala==NULL)$id_ala=-1;
        
//        ********** ALARMA DE DISTANCIA ****************
        //Determino cuantos detalleDispo necesito:
        $existeAlarmaDistancia=false;
//        $segDis = 200; //Cuantos segundos toleramos que el dispositivo está tapado (obtruido)
//        $envioDatos = 20; //segundos. Cada cuanto envia datos el dispositivo.
//        $porcDista = 0.8; //Tolerancia al momento de comparar el promedio de todos los registros
        $cantDetalleDispo = round($segDis/$envioDatos);
        $disSelec=$id_dis; //Dispositivo
                
        $ListDetalleDispo = DetalleDispo::model()->findAllByAttributes(array('id_dis'=>$id_dis));
        $ListDetalleDispo = array_slice($ListDetalleDispo, -$cantDetalleDispo, $cantDetalleDispo); //Ya tengo la cantidad de DetalleDispò necesario
       
        //Ahora analizo la tolerancia
        $contadorLimite=0;
        foreach ($ListDetalleDispo as $item=>$value){
            //Cuento cuantos registros se pasaron del limite de aceptacion de distancia
            if($value{'distancia'}>=$dist_permitido) $contadorLimite++;
        }
        //Determino porcentaje de aceptacion
        if($contadorLimite/$cantDetalleDispo>=$porcDis){
            //GENERO ALARMA DISTANCIA
//                ********************************
            
        if($id_ala!=null){
            $alarma = Alarma::model()->findByAttributes(array('id'=>$id_ala));
            if($this->PermitirGenerarAlarma($id_dis, 2, $recibirAlaDistancia,$preAlarma,$alarma{'id'})){//ALARMA DISTANCIA   18000seg=5 mintos
                $id_ala=$this->GenerarAlarmaContinua($id_dis,2,$preAlarma,$alarma{'id'});
                $existeAlarmaDistancia=true;
           }
        }else{
            if($this->PermitirGenerarAlarma($id_dis, 2, $recibirAlaDistancia,$preAlarma)){//ALARMA DISTANCIA   18000seg=5 mintos
                $id_ala=$this->GenerarAlarmaContinua($id_dis,2,$preAlarma);
                $existeAlarmaDistancia=true;
           }
        }
            
    }
        
        return $id_ala;
    }
    
    public function VerificarDispositivoMuerto($tiempoTolerancia, $recibirAlaMuerto, $preAlarma, $id_ala=null){
        $ExistePREAlarma = false;
        $alarmasGeneradas=array();
        

        if($id_ala!=null){
            $alarma = Alarma::model()->findByAttributes(array('id'=>$id_ala));
            $UltimoAcceso = Accesodispositivo::model()->findByAttributes(array('id_dis_detDis'=>$alarma{'id_dis'}));
            
            date_default_timezone_set('America/Buenos_Aires');
            $hoy = getdate();
            $fechahoy=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];
            $hshoy=$hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds'];
            if(abs(strtotime($fechahoy)-strtotime($UltimoAcceso{'fechaUltimo'}))<=86400){ //Pertenece al mismo dia
                if(abs($this->actionRestarHoras($hshoy, $UltimoAcceso{'hsUltimo'}))>=(float)$tiempoTolerancia){
                    $alarma->preAlarma=0;
                    $alarma->fechahs=$fechahoy . " " . $hshoy;
                    $alarma->save();
                }
            }else{
                $alarma->preAlarma=0;
                $alarma->fechahs=$fechahoy . " " . $hshoy;
                $alarma->save();
            }   
            
        }else{                    //        Busco todos los ultimos accesos donde los dispositivos FUINCIONEN
        
                    $dispositivosOFF = Dispositivo::model()->findAllByAttributes(array('funciona'=>1));
                    $dispositivosOFF = CHtml::listData($dispositivosOFF, 'id', 'id');
                    $UltimosAccesos=array();
                    $UltimosAccesosAUX = Accesodispositivo::model()->findAll();
                    if(count($UltimosAccesosAUX)>1){
                         foreach ($UltimosAccesosAUX as $item=>$value){
                             if(in_array($value{'id_dis_detDis'}, $dispositivosOFF)){
                                 $UltimosAccesos[]=$value;
                             }
                         } 
                    }elseif(count($UltimosAccesosAUX)==1) {
                        if(in_array($UltimosAccesosAUX[0]{'id_dis_detDis'}, $dispositivosOFF)){
                                 $UltimosAccesos[]=$UltimosAccesosAUX[0];
                             } 
                    }
                    
                    $dispoMuerto = [];
                    date_default_timezone_set('America/Buenos_Aires');
                    $hoy = getdate();
                    $fechahoy=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];
                    $hshoy=$hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds'];
                    if(count($UltimosAccesos)>1){
                         foreach ($UltimosAccesos as $item=>$value){
                            //Me fijo si existe una diferencia de al menos un dia. Un dia tiene 86400 segundos 
                             if(abs(strtotime($fechahoy)-strtotime($value{'fechaUltimo'}))<=86400){ //Pertenece al mismo dia
                                 if(abs($this->actionRestarHoras($hshoy, $value{'hsUltimo'}))>=$tiempoTolerancia){
                                     $dispoMuerto[]=$value{'id_dis_detDis'};
                                 }
                             }else{
                                  $dispoMuerto[]=$value{'id_dis_detDis'};
                             }            
                         }   
                         
                         if(count($dispoMuerto)!=0){
                             if(count($dispoMuerto)>1){//Genero tantas alarmas como dispositivos muertos halla
                                 foreach ($dispoMuerto as $item1 => $value1){
                                    $alarma = new Alarma();
                                    $alarma->id_tipAla=5;
                                    $alarma->preAlarma=$preAlarma;
                                    $alarma->enviarSMS=1;
                                    $alarma->id_dis=$value1;
                                    $alarma->fechahs=$fechahoy . " " . $hshoy;
                                    if($this->PermitirGenerarAlarma($alarma{'id_dis'}, 5, $recibirAlaMuerto,$preAlarma)){
                                        $ExistePREAlarma=true;
                                         $alarma->insert();
                                         $alarmasGeneradas[]=$alarma;
                                    } 

                                 }
                             }else{
                                    $alarma = new Alarma();
                                    $alarma->id_tipAla=5;
                                    $alarma->enviarSMS=1;
                                    $alarma->preAlarma=$preAlarma;
                                    $alarma->id_dis=$dispoMuerto[0];
                                    $alarma->fechahs=$fechahoy . " " . $hshoy;
                                    if($this->PermitirGenerarAlarma($alarma{'id_dis'}, 5, $recibirAlaMuerto,$preAlarma)){
                                        $ExistePREAlarma=true;
                                           $alarma->insert();
                                           $alarmasGeneradas[]=$alarma;
                                      }
                             }
                         }
                    }elseif (count($UltimosAccesos)==1) {
                         if(abs(strtotime($fechahoy)-strtotime($UltimosAccesos[0]{'fechaUltimo'}))<=86400){ //Pertenece al mismo dia                            
                                 if(abs($this->actionRestarHoras($hshoy, $UltimosAccesos[0]{'hsUltimo'}))>=(float)$tiempoTolerancia){
                                     $dispoMuerto[]=$UltimosAccesos[0]{'id_dis_detDis'}; 
                                 }
                             }else{
                                  $dispoMuerto[]=$UltimosAccesos[0]{'id_dis_detDis'};
                             }
                             
                             if(count($dispoMuerto)!=0){
                                    $alarma = new Alarma();
                                    $alarma->id_tipAla=5;
                                    $alarma->enviarSMS=1;
                                    $alarma->preAlarma=$preAlarma;
                                    $alarma->id_dis=$dispoMuerto[0];
                                    $alarma->fechahs=$fechahoy . " " . $hshoy; 
                                    if($this->PermitirGenerarAlarma($alarma{'id_dis'}, 5, $recibirAlaMuerto,$preAlarma)){
                                        $ExistePREAlarma=true;
                                           $alarma->insert();
                                           $alarmasGeneradas[]=$alarma;
                                      }
                            }
                    }
                  
                    if($ExistePREAlarma && $preAlarma==1){

                        //Recorro todas las alarmas y mando notificaciones (SMS y Email)
                        if(count($alarmasGeneradas)>=1){
                            foreach ($alarmasGeneradas as $alarmitas){                    
                                $HistoAsignacion = Histoasignacion::model()->findByAttributes(array('id_dis'=> $alarmitas{'id_dis'}, 'fechaBaja'=>'1900-01-01'));
                                $Sucursal = Sucursal::model()->findByAttributes(array('id'=>$HistoAsignacion{'id_suc'}));
                                $direccion = Direccion::model()->findByAttributes(array('id'=>$Sucursal{'id_dir'}));
                                $mensaje= "SCRM: Se ha detectado un inconveniente en " . $Sucursal{'nombre'} . ", " . $direccion{'calle'} . " " . $direccion{'altura'} . ", debido a: ";
                                $mensaje = $mensaje . "Dispositivo desconectado.";
                                sleep(3);
                                $this->EnviarSMSEncargado($alarmitas{'id'}, $mensaje);

                            }
                        }           
                    }
            
        }
    }

    public function actionRestarHoras($horaini,$horafin)
{
	
        $horai=explode(":", $horaini)[0];
	$mini=explode(":", $horaini)[1];
	$segi=explode(":", $horaini)[2];
 
	$horaf=explode(":", $horafin)[0];
	$minf=explode(":", $horafin)[1];
	$segf=explode(":", $horafin)[2];
        
	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);
 
	$dif=$fin-$ini; //diferencia en Segundos
        return $dif;
//	$difh=floor($dif/3600);
//	$difm=floor(($dif-($difh*3600))/60);
//	$difs=$dif-($difm*60)-($difh*3600);
//	return date("H-i-s",mktime($difh,$difm,$difs));
}

/**
 * Funcion que convierte una fecha en formato dd/mm/yyyy en formato ingles yyyy/mm/dd
 * Puede recibir la fecha:
 *	dd/mm/yyyy
 *	d/m/yyyy
 *	d/mm/yy
 */
public function convertDateToEnglish($date)
{
	if($this->validateDateEs($date))
	{
		$values=preg_split('/(\/|-)/',$date);
		$values[0]=(strlen($values[0])==2?$values[0]:"0".$values[0]);
		$values[1]=(strlen($values[1])==2?$values[1]:"0".$values[1]);
		$values[2]=(strlen($values[2])==4?$values[2]:substr(date("Y"),0,2).$values[4]);
		return $values[2].$values[1].$values[0];
	}
	return "";
}

public function GenerarAlarmaContinua($id_dis, $tipoAlarma, $preAlarma, $id_ala=null)
{
	if($id_ala!=NULL){
            $Alarma=  Alarma::model()->findByAttributes(array('id'=>$id_ala));
        }  else {
            $Alarma = new Alarma();
        }
        date_default_timezone_set('America/Buenos_Aires');
        $hoy = getdate();
        
        $Alarma->id_tipAla=$tipoAlarma;
        $Alarma->preAlarma=$preAlarma;
        $Alarma->enviarSMS=1;
        if($preAlarma==0)$Alarma->enviarSMS=1;
        $Alarma->id_dis=$id_dis; 
        $Alarma->fechahs=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'] . " " . $hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds'];       
        
        if($id_ala!=NULL){
            $Alarma->save();
        }  else {
            $Alarma->insert();
        }       
        
        return $Alarma{'id'};
}

public function PermitirGenerarAlarma($id_dis, $id_tipAla, $recibirAlarmaTiempo, $preAlarma, $id_ala=null){
    /* Verifica el perioro de tiempo que transcurrio luego de la ultima alarma.
     * Teniendo en cuenta: id_dis y id_tipAla */
//        $tiempoTolerancia = Es la tolerancia de tiempo entre alarmas. EN SEGUNDOS 
//        Busco la ultima alarma dispoible 
        
     $generarAlarma = FALSE;
    if($preAlarma==1){
        $alarma = Alarma::model()->findByAttributes(array('id_dis'=>$id_dis, 'id_tipAla'=>$id_tipAla, 'solucionado'=>'0'));
       
        if($alarma==NULL){
            $generarAlarma=TRUE;
        }elseif($alarma{'preAlarma'}==0 || $alarma{'preAlarma'}==1){
            $generarAlarma=FALSE;        
        }
        
        if($generarAlarma){
            $maxAnsTime = Alarma::model()->findByAttributes(array('id_dis'=>$id_dis, 'id_tipAla'=>$id_tipAla, 'solucionado'=>'1'), array('order' => 'fechahs DESC'));
           
            $fechahs=explode(" ", $maxAnsTime['fechahs']);
            date_default_timezone_set('America/Buenos_Aires');
            $hoy = getdate();

             $fechahoy=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];
             $hshoy=$hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds']; 
            //Me fijo si existe una diferencia de al menos un dia. Un dia tiene 86400 segundos 
            if(abs(strtotime($fechahs[0])-strtotime($fechahoy))<=86400){ //Pertenece al mismo dia
                if(abs($this->actionRestarHoras($fechahs[1], $hshoy))>=(float)$recibirAlarmaTiempo){
                    $generarAlarma = TRUE;
                }else $generarAlarma=FALSE;
            }else  $generarAlarma = TRUE;
        }             
    }elseif($preAlarma==0){
            $alarma=  Alarma::model()->findByAttributes(array('id'=>$id_ala));
            
            $fechahs=explode(" ", $alarma['fechahs']);
            date_default_timezone_set('America/Buenos_Aires');
            $hoy = getdate();            
             $fechahoy=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];
             $hshoy=$hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds'];            
            //Me fijo si existe una diferencia de al menos un dia. Un dia tiene 86400 segundos 
            if(abs(strtotime($fechahs[0])-strtotime($fechahoy))<=86400){ //Pertenece al mismo dia
                if(abs($this->actionRestarHoras($fechahs[1], $hshoy))>=(float)$recibirAlarmaTiempo){
                    $generarAlarma = TRUE;
                }
            }else  $generarAlarma = TRUE;
    }             
    
    
    
    return $generarAlarma;        
}

public function SendSMS($numeroDestino, $mensaje){
    
    //Yii::app()->sms->send(array('to'=>"54".$numeroDestino, 'message'=>$mensaje));
    spl_autoload_unregister(array('YiiBase','autoload'));
    require_once('Services/Twilio.php');
    $AccountSid = "ACb82c2f321e995cf545bfb147f0a41696";
    $AuthToken = "8a00cfd50d0e4fc6f350669fa3d1a625";
    $client = new Services_Twilio($AccountSid, $AuthToken);
    
    $numeroDestino="+54".$numeroDestino;
    spl_autoload_register(array('YiiBase','autoload'));
    
    try {
        $sms = $client->account->sms_messages->create(
         '+17076391065',
         $numeroDestino,
         $mensaje
         );
        echo "Sent message {$sms->sid}";
    } catch (Services_Twilio_RestException $e) {
        echo $e->getMessage();
    }
    
       
    
}
public function Sendemail($id_alarma, $emailDestino){
            
            $alarma = Alarma::model()->findByAttributes(array('id'=>$id_alarma));
            $dispositivo = Dispositivo::model()->findByAttributes(array('id'=>$alarma{'id_dis'}));
            $histoAsig = Histoasignacion::model()->findByAttributes(array('id_dis'=>$dispositivo{'id'}, 'fechaBaja'=>'1900-01-01'));
            $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoAsig{'id_suc'}));
            $empresa = Empresa::model()->findByAttributes(array('cuit'=>$sucursal{'cuit_emp'}));
            $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
            $tipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$alarma{'id_tipAla'}));
            $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
            
            $datos = array();
            $date = $alarma{'fechahs'};
            $date = explode(" ", $date);
            $date[0] = date_create($date[0]);
            $datos['fecha']= date_format($date[0], 'd-m-Y');
            
            
            $datos['id']= $alarma{'id'};
            $datos['descripcion']= $tipoAlarma{'descripcion'};
            $datos['hs']= $date[1];
            $datos['sucursal']=$sucursal{'nombre'};
            $datos['empresa']=$empresa{'razonsocial'};
            $datos['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'};
            $datos['localidad']=$localidad{'nombre'};
           
            
            $message = new YiiMailMessage;                     
            $message->subject = 'SCRM';
            $message->view ='test';//nombre de la vista q conformara el mail            
            $message->setBody(array('datos'=>$datos),'text/html');//codificar el html de la vista
            $message->from =('SCRM@sistema.com'); // alias del q envia
            $message->setTo($emailDestino); // a quien se le envia
            
            if(Yii::app()->mail->send($message)){
                 Yii::app()->user->setFlash('success', "<strong>Enviado!</strong> Mail enviado correctamente ");
//                 $this->render('admin');
            }else  {
                Yii::app()->user->setFlash('error', "<strong>Error!</strong> No se ha enviado el mail ");
                
                
            }
            

        }

    public function actionValidarEstado(){
        $ConfigAlarma = Configalarma::model()->find();
        if(1){//Validar dispositivo Muerto                
           $this->VerificarDispositivoMuerto($ConfigAlarma{'segMuerto'},$ConfigAlarma{'recibirAlaMuerto'},1);
        } 
        
//        Determina si existen pre-alarmas, es decir timeOutEspera=0 (NO paso el tiempo de espera)
//        Verifico para cada pre-alarma el tiempo que paso.
//        Una vez que paso el tiempo:
//            Verifico nuevamente si existe la alarma por la cual se generó, es decir, ej, 
//            si se genero por una alrma de tipo 5 (d. muerto) verifico esta alarma nuevamente
        if(1){
            $tiempoEsperaAgotado = false;
            //Busco la pre-alrma mas vieja para verificar el tiempo que transcurrio hasta el momento
            $PREalarmas = Alarma::model()->findAllByAttributes(array('preAlarma'=>'1'), array('order'=>'fechahs ASC'));
            
            if(count($PREalarmas)>=1){
                $PREAlarmaOld = $PREalarmas[0];
                
                $fechahs=explode(" ", $PREAlarmaOld['fechahs']);
                date_default_timezone_set('America/Buenos_Aires');
                $hoy = getdate();

                 $fechahoy=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];
                 $hshoy=$hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds'];
                //Me fijo si existe una diferencia de al menos un dia. Un dia tiene 86400 segundos 
                if(abs(strtotime($fechahs[0])-strtotime($fechahoy))<=86400){ //Pertenece al mismo dia
                    if(abs($this->actionRestarHoras($fechahs[1], $hshoy))>=(float)$ConfigAlarma{'tolResponsable'}){
                        $tiempoEsperaAgotado = TRUE;
                    }
                }else  $tiempoEsperaAgotado = TRUE;
            }
                
                if($tiempoEsperaAgotado){
                    //Verifico nuevamente la alarma generada.
                    $id_dis=$PREAlarmaOld{'id_dis'};
                    $HistoAsig = Histoasignacion::model()->findByAttributes(array('id_dis'=>$id_dis, 'fechaBaja'=>'1900-01-01')); 
                    $Calibracion = Calibracion::model()->findByAttributes(array('id_AsiDis'=>$HistoAsig{'id'}));
                    $Dispositivo = Dispositivo::model()->findByAttributes(array('id'=>$id_dis));
                   
                    switch ($PREAlarmaOld{'id_tipAla'}) {
                        case 2://Limite de Distancia  segDis = tolResponsable
                            $this->VerificarDistancia($id_dis, $Calibracion{'dist_permitido'}, $ConfigAlarma{'tolResponsable'}, $Dispositivo{'tiempo'}, $ConfigAlarma{'porcDis'}, $ConfigAlarma{'recibirAlaDistancia'},0,$PREAlarmaOld{'id'});                                
                            break;
                        case 3://Ruido Continuo segCon = tolResponsable
                            $this->VerificarRuidoContinua($id_dis, $Calibracion{'db_permitido'}, $ConfigAlarma{'tolResponsable'}, $Dispositivo{'tiempo'}, $ConfigAlarma{'porcCont'}, $ConfigAlarma{'recibirAlaContinuo'},0,$PREAlarmaOld{'id'});                                
                            break;
                        case 4://Ruido Intermitente segInt = tolResponsable                           
                            $this->VerificarRuidoIntermedio($id_dis, $Calibracion{'db_permitido'}, $ConfigAlarma{'tolResponsable'}, $Dispositivo{'tiempo'}, $ConfigAlarma{'porcInt'}, 4, $ConfigAlarma{'recibirAlaIntermitente'},0,$PREAlarmaOld{'id'});                            
                            break;
                        case 5://Dispositivo Muerto
                            $this->VerificarDispositivoMuerto($ConfigAlarma{'tolResponsable'}, $ConfigAlarma{'recibirAlaMuerto'},0,$PREAlarmaOld{'id'});                                                            
                            break;
                        default :
                            Yii::app()->user->setFlash('error', "<strong>Error!</strong> No se puede verificar el tipo de una PreAlarma: DetalleDispo/VerificarEstado ");
                            break;
                    }
                }
            
        }
 

    }
    
    
    
}