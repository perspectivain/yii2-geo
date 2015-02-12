<?php
namespace app\extensions\geom\kml\models;

use Yii;
use yii\base\Model as YiiModel;

/**
 * A geojson abstract model object 
 */
abstract class Model extends YiiModel
{
    /**
     * Type of object
     * @var mixed 
     */
    protected $type;
    
    /**
     * Value of object
     * @var mixed 
     */
    public $value;
    
    /**
     * Validation rule for object 
     * @uses model errors
     * @return void
     */
    abstract protected function validateObject();
    
    /**
     * @inheritdoc 
     */
    public function rules()
    {
        return [
            [['value'], 'required'],  
            [['value'], 'validateObject'],
        ];
    }
    
    /**
     * @inheritdoc 
     */
    public function attributeLabels()
    {
        return [
            'value' => 'KML Object',
        ];
    }
 
    /**
     * Generate the output of geo object
     * @return string
     */
    abstract public function output();
}