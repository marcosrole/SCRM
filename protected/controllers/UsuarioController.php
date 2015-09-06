<?php

class UsuarioController extends Controller {

     public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('create','view','update'),
                'users' => array('admin'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('loging'),
                'users' => array('*'),
            ),            
        );
    }

    public function actionCreate() {
        $model = new Usuario;

        if (isset($_POST['Usuario'])) {
            //Verifico si existe el usuario.
            $model->attributes = $_POST['Usuario'];
            if ($model->validate()) {
                //Verifico que no exista
                $criterial = new CDbCriteria;
                $criterial->condition = "name='" . $model->{'name'} . "'";

                if (Usuario::model()->count($criterial) != 0) { //Existe el modelo                    
                    $user = Yii::app()->getComponent('user');
                    $user->setFlash('error', "<strong>Error!</strong> Ya existe el usuario.");
                    $this->widget('booster.widgets.TbAlert', array(
                        'fade' => true,
                        'closeText' => '&times;', // false equals no close link
                        'events' => array(),
                        'htmlOptions' => array(),
                        'userComponentId' => 'user',
                        'alerts' => array(// configurations per alert type
                            // success, info, warning, error or danger
                            'error' => array('closeText' => '&times;'),
                        ),
                    ));
                   // header('Refresh:2;url=' . $this->createUrl('Usuario/create'));
                }elseif ($model->save()) {
                    $user = Yii::app()->getComponent('user');
                    $user->setFlash('success', "<strong>OK!</strong> Usuario almacenado con exito.");
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
                    header('Refresh:2;url=' . $this->createUrl('Usuario/create'));                    
                }
            }
        }
        $this->render('create', array('model' => $model));
    }

    
    public function actionDelete(){
        $model = new Usuario;
        $criterial = new CDbCriteria;
        $criterial->condition = "name='" . 'mma' . "'";
        $criterial->addCondition("pass='" . '12' . "'");
        if(Usuario::model()->deleteAll($criterial)){
            return true;
        }
        return false;
    }
    
    public function actionView(){
        
    }
    
     public function actionList(){
        $model = new Usuario;
        $this->render('list',array('model'=>$model));
    }
    
    public function actionUpdate(){
        
    }
    
    public function actionLoging(){
        $model = new Usuario;
                     
        if(isset($_POST['Usuario'])){
            $model->attributes = $_POST['Usuario'];
            if($model->validate()){            
                if($model->authenticate($model->pass, $model->name)){
                    $this->redirect(Yii::app()->user->returnUrl);
                }                
            }
        }
        $this->render('login',array('model'=>$model));
    }
    
    public function actionLogout(){
        Yii::app()->user->logout();
	$this->redirect(Yii::app()->homeUrl);
    }
    
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
