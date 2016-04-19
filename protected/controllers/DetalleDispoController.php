<?php

class DetalleDispoController extends Controller
{
	
    public function actionDeleteAll(){
        $url_anterior = Yii::app()->user->returnUrl;
        die($url_anterior);
        DetalleDispo::model()->deleteAll();
        //Retorno a la URL 
        Yii::app()->request->redirect($url_anterior);
    }

    public function actionCreate() {
        $this->PermitirGenerarAlarma(204, 3, 3);
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
                $model->setAttribute('fecha', $_GET['fecha']);
                $model->setAttribute('hs', $_GET['hs']);

                if ($model->validate()) {
                    if ($model->insert()) { //Si se guardo Correctamente.. insert() devuelve un boolean 
                        Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> El registro del dispositivo: " . $_GET['id'] . " se guardo corectamente");                                                
                        $transaction->commit();

                        //Cargo la table ACCESO DISPOSITIVO
                        $AccesoDispo = new Accesodispositivo();
                        Accesodispositivo::model()->deleteAllByAttributes(array('id_dis_detDis'=>$_GET['id']));
                        $AccesoDispo->fechaUltimo=$_GET['fecha'];
                        $AccesoDispo->hsUltimo=$_GET['hs'];
                        $AccesoDispo->id_detDis=$model{'id'};
                        $AccesoDispo->id_dis_detDis=$_GET['id'];

                        $AccesoDispo->insert();
                        
                        if(true){//VERIFICO ALARMA
                            $Calibracion = Calibracion::model()->findByAttributes(array('id_AsiDis'=>$HistoAsig{'id'}));
                            if(!$this->VerificarAlarmaContinua($_GET['id'],$Calibracion{'db_permitido'})){                                
                               if($this->VerificarRuidoIntermedio($_GET['id'],$Calibracion{'db_permitido'}, 0.5)){
                                   $this->GenerarAlarmaContinua($_GET['id'], 4);
                               }
                            }                            
                        }
                        
                    }
                } else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios");}
            }

            //Se pregunta si el formulario ha sido enviado
            if (isset($_POST['DetalleDispo'])) {
                $model->attributes = $_POST['DetalleDispo'];
                $id_dispo_aux = $_POST['DetalleDispo']['id'];
                $model->id_dis=$array_dispo[$id_dispo_aux];

                if ($model->validate()) {
                    //----------------------------------------------------------                        
                    //Cambio el formato de la fecha.
                    //SQL: yyyy-mm-dd
                    $originalDate = $model->{'fecha'};
                    $newDate = date("Y-m-d", strtotime($originalDate));
                    $model->setAttribute('fecha', $newDate);
                    //----------------------------------------------------------                                                
                    $model->save();
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos vacios o incorrectos");}
            }
            }           
            
            
        } catch (Exception $ex) {
            Yii::app()->user->setFlash('error',$ex->getMessage());
        }
        
        $this->render('create', array('model' => $model, 'array_dispo' => $array_dispo));
    }
    
    

    public function actionVerDetalle($id){
                       
        $model = new DetalleDispo('search');
        $model->unsetAttributes();  // clear any default values
        
        $criteria=new CDbCriteria(array(
                        'select'=>array('db',
                                        'distancia',
                                        'fecha',
                                        'hs',                                        
                                        ),
                        'order'=>'fecha DESC, hs DESC',                       
                       'condition'=>'id_dis=:id',
                       'params'=>array(':id'=> $id),
        ));
        
        $detalles = DetalleDispo::model()->findAll($criteria);
        $dataProvider = DetalleDispo::model()->search();
        $dataProvider->setData($detalles);
        
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
        $calibracion = Calibracion::model()->findByAttributes(array('id_AsiDis'=>$HistoAsign{'id_dis'}));
        $db_limite = (int)$calibracion{'db_permitido'};        
        $dist_limite = (int)$calibracion{'dist_permitido'};        
        
        foreach ($detalles as $modelo){            
            if($cant!=0){
                $datos_db[]=(int)$modelo{'db'};
                $datos_dist[]=(int)$modelo{'distancia'};
                $datos_hs[]=$modelo{'hs'};
                $datos_db_permitido[]=$db_limite;
                $datos_dist_permitido[]=$dist_limite;
                $cant=$cant-1;
            }else                break;            
        }
            
        
        $datos_grafico['db']=$datos_db;
        $datos_grafico['dist']=$datos_dist;
        $datos_grafico['hs']=$datos_hs;
        $datos_grafico['db_permitido']=$datos_db_permitido;
        $datos_grafico['dist_permitido']=$datos_dist_permitido;
        
          
        
                
        $this->render('list',array(
            'dataProvider'=>$dataProvider,
            'datos_grafico'=>$datos_grafico,
            'id_dis' => $id
                ));
        
    }
    
    public function actionView(){
        $this->render('create', array('model' => $model, 'array_dispo' => $array_dispo)); 
    }
    
    public function VerificarAlarmaContinua($id_dis, $db_permitido){
//        ********** ALARMA CONTINUA ****************
        //Determino cuantos detalleDispo necesito:
        $existeRuidoContinuo=false;
        $segCont = 200; //segundos
        $envioDatos = 20; //segundos. Cada cuanto envia datos el dispositivo.
        $porcCont = 0.8;
        $cantDetalleDispo = round($segCont/$envioDatos);
        $disSelec=$id_dis; //Dispositivo
                
        $ListDetalleDispo = DetalleDispo::model()->findAllByAttributes(array('id_dis'=>$id_dis));
        $ListDetalleDispo = array_slice($ListDetalleDispo, -$cantDetalleDispo, $cantDetalleDispo); //Ya tengo la cantidad de DetalleDispò necesario
       
        if(count($ListDetalleDispo)==$cantDetalleDispo){
            $fechas = CHtml::listData($ListDetalleDispo, 'id','fecha');
            $horas = CHtml::listData($ListDetalleDispo, 'id', 'hs');

            $Solofechas=[];

            while (list($clave, $valor) = each($fechas)) {
                array_push($Solofechas, $valor);
            }        
            $contador=0;
            for ($i=0; $i<count($Solofechas)-1; $i++){            
                $contador+=abs(strtotime($Solofechas[$i])-strtotime($Solofechas[$i+1]));
            }

            if($contador<=86400){ // ¿Paso menos de un dia?
                //Verifico que diferencia hay en los registros de HORA:
                 $SoloHoras=[];
                 $contador=0;
                while (list($clave, $valor) = each($horas)) {
                    array_push($SoloHoras, $valor);
                } 
                for ($i=0; $i<count($SoloHoras)-1; $i++){ 
                    $contador+=$this->actionRestarHoras($SoloHoras[$i], $SoloHoras[$i+1]);                
                }
                $horaTolerancia = 86400; //segundos
                if ($contador<$horaTolerancia){
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
                        if($this->PermitirGenerarAlarma($id_dis, 3, 18000)){//ALARMA CONTINUA   18000seg=5 mintos
                             $this->GenerarAlarmaContinua($id_dis,3);
                             $existeRuidoContinuo=true;
                        }
                    }
                    
                }

            }else{//No genero alarma: Paso mas de un dia entre los registros
                }

        }
        
        return $existeRuidoContinuo;
    }
    
    public function actionRestarHoras($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);
 
	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);
 
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

public function GenerarAlarmaContinua($id_dis, $tipoAlarma)
{
	date_default_timezone_set('America/Buenos_Aires');
        $hoy = getdate();
        $Alarma = new Alarma();
        $Alarma->id_tipAla=$tipoAlarma;
        $Alarma->id_dis=$id_dis; 
        $Alarma->fechahs=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'] . " " . $hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds'];
       
        $Alarma->insert();
}

public function VerificarRuidoIntermedio($id_dis, $dbPermitido, $tolRuidoIntermedio)
{
    $existeRuidoIntermedio = false;
    $cantDetalleDispo = 90;
    
    $LisDetalleDispo = DetalleDispo::model()->findAllByAttributes(array('id_dis'=>$id_dis));
    $LisDetalleDispo = array_slice($LisDetalleDispo, -$cantDetalleDispo, $cantDetalleDispo); //Ya tengo la cantidad de DetalleDispò necesario
       
    
    $cantDetDisSobrepasados = 0;
    foreach ($LisDetalleDispo as $item=>$value){
        if($value['db']>=$dbPermitido) $cantDetDisSobrepasados++;
    }
    
    if($cantDetDisSobrepasados/count($LisDetalleDispo) > $tolRuidoIntermedio) $existeRuidoIntermedio=TRUE;
    RETURN $existeRuidoIntermedio;    
}

public function PermitirGenerarAlarma($id_dis, $id_tipAla, $tiempoTolerancia)
{
    $generarAlarma = FALSE;
    /* Verifica el perioro de tiempo que transcurrio luego de la ultima alarma.
     * Teniendo en cuenta: id_dis y id_tipAla */
//        $tiempoTolerancia = Es la tolerancia de tiempo entre alarmas. EN SEGUNDOS 
//        Busco la ultima alarma dispoible 
        $alarma = Alarma::model()->findByAttributes(array('id_dis'=>$id_dis, 'id_tipAla'=>$id_tipAla));
        $alarma = new Alarma();
        
        $maxAnsTime = Yii::app()->db
        ->createCommand("SELECT * FROM alarma ORDER BY fechahs DESC LIMIT 1")
        ->where('id_dis=:idDis', array(':idDis'=>$id_dis))
        ->andWhere('id_tipAla=:idtipAla', array(':idtipAla'=>$id_tipAla))        
        ->queryRow();
        
        $fechahs=explode(" ", $maxAnsTime['fechahs']);
        
        date_default_timezone_set('America/Buenos_Aires');
        $hoy = getdate();
         
         $fechahoy=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];
         $hshoy=$hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds'];
         
        //Me fijo si pertenece al mismo dia
        if(abs(strtotime($fechahs[0])-strtotime($fechahoy))==0){ //Pertenece al mismo dia
            if($this->actionRestarHoras($fechahs[1], $hshoy)>=$tiempoTolerancia){
                $generarAlarma=true;
            }
        }
        return $generarAlarma;
        
}




    
    
    
    
}