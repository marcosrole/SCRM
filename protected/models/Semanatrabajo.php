<?php

/**
 * This is the model class for table "semanatrabajo".
 *
 * The followings are the available columns in table 'semanatrabajo':
 * @property integer $id
 * @property integer $nrosemana
 * @property integer $lun
 * @property integer $mar
 * @property integer $mie
 * @property integer $jue
 * @property integer $vie
 * @property integer $sab
 * @property integer $dom
 * @property string $hsdesde
 * @property string $hshasta
 *
 * The followings are the available model relations:
 * @property Usuariosemtra[] $usuariosemtras
 */
class Semanatrabajo extends CActiveRecord
{
    public $dias;
    public $id_usr;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'semanatrabajo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nrosemana, hsdesde, hshasta', 'required'),
			array('nrosemana, lun, mar, mie, jue, vie, sab, dom', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nrosemana, lun, mar, mie, jue, vie, sab, dom, hsdesde, hshasta', 'safe', 'on'=>'search'),
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
			'usuariosemtras' => array(self::HAS_MANY, 'Usuariosemtra', 'id_semtra'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nrosemana' => 'Nrosemana',
			'lun' => 'Lun',
			'mar' => 'Mar',
			'mie' => 'Mie',
			'jue' => 'Jue',
			'vie' => 'Vie',
			'sab' => 'Sab',
			'dom' => 'Dom',
			'hsdesde' => 'Hsdesde',
			'hshasta' => 'Hshasta',
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
		$criteria->compare('nrosemana',$this->nrosemana);
		$criteria->compare('lun',$this->lun);
		$criteria->compare('mar',$this->mar);
		$criteria->compare('mie',$this->mie);
		$criteria->compare('jue',$this->jue);
		$criteria->compare('vie',$this->vie);
		$criteria->compare('sab',$this->sab);
		$criteria->compare('dom',$this->dom);
		$criteria->compare('hsdesde',$this->hsdesde,true);
		$criteria->compare('hshasta',$this->hshasta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Semanatrabajo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
