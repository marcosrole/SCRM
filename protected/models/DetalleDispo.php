<?php

/**
 * This is the model class for table "detalle_dispo".
 *
 * The followings are the available columns in table 'detalle_dispo':
 * @property integer $id
 * @property double $db
 * @property double $distancia
 * @property integer $id_dis
 * @property string $fechahs
 *
 * The followings are the available model relations:
 * @property Accesodispositivo[] $accesodispositivos
 * @property Accesodispositivo[] $accesodispositivos1
 * @property Dispositivo $idDis
 */
class DetalleDispo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalle_dispo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('db, distancia, id_dis, fechahs', 'required'),
			array('id_dis', 'numerical', 'integerOnly'=>true),
			array('db, distancia', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, db, distancia, id_dis, fechahs', 'safe', 'on'=>'search'),
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
			'accesodispositivos' => array(self::HAS_MANY, 'Accesodispositivo', 'id_detDis'),
			'accesodispositivos1' => array(self::HAS_MANY, 'Accesodispositivo', 'id_dis_detDis'),
			'idDis' => array(self::BELONGS_TO, 'Dispositivo', 'id_dis'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'db' => 'Db',
			'distancia' => 'Distancia',
			'id_dis' => 'Id Dis',
			'fechahs' => 'Fechahs',
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
		$criteria->compare('db',$this->db);
		$criteria->compare('distancia',$this->distancia);
		$criteria->compare('id_dis',$this->id_dis);
		$criteria->compare('fechahs',$this->fechahs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DetalleDispo the static model class
	 */
        
        public static function validarDatos($id_dis){
            Registroalarma::model()->determinarRuidoContinuo(20, 90, 180, $id_dis);            
        }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
