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
	public function actionIndex()
	{
            $user = new Usuario();
            $error=false;
            if (isset($_POST['Usuario'])){
                $user->attributes=$_POST['Usuario'];
                $identity = new UserIdentity(($_POST['Usuario']['name']),md5($_POST['Usuario']['pass']));
               
//                if ($user->validate()){
                    if ($identity->authenticate()){
                        
                        Yii::app()->user->login($identity);                        
                        $this->redirect(Yii::app()->user->returnUrl);
                    }else $error=true;
//                }
                

            }            
            $this->render('index', array('usuario'=>$user, 'error'=>$error));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
                
	{
            $name='=?UTF-8?B?'.base64_encode("marcos").'?=';
				$subject='=?UTF-8?B?'.base64_encode("pruebaa").'?=';
				$headers="From: $name <{'marcosrole@gmail.com'}>\r\n".
					"Reply-To: {'marcosrole@gmail.com'}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				if(mail(Yii::app()->params['adminEmail'],$subject,"Holaaaaaaaaaa",$headers)){
                                    echo "se envio";
                                }else echo "no";
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
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
                
                $identity = new UserIdentity(($_POST['Usuario']['name']),md5($_POST['Usuario']['pass']));
                    if ($identity->authenticate()){                      
                        Yii::app()->user->login($identity);                          
                        $this->redirect(Yii::app()->user->returnUrl);
                        }else $error=true;
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
}