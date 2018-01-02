<?php

function setup_data($ID, $term = MEDIUM_TERM) {

	if ($_GET['transient'] == 'false') delete_transient(ns_.'var_'.$ID);
	if (false === ($var = get_transient('bb_var_'.$ID))) {

		$var = array();
		$var['meta'] = array();
		global $post;

		if (is_page($ID) || is_single($ID)) {
	    	$var['meta'] = bb_get_post_meta($post->ID);
	    	$var['ancestors'] = get_ancestors($post->ID, get_post_type($post));
	    	$ancestor_string = '';
	    	if (!empty($var['ancestors'])) {
	        	$var['ancestor_string'] = '_'.implode('_', $ancestors);
	    	}
	    	$var['transient_suffix'] = $var['ancestor_string'].'_'.$post->ID;
		} 

		if (is_archive($ID)) {
	        $var['transient_suffix'] = '_'.$post->post_type;
	        $var['archive_page'] = get_page_by_path($post->post_type);
	        $var['meta'] = bb_get_post_meta($var['archive_page']->ID);
	    }

	    set_transient('bb_var_'.$ID, $var, $term);

	}

	// after extract($var):
	// 	$meta
	// 	$ancestors
	// 	$ancestor_string
	// 	$transient_suffix
	// 	$archive_page
	// 	
	
    return $var;

}