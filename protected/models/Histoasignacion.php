<?php

/**
 * This is the model class for table "histoasignacion".
 *
 * The followings are the available columns in table 'histoasignacion':
 * @property integer $id_dis
 * @property string $mac_dis
 * @property string $cuit_emp
 * @property string $razonsocial_emp
 * @property string $fecha_alta
 * @property string $fecha_modif
 * @property string $fecha_baja
 * @property string $coord_lat
 * @property string $coord_lon
 * @property string $observacion
 *
 * The followings are the available model relations:
 * @property Dispositivo $idDis
 * @property Dispositivo $macDis
 * @property Empresa $cuitEmp
 * @property Empresa $razonsocialEmp
 */
class Histoasignacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'histoasignacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_dis, id_suc, fechaAlta', 'required'),
			array('id_dis, id_suc', 'numerical', 'integerOnly'=>true),			
			array('observacion', 'length', 'max'=>120),
                        //array('fechaModif, fechaAlta, fechaBaja', 'date', 'format'=>'yyyy-MM-dd'),			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dis, id_suc, fechaAlta, fechaModif, fechaBaja, coordLat, coordLon, observacion', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(			
                        'dispositivo' => array(self::BELONGS_TO, 'Dispositivo', 'id_dis'),
			'empresa' => array(self::BELONGS_TO, 'Sucursal', 'id_suc'),
			//'empresa_razonsocialEmp' => array(self::BELONGS_TO, 'Empresa', 'razonsocial_emp'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                        'id' => 'ID',
			'id_dis' => 'ID Dispositivo',
                        'id_suc' => 'ID Sucursal',			
			'fechaAlta' => 'Fecha Alta',
			'fechaModif' => 'Fecha Modif',
			'fechaBaja' => 'Fecha Baja',
			'coordLat' => 'Coordenada Latitud',
			'coordLon' => 'Coordenada Longitud',
			'observacion' => 'Observacion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
                $criteria->compare('id_dis',$this->id_dis);
                $criteria->compare('id_suc',$this->id_suc);		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getListado()
	{
		return Histoasignacion::model()->findAll();
	}
        
        public static function getVigentes()
	{
            $criterial= new CDbCriteria();
            $criterial->condition=("fechaBaja='1900-01-01'");	
            return Histoasignacion::model()->findAll($criterial);
	}
        
        public static function getDispositivosNODisponibles(){
            $criterial = new CDbCriteria();
            $criterial->condition=("fechaBaja='1900-01-01'");            
            return Histoasignacion::model()->with('dispositivo')->findAll($criterial);
        }
        
        public static function getDatosMapa(){
            //[id_dis coord_lat coord_lon direccion]
            $criterial = new CDbCriteria();
            $criterial->condition=("fechaBaja='1900-01-01'");
            $nodisponibles=Histoasignacion::model()->with('dispositivo')->findAll($criterial);
            
            $array_datos_mapa = array(); // [id => direccion]
            
            $criterial = new CDbCriteria();            
            foreach ($nodisponibles as $key=>$value){                
                $sucursal = Sucursal::model()->findByAttributes(array('id'=>$value{'id_suc'}));
                $direccion = Direccion::model()->findByAttributes(array('id'=>$sucursal{'id_dir'}));
                $array_datos_mapa[]=[$value{'id_dis'}, $value{'coordLat'}, $value{'coordLon'}, ($direccion{'calle'} . " " . $direccion{'altura'} . " Piso:" . $direccion{'piso'} . " Depto:" . $direccion{'depto'})];                                        
            }
            
            return $array_datos_mapa;
        }
        
        
        

        public static function getDispositivosDispoibles(){
            //Obtengo los Dispositivos ocupados o los NO DISPONIBLES:
            $criterial = new CDbCriteria();
            $criterial->condition=("fechaBaja='1900-01-01'");
            $dispositivosNoDispoibles = Histoasignacion::model()->with('dispositivo')->findAll($criterial);
            $dispositivos = Dispositivo::model()->findAll();
                                   
            $bandera=false;
            $dispositivosDisponibles=array();
            foreach ($dispositivos as $Dispo) {
                foreach ($dispositivosNoDispoibles as $NoDispo) {
                    if($Dispo->id==$NoDispo->id_dis){                        
                        $bandera=true;
                    }
                }
                if(!$bandera){                    
                    $dispositivosDisponibles[]=$Dispo;
                }
                $bandera=false;
            }
            return $dispositivosDisponibles;
        }
        
        public static function getEmpresaDispoibles(){
            
            //Obtengo los Dispositivos ocupados o los NO DISPONIBLES:            
            $criterial = new CDbCriteria();
            $criterial->condition=("fechaBaja='1900-01-01'");
            $empresaNoDispoibles = Histoasignacion::model()->with('empresa')->findAll($criterial);
            
            
            $empresas = Empresa::model()->findAll();
                                   
            $bandera=false;
            $empresasDisponibles=array();
            foreach ($empresas as $Dispo) {
                foreach ($empresaNoDispoibles as $NoDispo) {
                    if($Dispo->cuit==$NoDispo->cuit_emp && $Dispo->razonsocial==$NoDispo->razonsocial_emp){                        
                        $bandera=true;
                    }
                }
                if(!$bandera){                    
                    $empresasDisponibles[]=$Dispo;
                }
                $bandera=false;
            }
            return $empresasDisponibles;
        }

        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Histoasignacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
