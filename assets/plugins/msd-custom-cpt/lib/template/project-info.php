<?php global $wpalchemy_media_access;         
$containers = array('challenge'=>'Challenge','solutions'=>'Solution','results'=>'Result');

?>
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
    margin-bottom: 1rem;
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
        <?php $i = 0; ?>
    <div class="row <?php print $i%2==0?'even':'odd'; ?>">
        <div class="cell">
            <label>Entry Type</label>
            <div class="input_container">
                <?php $mb->the_field('case_study'); ?>
               <select name="<?php $mb->the_name(); ?>">
                <option value="0"<?php $mb->the_select_state('0'); ?>>Sample</option>
                <option value="100"<?php $mb->the_select_state('100'); ?>>Gallery</option>
                <option value="200"<?php $mb->the_select_state('200'); ?>>Case Study</option>
                <option value="300"<?php $mb->the_select_state('300'); ?>>Case Study &amp; Gallery</option>
                </select>
           </div>
        </div>
    </div>
    <?php $i++; ?>
        <?php foreach($containers AS $c => $t){ ?>
    <div class="row <?php print $i%2==0?'even':'odd'; ?>">
        <div class="cell">
            <label><?php print ucfirst($t); ?></label>
            <div class="input_container">
                <?php 
                $mb->the_field($c);
                $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                $mb_editor_id = sanitize_key($mb->get_the_name());
                $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                ?>
           </div>
        </div>
    </div>
    <?php $i++; ?>
        <?php } ?>
    </div>
</div>
<script>
jQuery(function($){
    $("#postdivrich").after($("#_project_info_metabox"));
});</script>
