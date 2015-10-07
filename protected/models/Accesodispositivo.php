<?php

/**
 * This is the model class for table "accesodispositivo".
 *
 * The followings are the available columns in table 'accesodispositivo':
 * @property integer $id
 * @property string $fechaUltimo
 * @property string $hsUltimo
 * @property integer $id_detDis
 * @property integer $id_dis_detDis
 *
 * The followings are the available model relations:
 * @property DetalleDispo $idDetDis
 * @property DetalleDispo $idDisDetDis
 */
class Accesodispositivo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accesodispositivo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fechaUltimo, hsUltimo, id_detDis, id_dis_detDis', 'required'),
			array('id_detDis, id_dis_detDis', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fechaUltimo, hsUltimo, id_detDis, id_dis_detDis', 'safe', 'on'=>'search'),
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
			'idDetDis' => array(self::BELONGS_TO, 'DetalleDispo', 'id_detDis'),
			'idDisDetDis' => array(self::BELONGS_TO, 'DetalleDispo', 'id_dis_detDis'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechaUltimo' => 'Fecha Ultimo',
			'hsUltimo' => 'Hs Ultimo',
			'id_detDis' => 'Id Det Dis',
			'id_dis_detDis' => 'Id Dis Det Dis',
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
		$criteria->compare('fechaUltimo',$this->fechaUltimo,true);
		$criteria->compare('hsUltimo',$this->hsUltimo,true);
		$criteria->compare('id_detDis',$this->id_detDis);
		$criteria->compare('id_dis_detDis',$this->id_dis_detDis);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Accesodispositivo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
