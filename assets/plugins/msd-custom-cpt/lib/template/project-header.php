<?php global $wpalchemy_media_access; ?>
<style>
    .meta_control .table {display: block; width: 100%;}
    .meta_control .row {display: block;}
    .meta_control .row:before,
.meta_control .row:after {
    content: " "; /* 1 */
    display: table; /* 2 */
}

.meta_control .row:after {
    clear: both;
}

/**
 * For IE 6/7 only
 * Include this rule to trigger hasLayout and contain floats.
 */
.meta_control .row {
    *zoom: 1;
}
.meta_control .cell {display: block; clear: both;margin-left: 1rem;}
    .even {background: #eee;}
    .odd {background: #fff;}
    .file input[type="text"] {width: 75%}
    .meta_control label{ display:block; font-weight:bold; margin-right: 1%;float: left; width: 14%; text-align: right;}
 .input_container{width: 85%;float: left;}
 .input_container.full_width{width: 98%;float: none;}
.meta_control textarea, .meta_control input[type='text'], .meta_control select,.meta_control .wp-editor-wrap
{ display:inline;margin-bottom:3px; width: 90%;
     }
     .meta_control .file input[type='text']{width: 76%;}
</style>
<div class="meta_control">
    <div class="table">
    <div class="row">
        <div class="cell">
            <div class="input_container full_width">
                <?php 
                $mb->the_field('content');
                $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                $mb_editor_id = sanitize_key($mb->get_the_name());
                $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                ?>
           </div>
        </div>
    </div>
    </div>
</div>
<script>
jQuery(function($){
    $("#postdivrich").before($("#_project_header_metabox"));
});</script>
