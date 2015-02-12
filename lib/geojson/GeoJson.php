<?php
namespace app\extensions\geom;

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
    
    public function add($object) 
    {
        $class = get_class($object);
        if(!$object->validate()) {
            return false;
        }
        
        $this->_items[] = $object;
    }
    
    public function toJSON()
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
