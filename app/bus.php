<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once 'settings.php';
define('SYSTEM', 'test');
$settings = get_settings(SYSTEM);
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

$data = get_data($settings['base_url']);
var_dump($data);
//print_r($data);
//cleaecho "\n";

//$json = json_encode($data);
//print_r($json);
//echo "\n";
$bus_array = json_decode($data,true);
//var_dump($bus_array);
echo "\n";
//header('Content-Type: application/javascript');
//echo "raveCallback(". $json.")";