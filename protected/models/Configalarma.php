<?php

/**
 * This is the model class for table "configalarma".
 *
 * The followings are the available columns in table 'configalarma':
 * @property integer $id
 * @property integer $segCont
 * @property double $porcCont
 * @property integer $segInt
 * @property double $porcInt
 * @property double $division
 * @property double $segDis
 * @property double $porcDis
 * @property double $recibirAlaDistancia
 * @property double $recibirAlaIntermitente
 * @property double $recibirAlaContinuo
 * @property double $tolResponsable
 */
class Configalarma extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'configalarma';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('segCont, porcCont, segInt, segMuerto, porcInt, division, segDis, porcDis, recibirAlaDistancia, recibirAlaIntermitente, recibirAlaContinuo, recibirAlaMuerto, tolResponsable', 'required'),
			array('segCont, segInt', 'numerical', 'integerOnly'=>true),
			array('porcCont, porcInt, division, segDis, segMuerto, porcDis, recibirAlaDistancia, recibirAlaIntermitente, recibirAlaMuerto, recibirAlaContinuo, tolResponsable', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, segCont, porcCont, segInt, porcInt, division, segDis, porcDis, recibirAlaDistancia, recibirAlaIntermitente, recibirAlaContinuo, tolResponsable', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'segCont' => 'Ruido Continuo',
			'porcCont' => 'Porcentaje aceptacion',
			'segInt' => 'Ruido Intermitente',
			'porcInt' => 'Porcentaje aceptacion',
			'division' => 'Division',
			'segDis' => 'Tiempo de obstrucción aceptable',
			'porcDis' => 'Porcentaje de aceptacion',
			'recibirAlaDistancia' => 'Recibir Alarma de Distancia',
			'recibirAlaIntermitente' => 'Recibir Alarma de R. Intermitente',
			'recibirAlaContinuo' => 'Recibir Alarma de R. Continuo',
			'tolResponsable' => 'Tiempo para el encargado',
                        'segMuerto' => 'Tiempo muerto de aceptación',
			'recibirAlaMuerto' => 'Recibir Alarma Dispositivo Muerto',
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
		$criteria->compare('segCont',$this->segCont);
		$criteria->compare('porcCont',$this->porcCont);
		$criteria->compare('segInt',$this->segInt);
		$criteria->compare('porcInt',$this->porcInt);
		$criteria->compare('division',$this->division);
		$criteria->compare('segDis',$this->segDis);
		$criteria->compare('porcDis',$this->porcDis);
		$criteria->compare('recibirAlaDistancia',$this->recibirAlaDistancia);
		$criteria->compare('recibirAlaIntermitente',$this->recibirAlaIntermitente);
		$criteria->compare('recibirAlaContinuo',$this->recibirAlaContinuo);
		$criteria->compare('tolResponsable',$this->tolResponsable);
                $criteria->compare('segMuerto',$this->segMuerto);
		$criteria->compare('recibirAlaMuerto',$this->recibirAlaMuerto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Configalarma the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
