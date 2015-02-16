<?php
namespace perspectivain\geo\kml;

use Yii;

/**
 * Interface to generate kml file
 */
class Kml
{
    /**
     * Object ID
     */
    public $id = 'object';

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

            if($object->extendedData) {

                $extendedDataNode = $dom->createElement('ExtendedData');

                foreach($object->extendedData as $key => $value) {

                    $extendedDataDataNode = $dom->createElement('Data');
                    $extendedDataDataNode->setAttribute('name', $key);

                    $extendedDataValueNode = $dom->createElement('value', $value);
                    $extendedDataDataNode->appendChild($extendedDataValueNode);

                    $extendedDataNode->appendChild($extendedDataDataNode);
                }

                $placeNode->appendChild($extendedDataNode);
            }

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
