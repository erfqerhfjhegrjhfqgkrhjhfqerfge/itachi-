<?php
// Get the user's IP address
$ip_address = $_SERVER['REMOTE_ADDR'];

// Get the user's location using an IP geolocation API
$location_api_url = "https://ipapi.co/$ip_address/json/";
$location_response = file_get_contents($location_api_url);
$location_data = json_decode($location_response, true);

// Get the user's browser and operating system
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$browser_os = get_browser_and_os($user_agent);

// Get the user's device type
$device_type = get_device_type($user_agent);

// Get the user's screen resolution
$screen_resolution = $_SERVER['HTTP_SEC_CH_UA_MOBILE'] == '?0' ? $_SERVER['HTTP_SEC_CH_UA_PLATFORM'] : 'Mobile';

// Prepare the response data
$user_info = array(
    'ip_address' => $ip_address,
    'latitude' => $location_data['latitude'],
    'longitude' => $location_data['longitude'],
    'browser' => $browser_os['browser'],
    'os' => $browser_os['os'],
    'device_type' => $device_type,
    'screen_resolution' => $screen_resolution
);

// Output the user information as a JSON response
header('Content-Type: application/json');
echo json_encode($user_info);

// Helper functions to get browser, OS, and device type
function get_browser_and_os($user_agent) {
    $browser = "Unknown";