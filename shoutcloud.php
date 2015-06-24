<?php
/*
Plugin Name: SHOUTCLOUD
Plugin URI:  https://wordpress.org/plugins/shoutcloud/
Description: INTEGRATE SHOULDCLOUD WITH WORDPRESS. EVERYTHING IS BETTER WHEN YOU SHOUT IT.
Version:     1.1
Author:      Chris Worfolk
Author URI:  http://www.worfolk.co.uk/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require 'shoutcloud_admin.php';

function shoutcloud_prepare ($str) {
    return strip_tags($str, '<p><br><br /><div><pre><blockquote><em><strong>');
}

function shoutcloud_request ($str) {
    $jsonInput = [
        'INPUT' => $str
    ];
    
    $ch = curl_init();
    
    if ($ch) {
        curl_setopt($ch, CURLOPT_URL, 'HTTP://API.SHOUTCLOUD.IO/V1/SHOUT');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonInput));
        $result = curl_exec($ch);
        curl_close($ch);
        
        if ($result) {
            $json = json_decode($result);
            return $json->OUTPUT;
        }
    }
    
    return null;
}

function shoutcast_string ($str) {
    $input  = shoutcloud_prepare($str);
    $output = shoutcloud_request($input);
    
    if ($output === null) {
        $output = strtoupper($input);
    }
    
    return $output;
}

if (get_option('shoutcloud_enabled')) {
    add_filter('the_title', 'shoutcast_string');
    add_filter('the_content', 'shoutcast_string');
    add_filter('the_tags', 'shoutcast_string');
}
