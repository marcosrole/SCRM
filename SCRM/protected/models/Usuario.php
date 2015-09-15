<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property string $name
 * @property string $pass
 */
class Usuario extends CActiveRecord
{
    
        public $name;
	public $pass;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, pass', 'required'),
			array('name, pass', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('name, pass', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'pass' => 'Pass',
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('pass',$this->pass,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function authenticate($pass, $name)
	{
            $criterial = new CDbCriteria();
            $criterial->condition = "name='" . $name . "'";
            $criterial->addCondition("pass='" . $pass . "'");
            if($this->findAll($criterial)){
                return true;
            }else return false;
	}
        
//        public function delete($name, $pass){
//            if($this->delete($name, $pass)){
//                return true;
//            }else return false;
//        }
        
//        public function update($name, $pass){
//            $criterial = new CDbCriteria();
//            $criterial->condition = "name='" . $name . "'";
//            $criterial->addCondition("pass='" . $pass . "'");
//            if($this->find($criterial)){//Si encontró el modelo, actulizo
//                //Elimino y despues cargo.
//                $this->delete($name, $pass);                
//                if ($this->insert($name, $pass)){
//                    return true;
//                }
//            }
//            return false;            
//        }

        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
