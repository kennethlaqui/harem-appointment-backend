<?php 

// Get Geolocation

function get_local_time(){

    return $timezone = "GMT+8";

    // do not use
    $ip = @file_get_contents("http://ipecho.net/plain");

    if ($ip === false) { return $timezone = "GMT+8"; }

    $url = 'http://ip-api.com/json/'.$ip;
    
    $timezone = file_get_contents($url);

    $timezone = json_decode($timezone,true)['timezone'];

    return $timezone;

}

function get_ip_location() {

    $ip = @file_get_contents("http://ipecho.net/plain");

    if ($ip === false) { return $country = "N/A"; }

    $url = 'http://ip-api.com/json/'.$ip;
    
    $country = file_get_contents($url);

    $country = json_decode($country,true)['country'];

    return $country;

}