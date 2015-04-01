<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
function get_settings($system) {
    switch ($system) {
        case 'test':
            $settings['base_url'] = 'http://realtime.mbta.com/developer/api/v2/predictionsbystop?api_key=wX9NwuHnZU2ToO7GmGR9uw&stop=1036&format=json';
            $settings['token'] = 'wX9NwuHnZU2ToO7GmGR9uw';
            break;
        case 'prod':
            $settings['base_url'] = '';
            $settings['token'] = 'wX9NwuHnZU2ToO7GmGR9uw';
            break;
    }
    return $settings;
}
