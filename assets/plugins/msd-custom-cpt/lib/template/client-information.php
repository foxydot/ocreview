<?php
$states = array('AL'=>"Alabama",
        'AK'=>"Alaska",
        'AZ'=>"Arizona",
        'AR'=>"Arkansas",
        'CA'=>"California",
        'CO'=>"Colorado",
        'CT'=>"Connecticut",
        'DE'=>"Delaware",
        'DC'=>"District Of Columbia",
        'FL'=>"Florida",
        'GA'=>"Georgia",
        'HI'=>"Hawaii",
        'ID'=>"Idaho",
        'IL'=>"Illinois",
        'IN'=>"Indiana",
        'IA'=>"Iowa",
        'KS'=>"Kansas",
        'KY'=>"Kentucky",
        'LA'=>"Louisiana",
        'ME'=>"Maine",
        'MD'=>"Maryland",
        'MA'=>"Massachusetts",
        'MI'=>"Michigan",
        'MN'=>"Minnesota",
        'MS'=>"Mississippi",
        'MO'=>"Missouri",
        'MT'=>"Montana",
        'NE'=>"Nebraska",
        'NV'=>"Nevada",
        'NH'=>"New Hampshire",
        'NJ'=>"New Jersey",
        'NM'=>"New Mexico",
        'NY'=>"New York",
        'NC'=>"North Carolina",
        'ND'=>"North Dakota",
        'OH'=>"Ohio",
        'OK'=>"Oklahoma",
        'OR'=>"Oregon",
        'PA'=>"Pennsylvania",
        'RI'=>"Rhode Island",
        'SC'=>"South Carolina",
        'SD'=>"South Dakota",
        'TN'=>"Tennessee",
        'TX'=>"Texas",
        'UT'=>"Utah",
        'VT'=>"Vermont",
        'VA'=>"Virginia",
        'WA'=>"Washington",
        'WV'=>"West Virginia",
        'WI'=>"Wisconsin",
        'WY'=>"Wyoming");


?>
<div class="meta_control">
    <div class="table">
        
<?php while($mb->have_fields('client',1)): ?>
    <div class="row">
        <div class="cell">
            <?php $metabox->the_field('name'); ?>
            <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Client Name</label>
            <div class="input_container"><input type="text" tabindex="1" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </div>
    
    <div class="row">
        <div class="cell">
    <?php $metabox->the_field('city'); ?>
    <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Client City</label>
    <div class="input_container"><input type="text" tabindex="3" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>

        </div>
    </div>
    
    <div class="row">
        <div class="cell">
    <?php $metabox->the_field('state'); ?>
    <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Client State</label>
    <div class="input_container">
    <select tabindex="4" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
        <option value="">--SELECT--</option>
        <?php foreach($states AS $k =>$v){ ?>
            <option value="<?php print $v; ?>"<?php print $metabox->get_the_value()==$v?' SELECTED':''?>><?php print $v; ?></option>
        <?php } ?>
    </select>
    </div>
        </div>
    </div>
    </div>
<?php endwhile; ?>
</div>
<script>
jQuery(function($){
    $("#postdivrich").before($("#_client_information_metabox"));
});</script>