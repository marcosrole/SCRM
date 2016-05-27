<?php

/**
 * This is the model class for table "inspector".
 *
 * The followings are the available columns in table 'inspector':
 * @property integer $id
 * @property integer $ocupado
 * @property integer $id_rol
 * @property integer $id_zon
 * @property integer $id_usr
 * @property string $fechaDesocupado
 *
 * The followings are the available model relations:
 * @property Acta[] $actas
 * @property Asignarinspector[] $asignarinspectors
 * @property Rol $idRol
 * @property Zona $idZon
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
			array('id_rol, id_zon', 'required'),
			array('ocupado, id_rol, id_zon, id_usr', 'numerical', 'integerOnly'=>true),
			array('fechaDesocupado', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ocupado, id_rol, id_zon, id_usr, fechaDesocupado', 'safe', 'on'=>'search'),
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
			'actas' => array(self::HAS_MANY, 'Acta', 'id_ins'),
			'asignarinspectors' => array(self::HAS_MANY, 'Asignarinspector', 'id_ins'),
			'idRol' => array(self::BELONGS_TO, 'Rol', 'id_rol'),
			'idZon' => array(self::BELONGS_TO, 'Zona', 'id_zon'),
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
			'ocupado' => 'Ocupado',
			'id_rol' => 'Id Rol',
			'id_zon' => 'Id Zon',
			'id_usr' => 'Id Usr',
			'fechaDesocupado' => 'Fecha Desocupado',
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
		$criteria->compare('id_usr',$this->id_usr);
		$criteria->compare('fechaDesocupado',$this->fechaDesocupado,true);

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
        public static function estoyOcupado($id, $fecha){
            $inspector= Inspector::model()->findByAttributes(array('id'=>$id));
            $inspector->ocupado=1;
            $inspector->fechaDesocupado=$fecha;
            $inspector->save();
        }
        public static function estoyLibre($id){
            $inspector= Inspector::model()->findByAttributes(array('id'=>$id));
            $inspector->ocupado=0;
            $inspector->save();
        }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
