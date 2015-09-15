<?php

/**
 * This is the model class for table "detalle_dispo".
 *
 * The followings are the available columns in table 'detalle_dispo':
 * @property integer $id_dis
 * @property integer $id_det
 * @property string $mac_dis
 * @property double $db
 * @property double $distancia
 * @property string $fecha
 * @property string $hs
 *
 * The followings are the available model relations:
 * @property Dispositivo $idDis
 * @property Dispositivo $macDis
 */
class DetalleDispo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalle_dispo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mac_dis, db, distancia, fecha, hs', 'required'),
			array('id_dis', 'numerical', 'integerOnly'=>true),
			array('db, distancia', 'numerical'),
			array('mac_dis', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dis, id_det, mac_dis, db, distancia, fecha, hs', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_dis' => 'Id Dis',
			'id_det' => 'Id Det',
			'mac_dis' => 'Mac Dis',
			'db' => 'Db',
			'distancia' => 'Distancia',
			'fecha' => 'Fecha',
			'hs' => 'Hs',
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
		$criteria->compare('id',$this->id);
		$criteria->compare('mac_dis',$this->mac_dis,true);
		$criteria->compare('db',$this->db);
		$criteria->compare('distancia',$this->distancia);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hs',$this->hs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DetalleDispo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
