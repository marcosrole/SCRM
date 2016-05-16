<?php

/**
 * This is the model class for table "localidad".
 *
 * The followings are the available columns in table 'localidad':
 * @property integer $id_loc
 * @property string $nombre
 * @property string $cp
 *
 * The followings are the available model relations:
 * @property Direccion[] $direccions
 */
class Localidad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'localidad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_loc, nombre, cp', 'required'),
			array('id_loc', 'numerical', 'integerOnly'=>true),
			array('nombre, cp', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_loc, nombre, cp', 'safe', 'on'=>'search'),
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
			'direccions' => array(self::HAS_MANY, 'Direccion', 'id_loc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_loc' => 'Id Loc',
			'nombre' => 'Nombre',
			'cp' => 'Cp',
		);
	}
        public static function getId($nombre){
            $criterial = new CDbCriteria;
            $criterial->condition = "nombre='" . $nombre . "'";
            return Localidad::model()->find($criterial);
        }

        public static function getListNombre(){
            $lista_localidades = array();        
            $localidades = Localidad::model()->findAll();                 
            foreach ($localidades as $key => $value) {            
                $lista_localidades2[]= [$value{'id'}=>$value{'nombre'}];
            }  
            
            foreach ($localidades as $key => $value) {            
               $lista_localidades[$count]= $value{'nombre'};
               
            }  
            return $lista_localidades;
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('cp',$this->cp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Localidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
