Yii2 Geo
=======
An interface to generate geographic annotations in different formats.

Currently supports KML and geoJSON formats.

```
More about geoJSON: http://geojson.org/geojson-spec.html

More about KML: https://developers.google.com/kml/documentation/
```

Usage
=======
Create and action to response in geo format

```
public function actionCityDistricts()
{
  $model = new Kml;
  $model->id = 'district';
  
  $districts = District::find()->all();
  foreach($districts as $district) {
  
      $polygon = new Polygon;
  
      foreach($district->coordinates as $coordinate) {
          $point = new Point;
          $point->value = $coordinate;
          $polygon->value[] = $point;
          unset($point);
      }
  
      $model->add($polygon);
      unset($polygon);
  }
  
  return $model->toJSON();
}
```

And the return is an valid KML file


Installing
======
The preferred way to install this extension is through composer.

```
{
  "require": {
    "perspectivain/yii2-geo": "*"
  }
}
