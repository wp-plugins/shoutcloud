<?php
/**
 * Admin page configuration
 */

add_action('admin_init', 'shoutcloud_admin_init');

function shoutcloud_admin_init () {
    add_settings_section('shoutcloud', 'SHOUTCLOUD', function () {
        echo 'CONFIGURE YOUR <a href="http://shoutcloud.io/" target="_blank">SHOUTCLOUD</a> INTEGRATION';
    }, 'reading');
    
    add_settings_field('shoutcloud_enabled', 'ENABLE SHOUTCLOUD', function () {
        echo '<input name="shoutcloud_enabled" id="shoutcloud_enabled" type="checkbox" value="1" class="code" ' . checked(1, get_option( 'shoutcloud_enabled'), false) . ' /> ALL TITLES, CONTENT AND TAGS WILL BE MANIPULATED';
 }, 'reading', 'shoutcloud');
    
    register_setting('reading', 'shoutcloud_enabled');
}
