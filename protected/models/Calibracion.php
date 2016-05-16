<?php

/**
 * This is the model class for table "calibracion".
 *
 * The followings are the available columns in table 'calibracion':
 * @property integer $id
 * @property double $db_permitido
 * @property double $dist_permitido
 * @property string $fecha
 * @property integer $id_AsiDis
 *
 * The followings are the available model relations:
 * @property Histoasignacion $idAsiDis
 */
class Calibracion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'calibracion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('db_permitido, dist_permitido, fecha, id_AsiDis', 'required'),
			array('id_AsiDis', 'numerical', 'integerOnly'=>true),
			array('db_permitido, dist_permitido', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, db_permitido, dist_permitido, fecha, id_AsiDis', 'safe', 'on'=>'search'),
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
			'idAsiDis' => array(self::BELONGS_TO, 'Histoasignacion', 'id_AsiDis'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'db_permitido' => 'Db Permitido',
			'dist_permitido' => 'Dist Permitido',
			'fecha' => 'Fecha',
			'id_AsiDis' => 'Id Asi Dis',
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
		$criteria->compare('db_permitido',$this->db_permitido);
		$criteria->compare('dist_permitido',$this->dist_permitido);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_AsiDis',$this->id_AsiDis);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Calibracion the static model class
	 */
	public static function verificarDatos($id_dis, $db_in, $dist_in){            
            $calibracion = Calibracion::model()->findByAttributes(array('id_dis'=>$id_dis));            
            
            $estado=array();
            $estado['db']=true;
            $estado['dist']=true;
            
            if($calibracion->db_permitido < $db_in) $estado['db']=false;            
            if($calibracion->dist_permitido < $dist_in) $estado['dist']=false;
            return $estado;
            
        }
        public static function dbEsperado($id_dis){
            $calibracion = Calibracion::model()->findByAttributes(array('id_dis'=>$id_dis));                        
            return $calibracion{'db_permitido'};            
        }
        public static function distEsperado($id_dis){
            $calibracion = Calibracion::model()->findByAttributes(array('id_dis'=>$id_dis));                        
            return $calibracion{'dist_permitido'};            
        }
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
