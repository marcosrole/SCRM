<?php

class SemanatrabajoController extends Controller
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
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id_usr)
	{            
            $UsuarioSemTra = Usuariosemtra::model()->findAllByAttributes(array('id_usr'=>$id_usr));
            $Usuario= Usuario::model()->findByAttributes(array('id'=>$id_usr));
            $persona = Persona::model()->findByAttributes(array('dni'=>$Usuario{'dni_per'}));
            $Usuario->nombre=$persona{'nombre'};
            $Usuario->apellido=$persona{'apellido'};            
            $rarData = array();            
            if(count($UsuarioSemTra)==1){                                                
                $SemanaTrabajo = Semanatrabajo::model()->findByAttributes(array('id'=>$UsuarioSemTra[0]{'id_semtra'}));
                
                $raw['id']=(int)$SemanaTrabajo{'id'};
                $raw['nrosemana']=$SemanaTrabajo{'nrosemana'};
                $raw['lun']=$SemanaTrabajo{'lun'};
                $raw['mar']=$SemanaTrabajo{'mar'};
                $raw['mie']=$SemanaTrabajo{'mie'};
                $raw['jue']=$SemanaTrabajo{'jue'};
                $raw['vie']=$SemanaTrabajo{'vie'};
                $raw['sab']=$SemanaTrabajo{'sab'};
                $raw['dom']=$SemanaTrabajo{'dom'};
                $raw['hsdesde']=$SemanaTrabajo{'hsdesde'}; 
                $raw['hshasta']=$SemanaTrabajo{'hshasta'}; 
                $rarData[]=$raw;                        
                
                $DataProviderSemanas=new CArrayDataProvider($rarData, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
               ));
               
                $this->render('view',array(
                        'usuario'=>$Usuario,
                        'DataProviderSemanas'=>$DataProviderSemanas,			
		));
            }else{ //Si son varias semanas
                $rawData = array();
                foreach ($UsuarioSemTra as $key=>$algo){
                    $value = Semanatrabajo::model()->findByAttributes(array('id'=>$algo{'id_semtra'}));
                    $raw['id']=(int)$value{'id'};
                    $raw['nrosemana']=$value{'nrosemana'};
                    $raw['lun']=$value{'lun'};
                    $raw['mar']=$value{'mar'};
                    $raw['mie']=$value{'mie'};
                    $raw['jue']=$value{'jue'};
                    $raw['vie']=$value{'vie'};
                    $raw['sab']=$value{'sab'};
                    $raw['dom']=$value{'dom'};                                        
                    $raw['hsdesde']=$value{'hsdesde'}; 
                    $raw['hshasta']=$value{'hshasta'}; 
                    $rawData[]=$raw;
                }
                
                $DataProviderSemanas=new CArrayDataProvider($rawData, array(
                           'id'=>'id',
                           'pagination'=>array(
                               'pageSize'=>10,
                           ),
                       )); 
                   
                    $this->render('view',array(
                            'usuario'=>$Usuario,
                            'DataProviderSemanas'=>$DataProviderSemanas,			
                    ));
                
            }
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id_usr=null)
	{
            $model = new Semanatrabajo();
            $datos_usuario = array();
            if($id_usr!=NULL){
                $usuario = Usuario::model()->findByAttributes(array('id'=>$id_usr));
                $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));
                $UsuarioRol = Usuariorol::model()->findByAttributes(array('id_usr'=>$usuario{'id'}));
                $Inspector = Inspector::model()->findByAttributes(array('id_rol'=>$UsuarioRol{'id_rol'}));
                $zona = Zona::model()->findByAttributes(array('id'=>$Inspector{'id_zon'}));
                $datos_usuario['nombre']=$persona{'apellido'} . " " . $persona{'nombre'};
                $datos_usuario['zona']=$zona{'nombre'};
                 $datos_usuario['id']=$id_usr;
                
            }
            
            //=================================================================================
            //                  SOLO PARA MOSTRAR LOS DATOS
            //=================================================================================
            $UsuarioSemTra = Usuariosemtra::model()->findAllByAttributes(array('id_usr'=>$id_usr));
            $rarData = array();            
            if(count($UsuarioSemTra)==1){                                                
                $SemanaTrabajo = Semanatrabajo::model()->findByAttributes(array('id'=>$UsuarioSemTra[0]{'id_semtra'}));
                
                $raw['id']=(int)$SemanaTrabajo{'id'};
                $raw['nrosemana']=$SemanaTrabajo{'nrosemana'};
                $raw['lun']=$SemanaTrabajo{'lun'};
                $raw['mar']=$SemanaTrabajo{'mar'};
                $raw['mie']=$SemanaTrabajo{'mie'};
                $raw['jue']=$SemanaTrabajo{'jue'};
                $raw['vie']=$SemanaTrabajo{'vie'};
                $raw['sab']=$SemanaTrabajo{'sab'};
                $raw['dom']=$SemanaTrabajo{'dom'};
                $raw['hsdesde']=$SemanaTrabajo{'hsdesde'}; 
                $raw['hshasta']=$SemanaTrabajo{'hshasta'}; 
                $rarData[]=$raw;                        
                
                $DataProviderSemanas=new CArrayDataProvider($rarData, array(
                   'id'=>'id',
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
               ));               
            }else{ //Si son varias semanas
                $rawData = array();
                foreach ($UsuarioSemTra as $key=>$algo){
                    $value = Semanatrabajo::model()->findByAttributes(array('id'=>$algo{'id_semtra'}));
                    $raw['id']=(int)$value{'id'};
                    $raw['nrosemana']=$value{'nrosemana'};
                    $raw['lun']=$value{'lun'};
                    $raw['mar']=$value{'mar'};
                    $raw['mie']=$value{'mie'};
                    $raw['jue']=$value{'jue'};
                    $raw['vie']=$value{'vie'};
                    $raw['sab']=$value{'sab'};
                    $raw['dom']=$value{'dom'};                                        
                    $raw['hsdesde']=$value{'hsdesde'}; 
                    $raw['hshasta']=$value{'hshasta'}; 
                    $rawData[]=$raw;
                }
                
                $DataProviderSemanas=new CArrayDataProvider($rawData, array(
                           'id'=>'id',
                           'pagination'=>array(
                               'pageSize'=>10,
                           ),
                       ));
            }
                
                //=======================================================================================
                //=======================================================================================
            
		$transaction = Yii::app()->db->beginTransaction();
                try { 
                    if(isset($_POST['Semanatrabajo']))
		{                    
                    $lista_usuarioSemTra = Usuariosemtra::model()->findByAttributes(array('id_usr'=>$id_usr));
                    if($lista_usuarioSemTra==null){ //No tiene semanas, agrego
                        
                        if($_POST['Semanatrabajo']['dias'] !=''){
                            $hsdesde = $_POST['Semanatrabajo']['hsdesde'];
                            $hshasta = $_POST['Semanatrabajo']['hshasta'];
                          
                            if($hshasta>$hsdesde){                                
                                foreach ($_POST['Semanatrabajo']['dias'] as $key){
                                   
                                    switch ($key) {
                                        case 0:
                                            $model->lun=1;
                                            break;
                                        case 1:
                                            $model->mar=1;
                                            break;
                                        case 2:
                                            $model->mie=1;
                                            break;
                                        case 3:
                                            $model->jue=1;
                                            break;
                                        case 4:
                                            $model->vie=1;
                                            break;
                                        case 5:
                                            $model->sab=1;
                                            break;
                                        case 6:
                                            $model->dom=1;
                                            break;
                                    }
                                }
                                
                                //Fechas:                            
                                $model->hsdesde = $hsdesde+1 . ":00:00";
                                $model->hshasta = $hshasta+1 . ":00:00";
                                $model->nrosemana=$_POST['Semanatrabajo']['nrosemana']+1;                                
                                $model->insert();                                
                                
                                $usuarioSemTra = new Usuariosemtra();
                                $usuarioSemTra->id_usr=(int)$id_usr;                                
                                $usuarioSemTra->id_semtra=(int)$model{'id'};
                                $usuarioSemTra->insert();
                                $transaction->commit(); 
                                $this->redirect(array('view','id_usr'=>$id_usr));
                                Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                                                
                                
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Horarios!</strong> El horario de inicio no puede ser mayor al horario de fin");}                                                
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Dias de la semana!</strong> Debe seleccionar un dia de la semana");}                                                
                    }else{//No debe repetirese la semana                        
                        $bandera=false;
                        if(count($lista_usuarioSemTra)==1){   
                            $semanaTrabajo = Semanatrabajo::model()->findByAttributes(array('id'=>$lista_usuarioSemTra{'id_semtra'}));                            
                            if($semanaTrabajo{'nrosemana'} == $_POST['Semanatrabajo']['nrosemana']+1) $bandera=true;                            
                        }else{
                            foreach ($lista_usuarioSemTra as $key=>$value){
                                $semanaTrabajo = Semanatrabajo::model()->findByAttributes(array('id'=>$value{'id_semtra'}));
                                if($semanaTrabajo{'nrosemana'} == $_POST['Semanatrabajo']['nrosemana']+1) $bandera=true;                                                        
                            }
                        }
                        if(!$bandera){
                            
                            if($_POST['Semanatrabajo']['dias'] !=''){
                                $hsdesde = $_POST['Semanatrabajo']['hsdesde'];
                                $hshasta = $_POST['Semanatrabajo']['hshasta'];
                                
                                if($hshasta>$hsdesde){
                                    foreach ($_POST['Semanatrabajo']['dias'] as $dias){
                                        switch ($dias) {
                                            case 0:
                                                $model->lun=1;
                                                break;
                                            case 1:
                                                $model->mar=1;
                                                break;
                                            case 2:
                                                $model->mie=1;
                                                break;
                                            case 3:
                                                $model->jue=1;
                                                break;
                                            case 4:
                                                $model->vie=1;
                                                break;
                                            case 5:
                                                $model->sab=1;
                                                break;
                                            case 6:
                                                $model->dom=1;
                                                break;
                                        }
                                    }
                                    //Fechas:                            
                                   
                                    $model->hsdesde = $hsdesde+1 . ":00:00";
                                    $model->hshasta = $hshasta+1 . ":00:00";
                                    
                                    $model->nrosemana=$_POST['Semanatrabajo']['nrosemana']+1;
                                   
                                    $model->insert();                                
                                    $usuarioSemTra = new Usuariosemtra();
                                    $usuarioSemTra->id_usr=$id_usr;
                                    $usuarioSemTra->id_semtra=$model{'id'};
                                    $usuarioSemTra->insert();                                    
                                    
                                    $transaction->commit(); 
                                    $this->redirect(array('view','id_usr'=>$id_usr));
                                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                
                                    
                                    

                                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Horarios!</strong> El horario de inicio no puede ser mayor al horario de fin");}                                                
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Dias de la semana!</strong> Debe seleccionar un dia de la semana");}                                                
                        }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Dias de la semana!</strong> Ya existe configuración para la semana " );}                                                                       
                    }                    
                }
                } catch (Exception $ex) {
                    Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
                }
		              
                	$this->render('create',array(
			'model'=>$model,                        
                        'datos_usuario'=>$datos_usuario,
                        'DataProviderSemanas'=>$DataProviderSemanas,
                        
		));
	
        }

                
           
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $id_usr)
	{
		$model=$this->loadModel($id);
                
		if($model->lun == 1) $model->dias[]=0;
                if($model->mar == 1) $model->dias[]=1;
                if($model->mie == 1) $model->dias[]=2;
                if($model->jue == 1) $model->dias[]=3;
                if($model->vie == 1) $model->dias[]=4;
                if($model->sab == 1) $model->dias[]=5;
                if($model->dom == 1) $model->dias[]=6;
                
                $hsdesde = substr($model{'hsdesde'}, 0, -6);
                $hshasta = substr($model{'hshasta'}, 0, -6);
                
                $model->hsdesde=(int)$hsdesde-1;
                $model->hshasta=(int)$hshasta-1;
                $model{'nrosemana'}=$model->nrosemana-1;
                

		
                $transaction = Yii::app()->db->beginTransaction();
                try { 
                    if(isset($_POST['Semanatrabajo'])){                    
                    $lista_usuarioSemTra = Usuariosemtra::model()->findAllByAttributes(array('id_usr'=>$id_usr));                    
                    foreach ($lista_usuarioSemTra as $key=>$semana){                        
                        if($semana{'id_semtra'}==$model{'id'}){                            
                            if($_POST['Semanatrabajo']['dias'] !=''){
                                $hsdesde = $_POST['Semanatrabajo']['hsdesde'];
                                $hshasta = $_POST['Semanatrabajo']['hshasta'];
                                if($hshasta>$hsdesde){    
                                    $model->lun=0;
                                    $model->mar=0;
                                    $model->mie=0;
                                    $model->jue=0;
                                    $model->vie=0;
                                    $model->sab=0;
                                    $model->dom=0;
                                    foreach ($_POST['Semanatrabajo']['dias'] as $key){
                                        switch ($key) {
                                            case 0:
                                                $model->lun=1;
                                                break;
                                            case 1:
                                                $model->mar=1;
                                                break;
                                            case 2:
                                                $model->mie=1;
                                                break;
                                            case 3:
                                                $model->jue=1;
                                                break;
                                            case 4:
                                                $model->vie=1;
                                                break;
                                            case 5:
                                                $model->sab=1;
                                                break;
                                            case 6:
                                                $model->dom=1;
                                                break;
                                        }
                                    }

                                    //Fechas:                            
                                    $model->hsdesde = $hsdesde+1 . ":00:00";
                                    $model->hshasta = $hshasta+1 . ":00:00";  
                                    $model->nrosemana= $model->nrosemana+1;
                                    
                                    $model->save();                                
                                    
                                    $transaction->commit(); 
                                    $this->redirect(array('view','id_usr'=>$id_usr));
                                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Los datos se han guardado ");                                                

                                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Horarios!</strong> El horario de inicio no puede ser mayor al horario de fin");}                                                
                            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Dias de la semana!</strong> Debe seleccionar un dia de la semana");}                                                
                        }
                    }
                }
                } catch (Exception $ex) {
                    Yii::app()->user->setFlash('error', "<strong>Error!</strong> " .  $ex->getMessage());                  
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
	public function actionEliminar($id, $id_usr)
	{
            $UsuarioSemTra = Usuariosemtra::model()->findByAttributes(array('id_semtra'=>$id));
            
            $SemanaTrabajo = Semanatrabajo::model()->findByAttributes(array('id'=>$id));
            $transaction = Yii::app()->db->beginTransaction();
            if($UsuarioSemTra->delete()){
                if($SemanaTrabajo->delete()){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Se ha eliminado la semana");                                                
                    
                     $this->redirect(array('admin' ,'id_usr'=>$id_usr));
                    
                }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> No se pudo eliminar el registro");}
            }else {$transaction->rollback (); Yii::app()->user->setFlash('error', "<strong>Error!</strong> No se pudo eliminar el registro");}
                
            
                
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Semanatrabajo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id_usr)
	{
            $usuario = Usuario::model()->findByAttributes(array('id'=>$id_usr));
            $persona = Persona::model()->findByAttributes(array('dni'=>$usuario{'dni_per'}));
            $usuario->apellido=$persona{'apellido'};
            $usuario->nombre=$persona{'nombre'};
		$UsuarioSemTra = Usuariosemtra::model()->findAllByAttributes(array('id_usr'=>$id_usr));
                $semanasDeTrabajo=[];
                foreach ($UsuarioSemTra as $key=>$value){
                    $semanasDeTrabajo[]=Semanatrabajo::model()->findByAttributes(array('id'=>$value{'id_semtra'}));
                }
                                
                $DataProviderSemanas=new CArrayDataProvider($semanasDeTrabajo, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>10,
                       ),
                   )); 
               
                $semanatrabajo =$semanasDeTrabajo[0];
                $semanatrabajo->id_usr=$id_usr;
		$this->render('admin',array(
			'DataProviderSemanas'=>$DataProviderSemanas,
                        'usuario'=> $usuario ,
                        'semanatrabajo'=>$semanatrabajo,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Semanatrabajo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Semanatrabajo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Semanatrabajo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='semanatrabajo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
