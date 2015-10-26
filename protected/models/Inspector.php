<?php

/**
 * This is the model class for table "inspector".
 *
 * The followings are the available columns in table 'inspector':
 * @property integer $id
 * @property integer $matricula
 * @property string $coordLat
 * @property string $coordLon
 * @property integer $ocupado
 * @property integer $id_usr
 *
 * The followings are the available model relations:
 * @property Usuario $idUsr
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
			array('matricula, id_usr', 'required'),
			array('matricula, ocupado, id_usr', 'numerical', 'integerOnly'=>true),
			array('coordLat, coordLon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, matricula, coordLat, coordLon, ocupado, id_usr', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'matricula' => 'Matricula',
			'coordLat' => 'Coord Lat',
			'coordLon' => 'Coord Lon',
			'ocupado' => 'Ocupado',
			'id_usr' => 'Id Usr',
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
		$criteria->compare('matricula',$this->matricula);
		$criteria->compare('coordLat',$this->coordLat,true);
		$criteria->compare('coordLon',$this->coordLon,true);
		$criteria->compare('ocupado',$this->ocupado);
		$criteria->compare('id_usr',$this->id_usr);

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
