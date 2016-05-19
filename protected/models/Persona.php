<?php

/**
 * This is the model class for table "persona".
 *
 * The followings are the available columns in table 'persona':
 * @property integer $dni
 * @property string $tipo_dni
 * @property string $nombre
 * @property string $apellido
 * @property integer $sexo
 * @property string $cuil
 * @property string $email
 * @property string $telefono
 * @property string $celular
 * @property string $fechaNacimiento
 * @property integer $id_dir
 *
 * The followings are the available model relations:
 * @property Empresa[] $empresas
 * @property Direccion $idDir
 * @property Usuario[] $usuarios
 */
class Persona extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $checked = false;
        public function tableName()
	{
		return 'persona';
	}
        

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dni, tipo_dni, nombre, apellido', 'required'),
                        array('email', 'email'),
			array('dni, sexo, id_dir', 'numerical', 'integerOnly'=>true),
			array('tipo_dni, nombre, apellido, telefono, celular', 'length', 'max'=>50),
			array('cuil, fechaNacimiento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dni, tipo_dni, nombre, apellido, sexo, cuil, email, telefono, celular, fechaNacimiento, id_dir', 'safe', 'on'=>'search'),
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
			'empresas' => array(self::HAS_MANY, 'Empresa', 'dni_per'),
			'direccion' => array(self::BELONGS_TO, 'Direccion', 'id_dir'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'dni_per'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dni' => 'DNI',
			'tipo_dni' => 'Tipo Dni',
			'nombre' => 'Nombre',
			'apellido' => 'Apellido',
			'sexo' => 'Sexo',
			'cuil' => 'Cuil',
			'email' => 'Email',
			'telefono' => 'Telefono',
			'celular' => 'Celular',
			'fechaNacimiento' => 'Fecha Nacimiento',
			'id_dir' => 'Id Dir',
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

		$criteria->compare('dni',$this->dni);
		$criteria->compare('tipo_dni',$this->tipo_dni,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido',$this->apellido,true);
		$criteria->compare('sexo',$this->sexo);
		$criteria->compare('cuil',$this->cuil,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('fechaNacimiento',$this->fechaNacimiento,true);
		$criteria->compare('id_dir',$this->id_dir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Persona the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
