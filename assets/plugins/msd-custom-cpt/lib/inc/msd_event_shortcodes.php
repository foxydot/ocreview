<?php
if (!class_exists('MSDEventShortcodes')) {
    class MSDEventShortcodes {
        //Properties
        var $cpt = 'event';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDEventShortcodes(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            add_shortcode('upcoming-events', array(&$this,'upcoming_events'));
            add_shortcode('upcoming_events', array(&$this,'upcoming_events'));
        }
        
        function upcoming_events($atts){
            global $event_info;
            extract( shortcode_atts( array(
                'months' => '12',
                'number_posts' => 3
            ), $atts ) );
            $args = array(
                'posts_per_page' => $number_posts,
                'post_type' => $this->cpt,
                'meta_query' => array(
                    array(
                        'key' => '_event_event_datestamp',
                        'value' => time()-86400,
                        'compare' => '>'
                    ),
                    array(
                        'key' => '_event_event_datestamp',
                        'value' => mktime(0, 0, 0, date("m")+$months, date("d"), date("Y")),
                        'compare' => '<'
                    )
                ),
                'meta_key' => '_event_event_datestamp',
                'orderby'=>'meta_value_num',
                'order'=>'ASC',
            );
            $events = get_posts($args);
            $i = 0;
            foreach($events AS $up){
                $event_info->the_meta($up->ID);
                $events[$i]->event_date = $event_info->get_the_value('event_datestamp');
                $events[$i]->venue = $event_info->get_the_value('venue');
                $events[$i]->title = $up->post_title;
                $i++;
            }
            
            $ret = '<div class="msdlab_upcoming_events">';
            if ( !empty( $events ) ):
            $ret .= '
            <div data-ride="carousel" class="msd_upcoming_event_list carousel slide" id="msdUpcomingEventCarousel">
            <h3 class="pull-left">Upcoming Events:</h3>
            <div class="carousel-controls">
             <a data-slide="prev" role="button" href="#msdUpcomingEventCarousel" class="left carousel-control">
        <span aria-hidden="true" class="fa fa-arrow-circle-o-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a data-slide="next" role="button" href="#msdUpcomingEventCarousel" class="right carousel-control">
        <span aria-hidden="true" class="fa fa-arrow-circle-o-right"></span>
        <span class="sr-only">Next</span>
      </a>
      </div>
      <div role="listbox" class="carousel-inner">
                ';
                $i = 0;
            foreach ( $events as $event ):
                $active = $i==0?' active':'';
            $ret .= '
            <div class="item'.$active.'" id="event_'.$event->ID.'">
                <span class="event-date span2">'.date( "M d, Y", $event->event_date ).'</span>
                <span class="event-title span2">'.$event->title.'</span>
                <span class="event-venue span2">'.$event->venue.'</span>
           </div>';
           $i++;
            endforeach;
                $ret .= '
                </div>
                <a href="'.get_post_type_archive_link($this->cpt).'" class="pull-right">View All Events</a>
                </div>';
            else:
                $ret .= '<p>No Upcoming Events</p>';
            endif;
            $ret .= '</div>';
            return $ret;
        }
        
        function sort_by_event_date( $a, $b ) {
            return $a->event_date == $b->event_date ? 0 : ( $a->event_date > $b->event_date ) ? 1 : -1;
        }
    }
}