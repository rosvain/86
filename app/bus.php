<?php
//Problem: get all the data about predicting the bus details according to directiona and closest stop
//What I know:
//  route:86, this is constant, it will never change
//  coordinates: longitude and latitude provided by browser
//  direction: outbound and inbound, depending on what state the buttons are
//Details needed to get and calculate by nearest stop:
//  Determine what is the nearest stop depending on users location and preferred direction using stopsbylocation and stopsbyroute api
//      http://realtime.mbta.com/developer/api/v2/stopsbylocation?api_key=wX9NwuHnZU2ToO7GmGR9uw&lat=42.355375699999996&lon=-71.149031&format=json
//      This api returns all stops nearby regardles of the route so better filter all other routes out
//      http://realtime.mbta.com/developer/api/v2/stopsbyroute?api_key=wX9NwuHnZU2ToO7GmGR9uw&route=86&format=json
//      Get stop
//  Get details for the nearest stop predictionbystop api:
//      http://realtime.mbta.com/developer/api/v2/predictionsbystop?api_key=wX9NwuHnZU2ToO7GmGR9uw&stop=1039&format=json
//      Get predictions by stop of nearest bus
//      Transform sch_arr_dt (schedule arrival time in epoch time)
//      Transform pre_away (predicted arrivel time in seconds) 
//      Get bus current location vehicle_lat and vehicle_lon
//
error_reporting(E_ALL);
require_once 'settings.php';
define('SYSTEM', 'test');
define('ROUTE', '86');
$latitude = '42.355375699999996';
$longitude = '-71.149031';
$stop = '1036';
$settings = get_settings(SYSTEM);
$stops_by_location = $settings['base_url'] . "stopsbylocation?api_key={$settings['token']}&lat={$latitude}&lon={$longitude}&format=json";
$stops_by_route = $settings['base_url'] . "stopsbyroute?api_key={$settings['token']}&route={$settings['route']}&format=json";
$predictions_by_stop = $settings['base_url'] . "predictionsbystop?api_key={$settings['token']}&stop={$stop}&format=json";
//print_r($settings);
//echo "<br/>";
//echo $settings['token'];
 function get_data($url)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}

$data = get_data($predictions_by_stop);
//header('Content-Type: application/javascript');
//var_dump($data);
//print_r($data);
//cleaecho "\n";

//$json = json_encode($data);
//print_r($json);
//echo "\n";
$bus_array = json_decode($data,true);
echo '<pre>';
print_r($bus_array);
echo '</pre>';
//echo "\n";
//header('Content-Type: application/javascript');
//echo "raveCallback(". $json.")";
echo "********\n";
$data = get_data($stops_by_route);
$bus_array = json_decode($data,true);
echo '<pre>';
print_r($bus_array);
echo '</pre>';
echo "********\n";
$data = get_data($stops_by_location);
$bus_array = json_decode($data,true);
echo '<pre>';
print_r($bus_array);
echo '</pre>';