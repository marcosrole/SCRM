<?php

/**
 * This is the model class for table "asignarinspector".
 *
 * The followings are the available columns in table 'asignarinspector':
 * @property integer $id
 * @property string $fechahsIns
 * @property string $fechahsDue
 * @property integer $id_ins
 * @property integer $id_ala
 * @property string $observacion
 * @property integer $finalizado
 *
 * The followings are the available model relations:
 * @property Inspector $idIns
 * @property Alarma $idAla
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
			array('fechahsIns, fechahsDue, id_ins, id_ala', 'required'),
			array('id_ins, id_ala, finalizado', 'numerical', 'integerOnly'=>true),
			array('observacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fechahsIns, fechahsDue, id_ins, id_ala, observacion, finalizado', 'safe', 'on'=>'search'),
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
			'idAla' => array(self::BELONGS_TO, 'Alarma', 'id_ala'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechahsIns' => 'Fechahs Ins',
			'fechahsDue' => 'Fechahs Due',
			'id_ins' => 'Id Ins',
			'id_ala' => 'Id Ala',
			'observacion' => 'Observacion',
			'finalizado' => 'Finalizado',
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
		$criteria->compare('fechahsIns',$this->fechahsIns,true);
		$criteria->compare('fechahsDue',$this->fechahsDue,true);
		$criteria->compare('id_ins',$this->id_ins);
		$criteria->compare('id_ala',$this->id_ala);
		$criteria->compare('observacion',$this->observacion,true);
		$criteria->compare('finalizado',$this->finalizado);

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
