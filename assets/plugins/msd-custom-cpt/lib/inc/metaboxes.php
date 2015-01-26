<?php 
global $project_header,$project_info,$client_info,$additional_files,$event_info,$testimonial_info,$gallery_info,$location_info;

$client_info = new WPAlchemy_MetaBox(array
        (
            'id' => '_client_information',
            'title' => 'Client Information',
            'types' => array('project'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/client-information.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_client_' // defaults to NULL
        ));
$project_header = new WPAlchemy_MetaBox(array
        (
            'id' => '_project_header',
            'title' => 'Project Header',
            'types' => array('project'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/project-header.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_project_' // defaults to NULL
        ));
$project_info = new WPAlchemy_MetaBox(array
        (
            'id' => '_project_info',
            'title' => 'Project Info',
            'types' => array('project'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/project-info.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_project_' // defaults to NULL
        ));
$gallery_info = new WPAlchemy_MetaBox(array
        (
            'id' => '_gallery_info',
            'title' => 'Gallery Info',
            'types' => array('project'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/gallery-info.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_gallery_' // defaults to NULL
        ));
$additional_files = new WPAlchemy_MetaBox(array
        (
            'id' => '_additional_files',
            'title' => 'Additional Files',
            'types' => array(),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/additional-files.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_files_' // defaults to NULL
        ));
$event_info = new WPAlchemy_MetaBox(array
        (
            'id' => '_event_info',
            'title' => 'Event Info',
            'types' => array('event'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/event-information.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_event_' // defaults to NULL
        ));
$testimonial_info = new WPAlchemy_MetaBox(array
        (
            'id' => '_testimonial_info',
            'title' => 'Testimonial Info',
            'types' => array('testimonial'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/testimonial-information.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_testimonial_' // defaults to NULL
        ));
$location_info = new WPAlchemy_MetaBox(array
        (
            'id' => '_location_info',
            'title' => 'Location Info',
            'types' => array('location'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/location-information.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_location_' // defaults to NULL
        ));