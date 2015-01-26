<?php 
if (!class_exists('MSDEventCPT')) {
	class MSDEventCPT {
		//Properties
		var $cpt = 'event';
		//Methods
	    /**
	    * PHP 4 Compatible Constructor
	    */
		public function MSDEventCPT(){$this->__construct();}
	
		/**
		 * PHP 5 Constructor
		 */
		function __construct(){
			global $current_screen;
        	//"Constants" setup
        	$this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
        	$this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
			//Actions
			add_action( 'init', array(&$this,'register_cpt_event') );
			add_action('admin_head', array(&$this,'plugin_header'));
			add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
			add_action('admin_print_styles', array(&$this,'add_admin_styles') );
			add_action('admin_footer',array(&$this,'info_footer_hook') );
			// important: note the priority of 99, the js needs to be placed after tinymce loads
			add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
			
			//Filters
			add_filter( 'pre_get_posts', array(&$this,'custom_query') );
			add_filter( 'enter_title_here', array(&$this,'change_default_title') );
            
            if(class_exists('MSDEventShortcodes')){
                $this->event_shortcodes = new MSDEventShortcodes();
            }
		}
		
		function register_cpt_event() {
		
		    $labels = array( 
		        'name' => _x( 'Events', 'event' ),
		        'singular_name' => _x( 'Event', 'event' ),
		        'add_new' => _x( 'Add New', 'event' ),
		        'add_new_item' => _x( 'Add New Event', 'event' ),
		        'edit_item' => _x( 'Edit Event', 'event' ),
		        'new_item' => _x( 'New Event', 'event' ),
		        'view_item' => _x( 'View Event', 'event' ),
		        'search_items' => _x( 'Search Event', 'event' ),
		        'not_found' => _x( 'No event found', 'event' ),
		        'not_found_in_trash' => _x( 'No event found in Trash', 'event' ),
		        'parent_item_colon' => _x( 'Parent Event:', 'event' ),
		        'menu_name' => _x( 'Event', 'event' ),
		    );
		
		    $args = array( 
		        'labels' => $labels,
		        'hierarchical' => false,
		        'description' => 'Event',
		        'supports' => array( 'title', 'editor', 'author', 'thumbnail' ,'genesis-cpt-archives-settings'),
		        'taxonomies' => array(),
		        'public' => true,
		        'show_ui' => true,
		        'show_in_menu' => true,
		        'menu_position' => 20,
		        
		        'show_in_nav_menus' => true,
		        'publicly_queryable' => true,
		        'exclude_from_search' => true,
		        'has_archive' => true,
		        'query_var' => true,
		        'can_export' => true,
		        'rewrite' => array('slug'=>'event','with_front'=>false),
		        'capability_type' => 'post'
		    );
		
		    register_post_type( $this->cpt, $args );
		}
		
		function plugin_header() {
			global $post_type;
		}
		 
		function add_admin_scripts() {
			global $current_screen;
			if($current_screen->post_type == $this->cpt){
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-datepicker');
                wp_enqueue_script('jquery-timepicker',plugin_dir_url(dirname(__FILE__)).'js/jquery.timepicker.min.js',array('jquery'));
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
			}
		}

        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('thickbox');
                wp_enqueue_style('jquery-ui-style','http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css');
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'css/meta.css');
            }
        }   
			
		function print_footer_scripts()
		{
			global $current_screen;
			if($current_screen->post_type == $this->cpt){
				print '<script type="text/javascript">/* <![CDATA[ */
					jQuery(function($){
						
					});
				/* ]]> */</script>';
			}
		}
		function change_default_title( $title ){
			global $current_screen;
			if  ( $current_screen->post_type == $this->cpt ) {
				return __('Event Name','event');
			} else {
				return $title;
			}
		}
		
		function info_footer_hook()
		{
			global $current_screen;
			if($current_screen->post_type == $this->cpt){
				?><script type="text/javascript">
                    jQuery(function($){
                        $( ".datepicker" ).datepicker({
                        onSelect : function(dateText, inst)
                        {
                            var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
                            $('.datestamp').val(epoch);
                        }
                        });
                        $('.timepicker').timepicker({ 'scrollDefaultNow': true });
                        $("#postdivrich").after($("#_event_info_metabox"));
                    });
                 </script><?php
			}
		}
		

		function custom_query( $query ) {
			if(!is_admin()){
				if($query->is_main_query() && $query->is_search){
					$searchterm = $query->query_vars['s'];
					// we have to remove the "s" parameter from the query, because it will prevent the posts from being found
					$query->query_vars['s'] = "";
					
					if ($searchterm != "") {
						$query->set('meta_value',$searchterm);
						$query->set('meta_compare','LIKE');
					};
					$query->set( 'post_type', array('post','page',$this->cpt) );
				}
			}
		}			
  } //End Class
} //End if class exists statement