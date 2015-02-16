Yii2 Geo
=======
An interface to generate geographic annotations in different formats.

Currently supports KML and geoJSON formats and MultiPolygon, Point and Polygon types.

```
More about geoJSON: http://geojson.org/geojson-spec.html

More about KML: https://developers.google.com/kml/documentation/
```

Usage
=======
Create and action to response in geo format

```
use perspectivain\geo\kml\Kml;
use perspectivain\geo\kml\models\Polygon;
use perspectivain\geo\kml\models\Point;

public function actionCityDistricts()
{
  $document = new Kml; //change to "new Geojson" to generate this file 
  $document->id = 'district';
  
  $districts = District::find()->all();
  foreach($districts as $district) {
  
      $polygon = new Polygon;
  
      foreach($district->coordinates as $coordinate) {
          $point = new Point;
          $point->value = $coordinate;
          $polygon->value[] = $point;
          unset($point);
      }
  
      $document->add($polygon);
      unset($polygon);
  }
  
  return $document->output();
}
```

And the return is an valid KML file

Passing properties in object
=======
To pass properties to object, do this:

```
use perspectivain\geo\kml\Kml;
use perspectivain\geo\kml\models\Polygon;
use perspectivain\geo\kml\models\Point;

public function actionCityDistricts()
{
  $document = new Kml; //change to "new Geojson" to generate this file 
  $document->id = 'district';
  
  $districts = District::find()->all();
  foreach($districts as $district) {
  
      $polygon = new Polygon;
  
      foreach($district->coordinates as $coordinate) {
          $point = new Point;
          $point->value = $coordinate;
          $polygon->value[] = $point;
          unset($point);
      }
      
      $polygon->extendedData = [
        'property' => 1,
      ];
  
      $document->add($polygon);
      unset($polygon);
  }
  
  return $document->output();
}
```


Installing
======
The preferred way to install this extension is through composer.

```
{
  "require": {
    "perspectivain/yii2-geo": "*"
  }
}
