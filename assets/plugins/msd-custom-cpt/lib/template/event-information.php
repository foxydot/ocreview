<?php global $wpalchemy_media_access; 
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
<style>
#postdivrich {display: none;}
</style>
<div class="meta_control">
    <div class="table">
        <div class="row">
            <div class="cell">
            <?php $metabox->the_field('venue'); ?>
                <label>Location Name</label>
                <div class="input_container">
                    <input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
               </div>
            </div>
        </div>
        
<?php while($mb->have_fields('address',1)): ?>
    <div class="row">
        <div class="cell">
        <?php $metabox->the_field('street'); ?>
        <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Street Address</label>
        <div class="input_container"><input type="text" value="<?php $metabox->the_value(); ?>" id="_location_street" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </div>
    <div class="row">
        <div class="cell">
        <?php $metabox->the_field('city'); ?>
        <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">City</label>
        <div class="input_container"><input type="text" value="<?php $metabox->the_value(); ?>" id="_location_city" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </div>
    <div class="row">
        <div class="cell">
        <?php $metabox->the_field('state'); ?>
        <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">State</label>
        <div class="input_container">
            <select id="_location_state" name="<?php $metabox->the_name(); ?>">
                <option value="">--SELECT--</option>
                <?php foreach($states AS $k =>$v){ ?>
                    <option value="<?php print $v; ?>"<?php print $metabox->get_the_value()==$v?' SELECTED':''?>><?php print $v; ?></option>
                <?php } ?>
            </select>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="cell">
        <?php $metabox->the_field('zip'); ?>
        <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Zip Code</label>
        <div class="input_container"><input type="text" value="<?php $metabox->the_value(); ?>" id="_location_zip" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </div>
<?php endwhile; ?>
    <div class="row">
        <div class="cell">
            <hr />
       </div>
    </div>
        <div class="row">
            <div class="cell">
                <?php $metabox->the_field('event_datestamp'); ?>
                <input type="hidden" class="datestamp" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
                <?php $metabox->the_field('event_date'); ?>
                <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Event Date</label>
                <div class="input_container">
                    <input type="text" class="datepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="cell">
            <?php $metabox->the_field('event_start_time'); ?>
                <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">Event Times</label>
                <div class="input_container"><input type="text" class="timepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
                    to 
                <?php $metabox->the_field('event_end_time'); ?>
                <input type="text" class="timepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
                </div>
            </div>    
        </div>
    </div>
</div>