<?php 
if (!class_exists('MSDClientCPT')) {
    class MSDClientCPT {
        //Properties
        var $cpt = 'client';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDClientCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_cpt_client') );
            add_action('admin_head', array(&$this,'plugin_header'));
            add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
            add_action('admin_print_styles', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'info_footer_hook') );
            // important: note the priority of 99, the js needs to be placed after tinymce loads
            add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
            
            //Filters
            add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
            
            add_shortcode('logo_gallery', array(&$this,'logo_gallery'));
            add_image_size('logo',300,400,false);
        }


        
        function register_cpt_client() {
        
            $labels = array( 
                'name' => _x( 'Clients', 'client' ),
                'singular_name' => _x( 'Client', 'client' ),
                'add_new' => _x( 'Add New', 'client' ),
                'add_new_item' => _x( 'Add New Client', 'client' ),
                'edit_item' => _x( 'Edit Client', 'client' ),
                'new_item' => _x( 'New Client', 'client' ),
                'view_item' => _x( 'View Client', 'client' ),
                'search_items' => _x( 'Search Client', 'client' ),
                'not_found' => _x( 'No client found', 'client' ),
                'not_found_in_trash' => _x( 'No client found in Trash', 'client' ),
                'parent_item_colon' => _x( 'Parent Client:', 'client' ),
                'menu_name' => _x( 'Client', 'client' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Client',
                'supports' => array( 'title', 'thumbnail' ),
                'taxonomies' => array( 'market_sector' ),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                
                'show_in_nav_menus' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true,
                'has_archive' => false,
                'query_var' => true,
                'can_export' => true,
                'rewrite' => array('slug'=>'client','with_front'=>false),
                'capability_type' => 'post'
            );
        
            register_post_type( $this->cpt, $args );
        }
        
        function plugin_header() {
            global $post_type;
            ?>
            <?php
        }
         
        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                //wp_register_script('my-upload', plugin_dir_url(dirname(__FILE__)).'/js/msd-upload-file.js', array('jquery','media-upload','thickbox'),FALSE,TRUE);
                wp_enqueue_script('my-upload');
            }
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('thickbox');
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'/css/meta.css');
            }
        }   
            
        function print_footer_scripts()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
            }
        }
        function change_default_title( $title ){
            global $current_screen;
            if  ( $current_screen->post_type == $this->cpt ) {
                return __('Client Name','client');
            } else {
                return $title;
            }
        }
        
        function info_footer_hook()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                ?><script type="text/javascript">
                        jQuery('#titlediv').after(jQuery('#postimagediv'));
                        jQuery('#postimagediv h3.hndle span').html('Logo Image');
                        jQuery('#postimagediv #set-post-thumbnail').html(function(){
                            if($(this).html == "Set featured image"){
                                return 'Set logo image';
                            } else {
                                return $(this).html();
                            }
                        }).attr('title',function(){
                            if($(this).html == "Set featured image"){
                                return 'Set logo image';
                            } else {
                                return $(this).html();
                            }
                        });
                    </script><?php
            }
        }
        

        function custom_query( $query ) {
            if(!is_admin()){
                //$is_client = ($query->query_vars['client_type'])?TRUE:FALSE;
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
        
        function logo_gallery($atts){
            extract( shortcode_atts( array(
                'rows' => 4,
                'columns' => 4,
                'fade_in' => 'random',
                'animate' => false
            ), $atts ) );
            
            $args = array(
                'post_type' => $this->cpt,
                'orderby' => rand,
            );
            switch($animate){
                case true:
                case 'random':
                    $args['posts_per_page'] = -1;
                    break;
                case false:
                    $args['posts_per_page'] = $rows * $columns;
                    break;
            }
            $clients = get_posts($args);
            $ret = false;
            foreach($clients AS $client){
                $logo_image = wp_get_attachment_image_src( get_post_thumbnail_id($client->ID), 'logo' );
                $logo_url = $logo_image[0];
                switch($fade_in){
                    case 'rand':
                    case 'random':
                        $fade = rand(1,50).'00ms';
                        break;
                    case is_numeric($fade_in):
                        $fade = $fade_in.'ms';
                        break;
                    case true:
                        $fade = '2000ms';
                        break;
                    case false:
                    default:
                        $fade = '1ms';
                        break;
                }
                $ret .= '<div class="col-md-'. 12/$columns .' col-sm-1 item-wrapper" style="-webkit-transition-delay: '.$fade.';-moz-transition-delay: '.$fade.';-ms-transition-delay: '.$fade.';-o-transition-delay: '.$fade.';transition-delay: '.$fade.';"><div class="item" style="background-image:url('.$logo_url.');"></div></div>';
            }
            $ret = '<div class="msdlab_logo_gallery">'.$ret.'</div>';
            $ret .= '
            <style>
                .msdlab_logo_gallery .item-wrapper {
                    height:120px;
                    opacity: 0;
                    padding: 2rem 4rem;
                    /* For Safari 3.1 to 6.0 */
                    -webkit-transition-property: all;
                    -webkit-transition-duration: 2s;
                    -webkit-transition-timing-function: ease-in-out;
                    -moz-transition-property: all;
                    -moz-transition-duration: 2s;
                    -moz-transition-timing-function: ease-in-out;
                    -ms-transition-property: all;
                    -ms-transition-duration: 2s;
                    -ms-transition-timing-function: ease-in-out;
                    -o-transition-property: all;
                    -o-transition-duration: 2s;
                    -o-transition-timing-function: ease-in-out;
                    /* Standard syntax */
                    transition-property: all;
                    transition-duration: 2s;
                    transition-timing-function: ease-in-out;
                }
                .msdlab_logo_gallery .item-wrapper .item {
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center center;
                    height: 100%;
                    width: 100%;
                }

            </style>
            <script>
                jQuery(document).ready(function($) {   
                    $(".msdlab_logo_gallery .item-wrapper").css("opacity",1);
                });
            </script>';
            return $ret;
        }     
  } //End Class
} //End if class exists statement