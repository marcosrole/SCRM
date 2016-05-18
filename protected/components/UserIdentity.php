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
                    $this->_id=$user->id;
                    $nivelesAcceso=  $this->setNivelAcceso($this->getNivelAcceso());
                    $Menu = $this->getNivelesMenu($nivelesAcceso);
                                        
                    $this->setState('NivAcc', $nivelesAcceso);  
                    $this->setState('Menu', $Menu); 
                        //Yii::app()->user->getState("dni");
                    
//                    $this->setState('roles', $user->nivel);
            }
            
            return $this->errorCode;
	}
        
    public function getId(){ return $this->_id; }
    
    public function getNivelAcceso(){
        $id_usr = $this->_id;
        $Nivelacceso = Usuarionivacc::model()->findAllByAttributes(array('id_usr'=>$id_usr));       
        $nivelaccesoArray = array();
        if(count($Nivelacceso)!=0){
            foreach ($Nivelacceso as $item=>$value){
                $nivelaccesoArray[]=  Nivelacceso::model()->findByAttributes(array('id'=>$value{'id_nivAcc'}));
            }
        }
        return $nivelaccesoArray;
    }
    
    public function setNivelAcceso($arrayNivAcc){
        $list=[];
        if(count($arrayNivAcc)!=0){
            foreach ($arrayNivAcc as $item=>$value){
                $list[]=$value{'id'};
            }
        }
        return $list;
    }
    
    public function getNivelesMenu($array_NivAcc){
        $nivelesMenuArray = array();
        if($array_NivAcc!=0){
            for($i=0; $i<count($array_NivAcc); $i++){
                $Nivelesmenu = Nivelesmenu::model()->findAllByAttributes(array('id_nivAcc'=>$array_NivAcc[$i]));                       
                if(count($Nivelesmenu)!=0){
                    foreach ($Nivelesmenu as $item=>$value){
                        $nivelesMenuArray[]= Menu::model()->findByAttributes(array('id'=>$value{'id_men'}));
                    }
                }
            }
        }
        
        return $nivelesMenuArray;
    }
    
    
    
    
}