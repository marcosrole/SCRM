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
			array('fecha_modif, fecha_baja, coord_lat, coord_lon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dis, mac_dis, cuit_emp, razonsocial_emp, fecha_alta, fecha_modif, fecha_baja, coord_lat, coord_lon', 'safe', 'on'=>'search'),
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
			'idDis' => array(self::BELONGS_TO, 'Dispositivo', 'id_dis'),
			'macDis' => array(self::BELONGS_TO, 'Dispositivo', 'mac_dis'),
			'cuitEmp' => array(self::BELONGS_TO, 'Empresa', 'cuit_emp'),
			'razonsocialEmp' => array(self::BELONGS_TO, 'Empresa', 'razonsocial_emp'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_dis' => 'Id Dis',
			'mac_dis' => 'Mac Dis',
			'cuit_emp' => 'Cuit Emp',
			'razonsocial_emp' => 'Razonsocial Emp',
			'fecha_alta' => 'Fecha Alta',
			'fecha_modif' => 'Fecha Modif',
			'fecha_baja' => 'Fecha Baja',
			'coord_lat' => 'Coord Lat',
			'coord_lon' => 'Coord Lon',
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
		$criteria->compare('mac_dis',$this->mac_dis,true);
		$criteria->compare('cuit_emp',$this->cuit_emp,true);
		$criteria->compare('razonsocial_emp',$this->razonsocial_emp,true);
		$criteria->compare('fecha_alta',$this->fecha_alta,true);
		$criteria->compare('fecha_modif',$this->fecha_modif,true);
		$criteria->compare('fecha_baja',$this->fecha_baja,true);
		$criteria->compare('coord_lat',$this->coord_lat,true);
		$criteria->compare('coord_lon',$this->coord_lon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
