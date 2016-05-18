<?php

class NivelesmenuController extends Controller
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

        public function actionCreate($id=null, $id_usr=null){
            $menu = new Menu();
            $nivelacceso = array();
            $usuario = new Usuario();
            $persona = new Persona();
            
            //Busco usuario y la persona relacionada a el
//            -------------------------------------------------------------
            $usuario= Usuario::model()->findByPk($id_usr);            
            $persona = Persona::model()->findByPk($usuario->dni_per);
//            -------------------------------------------------------------
            
            //Niveles de acceso del usuario
//            ---------------------------------------------------------------
            $UsuarioNivAcc = new Usuarionivacc();
            $UsuarioNivAcc = Usuarionivacc::model()->findAllByAttributes(array('id_usr'=>$usuario->id));
            
            if(count($UsuarioNivAcc)==0){
                $raw['id']=1;
                $raw['usuario']="";                    
                $raw['NivelAcceso']="";
                $rawData[]=$raw;                   
            }else{
                foreach ($UsuarioNivAcc as $key=>$value){                   
                    $raw['id']=(int)$value{'id'};
                    $raw['usuario']=$value{'id_usr'};
                        $aux=Nivelacceso::model()->findByAttributes(array('id'=>$value{'id_nivAcc'}));
                    $raw['NivelAcceso']=$aux->nombre;
                    $rawData[]=$raw;                   
                }
            }
            

            $DataProviderNADispo=new CArrayDataProvider($rawData, array(
               'id'=>'id',
               'pagination'=>array(
                   'pageSize'=>10,
               ),
             ));
//            ---------------------------------------------------------------------
        
          
            
            //Niveles de Acceso Disponibles (NO cargados en el usuario)
//            --------------------------------------------------------------
            $ListNivAccDispo = array();
            $ListNivAcce = new Nivelacceso();            
            $ListNivAcce = Nivelacceso::model()->findAll();
            $flag=false;            
            foreach ($ListNivAcce as $item1=>$NivelAc){        
                $flag=false;
                foreach ($UsuarioNivAcc as $item2=>$UsrNivAcc){                    
                    $valor1=intval($NivelAc->id);
                    $valor2=intval($UsrNivAcc->id_nivAcc);
                    if(strcmp($valor1, $valor2)==0){                                            
                        $flag=true;
                    }         
                }              
                if(!$flag){                    
                    $ListNivAccDispo[]=$NivelAc;                    
                }
            }
             $menu = Menu::model()->findAll();
            
            //Verifico si se quiere asignar nuevo Nivel De acceso
            if (isset($_POST['selectNivelAcceso'])){
                //Guardo los niveles de acceso.
                $array_NivAcc = $_POST['selectNivelAcceso'];                 
                $NewUsrNivAcc = new Usuarionivacc();
                $NewUsrNivAcc->id_usr=$id_usr;
                $NewUsrNivAcc->id_nivAcc=$array_NivAcc[0];
                if(Usuarionivacc::model()->findByAttributes(array('id_usr'=>$id_usr, 'id_nivAcc'=>$array_NivAcc[0]))==NULL){
                    $NewUsrNivAcc->insert();
                    
                }
                $this->redirect(array('create','id_usr'=>$id_usr));
//                'url' => array('/site/logout'),
            }
            
//            --------------------------------------------------------------
            $this->render('create', array(
                'usuario'=>$usuario,
                'persona'=>$persona,                
                'DataProviderNADispo'=>$DataProviderNADispo,
                'ListNivAccDispo'=>$ListNivAccDispo,
            ));
        }

        public function actionEliminarr($id_UsrNivAcc)
	{
            //Busco el NivelAccedo del Usuario y Borro
            
            $UsuarioNivAcc = Usuarionivacc::model()->findByAttributes(array('id'=>$id_UsrNivAcc));
            $id_usr = $UsuarioNivAcc->id_usr;
            
            //Elimino:
            $UsuarioNivAcc->delete();            
            Yii::app()->user->setFlash('success', "<strong>Excelente!</strong> Nivel de Acceso eliminado" );            
            $this->redirect(array('create','id_usr'=>$id_usr));
            
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Nivelesmenu');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id_nivacc=null)
	{
            
            
            $NivAccSeleccionado = 'Seleccione un nivel de acceso';
            $NivelesAcceso = new Nivelacceso();
            
            $Menu = Menu::model()->findAll();
            
            foreach ($Menu as $item=> $value){
                $raw['id']=(int)$value{'id'};
                $raw['menu']=$value{'menu'}; 
                $raw['submenu']=$value{'submenu'};    
                $raw['descripcion']=$value{'descripcion'};    
                $raw['controller']=$value{'controller'};    
                $raw['action']=$value{'action'};    
                
                $rawData[]=$raw;  
            }
            
            $DataMenu=new CArrayDataProvider($rawData, array(
                       'id'=>'id',
                       'pagination'=>array(
                           'pageSize'=>100,
                       ),
                     ));
            
                   
            $ListMenu = Menu::model()->findAll();
            $ListNivelesAcceso = CHtml::listData($NivelesAcceso->findAll(array('order' => 'nombre')),'id','nombre');                        
            
            $transaction = Yii::app()->db->beginTransaction();
            if (isset($_POST['selectNivelAcceso'])) {
                try {
                    if($id_nivacc!=NULL){
                        
                        if ($_POST['selectNivelAcceso']!=NULL){
                            //Borro todos los menues de NIVELESMENU
                            Nivelesmenu::model()->deleteAllByAttributes(array('id_nivAcc'=>$id_nivacc));
                            
                            //Guardo los nuevos menues seleccionados:
                            $array_menu_selec = $_POST['selectNivelAcceso'];
                            $NivelesMenu = new Nivelesmenu();
                            for ($i=0; $i<count($array_menu_selec); $i++){
                                $NivelesMenu->id_men=$array_menu_selec[$i];
                                $NivelesMenu->id_nivAcc=$id_nivacc;                                        
                                $NivelesMenu->insert();            
                                $NivelesMenu = new Nivelesmenu();
                            }                            
                            Yii::app()->user->setFlash('success', "<strong>Datos guardados!</strong>" );
                            $transaction->commit();
                             $this->redirect(array('/site/logout'));
                            
                        }else{
                        $transaction->rollback();
                            Yii::app()->user->setFlash('error', "<strong>Error!</strong> Debe seleccionar al menos un menu para el Nivel de Acceso seleccionado ");
                    }
                    }else{
                        $transaction->rollback();
                            Yii::app()->user->setFlash('error', "<strong>Error!</strong> Debe seleccionar un Nivel de Acceso");
                    }
                    
                } catch (Exception $ex) {
                        Yii::app()->user->setFlash('error', $ex->getMessage());
                    }
            }
            
            if($id_nivacc!=null){
                $NivAcc = Nivelacceso::model()->findByAttributes(array('id'=>$id_nivacc));
                $NivAccSeleccionado = '--Nivel de Acceso: ' . $NivAcc{'nombre'} . '--';
                //Busco los menu de un Nivel determinado:                     
                
                $NivelesMenu = Nivelesmenu::model()->findAllByAttributes(array('id_nivAcc'=>$id_nivacc));
                
                $MenuSeleccionados = array();
                foreach ($NivelesMenu as $item=>$value){                
                    $MenuSeleccionados[]=$value{'id_men'};
                }
                
                $this->render('admin',array(
                            'ListNivelesAcceso'=>$ListNivelesAcceso,
                            'NivelesAcceso'=>$NivelesAcceso,
                            'ListMenu'=>$DataMenu,
                            'MenuSelecionado'=>$MenuSeleccionados,
                            'NivAccSeleccionado' => $NivAccSeleccionado,
                    ));
                
            }else{
                $this->render('admin',array(
                            'ListNivelesAcceso'=>$ListNivelesAcceso,
                            'NivelesAcceso'=>$NivelesAcceso,
                            'ListMenu'=>$DataMenu,
                            'MenuSelecionado'=>[],
                            'NivAccSeleccionado' => $NivAccSeleccionado,
                    ));
            }
            
            
	}
        
        

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Nivelesmenu the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Nivelesmenu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Nivelesmenu $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='nivelesmenu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        
}
