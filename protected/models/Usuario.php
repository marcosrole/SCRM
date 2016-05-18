<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $name
 * @property string $pass
 * @property integer $id_nivAcc
 * @property integer $dni_per
 *
 * The followings are the available model relations:
 * @property Asignarpermiso[] $asignarpermisos
 * @property Online[] $onlines
 * @property Persona $dniPer
 * @property Nivelacceso $idNivAcc
 * @property Usuariorol[] $usuariorols
 */
class Usuario extends CActiveRecord
{
        public $roles; //String con los niveles: "Administrador, Inspector"
        public $nombre;
        public $apellido;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, pass, dni_per', 'required'),
			array('id_nivAcc, dni_per', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			array('pass', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, pass, id_nivAcc, dni_per', 'safe', 'on'=>'search'),
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
			'asignarpermisos' => array(self::HAS_MANY, 'Asignarpermiso', 'id_usr'),
			'onlines' => array(self::HAS_MANY, 'Online', 'id_usr'),
			'dniPer' => array(self::BELONGS_TO, 'Persona', 'dni_per'),
			'idNivAcc' => array(self::BELONGS_TO, 'Nivelacceso', 'id_nivAcc'),
			'usuariorols' => array(self::HAS_MANY, 'Usuariorol', 'id_usr'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Usuario',
			'pass' => 'Contraseña',
			'id_nivAcc' => 'Id Niv Acc',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('id_nivAcc',$this->id_nivAcc);
		$criteria->compare('dni_per',$this->dni_per);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
