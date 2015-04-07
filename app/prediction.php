<?php
//setting error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);
//including settings and functions
require 'settings.php';
require 'bus.php';
//constant and variable declaration
define('SYSTEM', 'test');
$settings = get_settings(SYSTEM);
$latitude = '42.355375699999996';
$longitude = '-71.149031';
$direction = 'Inbound';
//building mbta url api for stops by location and stops by route
$api['stops_by_location'] = $settings['base_url'] . "stopsbylocation?api_key={$settings['token']}&lat={$latitude}&lon={$longitude}&format=json";
$api['stops_by_route'] = $settings['base_url'] . "stopsbyroute?api_key={$settings['token']}&route={$settings['route']}&format=json";
//getting users current station id, depending in location and directions
$current_station = get_current_station($direction, $api['stops_by_location'], $api['stops_by_route']);
$stop = $current_station['stop_id'];
//building mbta url api for predictios by stop
$api['predictions_by_stop'] = $settings['base_url'] . "predictionsbystop?api_key={$settings['token']}&stop={$stop}&format=json";
$predictions = get_prediction($api['predictions_by_stop']);
//returning the users predictions in json format to the client
$json = json_encode($predictions);
header('Content-Type: application/json; charset=UTF-8');
echo $json;
