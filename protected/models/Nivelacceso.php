<?php

/**
 * This is the model class for table "nivelacceso".
 *
 * The followings are the available columns in table 'nivelacceso':
 * @property integer $id
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property Nivelesmenu[] $nivelesmenus
 * @property Usuario[] $usuarios
 */
class Nivelacceso extends CActiveRecord
{
    public $id_usr;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nivelacceso';
	}
        public function getId() {
            return $this->_id;
          }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre', 'safe', 'on'=>'search'),
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
			'nivelesmenus' => array(self::HAS_MANY, 'Nivelesmenu', 'id_nivAcc'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'id_nivAcc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Nivel de Acceso',
			'nombre' => 'Nombre',
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
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getNivelesAcceso($id_usr){
            $UsuarioNivAcc = Usuarionivacc::model()->findAllByAttributes(array('id_usr'=>$id_usr));
            $nivelesAcceso = [];
            if(count($UsuarioNivAcc)>1){
                foreach ($UsuarioNivAcc as $key=>$value){
                    $nivelesAcceso[]=  Nivelacceso::model()->findByAttributes(array('id'=>$value{'id_nivAcc'}));
                }
            }elseif (count($UsuarioNivAcc)==1) $nivelesAcceso[]=  Nivelacceso::model()->findByAttributes(array('id'=>$UsuarioNivAcc[0]{'id_nivAcc'}));
            
            return $nivelesAcceso;
            
        }
        
        public function getNivelAcceso()
        {
            $NivelesAcceso = Nivelacceso::model()->findAll();
            $ListNivelesAcceso = array();
            foreach ($NivelesAcceso as $item=>$value){
                $ListNivelesAcceso[]=[$value{'id'}, $value{'nombre'}];
            }
                
            return $ListNivelesAcceso;
        }

        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Nivelacceso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
