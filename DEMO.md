Using Yii2 Geo With Yii2 Mapbox with Leaflet helper
=======
A powerful tool was created with use of Yii2 Geo and Yii2 Mapbox with Leaflet helper


[Yii2 Geo](https://github.com/perspectivain/yii2-geo)

[Yii2 Mapbox with Leaflet helper](https://github.com/perspectivain/yii2-mapbox-leaflet-helper)


The demo
=======

1) Create a map with Mapbox

```
<?php 
use perspectivain\mapbox\MapBoxAPIHelper;

MapBoxAPIHelper::registerScript($this, ['omnivore']);
?>
<script>
L.mapbox.accessToken = 'XXXXX';
var map = L.mapbox.map('map', 'XXX').setView([LAT , LON], 12);
</script>
```

2) Create and action to response in geo format

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

3) Integrate KML file to map

```
<script>
var loadedLayer = omnivore.kml('URL_TO_KML_CONTROLLER_ABOVE')
  .on('ready', function() {
      this.eachLayer(function(marker) {
        //polygons was added
        //do other thinks
      });
  })
  .addTo(map);
</script>
```

Result

![](http://perspectiva.in/mapexample.png)
