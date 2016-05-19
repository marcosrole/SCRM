<?php

/**
 * This is the model class for table "sucursal".
 *
 * The followings are the available columns in table 'sucursal':
 * @property integer $id
 * @property string $nombre
 * @property string $cuit_emp
 * @property integer $id_dir
 * @property integer $id_zon
 * @property integer $dni_per
 *
 * The followings are the available model relations:
 * @property Histoasignacion[] $histoasignacions
 * @property Persona $dniPer
 * @property Direccion $idDir
 * @property Empresa $cuitEmp
 * @property Zona $idZon
 */
class Sucursal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sucursal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, cuit_emp, id_dir, id_zon, dni_per', 'required'),
			array('id_dir, id_zon, dni_per', 'numerical', 'integerOnly'=>true),
			array('nombre, cuit_emp', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, cuit_emp, id_dir, id_zon, dni_per', 'safe', 'on'=>'search'),
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
			'histoasignacions' => array(self::HAS_MANY, 'Histoasignacion', 'id_suc'),
			'dniPer' => array(self::BELONGS_TO, 'Persona', 'dni_per'),
			'idDir' => array(self::BELONGS_TO, 'Direccion', 'id_dir'),
			'cuitEmp' => array(self::BELONGS_TO, 'Empresa', 'cuit_emp'),
			'idZon' => array(self::BELONGS_TO, 'Zona', 'id_zon'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'cuit_emp' => 'Cuit Emp',
			'id_dir' => 'Id Dir',
			'id_zon' => 'Id Zon',
			'dni_per' => 'Dni Per',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('cuit_emp',$this->cuit_emp,true);
		$criteria->compare('id_dir',$this->id_dir);
		$criteria->compare('id_zon',$this->id_zon);
		$criteria->compare('dni_per',$this->dni_per);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sucursal the static model class
	 */
        public static function getID($cuit){
            $criterial = new CDbCriteria();
            $criterial->condition="cuit_emp='" . $cuit . "' ";
            $sucursal = Sucursal::model()->find($criterial);
            var_dump($cuit);
            var_dump($sucursal);
            return $sucursal{'id'};            
        }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
