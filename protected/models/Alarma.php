<?php

/**
 * This is the model class for table "alarma".
 *
 * The followings are the available columns in table 'alarma':
 * @property integer $id
 * @property string $valorEsperado
 * @property string $valorActual
 * @property integer $tipo
 * @property string $fecha
 * @property string $hs
 * @property string $descripcion
 * @property integer $id_dis
 * @property integer $id_suc
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
			array('valorEsperado, valorActual, tipo, fecha, hs, descripcion, id_dis, id_suc', 'required'),
			array('tipo, id_dis, id_suc', 'numerical', 'integerOnly'=>true),
			array('valorEsperado, valorActual', 'length', 'max'=>20),
			array('descripcion', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, valorEsperado, valorActual, tipo, fecha, hs, descripcion, id_dis, id_suc', 'safe', 'on'=>'search'),
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
			'valorEsperado' => 'Valor Esperado',
			'valorActual' => 'Valor Actual',
			'tipo' => 'Tipo',
			'fecha' => 'Fecha',
			'hs' => 'Hs',
			'descripcion' => 'Descripcion',
			'id_dis' => 'Id Dis',
			'id_suc' => 'Id Suc',
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
		$criteria->compare('valorEsperado',$this->valorEsperado,true);
		$criteria->compare('valorActual',$this->valorActual,true);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hs',$this->hs,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('id_dis',$this->id_dis);
		$criteria->compare('id_suc',$this->id_suc);

		return new CActiveDataProvider($this, array(
                    'pagination' => array(
                             'pageSize' => 20,
                        ),
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Alarma the static model class
	 */
        public static function crearAlarma($id_dis, $id_suc, $valorEsperado, $valorActual, $tipo)
	{
		date_default_timezone_set('America/Buenos_Aires');
                $descripcion="";
                switch ($tipo) {
                    case 1:
                        $descripcion="Limite de dB";
                        break;
                    case 2:
                        $descripcion="Dispositivo obstruido";
                        break;                    
                }
                
                $NewAlarma = New Alarma();
                $NewAlarma->id_dis=$id_dis;
                $NewAlarma->id_suc=$id_suc;
                $NewAlarma->valorEsperado= $valorEsperado;
                $NewAlarma->valorActual= $valorActual;
                $NewAlarma->fecha=date("Y" . "-" . "m" . "-" . "d");
                $NewAlarma->hs=date('H:i:s');
                $NewAlarma->descripcion=$descripcion;
                $NewAlarma->tipo=$tipo;                
                $NewAlarma->insert();
                
                
                
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
