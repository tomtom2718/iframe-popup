<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class iframepopup_cls_widget
{
	public static function iframepopup_widget_int($arr)
	{
		if ( ! is_array( $arr ) )
		{
			return '';
		}
		
		$iframepopup_session = get_option('iframepopup_session');
		$display = "NO";
		if($iframepopup_session <> "YES")
		{
			$display = "YES";
		}
		else if($iframepopup_session == "YES" && isset($_SESSION['iframe-popup']) <> "YES")
		{
			$display = "YES";
		}
		else if($iframepopup_session == "YES" && isset($_SESSION['popup-with-fancybox']) == "YES")
		{
			$display = "NO";
		}
		
		if($display == "YES")
		{
			$id = isset($arr['id']) ? $arr['id'] : '0';
			$cat = isset($arr['cat']) ? $arr['cat'] : '';
			$data = array();
			$data = iframepopup_cls_dbquery::popup_widget($id, $cat);
			
			if( count($data) > 0 )
			{
				$form = array(
					'id' => $data[0]['id'],
					'title' => $data[0]['title'],
					'url' => $data[0]['url'],
					'width' => $data[0]['width'],
					'height' => $data[0]['height'],
					'transitionin' => $data[0]['transitionin'],
					'transitionout' => $data[0]['transitionout'],
					'centeronscroll' => $data[0]['centeronscroll'],
					'titleshow' => $data[0]['titleshow'],
					'expiration' => $data[0]['expiration'],
					'starttime' => $data[0]['starttime'],
					'overlaycolor' => $data[0]['overlaycolor'],
					'group' => $data[0]['group'],
					'timeout' => $data[0]['timeout']
				);
				require_once(IFRAMEPOP_DIR.'classes'.DIRECTORY_SEPARATOR.'iframe-widget.php');
				$_SESSION['iframe-popup'] = "YES";
			}
		}
	}
}

function iframepopup_shortcode( $atts ) 
{
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	//[iframe-popup id="1" cat=""]
	$id = isset($atts['id']) ? $atts['id'] : '0';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	
	$arr = array();
	$arr["id"] 	= $id;
	$arr["cat"] = $cat;
	echo iframepopup_cls_widget::iframepopup_widget_int($arr);
}

function iframepopup( $id = "", $cat = "" )
{
	$arr = array();
	$arr["id"] 	= $id;
	$arr["cat"] = $cat;
	echo iframepopup_cls_widget::iframepopup_widget_int($arr);
}
?>