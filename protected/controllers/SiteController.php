<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
        
        public function actionVerificarAlarma()
	{
            var_dump(Yii::app()->sms->get_balance());
            die();
	}
        
	public function actionIndex()
	{
            $user = new Usuario();
            $error=false;
            if (isset($_POST['Usuario'])){
                $user->attributes=$_POST['Usuario'];
                
                $identity = new UserIdentity(($_POST['Usuario']['name']),(md5($_POST['Usuario']['pass'])));
                
                    if (!$identity->authenticate()){
                        Yii::app()->user->login($identity);                          
                        $this->redirect(Yii::app()->user->returnUrl);
                        }else {
                            $error=true;
                        }
                    }            
            $this->render('index', array('usuario'=>$user, 'error'=>$error));
	}

	
	public function actionAbout()
	{
		$this->render('about');
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
                
	{
            $contacto = new Contacto();
            
            if(isset($_POST['Contacto'])){
                $contacto->attributes=$_POST['Contacto'];
                if($contacto->validate()){
                    $message = new YiiMailMessage;                     
                    $message->subject = $contacto{'subject'};
                    $message->view ='contacto';//nombre de la vista q conformara el mail            
                    $message->setBody(array('datos'=>$contacto),'text/html');//codificar el html de la vista
                    $message->from =($contacto{'fromEmail'}); // alias del q envia
                    $message->setTo('marcosrole@gmail.com'); // a quien se le envia 
                    if(Yii::app()->mail->send($message)){
                        Yii::app()->user->setFlash('success', "<strong>Gracias por contactarse con nosotros!</strong> Nos comunicaremos a la brevedad ");                                                            
                        $this->redirect('contact');
                   }else  Yii::app()->user->setFlash('error', "<strong>Error!</strong> No se ha enviado el mail ");
                }else Yii::app()->user->setFlash('error', "<strong>Error!</strong> Campos incompletos");
            }
            
            $this->render('contact',array('model'=>$contacto));
            
        }


	/**
	 * Displays the login page
	 */
        public function actionLogin()
	{            
            $user = new Usuario();
            $error=false;   
            if (isset($_POST['Usuario'])){
                $user->attributes=$_POST['Usuario'];
                
                $identity = new UserIdentity(($_POST['Usuario']['name']),(md5($_POST['Usuario']['pass'])));
               // var_dump($identity); die();
                    if (!$identity->authenticate()){
                        Yii::app()->user->login($identity);                          
                        $this->redirect(Yii::app()->user->returnUrl);                         
                        }else {
                            $error=true;
                             Yii::app()->user->setFlash('error', "Usuario o contraseña incorrectos "); 
                             
                        }
                        
                    } 
              
            $this->render('login',array('usuario'=>$user, 'error'=>$error));
            
//            $identity = new UserIdentity($username,$password);
//            var_dump($identity);
//            die();
//            if($identity->authenticate()){
//                Yii::app()->user->login($identity);
//            }else $identity->errorMessage;
//            
//		if($this->_identity===null)
//		{
//			$this->_identity=new UserIdentity($this->username,$this->password);
//			$this->_identity->authenticate();
//		}
//		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
//		{
//			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
//			Yii::app()->user->login($this->_identity,$duration);
//			return true;
//		}
//		else
//			return false;
	}
        
//	public function actionLogin()
//	{
//		$model=new LoginForm;
//
//		// if it is ajax validation request
//		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}
//
//		// collect user input data
//		if(isset($_POST['LoginForm']))
//		{
//			$model->attributes=$_POST['LoginForm'];
//			// validate user input and redirect to the previous page if valid
//			if($model->validate() && $model->login())
//				$this->redirect(Yii::app()->user->returnUrl);
//		}
//		// display the login form
//		$this->render('login',array('model'=>$model));
//	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        
        public function actionContarAlarmas(){
            echo count(Alarma::model()->findAllByAttributes(array('solucionado'=>'0', 'preAlarma'=>'0')));
        }
        public function actionContarPREAlarmas(){
            echo count(Alarma::model()->findAllByAttributes(array('solucionado'=>'0', 'preAlarma'=>'1')));
        }
}