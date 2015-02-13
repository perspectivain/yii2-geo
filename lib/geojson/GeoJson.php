<?php
namespace perspectivain\geo\geojson;

use Yii;

/**
 * Interface to generate geojson file 
 */
class GeoJson
{
    /**
     * List of items to output 
     * @var array
     */
    private $_items = [];
    
    /**
     * @param Object $object
     * @return void
     */ 
    public function add($object) 
    {
        $class = get_class($object);
        if(!$object->validate()) {
            return false;
        }
        
        $this->_items[] = $object;
    }
    
    /**
     * @return XML response
     */ 
    public function output()
    {
        $features = [];

        foreach($this->_items as $object) {
            
            $features[] = [
                'type' => 'Feature', 
                'properties' => [
                    'strokeWeight' => 1, 
                    'fillColor' => 'black',
                    'fillOpacity' => 1
                ],
                'geometry' => $object->output(),
            ];
        }

        \Yii::$app->response->format = 'xml';
        
        return [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];
    }
}
