<?php

class funcionesAux {
    public $actiones;
    
    
//    Pasandole un conjunto de MENU y el menu que interesa $menuABuscar, 
//    me devuelve un array con todas las action de ese menu
    public function obtenerActionsPermitidas($Menues, $menuABuscar){
        $actiones=[];
        if(count($Menues)!=0){
            foreach ($Menues as $item=>$value){
                if(strcmp(strtoupper($value{'controller'}),strtoupper($menuABuscar))==0){
                    $actiones[]=$value{'action'};
                }
            }
        }    
        $this->actiones=$actiones;
        return $this->actiones;
    }
    
}
