<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property string $name
 * @property string $pass
 * @property integer $dni_per
 *
 * The followings are the available model relations:
 * @property Inspector[] $inspectors
 * @property Inspector[] $inspectors1
 * @property Inspector[] $inspectors2
 * @property Online[] $onlines
 * @property Online[] $onlines1
 * @property Online[] $onlines2
 * @property Permiso[] $permisos
 * @property Permiso[] $permisos1
 * @property Permiso[] $permisos2
 * @property Persona $dniPer
 */
class Usuario extends CActiveRecord
{
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
			//array('name, pass', 'required',"message"=>"El campo no puede estar en blanco"),
                        array('name, nivel, pass, dni_per', 'required',"message"=>"El campo no puede estar en blanco"),
                        array('name', 'unique',"message"=>'El usuario ya existe'),
			array('dni_per', 'numerical', 'integerOnly'=>true,"message"=>"Debe ser un numero"),
			array('name, pass', 'length', 'max'=>20, "message"=>"No puede sobrepasar los 20 caracteres"),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, pass, dni_per', 'safe', 'on'=>'search'),
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
                        'esPersona' => array(self::BELONGS_TO, 'Persona', 'DNI_per'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Nombre de Usuario',
			'pass' => 'Contraseña',
			'dni_per' => 'DNI del Usuario',                        
                        'nivel' => 'Nivel de acceso',
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('dni_per',$this->dni_per);
                $criteria->compare('permiso',$this->permiso);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getDNI_per($name){            
            $criterial = new CDbCriteria();
            $criterial->condition="name='" . $name . "' ";
            $usuario = new Usuario();
            $usuario = Usuario::model()->find($criterial);
            
            return $usuario{'dni_per'};
            
        }
        public static function getArrayUsuarios()
	{
            $usuarios = Usuario::model()->findAll();
            $array_usuarios = array();
            
            foreach ($usuarios as $key=>$value){
                $array_usuarios[$value{'id'}]=$value{'name'};
            }
                return $array_usuarios;
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
