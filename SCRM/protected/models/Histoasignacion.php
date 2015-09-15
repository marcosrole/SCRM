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
			array('id_dis, mac_dis, cuit_emp, razonsocial_emp, fecha_alta', 'required'),
			array('id_dis', 'numerical', 'integerOnly'=>true),
			array('mac_dis, cuit_emp, razonsocial_emp', 'length', 'max'=>50),
			array('observacion', 'length', 'max'=>100),
			array('fecha_modif, fecha_baja, coord_lat, coord_lon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dis, mac_dis, cuit_emp, razonsocial_emp, fecha_alta, fecha_modif, fecha_baja, coord_lat, coord_lon, observacion', 'safe', 'on'=>'search'),
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
                        'dispositivo' => array(self::BELONGS_TO, 'Dispositivo', 'id_dis,mac_dis'),
			'empresa' => array(self::BELONGS_TO, 'Empresa', 'cuit_emp,razonsocial_emp'),
			//'empresa_razonsocialEmp' => array(self::BELONGS_TO, 'Empresa', 'razonsocial_emp'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                        'id' => 'Id',
			'id_dis' => 'Id Dis',
			'mac_dis' => 'Mac Dis',
			'cuit_emp' => 'Cuit Emp',
			'razonsocial_emp' => 'Razonsocial Emp',
			'fecha_alta' => 'Fecha Alta',
			'fecha_modif' => 'Fecha Modif',
			'fecha_baja' => 'Fecha Baja',
			'coord_lat' => 'Coord Lat',
			'coord_lon' => 'Coord Lon',
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
		$criteria->compare('mac_dis',$this->mac_dis,true);
		$criteria->compare('cuit_emp',$this->cuit_emp,true);
		$criteria->compare('razonsocial_emp',$this->razonsocial_emp,true);
		$criteria->compare('fecha_alta',$this->fecha_alta,true);
		$criteria->compare('fecha_modif',$this->fecha_modif,true);
		$criteria->compare('fecha_baja',$this->fecha_baja,true);
		$criteria->compare('coord_lat',$this->coord_lat,true);
		$criteria->compare('coord_lon',$this->coord_lon,true);
		$criteria->compare('observacion',$this->observacion,true);

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
            $criterial->condition=("fecha_baja='1900-1-1'");	
            return Histoasignacion::model()->findAll($criterial);
	}
        
        public static function getDispositivosNODisponibles(){
            $criterial = new CDbCriteria();
            $criterial->condition=("fecha_baja='1900-1-1'");            
            return Histoasignacion::model()->with('dispositivo')->findAll($criterial);
        }
        
        public static function getDatosMapa(){
            //[id_dis coord_lat coord_lon direccion]
            $criterial = new CDbCriteria();
            $criterial->condition=("fecha_baja='1900-1-1'");
            $nodisponibles=Histoasignacion::model()->with('dispositivo')->findAll($criterial);
            
            $array_datos_mapa = array(); // [id => direccion]
            
            $criterial = new CDbCriteria();            
            foreach ($nodisponibles as $key=>$value){
                $criterial->condition=("cuit='" . $value{'cuit_emp'} . "'");                
                $empresa = new Empresa();
                $empresa = Empresa::model()->find($criterial);                
                $array_datos_mapa[]=[$value{'id_dis'}, $value{'coord_lat'}, $value{'coord_lon'}, ($empresa{'calle_dir'} . "" . $empresa{'altura_dir'} . " ")];                                        
            }
            
            return $array_datos_mapa;
        }
        
        
        

        public static function getDispositivosDispoibles(){
            //Obtengo los Dispositivos ocupados o los NO DISPONIBLES:
            $criterial = new CDbCriteria();
            $criterial->condition=("fecha_baja='1900-1-1'");
            $dispositivosNoDispoibles = Histoasignacion::model()->with('dispositivo')->findAll($criterial);
            $dispositivos = Dispositivo::model()->findAll();
                                   
            $bandera=false;
            $dispositivosDisponibles=array();
            foreach ($dispositivos as $Dispo) {
                foreach ($dispositivosNoDispoibles as $NoDispo) {
                    if($Dispo->id==$NoDispo->id_dis && $Dispo->mac==$NoDispo->mac_dis){                        
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
            $criterial->condition=("fecha_baja='1900-1-1'");
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
