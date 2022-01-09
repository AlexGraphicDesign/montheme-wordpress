<?php

//Activable avec http://bulle-d-art.test/wp-cron.php

// add_action('bulledart_import_content', function(){
//     touch(__DIR__ . '/demo-' . time());
// });

// add_filter('cron_schedules', function($schedules){
//     $schedules['ten_seconds'] = [
//         'interval' => 10,
//         'display' => __('Toutes les 10 secondes', 'montheme')
//     ];
//     return $schedules;
// });

///////////////////////////////////////////////////////////////////////////////

// if($timestamp = wp_next_scheduled('bulledart_import_content')){
//     wp_unschedule_event($timestamp, 'bulledart_import_content');
// }

// echo '<pre>';
// var_dump(_get_cron_array());
// echo '</pre>';
// die();

////////////////////////////////////////////////////////////////////////////////

// if(!wp_next_scheduled('bulledart_import_content')){
//     wp_schedule_event(time(), 'ten_seconds', 'bulledart_import_content');
// }