<?php

/*
Plugin Name: Image vertical reel scroll slideshow
Plugin URI: http://www.gopiplus.com/work/2011/05/30/wordpress-plugin-image-vertical-reel-scroll-slideshow/
Description: Image vertical reel scroll slideshow wordpress plugin will create the vertical scroll slideshow on the website. This will create the slideshow like reel. The images will scroll one by one from bottom to top. Each slide can be optionally hyper linked.
Author: Gopi.R
Version: 6.1
Author URI: http://www.gopiplus.com/work/
Donate link: http://www.gopiplus.com/work/2011/05/30/wordpress-plugin-image-vertical-reel-scroll-slideshow/
Tags: vertical, image, reel, scroll, slideshow, gallery
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("WP_ivrss_TABLE", $wpdb->prefix . "ivrss_plugin");

function ivrss() 
{
	
	global $wpdb;
	$ivrss_html = "";
	$ivrss_js = "";
	
	$ivrss_scrollercount = get_option('ivrss_scrollercount');
	$ivrss_scrollerheight = get_option('ivrss_scrollerheight');
	$ivrss_type = get_option('ivrss_type');
	$ivrss_random = get_option('ivrss_random');
	
	if(!is_numeric($ivrss_scrollerheight))
	{
		$ivrss_scrollerheight = 50;
	}
	if(!is_numeric($ivrss_scrollercount))
	{
		$ivrss_scrollercount = 5;
	}
	if($ivrss_type == "")
	{
		$ivrss_type = "Please enter gallery type";
	}
	
	$sSql = "select * from ".WP_ivrss_TABLE." where ivrss_status='YES' and ivrss_type='$ivrss_type'";
	if($ivrss_random == "YES")
	{
	 	$sSql  = $sSql . " ORDER BY rand()";
	}
	else
	{
		$sSql  = $sSql . " ORDER BY ivrss_order";
	}
	
	$data = $wpdb->get_results($sSql);

	if ( ! empty($data) ) 
	{
		$ivrss_count = 0;
		foreach ( $data as $data ) 
		{
			$ivrss_path = $data->ivrss_path;
			$ivrss_link = $data->ivrss_link;
			$ivrss_target = $data->ivrss_target;

			$dis_height = $ivrss_scrollerheight."px";
			
			$ivrss_html = $ivrss_html . "<div class='cas_div' style='height:$dis_height;padding:2px 0px 2px 0px;'>"; 
			$ivrss_html = $ivrss_html . "<a style='text-decoration:none' target='$ivrss_target' class='cas_div' href='$ivrss_link'><img border='0' src='$ivrss_path'></a>";
			$ivrss_html = $ivrss_html . "</div>";
			
			$ivrss_js = $ivrss_js . "ivrss_array[$ivrss_count] = '<div class=\'cas_div\' style=\'height:$dis_height;padding:2px 0px 2px 0px;\'><a style=\'text-decoration:none\'  target=\'$ivrss_target\' href=\'$ivrss_link\'><img border=\'0\' src=\'$ivrss_path\'></a></div>'; ";	
			
			$ivrss_count++;
		}
	
		$ivrss_scrollerheight = $ivrss_scrollerheight + 4;
		if($ivrss_count >= $ivrss_scrollercount)
		{
			$ivrss_count = $ivrss_scrollercount;
			$ivrss_height = ($ivrss_scrollerheight * $ivrss_scrollercount);
		}
		else
		{
			$ivrss_count = $ivrss_count;
			$ivrss_height = ($ivrss_count*$ivrss_scrollerheight);
		}
		$ivrss_height1 = $ivrss_scrollerheight."px";
		?>
		<div style="padding-top:8px;padding-bottom:8px;">
			<div style="text-align:left;vertical-align:middle;text-decoration: none;overflow: hidden; position: relative; margin-left: 1px; height: <?php echo $ivrss_height1; ?>;" id="ivrss_holder1">
				<?php echo $ivrss_html; ?>
			</div>
		</div>
		<script type="text/javascript">
        var ivrss_array	= new Array();
        var ivrss_obj	= '';
        var ivrss_scrollPos 	= '';
        var ivrss_numScrolls	= '';
        var ivrss_heightOfElm = '<?php echo $ivrss_scrollerheight; ?>'; // Height of each element (px)
        var ivrss_numberOfElm = '<?php echo $ivrss_count; ?>';
        var ivrss_scrollOn 	= 'true';
        function ivrss_createscroll() 
        {
            <?php echo $ivrss_js; ?>
            ivrss_obj	= document.getElementById('ivrss_holder1');
            ivrss_obj.style.height = (ivrss_numberOfElm * ivrss_heightOfElm) + 'px'; // Set height of DIV
            ivrss_content();
        }
        </script>
        <script type="text/javascript">
        ivrss_createscroll();
        </script>
		<?php
	}
	else
	{
		echo "<div style='padding-bottom:5px;padding-top:5px;'>No data available fot this type : $ivrss_type</div>";
	}
}

function ivrss_install() 
{
	global $wpdb;
	
	if($wpdb->get_var("show tables like '". WP_ivrss_TABLE . "'") != WP_ivrss_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_ivrss_TABLE . "` (";
		$sSql = $sSql . "`ivrss_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`ivrss_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`ivrss_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`ivrss_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`ivrss_title` VARCHAR( 500 ) NOT NULL ,";
		$sSql = $sSql . "`ivrss_order` INT NOT NULL ,";
		$sSql = $sSql . "`ivrss_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`ivrss_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`ivrss_extra1` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`ivrss_extra2` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`ivrss_date` datetime NOT NULL default '0000-00-00 00:00:00' ,";
		$sSql = $sSql . "PRIMARY KEY ( `ivrss_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		
		$IsSql = "INSERT INTO `". WP_ivrss_TABLE . "` (`ivrss_path`, `ivrss_link`, `ivrss_target` , `ivrss_title` , `ivrss_order` , `ivrss_status` , `ivrss_type` , `ivrss_date`)"; 
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/image-vertical-reel-scroll-slideshow/images/250x167_1.jpg', '#', '_self', 'Image 1', '1', 'YES', 'gallery1', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/image-vertical-reel-scroll-slideshow/images/250x167_2.jpg' ,'#', '_self', 'Image 2', '2', 'YES', 'gallery1', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/image-vertical-reel-scroll-slideshow/images/250x167_3.jpg', '#', '_self', 'Image 3', '1', 'YES', 'gallery1', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/image-vertical-reel-scroll-slideshow/images/250x167_4.jpg', '#', '_self', 'Image 4', '2', 'YES', 'gallery1', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);

	}
	add_option('ivrss_title', "Vertical Slideshow");
	add_option('ivrss_scrollercount', "2");
	add_option('ivrss_scrollerheight', "170");
	add_option('ivrss_random', "YES");
	add_option('ivrss_type', "gallery1");
}

function ivrss_control() 
{
	echo '<p>Image vertical reel scroll slideshow.<br><br> To change the setting goto "Image vertical reel scroll slideshow" link under SETTING menu. ';
	echo '<a href="options-general.php?page=image-vertical-reel-scroll-slideshow/image-vertical-reel-scroll-slideshow.php">click here</a></p>';
}

function ivrss_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('ivrss_Title');
	echo $after_title;
	ivrss();
	echo $after_widget;
}

function ivrss_admin_options() 
{
	global $wpdb;
	
	echo "<div class='wrap'>";
	echo "<h2>Image vertical reel scroll slideshow</h2>"; 

	$ivrss_title = get_option('ivrss_title');
	$ivrss_scrollercount = get_option('ivrss_scrollercount');
	$ivrss_scrollerheight = get_option('ivrss_scrollerheight');
	$ivrss_random = get_option('ivrss_random');
	$ivrss_type = get_option('ivrss_type');
	
	if (@$_POST['ivrss_submit']) 
	{
		$ivrss_title = stripslashes($_POST['ivrss_title']);
		$ivrss_scrollercount = stripslashes($_POST['ivrss_scrollercount']);
		$ivrss_scrollerheight = stripslashes($_POST['ivrss_scrollerheight']);
		$ivrss_random = stripslashes($_POST['ivrss_random']);
		$ivrss_type = stripslashes($_POST['ivrss_type']);

		update_option('ivrss_title', $ivrss_title );
		update_option('ivrss_scrollercount', $ivrss_scrollercount );
		update_option('ivrss_scrollerheight', $ivrss_scrollerheight );
		update_option('ivrss_random', $ivrss_random );
		update_option('ivrss_type', $ivrss_type );
	}
	
	echo '<form name="ivrss_form" method="post" action="">';

	echo '<p>Title:<br><input  style="width: 450px;" maxlength="200" type="text" value="';
	echo $ivrss_title . '" name="ivrss_title" id="ivrss_title" /> Widget title.</p>';

	echo '<p>No of images you want to display at the same time :<br><input  style="width: 100px;" maxlength="200" type="text" value="';
	echo $ivrss_scrollercount . '" name="ivrss_scrollercount" id="ivrss_scrollercount" /> (only number).</p>';

	echo '<p>Height of each image :<br><input  style="width: 100px;" maxlength="200" type="text" value="';
	echo $ivrss_scrollerheight . '" name="ivrss_scrollerheight" id="ivrss_scrollerheight" /> (only number).</p>';

	echo '<p>Random order:<br><input  style="width: 100px;" type="text" value="';
	echo $ivrss_random . '" name="ivrss_random" id="ivrss_random" /> (YES/NO)</p>';

	echo '<p>Gallery type :<br><input  style="width: 150px;" type="text" value="';
	echo $ivrss_type . '" name="ivrss_type" id="ivrss_type" /> This field is to group the images for gallery.</p>';

	echo '<input name="ivrss_submit" id="ivrss_submit" class="button-primary" value="Submit" type="submit" />';

	echo '</form>';
	
	echo '</div>';
	?>
<div style="float:right;">
  <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=image-vertical-reel-scroll-slideshow/image-management.php'" value="Go to - Image Management" type="button" />
  <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=image-vertical-reel-scroll-slideshow/image-vertical-reel-scroll-slideshow.php'" value="Go to - Gallery Setting" type="button" />
</div>
<?php
	include("help.php");
}

add_shortcode( 'ivrss-gallery', 'ivrss_shortcode' );

function ivrss_shortcode( $atts ) 
{
	global $wpdb;
	
	$ivrss = "";
	$ivrss_html = "";
	$ivrss_js = "";
	
	// Old code
	//$scode = $matches[1];
	//list($ivrss_type_main, $ivrss_scrollercount_main, $ivrss_scrollerheight_main, $ivrss_random_main) = split("[:.-]", $scode);
	//[IVRSS_GALLERY:TYPE=gallery1:DISPLAY=2:HEIGHT=170:RANDOM=YES]
	
	//list($ivrss_type_cap, $ivrss_type) = split('[=.-]', $ivrss_type_main);
	//list($ivrss_scrollercount_cap, $ivrss_scrollercount) = split('[=.-]', $ivrss_scrollercount_main);
	//list($ivrss_scrollerheight_cap, $ivrss_scrollerheight) = split('[=.-]', $ivrss_scrollerheight_main);
	//list($ivrss_random_cap, $ivrss_random) = split('[=.-]', $ivrss_random_main);
	
	// New code
	//[ivrss-gallery type="gallery1" display="2" height="170" random="YES"]
	if ( ! is_array( $atts ) ) { return ''; }
	$ivrss_type = $atts['type'];
	$ivrss_scrollercount = $atts['display'];
	$ivrss_scrollerheight = $atts['height'];
	$ivrss_random = $atts['random'];

	if(!is_numeric(@$ivrss_scrollercount)) { @$ivrss_scrollercount = 2 ;}
	if(!is_numeric(@$ivrss_scrollerheight)) { @$ivrss_scrollerheight = 100; }
	
	$sSql = "select * from ".WP_ivrss_TABLE." where 1=1";
	if($ivrss_type <> ""){ $sSql = $sSql . " and ivrss_type='".$ivrss_type."'"; }
	if($ivrss_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY ivrss_order"; }
	
	$data = $wpdb->get_results($sSql);
	
	if ( ! empty($data) ) 
	{
		$ivrss_count = 0;
		foreach ( $data as $data ) 
		{
			$ivrss_path = $data->ivrss_path;
			$ivrss_link = $data->ivrss_link;
			$ivrss_target = $data->ivrss_target;

			$dis_height = $ivrss_scrollerheight."px";
			
			$ivrss_html = $ivrss_html . "<div class='cas_div' style='height:$dis_height;padding:2px 0px 2px 0px;'>"; 
			$ivrss_html = $ivrss_html . "<a style='text-decoration:none' target='$ivrss_target' class='cas_div' href='$ivrss_link'><img border='0' src='$ivrss_path' /></a>";
			$ivrss_html = $ivrss_html . "</div>";
			
			$ivrss_js = $ivrss_js . "ivrss_array[$ivrss_count] = '<div class=\'cas_div\' style=\'height:$dis_height;padding:2px 0px 2px 0px;\'><a style=\'text-decoration:none\' target=\'$ivrss_target\' href=\'$ivrss_link\'><img border=\'0\' src=\'$ivrss_path\'></a></div>'; ";	
			
			$ivrss_count++;
		}
	
		$ivrss_scrollerheight = $ivrss_scrollerheight + 4;
		if($ivrss_count >= $ivrss_scrollercount)
		{
			$ivrss_count = $ivrss_scrollercount;
			$ivrss_height = ($ivrss_scrollerheight * $ivrss_scrollercount);
		}
		else
		{
			$ivrss_count = $ivrss_count;
			$ivrss_height = ($ivrss_count*$ivrss_scrollerheight);
		}
		$ivrss_height1 = $ivrss_scrollerheight."px";
		
		$ivrss_pluginurl = get_option('siteurl') . "/wp-content/plugins/image-vertical-reel-scroll-slideshow";
		
		$ivrss = $ivrss .'<div style="padding-top:8px;padding-bottom:8px;">';
			$ivrss = $ivrss .'<div style="text-align:left;vertical-align:middle;text-decoration: none;overflow: hidden; position: relative; margin-left: 1px; height:'.$ivrss_height1.'" id="ivrss_holder2">';
				$ivrss = $ivrss . $ivrss_html;
			$ivrss = $ivrss .'</div>';
		$ivrss = $ivrss .'</div>';
		//$ivrss = $ivrss .'<script type="text/javascript" src="'.$ivrss_pluginurl.'/image-vertical-reel-scroll-slideshow.js"><script>';
		
        $ivrss = $ivrss .'<script type="text/javascript">' ;
			$ivrss = $ivrss .'var ivrss_array	= new Array();' ;
			$ivrss = $ivrss .'var ivrss_obj	= "";' ;
			$ivrss = $ivrss .'var ivrss_scrollPos 	= "";' ;
			$ivrss = $ivrss .'var ivrss_numScrolls	= "";' ;
			$ivrss = $ivrss .'var ivrss_heightOfElm = "'.$ivrss_scrollerheight.'";' ;
			$ivrss = $ivrss .'var ivrss_numberOfElm = "'.$ivrss_count.'";' ;
			$ivrss = $ivrss .'var ivrss_scrollOn 	= "true";' ;
			$ivrss = $ivrss .'function ivrss_createscroll()' ;
			$ivrss = $ivrss .'{' ;
				$ivrss = $ivrss . $ivrss_js; ;
				$ivrss = $ivrss .'ivrss_obj	= document.getElementById("ivrss_holder2");' ;
				$ivrss = $ivrss .'ivrss_obj.style.height = (ivrss_numberOfElm * ivrss_heightOfElm) + "px";' ;
				$ivrss = $ivrss .'ivrss_content();' ;
			$ivrss = $ivrss .'}' ;
        $ivrss = $ivrss .'</script>' ;
        $ivrss = $ivrss .'<script type="text/javascript">' ;
        	$ivrss = $ivrss .'ivrss_createscroll();' ;
        $ivrss = $ivrss .'</script>' ;
	}
	else
	{
		$ivrss = "No image availabe for the mentioned group! please check the short code.";
	}
	return $ivrss;
}

function ivrss_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page('Image vertical reel scroll slideshow', 'Image vertical reel scroll slideshow', 'manage_options', __FILE__, 'ivrss_admin_options' );
		add_options_page('Image vertical reel scroll slideshow', '', 'manage_options', "image-vertical-reel-scroll-slideshow/image-management.php",'' );
	}
}

function ivrss_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('Image-vertical-reel-scroll-slideshow', 'Image vertical reel scroll slideshow', 'ivrss_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('Image-vertical-reel-scroll-slideshow', array('Image vertical reel scroll slideshow', 'widgets'), 'ivrss_control');
	} 
}

function ivrss_deactivation() 
{

}

function ivrss_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'image-vertical-reel-scroll-slideshow', get_option('siteurl').'/wp-content/plugins/image-vertical-reel-scroll-slideshow/image-vertical-reel-scroll-slideshow.js');
	}	
}

add_action('admin_menu', 'ivrss_add_to_menu');
add_action('wp_enqueue_scripts', 'ivrss_add_javascript_files');
add_action("plugins_loaded", "ivrss_init");
register_activation_hook(__FILE__, 'ivrss_install');
register_deactivation_hook(__FILE__, 'ivrss_deactivation');
?>
