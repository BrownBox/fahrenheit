<style>
/* START: <?php echo $section_args['filename'].' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {
	#row-breadcrumbs #breadcrumbs .breadcrumb_last {display: none;}
	.bbconnect {background-color: <?php echo bb_get_theme_mod('bb_colour9');?>; padding: 0.5rem 2rem; border-radius: 4px;}
	.bbconnect_wrapper {margin-bottom: 2rem;}
	.gform_wrapper ul.gfield_checkbox li label, .gform_wrapper ul.gfield_radio li label {vertical-align: text-top!important;}
	.gform_wrapper .gform_footer:not(.top_label) { margin-left: 0!important;}

}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ 

}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ 
	.bbconnect {width: 60%;float: left;}
	


}
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $section_args['filename']; ?> */
</style>
<?php
/*
 * Template Name: Thank you
 */
get_header();
ob_start();
bb_theme::section('name=content&file=content.php&inner_class=row');
$ob = ob_get_clean();
$entry = GFAPI::get_entry( $_GET['e'] );

// if ( is_user_logged_in() ) {
// //     var_dump($entry);
//     var_dump($entry["1.3"], $entry["payment_amount"] );
// }
switch ($_GET['f']) {
    case 31: // checkout form
        $ob = str_replace('%%FirstName%%', $entry["1.3"], $ob);
        $ob = str_replace('%%Amount%%', round(intval($entry["payment_amount"])), $ob);
        break;
    case 34: // checkout form
        $ob = str_replace('%%FirstName%%', $entry["2.3"], $ob);
        break;
}
echo $ob;
get_footer();