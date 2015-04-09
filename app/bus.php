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
//After getting all three json feeds, I have to make several calculations:
//  Ideally, I would store the contents of the Stops by Route response in a file, Stops will not change very frecuently on the 86 route.
//      Compare the file ocasionally in order to make sure that there are no changes in the route
//  Using Stops by Location, get closest station, stops_id (index 0 in the stops array). Compare stops_id from stops by location with stops_id's from outbound and inboound
//  stops by route.
//

function clean($array) {
    if (!empty($array)) {
        $clean['latitude'] = htmlentities($array['latitude'], ENT_QUOTES, "UTF-8");
        $clean['longitude'] = htmlentities($array['longitude'], ENT_QUOTES, "UTF-8");
        $clean['direction'] = htmlentities(strtolower($array['direction']), ENT_QUOTES, "UTF-8");
        return $clean;
    }
    return null;
}

function human_date($epoch_date) {
    $epoch_date = (int) $epoch_date;
    $human_date = new DateTime("@$epoch_date");
    $human_date->setTimezone(new DateTimeZone('America/New_York'));
    return $human_date->format('H:i:s');
}

function get_minutes($seconds) {
    $seconds = (int) $seconds;
    return round($seconds / 60, 0, PHP_ROUND_HALF_DOWN);
}

function get_data($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function get_current_station($direction, $api_location, $api_route) {
    $api_loc_result = get_data($api_location);
    $api_rout_result = get_data($api_route);
    $location_array = json_decode($api_loc_result, true);
    $route_array = json_decode($api_rout_result, true);
    $stop_location_stop_id = array_column($location_array['stop'], 'stop_id');
    if ('outbound' === $direction) {
        $outbound_stop_id = array_column($route_array['direction'][0]['stop'], 'stop_id');
        $matches_outbound = array_intersect($stop_location_stop_id, $outbound_stop_id);
        $key = array_keys($matches_outbound);
        return $location_array['stop'][$key[0]];
    }
    if ('inbound' === $direction) {
        $inbound_stop_id = array_column($route_array['direction'][1]['stop'], 'stop_id');
        $matches_inbound = array_intersect($stop_location_stop_id, $inbound_stop_id);
        $key = array_keys($matches_inbound);
        return $location_array['stop'][$key[0]];
    }
}

function get_prediction($api) {
    $prediction_data = array();
    $data = get_data($api);
    $prediction_array = json_decode($data, true);
    $prediction_data['stop_name'] = $prediction_array['stop_name'];
    $prediction_data['stop_id'] = $prediction_array['stop_id'];
    $prediction_data['direction'] = $prediction_array['mode'][0]['route'][0]['direction'][0]['direction_name'];
    $len = count($prediction_array['mode'][0]['route'][0]['direction'][0]['trip']);
    for ($i = 0; $i < $len; ++$i) {
        $prediction_data['prediction'][$i]['trip_id'] = $prediction_array['mode'][0]['route'][0]['direction'][0]['trip'][$i]['trip_id'];
        $prediction_data['prediction'][$i]['sch_arr_dt'] = human_date($prediction_array['mode'][0]['route'][0]['direction'][0]['trip'][$i]['sch_arr_dt']);
        $prediction_data['prediction'][$i]['pre_dt'] = human_date($prediction_array['mode'][0]['route'][0]['direction'][0]['trip'][$i]['pre_dt']);
        $prediction_data['prediction'][$i]['pre_away'] = get_minutes($prediction_array['mode'][0]['route'][0]['direction'][0]['trip'][$i]['pre_away']);
        if (array_key_exists('vehicle', $prediction_array['mode'][0]['route'][0]['direction'][0]['trip'][$i])) {
            $prediction_data['prediction'][$i]['vehicle_id'] = $prediction_array['mode'][0]['route'][0]['direction'][0]['trip'][0]['vehicle']['vehicle_id'];
            $prediction_data['prediction'][$i]['vehicle_lat'] = $prediction_array['mode'][0]['route'][0]['direction'][0]['trip'][0]['vehicle']['vehicle_lat'];
            $prediction_data['prediction'][$i]['vehicle_lon'] = $prediction_array['mode'][0]['route'][0]['direction'][0]['trip'][0]['vehicle']['vehicle_lon'];
        }
    }
    $prediction_data['alert'] = $prediction_array['alert_headers'];
    return $prediction_data;
}
