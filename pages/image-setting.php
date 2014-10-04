<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Image vertical reel scroll slideshow', 'vertical-reel'); ?></h2>
	<h3><?php _e('Widget Setting', 'vertical-reel'); ?></h3>
    <?php
	$ivrss_title = get_option('ivrss_title');
	$ivrss_scrollercount = get_option('ivrss_scrollercount');
	$ivrss_scrollerheight = get_option('ivrss_scrollerheight');
	$ivrss_random = get_option('ivrss_random');
	$ivrss_type = get_option('ivrss_type');
	
	$ivrss_speed = get_option('ivrss_speed');
	$ivrss_waitseconds = get_option('ivrss_waitseconds');
	
	if (isset($_POST['ivrss_submit'])) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('ivrss_form_setting');
			
		$ivrss_title = stripslashes($_POST['ivrss_title']);
		$ivrss_scrollercount = stripslashes($_POST['ivrss_scrollercount']);
		$ivrss_scrollerheight = stripslashes($_POST['ivrss_scrollerheight']);
		$ivrss_random = stripslashes($_POST['ivrss_random']);
		$ivrss_type = stripslashes($_POST['ivrss_type']);
		
		$ivrss_speed = stripslashes($_POST['ivrss_speed']);
		$ivrss_waitseconds = stripslashes($_POST['ivrss_waitseconds']);

		update_option('ivrss_title', $ivrss_title );
		update_option('ivrss_scrollercount', $ivrss_scrollercount );
		update_option('ivrss_scrollerheight', $ivrss_scrollerheight );
		update_option('ivrss_random', $ivrss_random );
		update_option('ivrss_type', $ivrss_type );
		
		update_option('ivrss_speed', $ivrss_speed );
		update_option('ivrss_waitseconds', $ivrss_waitseconds );
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'vertical-reel'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo WP_ivrss_PLUGIN_URL; ?>/pages/setting.js"></script>
    <form name="ivrss_form" method="post" action="">
      
	  <label for="tag-title"><?php _e('Enter widget title', 'vertical-reel'); ?></label>
      <input name="ivrss_title" id="ivrss_title" type="text" value="<?php echo $ivrss_title; ?>" size="80" />
      <p><?php _e('Enter widget title, Only for widget.', 'vertical-reel'); ?></p>
      
	  <label for="tag-width"><?php _e('Display image count (Only number)', 'vertical-reel'); ?></label>
      <input name="ivrss_scrollercount" id="ivrss_scrollercount" type="text" value="<?php echo $ivrss_scrollercount; ?>" />
      <p><?php _e('No of images you want to display at the same time.', 'vertical-reel'); ?> (Example: 2)</p>
      
	  <label for="tag-height"><?php _e('Height of each image', 'vertical-reel'); ?></label>
      <input name="ivrss_scrollerheight" id="ivrss_scrollerheight" type="text" value="<?php echo $ivrss_scrollerheight; ?>" />
      <p><?php _e('Height of each images in the gallery.', 'vertical-reel'); ?> (Example: 170)</p>
	  
	  <label for="tag-height"><?php _e('Random order', 'vertical-reel'); ?></label>
      <input name="ivrss_random" id="ivrss_random" type="text" value="<?php echo $ivrss_random; ?>" />
      <p><?php _e('Image display random order.', 'vertical-reel'); ?> (Example: YES or NO)</p>
      
	  <label for="tag-height"><?php _e('Select your gallery group (Gallery  Type)', 'vertical-reel'); ?></label>
      <!--<input name="ivrss_type" id="ivrss_type" type="text" value="<?php //echo $ivrss_type; ?>" />-->
	  <select name="ivrss_type" id="ivrss_type">
        <option value='GROUP1' <?php if($ivrss_type=='GROUP1') { echo 'selected' ; } ?>>Group1</option>
        <option value='GROUP2' <?php if($ivrss_type=='GROUP2') { echo 'selected' ; } ?>>Group2</option>
        <option value='GROUP3' <?php if($ivrss_type=='GROUP3') { echo 'selected' ; } ?>>Group3</option>
        <option value='GROUP4' <?php if($ivrss_type=='GROUP4') { echo 'selected' ; } ?>>Group4</option>
        <option value='GROUP5' <?php if($ivrss_type=='GROUP5') { echo 'selected' ; } ?>>Group5</option>
        <option value='GROUP6' <?php if($ivrss_type=='GROUP6') { echo 'selected' ; } ?>>Group6</option>
        <option value='GROUP7' <?php if($ivrss_type=='GROUP7') { echo 'selected' ; } ?>>Group7</option>
        <option value='GROUP8' <?php if($ivrss_type=='GROUP8') { echo 'selected' ; } ?>>Group8</option>
        <option value='GROUP9' <?php if($ivrss_type=='GROUP9') { echo 'selected' ; } ?>>Group9</option>
        <option value='GROUP0' <?php if($ivrss_type=='GROUP0') { echo 'selected' ; } ?>>Group0</option>
		<option value='Widget' <?php if($ivrss_type=='Widget') { echo 'selected' ; } ?>>Widget</option>
		<option value='sample' <?php if($ivrss_type=='Sample') { echo 'selected' ; } ?>>Sample</option>
      </select>
      <p><?php _e('This field is to group the images. Select your group name to fetch the images for widget.', 'vertical-reel'); ?></p>
	  
		<label for="ivrss_speed"><?php _e( 'Scrolling speed', 'vertical-reel' ); ?></label>
		<?php _e( 'Slow', 'vertical-reel' ); ?> 
		<input name="ivrss_speed" type="range" value="<?php echo $ivrss_speed; ?>"  id="ivrss_speed" min="1" max="10" /> 
		<?php _e( 'Fast', 'vertical-reel' ); ?> 
		<p><?php _e( 'Set how fast you want to scroll.', 'vertical-reel' ); ?></p>
		
		<label for="ivrss_waitseconds"><?php _e( 'Seconds to wait', 'vertical-reel' ); ?></label>
		<input name="ivrss_waitseconds" type="text" value="<?php echo $ivrss_waitseconds; ?>" id="ivrss_waitseconds" maxlength="4" />
		<p><?php _e( 'How many seconds you want the wait to scroll', 'vertical-reel' ); ?> (<?php _e( 'Example', 'vertical-reel' ); ?>: 5)</p>
      
	  <input name="ivrss_submit" id="ivrss_submit" class="button-primary" value="<?php _e('Submit', 'vertical-reel'); ?>" type="submit" />
	  <input name="publish" lang="publish" class="button-primary" onclick="ivrss_redirect()" value="<?php _e('Cancel', 'vertical-reel'); ?>" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="ivrss_help()" value="<?php _e('Help', 'vertical-reel'); ?>" type="button" />
	  <?php wp_nonce_field('ivrss_form_setting'); ?>
    </form>
  </div>
  <br />	
	<p class="description">
	<?php _e('Check official website for more information', 'vertical-reel'); ?>
	<a target="_blank" href="<?php echo WP_ivrss_FAV; ?>"><?php _e('click here', 'vertical-reel'); ?></a>
	</p>
</div>