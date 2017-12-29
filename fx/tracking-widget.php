<?php
function bb_tracking_widget() {
	wp_add_dashboard_widget(
             'bb_tracker',         // Widget slug.
             'BB Tracking',         // Title.
             'bb_tracking_output' // Display function.
    );
}
add_action( 'wp_dashboard_setup', 'bb_tracking_widget' );

function bb_tracking_output() {
	// Display whatever it is you want to show.
	$bb_tracking = unserialize(get_option('bb_tracking'));
	echo '<form role="tracker" method="get" class="tracker-form" action="/wp-admin/">'."\n";
	echo '<select name="t">'."\n";

	if(empty($bb_tracking)) {
	    $bb_tracking = array();
	}
	foreach ($bb_tracking as $tracker) {
	    if(count(unserialize(get_option($tracker)))>0){
    	    if($_GET['t'] == $tracker || count($bb_tracking) == 1) {
    	        $status = 'selected';
    	        $show = $tracker;
    	    } else {
    	        unset($status);
    	    }
    	    echo '<option value="'.$tracker.'" '.$status.'>'.$tracker.'</option>'."\n";
	    }
	}
	echo '</select>'."\n";
	echo '<input class="button button-primary" value="Go" name="action" type="submit" >'."\n";
	//echo '<input class="button button-primary" value="Reset" name="action" type="submit" >'."\n";
	echo '</form>'."\n";

	if(isset($show) && ($_GET['action'] == "Go" || !isset($_GET['action']))){
	    $tracked_data = unserialize(get_option($show));
?>
<style>
#bb_tracker td:not(.remove) {min-width: 40px; max-width:250px;padding: 0.25rem 0.5rem; }
#bb_tracker .remove > a {background-color: #eeeeee;color: #bbb; display: block;padding: 0.25rem 0.5rem;width: 9px;}
#bb_tracker .remove > a:hover {background-color: rgba(255, 0, 50, 0.75);color: #ffffff;}
#bb_tracker .remove {width: 25px;padding:0;background-color:#eeeeee;}
#bb_tracker td {border: 1px solid #ddd; vertical-align:top;white-space: nowrap;text-overflow: ellipsis; overflow: hidden;}
#bb_tracker tr td:last-of-type {text-align: right;}
#bb_tracker table {border-collapse: collapse; border-spacing: 0; margin-top: 1rem; width: 100%;}
#bb_tracker td small {display: none; font-size: 0.5rem; line-height: 0.7rem; opacity: 0.6; width:100%; white-space: normal;}
#bb_tracker td:hover small{display: flex; }
</style>
	<?php
	echo '<table>'."\n";
	arsort($tracked_data);
	$n = ($_GET['n']) ? intval($_GET['n']) : 1;
	$total = 0;
	$timestamp = false;
	foreach ($tracked_data as $key => $value) {
	        if(count($value)>=$n && $_GET['remove'] !== $key){
				$transient = ns_.'tracking_'.$key.'_'.$n.'_'.md5( $search_args['filename'] );
				if (false === ($markup = unserialize(get_transient($transient))) || $_GET['refresh'] == 'true') {
					if(false === $timestamp) {
						$markup = '<tr><td class="remove"><a href="?t='.$show.'&action=Go&refresh=true">#</a></td><td>Last Updated</td><td>'.date('j/n G:i', current_time( 'timestamp', 0 )).'</td></tr>'."\n";
						$timestamp = true;
					}

		            $referer = array();
		            foreach ($value as $v) {
		                if( strlen($value[0]["HTTP_REFERER"])>1) $referer[$value[0]["HTTP_REFERER"]][]++;
		            }
		            foreach ($referer as $key2 => $value){
		                $title .= '['.count($referer[$key2]).'] '.$key2.'<br>'."\n";
		            }
		            $markup .= '<tr><td class="remove"><a href="?t='.$show.'&action=Go&remove='.$key.'">X</a></td><td>'.$key.'<small>'.$title.'</small></td><td>'.count($value).'</td></tr>'."\n";
		            $total = $total + count($value);
		            unset($title);

		            set_transient( $transient, serialize($markup, SHORT_TERM ));
            		unset($transient);
		        }
		        echo $markup;
	        }
	    }
    	echo '</table>'."\n";
    	echo $total;
	}

	if($_GET['action'] == "Go" && isset($_GET['remove'])){
	    unset($tracked_data[$_GET['remove']]);
	    update_option($show, serialize($tracked_data));
	}
}
