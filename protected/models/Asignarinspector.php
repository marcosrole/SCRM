<?php

/**
 * This is the model class for table "asignarinspector".
 *
 * The followings are the available columns in table 'asignarinspector':
 * @property integer $id
 * @property string $hs
 * @property string $fecha
 * @property integer $id_ins
 * @property integer $id_suc
 *
 * The followings are the available model relations:
 * @property Inspector $idIns
 * @property Sucursal $idSuc
 */
class Asignarinspector extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asignarinspector';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hs, fecha, id_ins, id_ala', 'required'),
			array('id_ins, id_suc', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hs, fecha, id_ins, id_ala', 'safe', 'on'=>'search'),
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
			'idIns' => array(self::BELONGS_TO, 'Inspector', 'id_ins'),
			'idSuc' => array(self::BELONGS_TO, 'Alarma', 'id_ala'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hs' => 'Hs',
			'fecha' => 'Fecha',
			'id_ins' => 'Id Ins',
			'id_ala' => 'Id ala',
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
		$criteria->compare('hs',$this->hs,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_ins',$this->id_ins);
		$criteria->compare('id_ala',$this->id_ala);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Asignarinspector the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
