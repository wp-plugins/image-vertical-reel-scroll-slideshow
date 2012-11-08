<!--
/**
 *     Image vertical reel scroll slideshow
 *     Copyright (C) 2011 - 2013  www.gopiplus.com
 *     http://www.gopiplus.com/work/2011/05/30/wordpress-plugin-image-vertical-reel-scroll-slideshow/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
-->

<div class="wrap">
  <?php
  	global $wpdb;
    $mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=image-vertical-reel-scroll-slideshow/image-management.php";
    $DID=@$_GET["DID"];
    $AC=@$_GET["AC"];
    $submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['ivrss_link']) <>"")
    {
			if($_POST['ivrss_id'] == "" )
			{
					$sql = "insert into ".WP_ivrss_TABLE.""
					. " set `ivrss_path` = '" . mysql_real_escape_string(trim($_POST['ivrss_path']))
					. "', `ivrss_link` = '" . mysql_real_escape_string(trim($_POST['ivrss_link']))
					. "', `ivrss_target` = '" . mysql_real_escape_string(trim($_POST['ivrss_target']))
					. "', `ivrss_title` = '" . mysql_real_escape_string(trim($_POST['ivrss_title']))
					. "', `ivrss_order` = '" . mysql_real_escape_string(trim($_POST['ivrss_order']))
					. "', `ivrss_status` = '" . mysql_real_escape_string(trim($_POST['ivrss_status']))
					. "', `ivrss_type` = '" . mysql_real_escape_string(trim($_POST['ivrss_type']))
					. "'";	
			}
			else
			{
					$sql = "update ".WP_ivrss_TABLE.""
					. " set `ivrss_path` = '" . mysql_real_escape_string(trim($_POST['ivrss_path']))
					. "', `ivrss_link` = '" . mysql_real_escape_string(trim($_POST['ivrss_link']))
					. "', `ivrss_target` = '" . mysql_real_escape_string(trim($_POST['ivrss_target']))
					. "', `ivrss_title` = '" . mysql_real_escape_string(trim($_POST['ivrss_title']))
					. "', `ivrss_order` = '" . mysql_real_escape_string(trim($_POST['ivrss_order']))
					. "', `ivrss_status` = '" . mysql_real_escape_string(trim($_POST['ivrss_status']))
					. "', `ivrss_type` = '" . mysql_real_escape_string(trim($_POST['ivrss_type']))
					. "' where `ivrss_id` = '" . @$_POST['ivrss_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_ivrss_TABLE." where ivrss_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_ivrss_TABLE." where ivrss_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $ivrss_id_x = htmlspecialchars(stripslashes($data->ivrss_id)); 
		if ( !empty($data) ) $ivrss_path_x = htmlspecialchars(stripslashes($data->ivrss_path)); 
        if ( !empty($data) ) $ivrss_link_x = htmlspecialchars(stripslashes($data->ivrss_link));
		if ( !empty($data) ) $ivrss_target_x = htmlspecialchars(stripslashes($data->ivrss_target));
        if ( !empty($data) ) $ivrss_title_x = htmlspecialchars(stripslashes($data->ivrss_title));
		if ( !empty($data) ) $ivrss_order_x = htmlspecialchars(stripslashes($data->ivrss_order));
		if ( !empty($data) ) $ivrss_status_x = htmlspecialchars(stripslashes($data->ivrss_status));
		if ( !empty($data) ) $ivrss_type_x = htmlspecialchars(stripslashes($data->ivrss_type));
        $submittext = "Update Message";
    }
    ?>
  <h2>Image vertical reel scroll slideshow</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/image-vertical-reel-scroll-slideshow/setting.js"></script>
  <form name="ivrss_form" method="post" action="<?php echo @$mainurl; ?>" onsubmit="return ivrss_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="2" align="left" valign="middle">Enter image url:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ivrss_path" type="text" id="ivrss_path" value="<?php echo @$ivrss_path_x; ?>" size="125" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter target link:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ivrss_link" type="text" id="ivrss_link" value="<?php echo @$ivrss_link_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter target option:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ivrss_target" type="text" id="ivrss_target" value="<?php echo @$ivrss_target_x; ?>" size="50" /> ( _blank, _parent, _self, _new )</td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter image alt text:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ivrss_title" type="text" id="ivrss_title" value="<?php echo @$ivrss_title_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter gallery type (This is to group the images):</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="ivrss_type" type="text" id="ivrss_type" value="<?php echo @$ivrss_type_x; ?>" size="50" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="22%" align="left" valign="middle"><select name="ivrss_status" id="ivrss_status">
            <option value="">Select</option>
            <option value='YES' <?php if(@$ivrss_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if(@$ivrss_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select>
        </td>
        <td width="78%" align="left" valign="middle"><input name="ivrss_order" type="text" id="ivrss_rder" size="10" value="<?php echo @$ivrss_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="2" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="ivrss_redirect()" value="Cancel" type="button" />
              </td>
              <td width="50%" align="right">
			  <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=image-vertical-reel-scroll-slideshow/image-management.php'" value="Go to - Image Management" type="button" />
        	  <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=image-vertical-reel-scroll-slideshow/image-vertical-reel-scroll-slideshow.php'" value="Go to - Gallery Setting" type="button" />
			  <input name="Help1" lang="publish" class="button-primary" onclick="ivrss_help()" value="Help" type="button" />
			  </td>
            </tr>
          </table></td>
      </tr>
      <input name="ivrss_id" id="ivrss_id" type="hidden" value="<?php echo @$ivrss_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_ivrss_TABLE." order by ivrss_type,ivrss_order");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_ivrss_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="10%" align="left" scope="col">Type
              </td>
            <th width="52%" align="left" scope="col">Reference
              </td>
			 <th width="10%" align="left" scope="col">Target
              </td>
            <th width="8%" align="left" scope="col">Order
              </td>
            <th width="7%" align="left" scope="col">Display
              </td>
            <th width="13%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->ivrss_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->ivrss_type)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->ivrss_title)); ?></td>
			<td align="left" valign="middle"><?php echo(stripslashes($data->ivrss_target)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->ivrss_order)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->ivrss_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=image-vertical-reel-scroll-slideshow/image-management.php&DID=<?php echo($data->ivrss_id); ?>">Edit</a> &nbsp; <a onClick="javascript:ivrss_delete('<?php echo($data->ivrss_id); ?>')" href="javascript:void(0);">Delete</a> </td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <table width="100%">
    <tr>
      <td align="right" height="30"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=image-vertical-reel-scroll-slideshow/image-management.php'" value="Go to - Image Management" type="button" />
        <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=image-vertical-reel-scroll-slideshow/image-vertical-reel-scroll-slideshow.php'" value="Go to - Gallery Setting" type="button" />
		<input name="Help" lang="publish" class="button-primary" onclick="ivrss_help()" value="Help" type="button" />
      </td>
    </tr>
  </table>
</div>
<?php include("help.php"); ?>