<?php
  # http://code.google.com/intl/de/apis/maps/documentation/introduction.html
  # http://code.google.com/intl/de/apis/maps/documentation/overlays.html#Custom_Icons
  # http://code.google.com/intl/de/apis/maps/articles/phpsqlajax.html
  # http://marcgrabanski.com/article/jquery-google-maps-tutorial-ajax-php-mysql

  # http://code.google.com/intl/de/apis/maps/documentation/reference.html#GDownloadUrl
  # http://code.google.com/intl/de/apis/maps/documentation/reference.html#GClientGeocoder
  # http://code.google.com/intl/de/apis/maps/documentation/services.html#Geocoding_Direct

  /* this defined array should later come out of database */
  $companies = array(
    array('name' => 'möbel brucker', 'address' => 'zackstrasse 1', 'lat' => '50.55', 'lng' => '6.55', 'type' => 'bar'),
    array('name' => 'smart küche', 'address' => 'knuselstrasse 2', 'lat' => '52.2', 'lng' => '8.35', 'type' => 'restaurant')
  );

  /* this defined array should later come out of database */
  $companies_for_geocoder = array(
    array('name' => 'möbel wachendorf ', 'street' => 'Gottfried-Schenker-Str.8-12', 'zip' => '53879', 'city' => 'Euskirchen'),
    array('name' => 'möbel-mit', 'street' => 'Dessauer Straße 13', 'zip' => '06886', 'city' => 'Wittenberg'),
    array('name' => 'das ist frankfurt', 'street' => '', 'zip' => '', 'city' => 'frankfurt'),
    array('name' => 'joah gudde münchen', 'street' => '', 'zip' => '', 'city' => 'münchen'),
    array('name' => 'ike bin an berlina', 'street' => '', 'zip' => '', 'city' => 'berlin')
  );

  /* set item info for google maps pop-up window */
  $companies_for_geocoder = array_map('add_item_info', $companies_for_geocoder);

  function add_item_info($item) {
    $item_info = $item['name'] .'<br />'. $item['street'] .'<br />'. $item['zip'] .' '. $item['city'];
    $item['item_info'] = $item_info;
    return $item;
  }
?>