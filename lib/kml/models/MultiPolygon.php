<?php
namespace app\extensions\geom\kml\models;

class MultiPolygon extends Model
{
    /**
     * @inheritdoc 
     */
    protected $type = 'MultiPolygon';
    
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
        
        if(count($this->value) == 0){
            $this->addError('valor', 'Coordenadas inválidas');
        }
        
        foreach($this->value as $object) {
            
            if(!$object->validate()) {
                $this->addError('valor', 'Tipo de variável inválida');
                break;
            }
        }
    }
    
    /**
     * @inheritdoc 
     */
    public function attributeLabels()
    {
        return [
            'value' => 'MultiPolígono',
        ];
    }
    
    /**
     * Generate the output of geo object
     * @return mixed(array|null)
     */
    public function output()
    {
        if(!$this->type || !$this->validate()) {
            return null;
        }
        
        $coordinates = [];
        foreach($this->value as $polygon) {
            $coordinates[] = $polygon->value;
        }

        return [$this->type => ['coordinates' => $coordinates]];
    }
}