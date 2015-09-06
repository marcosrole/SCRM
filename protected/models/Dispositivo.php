<?php

/**
 * This is the model class for table "dispositivo".
 *
 * The followings are the available columns in table 'dispositivo':
 * @property integer $id_dis
 * @property string $mac
 * @property string $modelo
 * @property string $version
 * @property integer $funciona
 *
 * The followings are the available model relations:
 * @property DetalleDispo[] $detalleDispos
 * @property DetalleDispo[] $detalleDispos1
 * @property Histoasignacion[] $histoasignacions
 * @property Histoasignacion[] $histoasignacions1
 */
class Dispositivo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dispositivo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mac', 'required'),
			//array('id_dis, funciona', 'numerical', 'integerOnly'=>true),
			array('mac, modelo, version', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dis, mac, modelo, version, funciona', 'safe', 'on'=>'search'),
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
			'detalleDispos' => array(self::HAS_MANY, 'DetalleDispo', 'id_dis'),
			'detalleDispos1' => array(self::HAS_MANY, 'DetalleDispo', 'mac_dis'),
			'histoasignacions' => array(self::HAS_MANY, 'Histoasignacion', 'id_dis'),
			'histoasignacions1' => array(self::HAS_MANY, 'Histoasignacion', 'mac_dis'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_dis' => 'Id Dis',
			'mac' => 'Mac',
			'modelo' => 'Modelo',
			'version' => 'Version',
			'funciona' => 'Funciona',
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

		$criteria->compare('id_dis',$this->id_dis);
		$criteria->compare('mac',$this->mac,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('funciona',$this->funciona);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dispositivo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
                
        public static function getListado(){
            return Dispositivo::model()->findAll();
        }
        
        public static function getid_dis($mac){
            $modelo=Dispositivo::model()->findAllByAttributes(array('mac'=>$mac));
            $id=$modelo[0]['id_dis'];
            return $id;
        }
        
        
        public static function exits($id_dis, $mac){
            $existe= Dispositivo::model()->exists("mac='$mac' OR id_dis='$id_dis'");           
            return $existe;
        }
        public static function exitsMAC($mac){
            $existe= Dispositivo::model()->exists("mac='$mac'");
            
            return $existe;
        }
        public static function exitsid($id_dis){
            $existe= Dispositivo::model()->exists("id_dis='$id_dis'");
            return $existe;
        }
        
        public static function deleteDisp($id_dis){
            Dispositivo::model()->deleteAll(array('id_dis'=>$id_dis));
            return $existe;
        }
}
