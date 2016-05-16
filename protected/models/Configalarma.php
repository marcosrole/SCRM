<?php

/**
 * This is the model class for table "configalarma".
 *
 * The followings are the available columns in table 'configalarma':
 * @property integer $id
 * @property integer $segCont
 * @property double $porcCont
 * @property integer $segInter
 * @property integer $cantPico
 * @property integer $pico
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
			array('segCont, porcCont, segInter, cantPico, pico', 'required'),
			array('segCont, segInter, cantPico, pico', 'numerical', 'integerOnly'=>true),
			array('porcCont', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, segCont, porcCont, segInter, cantPico, pico', 'safe', 'on'=>'search'),
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
                    'segCont' => 'Segundos Ruido Continuo',
                    'porcCont' => '% aceptación Ruido Continuo',
                    'segInter' => 'Segundos Ruido Intermitente',
                    'cantPico' => 'Cantidad de Pico',
                    'pico' => 'Pico'                    
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
		$criteria->compare('segInter',$this->segInter);
		$criteria->compare('cantPico',$this->cantPico);
		$criteria->compare('pico',$this->pico);

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
