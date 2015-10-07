<?php

/**
 * This is the model class for table "permisosusuario".
 *
 * The followings are the available columns in table 'permisosusuario':
 * @property integer $id
 * @property integer $id_usr
 * @property integer $id_per
 *
 * The followings are the available model relations:
 * @property Usuario $idUsr
 * @property Permiso $idPer
 */
class Permisosusuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'permisosusuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usr, id_per', 'required'),
			array('id_usr, id_per', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_usr, id_per', 'safe', 'on'=>'search'),
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
			'idPer' => array(self::BELONGS_TO, 'Permiso', 'id_per'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_usr' => 'Id Usr',
			'id_per' => 'Id Per',
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
		$criteria->compare('id_usr',$this->id_usr);
		$criteria->compare('id_per',$this->id_per);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Permisosusuario the static model class
	 */
        public static function GenerarPermiso($id_usr, $id_permi){
            $permiso = new Permisosusuario();
            $permiso->id_usr=$id_usr;
            $permiso->id_per=$id_permi;            
            $permiso->insert();
            var_dump($permiso);
            die();
        }
        public static function getPermisos()
	{
            $permisos = Permiso::model()->findAll();
            $array_permisos = array();
            
            foreach ($permisos as $key=>$value){
                $array_permisos[]=$value{'titulo'};
            }
                return $array_permisos;
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
