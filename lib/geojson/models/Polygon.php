<?php
namespace app\extensions\geom\geojson\models;

class Polygon extends Model
{
    /**
     * @inheritdoc 
     */
    protected $type = 'Polygon';
    
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
            'value' => 'Polígono',
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
        foreach($this->value as $point) {
            $coordinates[] = [(float) $point->value[0], (float) $point->value[1]];
        }

        return ['type' => $this->type, 'coordinates' => [$coordinates]];
    }
}