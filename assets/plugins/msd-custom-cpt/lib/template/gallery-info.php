<?php global $wpalchemy_media_access; ?>
<style>
    .pull-right{float: right;}
</style>
<div class="gallery_meta_control meta_control">
 <p id="warning" style="display: none;background:lightYellow;border:1px solid #E6DB55;padding:5px;">Order has changed. Please click Save or Update to preserve order.</p>
	
 	<div class="table">
 	<?php $i = 0; ?>
	<?php while($mb->have_fields_and_multi('gallery')): ?>
	<?php $mb->the_group_open(); ?>
	<div class="row <?php print $i%2==0?'even':'odd'; ?>">
 		<div class="cell">
 		<label>Title</label>
		<?php $mb->the_field('title'); ?>
		<div class="input_container">
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		</div>
		</div><div class="cell file">
		<label>Image</label>
		<?php $mb->the_field('imageurl'); ?>
		<div class="input_container">
		    
        <?php if($mb->get_the_value() != ''){
            $thumb = wp_get_attachment_image_src( get_attachment_id_from_src($mb->get_the_value()), 'thumbnail' );
            print '<img src="'.$thumb[0].'"><br/>';
        } ?>
        <?php $wpalchemy_media_access->setGroupName('imageurl'. $mb->get_the_index())->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
		<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
        <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
		</div>
		</div>
 		<div class="cell">
 			<a href="#" class="dodelete button pull-right">Remove Image</a>
		</div>
 	</div>
 	<?php $i++; ?>
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 	</div>
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-gallery button">Add Image</a>
	<a href="#" class="dodelete-gallery button">Remove All Images</a></p>
		
</div>
<script>
jQuery(function($){
	$("#wpa_loop-gallery").sortable({
		change: function(){
			$("#warning").show();
		}
	});
});</script>