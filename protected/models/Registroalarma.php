<?php

/**
 * This is the model class for table "registroalarma".
 *
 * The followings are the available columns in table 'registroalarma':
 * @property integer $id
 * @property string $valorEsperado
 * @property string $valorActual
 * @property string $fecha
 * @property string $hs
 * @property integer $id_dis
 * @property integer $id_ala
 * @property integer $id_tipAla
 *
 * The followings are the available model relations:
 * @property Dispositivo $idDis
 * @property Alarma $idAla
 * @property Tipoalarma $idTipAla
 */
class Registroalarma extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'registroalarma';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('valorEsperado, valorActual, fecha, hs, id_dis, id_tipAla', 'required'),
			array('id_dis, id_ala, id_tipAla', 'numerical', 'integerOnly'=>true),
			array('valorEsperado, valorActual', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, valorEsperado, valorActual, fecha, hs, id_dis, id_ala, id_tipAla', 'safe', 'on'=>'search'),
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
			'idDis' => array(self::BELONGS_TO, 'Dispositivo', 'id_dis'),
			'idAla' => array(self::BELONGS_TO, 'Alarma', 'id_ala'),
			'idTipAla' => array(self::BELONGS_TO, 'Tipoalarma', 'id_tipAla'),
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
			'fecha' => 'Fecha',
			'hs' => 'Hs',
			'id_dis' => 'Id Dis',
			'id_ala' => 'Id Ala',
			'id_tipAla' => 'Id Tip Ala',
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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hs',$this->hs,true);
		$criteria->compare('id_dis',$this->id_dis);
		$criteria->compare('id_ala',$this->id_ala);
		$criteria->compare('id_tipAla',$this->id_tipAla);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
               

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Registroalarma the static model class
	 */
        
        public static function determinarRuidoContinuo($periodoEnvio,$porcentajaAceptacion,$periodoRContinuo, $id_dis){
//            $periodoEnvio=20; //cada cuanto eldispositivo envia datos
//            $porcentajaAceptacion; //Porcentaje de aceptación para decir que es un ruido continuo.
//            $periodoRContinuo=120; // definicion de un ruido continuo
//            //
            //Determino cuantos REGISTROS (detalle_dispo) de un dispositivo entran en el periodo definido.
            $cantidadDeRegistros = (int)$periodoRContinuo/$periodoEnvio; 
            
            //Ej si la cantidad de registro es 6, entonces busco los ultimos 6 registros de un dispositivo.
            $DetalleDispo = DetalleDispo::model()->findAllByAttributes(array('id_dis'=>$id_dis));           
            
            //Me quedo solo con $cantidadde Registro, ej: 6
            $registros_Dispositivo = array();
            $cont=0;
            $cantRegistro = count($DetalleDispo)-1;
            while ($cont<$cantidadDeRegistros){
                $registros_Dispositivo[]=$DetalleDispo[$cantRegistro];                
                $cont++;
                $cantRegistro--;
            }
            
            //Verifico de todos los registro (ej:6) cuantos generan una alarma: Determino porcetnaje
            $calibracion = Calibracion::model()->findByAttributes(array('id_dis'=>$id_dis));            
            
            $cantidadDeAlaras = 0; //Tengo el nro de alarmas generadas de los (ej: 6) registros del dispositivo.
            foreach ($registros_Dispositivo as $key=>$registro){
                if($calibracion->db_permitido < $registro{'db'}) $cantidadDeAlaras++;
            }            
            $porcentajeAlarma=$cantidadDeAlaras/$cantidadDeRegistros;
            
            $tiempoEspera = 120; //[seg] Tiempo de Espera para poder generar la siguiente alarma
            //Ej, se generaráotra alarma luego de 120 segundos
            //Si la ulitma fecha de la alarma ES LA FECHA DE HOY, si me fijo el tiempo de espera, SINO NO
            
            $UltimaAlarma=Yii::app()->db->createCommand('SELECT * 
                                                    FROM alarma 
                                                    WHERE id=(
                                                        SELECT max(id) FROM alarma
                                                        )')->queryAll();
            date_default_timezone_set('America/Buenos_Aires');
            
//            if($UltimaAlarma[0]{'fecha'}==date("Y-m-d")){
                //Convierto $tiempoEspera a formato time
                $horas = floor($tiempoEspera / 3600);
                $minutos = floor(($tiempoEspera - ($horas * 3600)) / 60);
                $segundos = $tiempoEspera - ($horas * 3600) - ($minutos * 60);

                $tiempoEspera= $horas . ':' . $minutos . ":" . $segundos;
                
                //Resto la ultima hs con la hs actual y veo si la diferencia es igual TIEMPOESPERA 
                                
                
                var_dump($UltimaAlarma[0]{'hs'});
                die();
                
//            }
                        
                        
            
            if($porcentajeAlarma>($porcentajaAceptacion/100)){//Si es TRUE => GENERO LA ALARMA DE RUIDO CONTINUO
                $cantRegistro = count($registros_Dispositivo)-1;
                $TipoAlarma = Tipoalarma::model()->findByAttributes(array('id'=>3));                
                $Alarma = New Alarma();
                $Alarma->id_tipAla=$TipoAlarma{'id'};
                $Alarma->fecha=$registros_Dispositivo[$cantRegistro]{'fecha'};
                $Alarma->hs=$registros_Dispositivo[$cantRegistro]{'hs'};
                $Alarma->insert();
                
                //Ahora genero todos los Registros que pertenencen a la Alarma (ej: los 6 registros del dispositivo):                
                foreach ($registros_Dispositivo as $key=>$registro){
                    
                    $NewRegistroAlarma = New Registroalarma();
                    $NewRegistroAlarma->valorEsperado=$calibracion{'db_permitido'};
                    $NewRegistroAlarma->valorActual=$registro{'db'};
                    $NewRegistroAlarma->fecha=$registro{'fecha'};
                    $NewRegistroAlarma->hs=$registro{'hs'};
                    $NewRegistroAlarma->id_dis=$id_dis;
                    $NewRegistroAlarma->id_ala=$Alarma{'id'};
                    $NewRegistroAlarma->id_tipAla=3;
                    $NewRegistroAlarma->insert();
                    
                }
                
            }
            
        }
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
