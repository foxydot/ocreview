<?php
/*
Plugin Name: MSD Review System
Description: Custom plugin by MSDLAB
Author: Catherine Sandrick
Version: 0.0.1
Author URI: http://msdlab.com
*/

global $msd_review;

if (!class_exists('MSDReviewSystem')) {
    class MSDReviewSystem {
        //Properites
        /**
         * @var string The plugin version
         */
        var $version = '0.0.1';
        
        /**
         * @var string The options string name for this plugin
         */
        var $optionsName = 'msd_review_options';
        
        /**
         * @var string $nonce String used for nonce security
         */
        var $nonce = 'msd_review-update-options';
        
        /**
         * @var string $localizationDomain Domain used for localization
         */
        var $localizationDomain = "msd_review";
        
        /**
         * @var string $pluginurl The path to this plugin
         */
        var $plugin_url = '';
        /**
         * @var string $pluginurlpath The path to this plugin
         */
        var $plugin_path = '';
        
        /**
         * @var array $options Stores the options for this plugin
         */
        var $options = array();
        
        /**
         * @var bool $flushrules Weather or not to flush rewrite rules on activation.
         */
        var $flushrules = FALSE;
        
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        function MSDCustomCPT(){$this->__construct();}
        
        /**
        * PHP 5 Constructor
        */        
        function __construct(){
            //"Constants" setup
            $this->plugin_url = plugin_dir_url(__FILE__).'/';
            $this->plugin_path = plugin_dir_path(__FILE__).'/';
            //Initialize the options
            $this->get_options();
            //check requirements
            register_activation_hook(__FILE__, array(&$this,'check_requirements'));
            add_action( 'init', array(&$this,'register_taxonomy_client') );
            add_action( 'init', array(&$this,'review_login') );
            add_action('user_register',array(&$this,'create_client_tag'));
            add_action('widgets_init', create_function('', 'return register_widget("MSDReviewMenu");'));
            add_action('widgets_init', create_function('', 'return register_widget("MSDReviewWelcome");'));
        }

        /**
         * @desc Loads the options. Responsible for handling upgrades and default option values.
         * @return array
         */
        function check_options() {
            $options = null;
            if (!$options = get_option($this->optionsName)) {
                // default options for a clean install
                $options = array(
                        'version' => $this->version,
                        'reset' => true
                );
                update_option($this->optionsName, $options);
            }
            else {
                // check for upgrades
                if (isset($options['version'])) {
                    if ($options['version'] < $this->version) {
                        // post v1.0 upgrade logic goes here
                    }
                }
                else {
                    // pre v1.0 updates
                    if (isset($options['admin'])) {
                        unset($options['admin']);
                        $options['version'] = $this->version;
                        $options['reset'] = true;
                        update_option($this->optionsName, $options);
                    }
                }
            }
            return $options;
        }
        
        /**
         * @desc Retrieves the plugin options from the database.
         */
        function get_options() {
            $options = $this->check_options();
            $this->options = $options;
        }
        /**
         * @desc Check to see if requirements are met
         */
        function check_requirements(){
           return true; 
        }
        /***************************/
        
        /**
         * @desc Create taxonomy
         */
         function register_taxonomy_client(){
             $labels = array( 
                'name' => _x( 'Clients', 'client' ),
                'singular_name' => _x( 'Client', 'client' ),
                'search_items' => _x( 'Search clients', 'client' ),
                'popular_items' => _x( 'Popular clients', 'client' ),
                'all_items' => _x( 'All clients', 'client' ),
                'parent_item' => _x( 'Parent client', 'client' ),
                'parent_item_colon' => _x( 'Parent client:', 'client' ),
                'edit_item' => _x( 'Edit client', 'client' ),
                'update_item' => _x( 'Update client', 'client' ),
                'add_new_item' => _x( 'Add new client', 'client' ),
                'new_item_name' => _x( 'New client name', 'client' ),
                'separate_items_with_commas' => _x( 'Separate clients with commas', 'client' ),
                'add_or_remove_items' => _x( 'Add or remove clients', 'client' ),
                'choose_from_most_used' => _x( 'Choose from the most used clients', 'client' ),
                'menu_name' => _x( 'Clients', 'client' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => false,
                'show_ui' => true,
                'show_tagcloud' => true,
                'hierarchical' => false, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.
        
                'rewrite' => array('slug'=>'client','with_front'=>false),
                'query_var' => true
            );
        
            register_taxonomy( 'client', array('post','page'), $args );
         }
       
        /**
         * @desc Create taxonomy term when adding a user
         */
         function create_client_tag($user_id){
             $user = get_userdata($user_id);
             $term = $user->user_login;
             $taxonomy = "client";
             $args = array('description' => $user->description);
             wp_insert_term( $term, $taxonomy, $args );
         }
         
         /**
          * @desc require login, or display list
          */
          function review_login(){
              if(!is_admin() && $GLOBALS['pagenow'] != 'wp-login.php'){
              add_filter( 'auth_redirect_scheme', array(&$this,'front_end_auth_redirect') );
              auth_redirect();
              add_action('pre_get_posts',array(&$this,'alter_query'));
              }
          }

          function alter_query($query){
             $current_user = wp_get_current_user();
              if( ! is_admin()){
                  if(current_user_can('edit_pages')){
                      return;
                  }
                  if( $query->is_main_query() ) {
                    $my_post = $query->get_queried_object_id(); //hrm https://core.trac.wordpress.org/ticket/27015#comment:10
                    $my_terms = array($current_user->data->user_login);
                    $terms = wp_get_object_terms($my_post, 'client', array('fields' => 'slugs') );
                    $test = array_intersect($terms, $my_terms);
                    
                    if($query->is_singular() ) {
                        if ( !empty($my_post) ){
                            if(empty( $test )){
                                $query->set( 'page_id', -1 ); // 404
                            }
                        }
                    } else {
                        $query->set('post_type',array('post','page'));
                        $query->set('tax_query', array(
                            array(
                                'taxonomy' => 'client',
                                'field'    => 'slug',
                                'terms'    => $current_user->data->user_login,
                            ),
                        ));
                    }
                  }
              }
          }
          
        function front_end_auth_redirect(){
            return 'logged_in';
        }
  } //End Class
} //End if class exists statement
class MSDReviewMenu extends WP_Widget {
    /** constructor */
    function __construct() {
        $widget_ops = array('classname' => 'review-menu', 'description' => __('Display menu of items to be reviewed.'));
        $control_ops = array('width' => 400, 'height' => 350);
        $this->WP_Widget('review-menu', __('Review Menu'), $widget_ops, $control_ops);
    }

    function widget( $args, $instance ) {
        $current_user = wp_get_current_user();
        extract($args);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
        
        echo $before_widget;
        if ( !empty( $title ) ) { print $before_title.$title.$after_title; } 
        $query_args['post_type'] = array('post','page');
        if(current_user_can('edit_pages')){
        } else {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'client',
                    'field'    => 'slug',
                    'terms'    => $current_user->data->user_login,
                ),
            );
        }
        $menu = get_posts($query_args);
         if($menu){
            global $post;
            echo '<ul>';
            echo walk_page_tree($menu, 5, $post->ID, array('walker' => new MSD_Review_Walker_Page));
            echo '</ul>';
         }
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $title = strip_tags($instance['title']);
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p> 
<?php
    }
}
class MSDReviewWelcome extends WP_Widget {
    /** constructor */
    function __construct() {
        $widget_ops = array('classname' => 'review-welcome', 'description' => __('Display client name and some options.'));
        $control_ops = array('width' => 400, 'height' => 350);
        $this->WP_Widget('review-welcome', __('Review Welcome'), $widget_ops, $control_ops);
    }

    function widget( $args, $instance ) {
        $current_user = wp_get_current_user();
        extract($args);
        
        echo $before_widget;
        print '<h4>Welcome, '.$current_user->data->display_name.'</h4>';
        echo $after_widget;
    }
}
class MSD_Review_Walker_Page extends Walker_Page{
    
    /**
     * @see Walker::start_el()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $page Page data object.
     * @param int $depth Depth of page. Used for padding.
     * @param int $current_page Page ID.
     * @param array $args
     */
    public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
        if ( $depth ) {
            $indent = str_repeat( "\t", $depth );
        } else {
            $indent = '';
        }

        $css_class = array( 'page_item', 'page-item-' . $page->ID );

        if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
            $css_class[] = 'page_item_has_children';
        }
        if ( ! empty( $current_page ) ) {
            $_current_page = get_post( $current_page );
            if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
                $css_class[] = 'current_page_ancestor';
            }
            if ( $page->ID == $current_page ) {
                $css_class[] = 'current_page_item';
            } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
                $css_class[] = 'current_page_parent';
            }
        } elseif ( $page->ID == get_option('page_for_posts') ) {
            $css_class[] = 'current_page_parent';
        }

        /**
         * Filter the list of CSS classes to include with each page item in the list.
         *
         * @since 2.8.0
         *
         * @see wp_list_pages()
         *
         * @param array   $css_class    An array of CSS classes to be applied
         *                             to each list item.
         * @param WP_Post $page         Page data object.
         * @param int     $depth        Depth of page, used for padding.
         * @param array   $args         An array of arguments.
         * @param int     $current_page ID of the current page.
         */
        $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

        if ( '' === $page->post_title ) {
            $page->post_title = sprintf( __( '#%d (no title)' ), $page->ID );
        }
        
        $comment_count_array = get_comment_count($page->ID);

        $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
        $args['link_after'] = empty( $args['link_after'] ) ? '<span class="comment-count">'.$comment_count_array['approved'].'</span>' : $args['link_after'];

        /** This filter is documented in wp-includes/post-template.php */
        $output .= $indent . sprintf(
            '<li class="%s"><a href="%s">%s%s%s</a>',
            $css_classes,
            get_permalink( $page->ID ),
            $args['link_before'],
            apply_filters( 'the_title', $page->post_title, $page->ID ),
            $args['link_after']
        );

        if ( ! empty( $args['show_date'] ) ) {
            if ( 'modified' == $args['show_date'] ) {
                $time = $page->post_modified;
            } else {
                $time = $page->post_date;
            }

            $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
            $output .= " " . mysql2date( $date_format, $time );
        }
    }
}
//instantiate
$msd_review = new MSDReviewSystem();