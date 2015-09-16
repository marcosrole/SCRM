<?php

/**
 * This is the model class for table "persona".
 *
 * The followings are the available columns in table 'persona':
 * @property integer $dni
 * @property string $tipo_dni
 * @property string $nom_ape
 * @property string $sexo
 * @property string $cuil
 * @property integer $id_dir
 * @property integer $altura_dir
 * @property string $calle_dir
 * @property string $telefono
 *
 * The followings are the available model relations:
 * @property Empresa[] $empresas
 * @property Empresa[] $empresas1
 * @property Direccion $idDir
 * @property Direccion $alturaDir
 * @property Direccion $calleDir
 * @property Usuario[] $usurios
 */
class Persona extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
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
			array('dni, tipo_dni, nom_ape', 'required'),
			array('dni, altura_dir', 'numerical', 'integerOnly'=>true),
			array('tipo_dni, nom_ape, calle_dir', 'length', 'max'=>50),
                        array('sexo', 'length', 'max'=>2),
                        array('telefono', 'length', 'max'=>20),
			array('cuil', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dni, tipo_dni, nom_ape, sexo, cuil, id_dir, altura_dir, calle_dir, telefono', 'safe', 'on'=>'search'),
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
			'empresas1' => array(self::HAS_MANY, 'Empresa', 'tipo_dni_per'),
			'idDir' => array(self::BELONGS_TO, 'Direccion', 'id_dir'),
			'alturaDir' => array(self::BELONGS_TO, 'Direccion', 'altura_dir'),
			'calleDir' => array(self::BELONGS_TO, 'Direccion', 'calle_dir'),
                        'usuario' => array(self::HAS_MANY, 'Usuario', 'dni_per'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dni' => 'DNI',
			'tipo_dni' => 'Tipo DNI',
			'nom_ape' => 'Nombre y Apellido',
			'sexo' => 'Sexo',
			'cuil' => 'CUIL',
			'id_dir' => 'Id Dir',
			'altura_dir' => 'Altura',
			'calle_dir' => 'Calle',
                        'telefono' => 'Telefono',
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
		$criteria->compare('nom_ape',$this->nom_ape,true);
		$criteria->compare('sexo',$this->sexo);
		$criteria->compare('cuil',$this->cuil,true);
		$criteria->compare('id_dir',$this->id_dir);
		$criteria->compare('altura_dir',$this->altura_dir);
		$criteria->compare('calle_dir',$this->calle_dir,true);
                $criteria->compare('telefono',$this->telefono,true);

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
