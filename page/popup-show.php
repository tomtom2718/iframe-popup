<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_iframepopup_display']) && $_POST['frm_iframepopup_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$iframepopup_success = '';
	$iframepopup_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$result = iframepopup_cls_dbquery::popup_count($did);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', IFRAMEPOP_TDOMAIN); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('iframepopup_form_show');
			
			//	Delete selected record from the table
			iframepopup_cls_dbquery::popup_delete($did);
			
			//	Set success message
			$iframepopup_success_msg = TRUE;
			$iframepopup_success = __('Selected record was successfully deleted.', IFRAMEPOP_TDOMAIN);
		}
	}
	
	if ($iframepopup_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $iframepopup_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e(IFRAMEPOP_PLUGIN_DISPLAY, IFRAMEPOP_TDOMAIN); ?>
	<a class="add-new-h2" href="<?php echo IFRAMEPOP_ADMINURL; ?>&page=iframe-popup&ac=add"><?php _e('Add New', IFRAMEPOP_TDOMAIN); ?></a></h2>
    <div class="tool-box">
	<?php
		$myData = array();
		$myData = iframepopup_cls_dbquery::popup_select(0);
		?>
		<script language="JavaScript" src="<?php echo IFRAMEPOP_URL; ?>page/setting.js"></script>
		<form name="frm_iframepopup_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="iframepopup_group_item[]" /></th>
			<th scope="col"><?php _e('Id', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Title', IFRAMEPOP_TDOMAIN); ?></th>
            <th scope="col"><?php _e('URL', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Width', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Height', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Start Date', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Expiration', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Category', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Overlay Color', IFRAMEPOP_TDOMAIN); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="iframepopup_group_item[]" /></th>
			<th scope="col"><?php _e('Id', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Title', IFRAMEPOP_TDOMAIN); ?></th>
            <th scope="col"><?php _e('URL', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Width', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Height', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Start Date', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Expiration', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Category', IFRAMEPOP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Overlay Color', IFRAMEPOP_TDOMAIN); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['id']; ?>" name="iframepopup_group_item[]"></td>
						<td><?php echo $data['id']; ?></td>
						<td><?php echo stripslashes(substr($data['title'], 0, 25)); ?>...
						<div class="row-actions">
						<span class="edit">
						<a title="Edit" href="<?php echo IFRAMEPOP_ADMINURL; ?>&ac=edit&amp;did=<?php echo $data['id']; ?>"><?php _e('Edit', IFRAMEPOP_TDOMAIN); ?></a> | </span>
						<span class="trash">
						<a onClick="javascript:_iframepopup_delete('<?php echo $data['id']; ?>')" href="javascript:void(0);"><?php _e('Delete', IFRAMEPOP_TDOMAIN); ?></a></span> 
						</div>
						</td>
						<td><a target="_blank" href="<?php echo $data['url']; ?>"><img src="<?php echo IFRAMEPOP_URL; ?>image/link_icon.gif" /></a></td>
						<td><?php echo $data['width']; ?></td>
						<td><?php echo $data['height']; ?></td>
						<td><?php echo substr($data['starttime'],0,10); ?></td>
						<td><?php echo substr($data['expiration'],0,10); ?></td>
						<td><?php echo $data['group']; ?></td>
						<td><?php echo $data['overlaycolor']; ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="10" align="center"><?php _e('No records available.', IFRAMEPOP_TDOMAIN); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('iframepopup_form_show'); ?>
		<input type="hidden" name="frm_iframepopup_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo IFRAMEPOP_ADMINURL; ?>&amp;ac=add"><?php _e('Add New', IFRAMEPOP_TDOMAIN); ?></a>
	  <a class="button add-new-h2" href="<?php echo IFRAMEPOP_ADMINURL; ?>&amp;ac=set"><?php _e('Session Setting', IFRAMEPOP_TDOMAIN); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo IFRAMEPOP_FAV; ?>"><?php _e('Help', IFRAMEPOP_TDOMAIN); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3><?php _e('Plugin configuration option', IFRAMEPOP_TDOMAIN); ?></h3>
	<ol>
		<li><?php _e('Drag and drop the widget (Display entire website)', IFRAMEPOP_TDOMAIN); ?>.</li>
		<li><?php _e('Add popup into specific  post or page using short code', IFRAMEPOP_TDOMAIN); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code', IFRAMEPOP_TDOMAIN); ?></li>
	</ol>
	<p class="description"><?php echo IFRAMEPOP_OFFICIAL; ?></p>
	</div>
</div>