<?php
namespace app\extensions\geom\geojson\models;

class Point extends Model
{
    /**
     * @inheritdoc 
     */
    protected $type = 'Point';
    
    /**
     * @inheritdoc 
     */
    public $value;
    
    /**
     * @inheritdoc 
     */
    public function validateObject()
    {    
        if(!is_array($this->value)) {
            $this->addError('valor', 'Tipo de variável inválida');
        }
        
        if(
            count($this->value) != 2 ||
            (!isset($this->value[0]) || !isset($this->value[1])) ||
            (!is_numeric($this->value[0]) || !is_numeric($this->value[1])) 
        ){
            $this->addError('valor', 'Coordenadas inválidas');
        }
    }
    
    /**
     * @inheritdoc 
     */
    public function attributeLabels()
    {
        return [
            'value' => 'Ponto',
        ];
    }
    
    /**
     * @inheritdoc 
     */
    public function output()
    {
        if(!$this->type || !$this->validate()) {
            return null;
        }

        return ['type' => $this->type, 'coordinates' => $this->value];
    }
}