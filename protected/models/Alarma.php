<?php

/**
 * This is the model class for table "alarma".
 *
 * The followings are the available columns in table 'alarma':
 * @property integer $id
 * @property integer $solucionado
 * @property integer $enviarSMS
 * @property integer $id_tipAla
 * @property integer $id_dis
 * @property string $fechahs
 * @property integer $timeOutEspera
 * @property integer $preAlarma
 *
 * The followings are the available model relations:
 * @property Tipoalarma $idTipAla
 * @property Dispositivo $idDis
 * @property Asignarinspector[] $asignarinspectors
 * @property Registroalarma[] $registroalarmas
 */
class Alarma extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alarma';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipAla', 'required'),
			array('solucionado, enviarSMS, id_tipAla, id_dis, timeOutEspera, preAlarma', 'numerical', 'integerOnly'=>true),
			array('fechahs', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, solucionado, enviarSMS, id_tipAla, id_dis, fechahs, timeOutEspera, preAlarma', 'safe', 'on'=>'search'),
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
			'idTipAla' => array(self::BELONGS_TO, 'Tipoalarma', 'id_tipAla'),
			'idDis' => array(self::BELONGS_TO, 'Dispositivo', 'id_dis'),
			'asignarinspectors' => array(self::HAS_MANY, 'Asignarinspector', 'id_ala'),
			'registroalarmas' => array(self::HAS_MANY, 'Registroalarma', 'id_ala'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'solucionado' => 'Solucionado',
			'enviarSMS' => 'Enviar Sms',
			'id_tipAla' => 'Id Tip Ala',
			'id_dis' => 'Id Dis',
			'fechahs' => 'Fechahs',
			'timeOutEspera' => 'Time Out Espera',
			'preAlarma' => 'Pre Alarma',
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
		$criteria->compare('solucionado',$this->solucionado);
		$criteria->compare('enviarSMS',$this->enviarSMS);
		$criteria->compare('id_tipAla',$this->id_tipAla);
		$criteria->compare('id_dis',$this->id_dis);
		$criteria->compare('fechahs',$this->fechahs,true);
		$criteria->compare('timeOutEspera',$this->timeOutEspera);
		$criteria->compare('preAlarma',$this->preAlarma);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Alarma the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
         public static function setSolucionada($id){
            $alarma = Alarma::model()->findByAttributes(array('id'=>$id));
            $alarma->solucionado=1;
            $alarma->save();
        }
}
