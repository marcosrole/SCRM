<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
            private $_id;
            public function authenticate()
            { 
                $record=Usuario::model()->findByAttributes(array('name'=>$this->username));
                $record->pass = crypt($record['pass']);
                
                if($record===null)
                    $this->errorCode=self::ERROR_USERNAME_INVALID;
                else if(!CPasswordHelper::verifyPassword($this->password,$record->pass))
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                else
                {
                    $this->_id=$record->id;
//                    $this->setState('title', $record->title); //Es para setear algun parametro del usuario, que dicho parametro se almacenara todo el tiempo de login del usuario
                    $this->errorCode=self::ERROR_NONE;
                }
                return !$this->errorCode;
            }

            
            public function getId()
            {
                return $this->_id;
            }
       
//	public function authenticate()
//	{
//		$users=array(
//			// username => password
//			'demo'=>'demo',
//			'admin'=>'admin',
//		);
//		if(!isset($users[$this->username]))
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		elseif($users[$this->username]!==$this->password)
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;
//		return !$this->errorCode;
//	}
}