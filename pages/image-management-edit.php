<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WP_ivrss_TABLE."
	WHERE `ivrss_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'vertical-reel'); ?></strong></p></div><?php
}
else
{
	$ivrss_errors = array();
	$ivrss_success = '';
	$ivrss_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_ivrss_TABLE."`
		WHERE `ivrss_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'ivrss_path' => $data['ivrss_path'],
		'ivrss_link' => $data['ivrss_link'],
		'ivrss_target' => $data['ivrss_target'],
		'ivrss_title' => $data['ivrss_title'],
		'ivrss_order' => $data['ivrss_order'],
		'ivrss_status' => $data['ivrss_status'],
		'ivrss_type' => $data['ivrss_type']
	);
}
// Form submitted, check the data
if (isset($_POST['ivrss_form_submit']) && $_POST['ivrss_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('ivrss_form_edit');
	
	$form['ivrss_path'] = isset($_POST['ivrss_path']) ? $_POST['ivrss_path'] : '';
	if ($form['ivrss_path'] == '')
	{
		$ivrss_errors[] = __('Please enter the image path.', 'vertical-reel');
		$ivrss_error_found = TRUE;
	}

	$form['ivrss_link'] = isset($_POST['ivrss_link']) ? $_POST['ivrss_link'] : '';
	if ($form['ivrss_link'] == '')
	{
		$ivrss_errors[] = __('Please enter the target link.', 'vertical-reel');
		$ivrss_error_found = TRUE;
	}
	
	$form['ivrss_target'] = isset($_POST['ivrss_target']) ? $_POST['ivrss_target'] : '';
	$form['ivrss_title'] = isset($_POST['ivrss_title']) ? $_POST['ivrss_title'] : '';
	$form['ivrss_order'] = isset($_POST['ivrss_order']) ? $_POST['ivrss_order'] : '';
	$form['ivrss_status'] = isset($_POST['ivrss_status']) ? $_POST['ivrss_status'] : '';
	$form['ivrss_type'] = isset($_POST['ivrss_type']) ? $_POST['ivrss_type'] : '';

	//	No errors found, we can add this Group to the table
	if ($ivrss_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_ivrss_TABLE."`
				SET `ivrss_path` = %s,
				`ivrss_link` = %s,
				`ivrss_target` = %s,
				`ivrss_title` = %s,
				`ivrss_order` = %d,
				`ivrss_status` = %s,
				`ivrss_type` = %s
				WHERE ivrss_id = %d
				LIMIT 1",
				array($form['ivrss_path'], $form['ivrss_link'], $form['ivrss_target'], $form['ivrss_title'], $form['ivrss_order'], 
							$form['ivrss_status'], $form['ivrss_type'], $did)
			);
		$wpdb->query($sSql);
		
		$ivrss_success = __('Image details was successfully updated.', 'vertical-reel');
	}
}

if ($ivrss_error_found == TRUE && isset($ivrss_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $ivrss_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($ivrss_error_found == FALSE && strlen($ivrss_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $ivrss_success; ?> 
		<a href="<?php echo WP_ivrss_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'vertical-reel'); ?></a></strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo WP_ivrss_PLUGIN_URL; ?>/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Image vertical reel scroll slideshow', 'vertical-reel'); ?></h2>
	<form name="ivrss_form" method="post" action="#" onsubmit="return ivrss_submit()"  >
      <h3><?php _e('Update image details', 'vertical-reel'); ?></h3>
      <label for="tag-image"><?php _e('Enter image path', 'vertical-reel'); ?></label>
      <input name="ivrss_path" type="text" id="ivrss_path" value="<?php echo $form['ivrss_path']; ?>" size="100" />
      <p><?php _e('Where is the picture located on the internet', 'vertical-reel'); ?></p>
      <label for="tag-link"><?php _e('Enter target link', 'vertical-reel'); ?></label>
      <input name="ivrss_link" type="text" id="ivrss_link" value="<?php echo $form['ivrss_link']; ?>" size="100" />
      <p><?php _e('When someone clicks on the picture, where do you want to send them', 'vertical-reel'); ?></p>
      <label for="tag-target"><?php _e('Enter target option', 'vertical-reel'); ?></label>
      <select name="ivrss_target" id="ivrss_target">
        <option value='_blank' <?php if($form['ivrss_target']=='_blank') { echo 'selected' ; } ?>>_blank</option>
        <option value='_parent' <?php if($form['ivrss_target']=='_parent') { echo 'selected' ; } ?>>_parent</option>
        <option value='_self' <?php if($form['ivrss_target']=='_self') { echo 'selected' ; } ?>>_self</option>
        <option value='_new' <?php if($form['ivrss_target']=='_new') { echo 'selected' ; } ?>>_new</option>
      </select>
      <p><?php _e('Do you want to open link in new window?', 'vertical-reel'); ?></p>
      <label for="tag-title"><?php _e('Enter image reference', 'vertical-reel'); ?></label>
      <input name="ivrss_title" type="text" id="ivrss_title" value="<?php echo $form['ivrss_title']; ?>" size="100" />
      <p><?php _e('Enter image reference. This is only for reference.', 'vertical-reel'); ?></p>
      <label for="tag-select-gallery-group"><?php _e('Select gallery type', 'vertical-reel'); ?></label>
      <select name="ivrss_type" id="ivrss_type">
        <option value='GROUP1' <?php if($form['ivrss_type']=='GROUP1') { echo 'selected' ; } ?>>Group1</option>
        <option value='GROUP2' <?php if($form['ivrss_type']=='GROUP2') { echo 'selected' ; } ?>>Group2</option>
        <option value='GROUP3' <?php if($form['ivrss_type']=='GROUP3') { echo 'selected' ; } ?>>Group3</option>
        <option value='GROUP4' <?php if($form['ivrss_type']=='GROUP4') { echo 'selected' ; } ?>>Group4</option>
        <option value='GROUP5' <?php if($form['ivrss_type']=='GROUP5') { echo 'selected' ; } ?>>Group5</option>
        <option value='GROUP6' <?php if($form['ivrss_type']=='GROUP6') { echo 'selected' ; } ?>>Group6</option>
        <option value='GROUP7' <?php if($form['ivrss_type']=='GROUP7') { echo 'selected' ; } ?>>Group7</option>
        <option value='GROUP8' <?php if($form['ivrss_type']=='GROUP8') { echo 'selected' ; } ?>>Group8</option>
        <option value='GROUP9' <?php if($form['ivrss_type']=='GROUP9') { echo 'selected' ; } ?>>Group9</option>
        <option value='GROUP0' <?php if($form['ivrss_type']=='GROUP0') { echo 'selected' ; } ?>>Group0</option>
		<option value='Widget' <?php if($form['ivrss_type']=='Widget') { echo 'selected' ; } ?>>Widget</option>
		<option value='sample' <?php if($form['ivrss_type']=='Sample') { echo 'selected' ; } ?>>Sample</option>
      </select>
      <p><?php _e('This is to group the images. Select your slideshow group.', 'vertical-reel'); ?></p>
      <label for="tag-display-status"><?php _e('Display status', 'vertical-reel'); ?></label>
      <select name="ivrss_status" id="ivrss_status">
        <option value='YES' <?php if($form['ivrss_status']=='YES') { echo 'selected' ; } ?>>Yes</option>
        <option value='NO' <?php if($form['ivrss_status']=='NO') { echo 'selected' ; } ?>>No</option>
      </select>
      <p><?php _e('Do you want the picture to show in your galler?', 'vertical-reel'); ?></p>
      <label for="tag-display-order"><?php _e('Display order', 'vertical-reel'); ?></label>
      <input name="ivrss_order" type="text" id="ivrss_order" size="10" value="<?php echo $form['ivrss_order']; ?>" maxlength="3" />
      <p><?php _e('What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.', 'vertical-reel'); ?></p>
      <input name="ivrss_id" id="ivrss_id" type="hidden" value="">
      <input type="hidden" name="ivrss_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button-primary" value="<?php _e('Update Details', 'vertical-reel'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button-primary" onclick="ivrss_redirect()" value="<?php _e('Cancel', 'vertical-reel'); ?>" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="ivrss_help()" value="<?php _e('Help', 'vertical-reel'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('ivrss_form_edit'); ?>
    </form>
</div>
	<p class="description">
		<?php _e('Check official website for more information', 'vertical-reel'); ?>
		<a target="_blank" href="<?php echo WP_ivrss_FAV; ?>"><?php _e('click here', 'vertical-reel'); ?></a>
	</p>
</div>