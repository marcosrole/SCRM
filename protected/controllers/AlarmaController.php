<?php

class AlarmaController extends Controller
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
                 $arr[]='AsignarInspector';
                 $arr[]='eliminar';
                 $arr[]='SendSMSPick';
                 if(count($arr)!=0){
                        return array(                    
                            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                    'actions'=>$arr,                             
                                    'users'=>array('@'),
                            ),
                            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                    'actions'=>array('ValidarEstado','PREadmin'),                             
                                    'users'=>array('*'),
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
////        
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
        
         
        
        public function actionAsignarInspector(){
            //Recorro todas las alarmas hasta el momento y verifico para cada una de ellas si pasó el limite de espera
            $tiempoEspera=5*60; //300 = 5 minutos
            $asignarInspector=false;
            date_default_timezone_set('America/Buenos_Aires');
            $hoy = getdate();
            
             $fechahoy=$hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];
             $hshoy=$hoy['hours'] . ":" . $hoy['minutes'] . ":" . $hoy['seconds']; 
            $Alarmas = Alarma::model()->findAllByAttributes(array('solucionado'=>'0', 'preAlarma'=>'0'), array('order'=>'fechahs ASC'));
            
            if(count($Alarmas)!=0){
                foreach($Alarmas as $item=>$alarma){
                    $fechahs=explode(" ", $alarma['fechahs']);
                    
                    //Me fijo si existe una diferencia de al menos un dia. Un dia tiene 86400 segundos 
                    if(abs(strtotime($fechahs[0])-strtotime($fechahoy))<=86400){ //Pertenece al mismo dia
                        if(abs($this->actionRestarHoras($fechahs[1], $hshoy))>=(float)$tiempoEspera){
                            $asignarInspector = TRUE; break;
                        }else $asignarInspector=FALSE;
                    }else  $asignarInspector = TRUE; break;
                }
                
                if($asignarInspector){
                    $transaction = Yii::app()->db->beginTransaction();
                        $inspector = Inspector::model()->findAllByAttributes(array('ocupado'=>'0'), array('order'=>'fechaDesocupado ASC'));
                        $inspector=$inspector[0];
                        $id_ins = $inspector{'id'};

                        $asignarInspectorModelo = new Asignarinspector();
                        $asignarInspectorModelo->id_ins=$id_ins;
                        $asignarInspectorModelo->id_ala=$alarma{'id'};
                        $asignarInspectorModelo->finalizado=0;
                        $asignarInspectorModelo->fechahsIns=$fechahoy . " " . $hshoy;
                        $asignarInspectorModelo->insert();

                        $inspector->estoyOcupado($asignarInspectorModelo{'id_ins'},date("Y-m-d H:i:s"));                                
                        $alarma->setSolucionada($alarma{'id'});
                        
                        $usuario = Usuario::model()->findByAttributes(array('id'=>$inspector{'id_usr'}));
                        $persona =  Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));
                        
                        $dispositivo = Dispositivo::model()->findByAttributes(array('id'=>$alarma{'id_dis'}));
                        $histoAsignacion = Histoasignacion::model()->findByAttributes(array('id_dis'=>$dispositivo{'id'}, 'fechaBaja'=>'1900-01-01'));
                        $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoAsignacion{'id_suc'}));
                        $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                        
                        $mensaje= "SCRM - Alarma Generada en " . $sucursal{'nombre'} . ", ubicada en " . $direccion{'calle'} . " " . $direccion{'altura'};
                       
                        //$this->SendSMS($persona{'celular'}, $mensaje);
                    $transaction->commit();
                }
            }
        }
        
        public function actionHisto(){
            $alarmas = Alarma::model()->findAllByAttributes(array('solucionado'=>'1'), ARRAY('order'=> 'fechahs DESC'));
            $rawData=array();  
             if(count($alarmas)!=0){
                foreach ($alarmas as $item=>$value){                                      
                        $raw['id']=(int)$value{'id'};
                        $raw['solucionado']=$value{'solucionado'}; 
                           $tipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$value{'id_tipAla'}));
                        $raw['alarma']=$tipoAlarma{'descripcion'};
                        $fechahs=explode(" ", $value['fechahs']);
                        $HistoAsignacion = Histoasignacion::model()->findByAttributes(array('id_dis'=>$value{'id_dis'}));
                            $Sucursal = Sucursal::model()->findByAttributes(array('id'=>$HistoAsignacion{'id_suc'}));
                        $raw['sucursal']=$Sucursal{'nombre'};  
                        $raw['fecha']=$fechahs[0];  
                        $raw['hs']=$fechahs[1];                          
                        $rawData[]=$raw;                   
                }    
               
             } else $rawData=array();        
              
                    $DataProviderAlarma=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>20,
                       ),
                     ));
                    
             $this->render('histo',array(
			'DataProviderAlarma'=>$DataProviderAlarma,
		));
            
            
        }
                
	public function actionView($id)
	{
            $alarma = Alarma::model()->findByAttributes(array('id'=>$id));
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
                
            
             if( Yii::app()->request->isAjaxRequest )
            {

                $this->renderPartial('view', array(
                    'datos'=>$datos,
                ), false, true);
            }
            else
            {
                $this->render('view', array(
                     'datos'=>$datos,

                ));
            }
            
           
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Alarma;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Alarma']))
		{
			$model->attributes=$_POST['Alarma'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Alarma']))
		{
			$model->attributes=$_POST['Alarma'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionEliminar($id)
	{
            $alarma = new Alarma();
            $alarma= Alarma::model()->findByAttributes(array('id'=>$id));            
            
            $alarma->delete();
            $this->redirect(array('alarma/admin'));
		
	}
        
        public function actionEliminarTodo()
	{
            Alarma::model()->deleteAll();
            $DataProviderAlarma=new CArrayDataProvider([], array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
            
           $this->render('admin',array(
			'DataProviderAlarma'=>$DataProviderAlarma,
		));
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$alarmas = Alarma::model()->findAllByAttributes(array('solucionado'=>'0', 'preAlarma'=>'0'));
               
                
                $rawData=[];
                if(count($alarmas)==0){
                    $DataProviderAlarma=new CArrayDataProvider([], array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                }elseif (count($alarmas)>=1) {
                    foreach ($alarmas as $item=>$value){ 
                        $dispositivo = Dispositivo::model()->findByAttributes(array('id'=>$value{'id_dis'}));
                        $histoAisg = Histoasignacion::model()->findByAttributes(array('id_dis'=>$dispositivo{'id'}, 'fechaBaja'=>'1900-01-01'));
                        $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoAisg{'id_suc'}));
                        $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                        $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                        
                        $raw['id']=(int)$value{'id'};
                        $raw['id_dis']=$dispositivo{'id'};
                        $raw['solucionado']=$value{'solucionado'}; 
                           $tipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$value{'id_tipAla'}));
                        $raw['alarma']=$tipoAlarma{'descripcion'};
                        $fechahs=explode(" ", $value['fechahs']);
                        $raw['fecha']=$fechahs[0];  
                        $raw['hs']=$fechahs[1];  
                        $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " - " . $localidad{'nombre'};
                        $raw['dispositivo']=$dispositivo{'id'};
                        $rawData[]=$raw;                   
                }    

                    $DataProviderAlarma=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                 }else{
                        $value=$alarmas; 
                        $dispositivo = Dispositivo::model()->findByAttributes(array('id'=>$value{'id_dis'}));
                        $histoAisg = Histoasignacion::model()->findByAttributes(array('id_dis'=>$dispositivo{'id'}, 'fechaBaja'=>'1900-01-01'));
                        $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoAisg{'id_suc'}));
                        $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                        $localidad = Localidad::model()->findByAttributes(array('id'=>$direccion{'id_loc'}));
                        
                        $raw['id']=(int)$value{'id'};
                         $raw['id_dis']=$dispositivo{'id'};
                        $raw['solucionado']=$value{'solucionado'}; 
                            $tipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$value{'id_tipAla'}));
                        $raw['alarma']=$tipoAlarma{'descripcion'};                                               
                        $fechahs=explode(" ", $value['fechahs']);
                        $raw['fecha']=$fechahs[0];  
                        $raw['hs']=$fechahs[1];  
                        $raw['direccion']=$direccion{'calle'} . " " . $direccion{'altura'} . " - " . $localidad{'nombre'};
                        $raw['dispositivo']=$dispositivo{'id'};
                        $rawData[]=$raw;                   
                   

                    $DataProviderAlarma=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     )); 
                 }
                 
                $this->render('admin',array(
			'DataProviderAlarma'=>$DataProviderAlarma,
		));
                                     
	}
        
        public function actionPREAdmin()
	{
            
            $alarmas = Alarma::model()->findAllByAttributes(array('solucionado'=>'0', 'preAlarma'=>'1'));
                
                $rawData=[];
                if(count($alarmas)==0){
                    $DataProviderAlarma=new CArrayDataProvider([], array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                }elseif (count($alarmas)>=1) {
                    foreach ($alarmas as $item=>$value){                                      
                        $raw['id']=(int)$value{'id'};
                        $raw['solucionado']=$value{'solucionado'}; 
                           $tipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$value{'id_tipAla'}));
                        $raw['alarma']=$tipoAlarma{'descripcion'};
                        $fechahs=explode(" ", $value['fechahs']);
                        $raw['id_dis']=$value{'id_dis'};
                            $HistoAsignacion = Histoasignacion::model()->findByAttributes(array('id_dis'=>$value{'id_dis'}));
                            $Sucursal = Sucursal::model()->findByAttributes(array('id'=>$HistoAsignacion{'id_suc'}));
                        $raw['sucursal']=$Sucursal{'nombre'};    
                        $raw['fecha']=$fechahs[0];  
                        $raw['hs']=$fechahs[1];                          
                        $rawData[]=$raw;                   
                }    

                    $DataProviderAlarma=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     ));
                 }else{
                        $value=$alarmas;                             
                        $raw['id']=(int)$value{'id'};
                        $raw['solucionado']=$value{'solucionado'}; 
                            $tipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$value{'id_tipAla'}));
                        $raw['alarma']=$tipoAlarma{'descripcion'};                                               
                        $fechahs=explode(" ", $value['fechahs']);
                        $raw['fecha']=$fechahs[0];  
                        $raw['id_dis']=$value{'id_dis'};
                            $HistoAsignacion = Histoasignacion::model()->findByAttributes(array('id_dis'=>$value{'id_dis'}));
                            $Sucursal = Sucursal::model()->findByAttributes(array('id'=>$HistoAsignacion{'id_suc'}));
                        $raw['sucursal']=$Sucursal{'nombre'}; 
                        $raw['hs']=$fechahs[1];                          
                        $rawData[]=$raw;                   
                   

                    $DataProviderAlarma=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                     )); 
                 }
                 
                $this->render('PREadmin',array(
			'DataProviderAlarma'=>$DataProviderAlarma,
		));
                                     
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Alarma the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Alarma::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

        
        
        
    public function actionSendemail($id_alarma){
            
            $alarma = Alarma::model()->findByAttributes(array('id'=>$id_alarma));
            $dispositivo = Dispositivo::model()->findByAttributes(array('id'=>$alarma{'id_dis'}));
            $histoAsig = Histoasignacion::model()->findByAttributes(array('id_dis'=>$dispositivo{'id'}, 'fechaBaja'=>'1900-01-01'));
            $sucursal = Sucursal::model()->findByAttributes(array('id'=>$histoAsig{'id_suc'}));
            $persona = Persona::model()->findByAttributes(array('dni'=>$sucursal{'dni_per'}));
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
            $message->setTo($persona{'email'}); // a quien se le envia
            
            
            
            if(Yii::app()->mail->send($message)){
                 Yii::app()->user->setFlash('success', "<strong>Enviado!</strong> Mail enviado correctamente ");
//                 $this->render('admin');
            }else  {
                Yii::app()->user->setFlash('error', "<strong>Error!</strong> No se ha enviado el mail ");
                
                
            }
            
            $this->redirect(array('alarma/PREadmin')); 

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
        
        public function SendSMS($numeroDestino, $mensaje){
            //Yii::app()->sms->send(array('to'=>"54".$numeroDestino, 'message'=>$mensaje));
            
            spl_autoload_unregister(array('YiiBase','autoload'));
            require('Services/Twilio.php');
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
         
         public function actionSendSMSPick($id_alarma){
            $Alarma = Alarma::model()->findByAttributes(array('id'=>$id_alarma));
            $TipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>$Alarma{'id_tipAla'}));
            $HistoAsignacion = Histoasignacion::model()->findByAttributes(array('id_dis'=>$Alarma{'id_dis'}, 'fechaBaja'=>'1900-01-01'));
            $Sucural = Sucursal::model()->findByAttributes(array('id'=>$HistoAsignacion{'id_suc'}));
            $Direccion = Direccion::model()->findByAttributes(array('id'=>$Sucural{'id_dir'}));
            $Empresa = Empresa::model()->findByAttributes(array('cuit'=>$Sucural{'cuit_emp'}));
            $Persona = Persona::model()->findByAttributes(array('dni'=>$Sucural{'dni_per'}));
            $mensaje = "SCRM - Sr/Sra., se ha producido un inconveniente en " . $Direccion{'calle'} . " " . $Direccion{'altura'} . ", " . $Sucural{'nombre'} . ", debido a: " . $TipoAlarma{'descripcion'}; 
            
            //Yii::app()->sms->send(array('to'=>'543483404260', 'message'=>"Hola"));
            //$this->redirect(array('alarma/admin'));            
            
            spl_autoload_unregister(array('YiiBase','autoload'));
            require('Services/Twilio.php');
            $AccountSid = "ACb82c2f321e995cf545bfb147f0a41696";
            $AuthToken = "8a00cfd50d0e4fc6f350669fa3d1a625";
            $client = new Services_Twilio($AccountSid, $AuthToken);

            $numeroDestino="+54".$Persona{'celular'};
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
            
            $this->redirect(array('alarma/PREadmin'));
            
         }
    
        
    
    
}
