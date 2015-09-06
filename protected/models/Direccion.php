<?php

/**
 * This is the model class for table "direccion".
 *
 * The followings are the available columns in table 'direccion':
 * @property integer $id_loc
 * @property integer $id_dir
 * @property integer $altura
 * @property string $calle
 * @property integer $piso
 * @property integer $depto
 *
 * The followings are the available model relations:
 * @property Localidad $idLoc
 * @property Empresa[] $empresas
 * @property Empresa[] $empresas1
 * @property Empresa[] $empresas2
 * @property Persona[] $personas
 * @property Persona[] $personas1
 * @property Persona[] $personas2
 */
class Direccion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'direccion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_loc, altura, calle, piso, depto', 'required'),
			array('id_loc, altura', 'numerical', 'integerOnly'=>true),
			array('calle', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_loc, id_dir, altura, calle, piso, depto', 'safe', 'on'=>'search'),
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
			'idLoc' => array(self::BELONGS_TO, 'Localidad', 'id_loc'),
			'empresas' => array(self::HAS_MANY, 'Empresa', 'id_dir_dir'),
			'empresas1' => array(self::HAS_MANY, 'Empresa', 'altura_dir'),
			'empresas2' => array(self::HAS_MANY, 'Empresa', 'calle_dir'),
			'personas' => array(self::HAS_MANY, 'Persona', 'id_dir'),
			'personas1' => array(self::HAS_MANY, 'Persona', 'altura_dir'),
			'personas2' => array(self::HAS_MANY, 'Persona', 'calle_dir'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_loc' => 'Id Loc',
			'id_dir' => 'Id Dir',
			'altura' => 'Altura',
			'calle' => 'Calle',
			'piso' => 'Piso',
			'depto' => 'Depto',
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

		$criteria->compare('id_loc',$this->id_loc);
		$criteria->compare('id_dir',$this->id_dir);
		$criteria->compare('altura',$this->altura);
		$criteria->compare('calle',$this->calle,true);
		$criteria->compare('piso',$this->piso);
		$criteria->compare('depto',$this->depto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Direccion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public static function getId_dir($altura, $calle, $piso, $depto){
            $criterial = new CDbCriteria();
            $criterial->addcondition("altura='" . $altura ."'" );
            $criterial->addCondition("calle='" . $calle ."'" );
            $criterial->addCondition("piso='" . $piso ."'" );
            $criterial->addCondition("depto='" . $depto ."'" );
            
            return Direccion::model()->find($criterial);
        }
}
