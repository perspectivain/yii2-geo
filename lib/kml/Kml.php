<?php
namespace app\extensions\geom\kml;

use Yii;

/**
 * Interface to generate geojson file
 */
class Kml
{
    /**
     * Nome do identificador do elemento
     */
    public $id = 'object';

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
        $dom = new \DOMDocument('1.0','UTF-8');

        $node = $dom->createElementNS('http://earth.google.com/kml/2.1','kml');
        $parNode = $dom->appendChild($node);

        $fnode = $dom->createElement('Document');
        $folderNode = $parNode->appendChild($fnode);
        $fnode->setAttribute('name', '');
        $fnode->setAttribute('description', '');

        $i = 1;
        foreach($this->_items as $object) {

            $node = $dom->createElement('Placemark');
            $placeNode = $folderNode->appendChild($node);

            $objectNode = $dom->createElement($object->type);
            $placeNode->appendChild($objectNode);
            $objectNode->setAttribute('id',$this->id . $i);

            $outerBundaryIsNode = $dom->createElement('outerBoundaryIs');
            $objectNode->appendChild($outerBundaryIsNode);

            $linearRingNode = $dom->createElement('LinearRing');
            $outerBundaryIsNode->appendChild($linearRingNode);

            $coorNode = $dom->createElement('coordinates',$object->output());
            $linearRingNode->appendChild($coorNode);

            $i++;
        }

        $kmlOutput = $dom->saveXML();

        header('Content-type: application/vnd.google-earth.kml+xml');

        echo $kmlOutput;
    }
}
