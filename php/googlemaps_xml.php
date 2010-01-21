<?php
  # http://code.google.com/intl/de/apis/maps/documentation/introduction.html
  # http://code.google.com/intl/de/apis/maps/documentation/overlays.html#Custom_Icons
  # http://code.google.com/intl/de/apis/maps/articles/phpsqlajax.html
  # http://marcgrabanski.com/article/jquery-google-maps-tutorial-ajax-php-mysql

  # http://code.google.com/intl/de/apis/maps/documentation/reference.html#GDownloadUrl
  # http://code.google.com/intl/de/apis/maps/documentation/reference.html#GClientGeocoder
  # http://code.google.com/intl/de/apis/maps/documentation/services.html#Geocoding_Direct

  header("Content-type: text/xml");
  $dom = new DOMDocument("1.0");
  $node = $dom->createElement("markers");
  $parnode = $dom->appendChild($node);

  /* this defined array should later come out of database */
  $companies = array(
    array('name' => 'möbel brucker', 'address' => 'zackstrasse 1', 'lat' => '50.55', 'lng' => '6.55', 'type' => 'bar'),
    array('name' => 'smart küche', 'address' => 'knuselstrasse 2', 'lat' => '52.2', 'lng' => '8.35', 'type' => 'restaurant')
  );

  /* Iterate through the rows, adding XML nodes for each */
  foreach ($companies as $row) {
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name",$row['name']);
    $newnode->setAttribute("address", $row['address']);
    $newnode->setAttribute("lat", $row['lat']);
    $newnode->setAttribute("lng", $row['lng']);
    $newnode->setAttribute("type", $row['type']);
  }

  echo $dom->saveXML();
?>