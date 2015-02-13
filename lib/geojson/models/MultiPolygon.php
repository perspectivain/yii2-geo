<?php
namespace perspectivain\geo\geojson\models;

class MultiPolygon extends Model
{
    /**
     * @inheritdoc 
     */
    public $type = 'MultiPolygon';
    
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
            $this->addError('value', 'Invalid variable value');
        }
        
        if(count($this->value) == 0){
            $this->addError('value', 'Invalid coordinates');
        }
        
        foreach($this->value as $object) {
            
            if(!$object->validate()) {
                $this->addError('value', 'Invalid variable type');
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
            'value' => 'MultiPolygon',
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

        return ['type' => $this->type, 'coordinates' => $coordinates];
    }
}
