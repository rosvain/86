<?php
error_reporting(E_ALL);
function get_settings($system) {
    switch ($system) {
        case 'test':
            $settings['base_url'] = 'http://realtime.mbta.com/developer/api/v2/';
            $settings['token'] = 'wX9NwuHnZU2ToO7GmGR9uw';
            $settings['route'] = '86';
            break;
        case 'prod':
            $settings['base_url'] = '';
            $settings['token'] = 'wX9NwuHnZU2ToO7GmGR9uw';
            $settings['route'] = '86';
            break;
    }
    return $settings;
}
