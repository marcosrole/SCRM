<?php

/**
 * This is the model class for table "usuariosemtra".
 *
 * The followings are the available columns in table 'usuariosemtra':
 * @property integer $id
 * @property integer $id_usr
 * @property integer $id_semtra
 *
 * The followings are the available model relations:
 * @property Usuario $idUsr
 * @property Semanatrabajo $idSemtra
 */
class Usuariosemtra extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuariosemtra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usr, id_semtra', 'required'),
			array('id_usr, id_semtra', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_usr, id_semtra', 'safe', 'on'=>'search'),
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
			'idUsr' => array(self::BELONGS_TO, 'Usuario', 'id_usr'),
			'idSemtra' => array(self::BELONGS_TO, 'Semanatrabajo', 'id_semtra'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_usr' => 'Id Usr',
			'id_semtra' => 'Id Semtra',
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
		$criteria->compare('id_usr',$this->id_usr);
		$criteria->compare('id_semtra',$this->id_semtra);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuariosemtra the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
