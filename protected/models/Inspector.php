<?php

/**
 * This is the model class for table "inspector".
 *
 * The followings are the available columns in table 'inspector':
 * @property integer $id
 * @property integer $ocupado
 * @property integer $id_rol
 * @property integer $id_zon
 *
 * The followings are the available model relations:
 * @property Asignarinspector[] $asignarinspectors
 * @property Zona $idZon
 * @property Rol $idRol
 * @property Rolsemtra[] $rolsemtras
 */
class Inspector extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inspector';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rol, id_zon', 'required'),
			array('ocupado, id_rol, id_zon', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ocupado, id_rol, id_zon', 'safe', 'on'=>'search'),
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
			'asignarinspectors' => array(self::HAS_MANY, 'Asignarinspector', 'id_ins'),
			'idZon' => array(self::BELONGS_TO, 'Zona', 'id_zon'),
			'idRol' => array(self::BELONGS_TO, 'Rol', 'id_rol'),
			'rolsemtras' => array(self::HAS_MANY, 'Rolsemtra', 'id_ins'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ocupado' => 'Ocupado',
			'id_rol' => 'Id Rol',
			'id_zon' => 'Id Zon',
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
		$criteria->compare('ocupado',$this->ocupado);
		$criteria->compare('id_rol',$this->id_rol);
		$criteria->compare('id_zon',$this->id_zon);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inspector the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
