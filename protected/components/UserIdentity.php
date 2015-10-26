<?php

class UserIdentity extends CUserIdentity
{
    private $_id;


    public function authenticate()
	{
            $criterial = new CDbCriteria();
            $criterial->addCondition("name='" . strtolower($this->username) . "' ");
            $user = Usuario::model()->find($criterial);
                      
            if($user===null)
                    $this->errorCode=self::ERROR_USERNAME_INVALID;                
            elseif($this->password!==$user->pass)
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
            else{
                    $this->errorCode=self::ERROR_NONE;
                        //Yii::app()->user->id
                    $this->_id=$user->name;
                        //Yii::app()->user->getState("dni");
                    $this->setState('dni', $user->dni_per);
                    $this->setState('roles', $user->nivel);
                    
                    
            }
            $flag=true;
            if($this->errorCode == 0){
                $flag=true;
            }else $flag=false;
            return $flag;
	}
}