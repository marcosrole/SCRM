<?php

/**
 * This is the model class for table "empresa".
 *
 * The followings are the available columns in table 'empresa':
 * @property string $cuit
 * @property string $razonsocial
 * @property integer $dni_per
 * @property string $tipo_dni_per
 * @property integer $id_dir
 * @property integer $altura_dir
 * @property string $calle_dir
 *
 * The followings are the available model relations:
 * @property Direccion $idDirDir
 * @property Direccion $alturaDir
 * @property Direccion $calleDir
 * @property Persona $dniPer
 * @property Persona $tipoDniPer
 * @property Histoasignacion[] $Histoasignacions
 * @property Histoasignacion[] $Histoasignacions1
 */
class Empresa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'empresa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cuit, razonsocial, dni_per, tipo_dni_per, altura_dir, calle_dir', 'required'),
			array('dni_per, altura_dir', 'numerical', 'integerOnly'=>true),
			array('cuit, razonsocial, tipo_dni_per, calle_dir', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cuit, razonsocial, dni_per, tipo_dni_per, id_dir, altura_dir, calle_dir', 'safe', 'on'=>'search'),
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
			'idDirDir' => array(self::BELONGS_TO, 'Direccion', 'id_dir'),
			'alturaDir' => array(self::BELONGS_TO, 'Direccion', 'altura_dir'),
			'calleDir' => array(self::BELONGS_TO, 'Direccion', 'calle_dir'),
			'dniPer' => array(self::BELONGS_TO, 'Persona', 'dni_per'),
			'tipoDniPer' => array(self::BELONGS_TO, 'Persona', 'tipo_dni_per'),
			'Histoasignacions' => array(self::HAS_MANY, 'Histoasignacion', 'cuit_emp'),
			'Histoasignacions1' => array(self::HAS_MANY, 'Histoasignacion', 'razonsocial_emp'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cuit' => 'Cuit',
			'razonsocial' => 'Razonsocial',
			'dni_per' => 'Dni Per',
			'tipo_dni_per' => 'Tipo Dni Per',
			'id_dir' => 'Id Dir Dir',
			'altura_dir' => 'Altura Dir',
			'calle_dir' => 'Calle Dir',
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

		$criteria->compare('cuit',$this->cuit,true);
		$criteria->compare('razonsocial',$this->razonsocial,true);
		$criteria->compare('dni_per',$this->dni_per);
		$criteria->compare('tipo_dni_per',$this->tipo_dni_per,true);
		$criteria->compare('id_dir',$this->id_dir);
		$criteria->compare('altura_dir',$this->altura_dir);
		$criteria->compare('calle_dir',$this->calle_dir,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Empresa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public static function getListado(){
            return Empresa::model()->findAll();
        }
        
}
