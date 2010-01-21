<?php require_once '../php/googlemaps.php'; ?>

<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAYCVI5Zl_dZfOaKi4PhaTchSkJKqWIq8YldSrI3VIY-bwdL1cHhR08bUL3LldJXROdDpB2c2Oh8k8-w&amp;sensor=false" type="text/javascript"></script>
    
    <script type="text/javascript">
      var map;
      var baseIcon
      var geocoder;
      var item_infos = new Array();

      function initialize() {
        if (GBrowserIsCompatible()) {
          map = new GMap2(document.getElementById("map_canvas"));
          map.setCenter(new GLatLng(51.165691, 10.451526), 5);
          map.addControl(new GLargeMapControl());
          map.addControl(new GMapTypeControl());
          map.setMapType(G_NORMAL_MAP);
          map.enableScrollWheelZoom();

          baseIcon = new GIcon(G_DEFAULT_ICON);
          baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
          baseIcon.iconSize = new GSize(20, 34);
          baseIcon.shadowSize = new GSize(37, 34);
          baseIcon.iconAnchor = new GPoint(9, 34);
          baseIcon.infoWindowAnchor = new GPoint(9, 2);

          /* set forty-four address */
//          var point = new GLatLng(50.37012123376511, 7.558572292327881, true);
//          map.addOverlay(createMarker(point, 1));

          /* get dynamic xml output */
//          GDownloadUrl("../php/googlemaps_xml.php", function(data) {
//            var xml = GXml.parse(data);
//            var markers = xml.documentElement.getElementsByTagName("marker");
//            for (var i = 0; i < markers.length; i++) {
//              var name = markers[i].getAttribute("name");
//              var address = markers[i].getAttribute("address");
//              var type = markers[i].getAttribute("type");
//              var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")), parseFloat(markers[i].getAttribute("lng")));
//              map.addOverlay(createMarker(point, 1));
//            }
//          });

          /* get values out from 'php/googlemaps.php' */
          <?php
            foreach ($companies as $key => $value) {
              echo "var point = new GLatLng({$value[lat]}, {$value[lng]}, true); \n";
              echo "map.addOverlay(createMarker(point, 1)); \n";
            }
          ?>

          /* geocoder search */
          var geocoder = new GClientGeocoder();
          <?php
            foreach ($companies_for_geocoder as $key => $value) {
              $search_string = $value['street'] .', '. $value['zip'] .' '. $value['city'];
              echo "item_infos[encode64('". $search_string  ."')] = '". $value['item_info'] ."'; \n";
              echo "geocoder.getLocations('". $search_string ."',  addToMap);";
            }
          ?>

          /* geocoder example */
//          var geocoder = new GClientGeocoder();
//          geocoder.getLocations('marktstraße 62, 56564 neuwied',  function (response) {
//            /*retrieve the object */
//            place = response.Placemark[0];
//            /* retrieve the latitude and longitude */
//            point = new GLatLng(place.Point.coordinates[1], place.Point.coordinates[0]);
//            /* set marker */
//            marker = new GMarker(point);
//            map.addOverlay(marker);
//          });

        }
      }

      function createMarker(point, index) {
        var letter = String.fromCharCode("A".charCodeAt(0) + index);
        var letteredIcon = new GIcon(baseIcon);
        letteredIcon.image = "http://www.google.com/mapfiles/marker" + letter + ".png";

        markerOptions = { icon:letteredIcon };
        var marker = new GMarker(point, markerOptions);

        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml("Marker <b>" + letter + "</b>");
        });
        return marker;
      }

      function addToMap(response) {
        /* retrieve the object */
        place = response.Placemark[0];
        /* retrieve the latitude and longitude */
        point = new GLatLng(place.Point.coordinates[1], place.Point.coordinates[0]);
        searchstring = response.name

        /* set marker */
        markerOptions = { icon: baseIcon };
        var marker = new GMarker(point, markerOptions);
        var item_info = item_infos[encode64(searchstring)];

        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(item_info);
        });

        map.addOverlay(marker);
      }

      function encode64(inp){
          var key="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
          var chr1,chr2,chr3,enc3,enc4,i=0,out="";
          while(i<inp.length){
              chr1=inp.charCodeAt(i++);if(chr1>127) chr1=88;
              chr2=inp.charCodeAt(i++);if(chr2>127) chr2=88;
              chr3=inp.charCodeAt(i++);if(chr3>127) chr3=88;
              if(isNaN(chr3)) {enc4=64;chr3=0;} else enc4=chr3&63
              if(isNaN(chr2)) {enc3=64;chr2=0;} else enc3=((chr2<<2)|(chr3>>6))&63
              out+=key.charAt((chr1>>2)&63)+key.charAt(((chr1<<4)|(chr2>>4))&63)+key.charAt(enc3)+key.charAt(enc4);
          }
          return encodeURIComponent(out);
      }

    </script>
  </head>

  <body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: 500px; height: 300px"></div>
  </body>

</html>