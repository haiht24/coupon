<?php
// ADD IN AUCTION
define('WLT_COUPON',true);

// INCLUDE GOOGLE FONT
function gfont(){?>
<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
<?php }
add_action('wp_head','gfont');

// ADD IN TOOLTIP JS TO FOOTER
function fextra(){ if(!defined('IS_MOBILEVIEW')){ ?>
<script>
jQuery(document).ready(function(){
jQuery('.thumbs span').tooltip();
});
</script>
<?php } }
add_action('wp_footer','fextra');
 
// HOOK ADMIN STYLES TO INCLUDE CHILD THEME STYLING
function _ct_new_styles($c){ global $CORE, $STRING;

		if(isset($_POST['shownewcode']) && $_POST['shownewcode'] == "save" && isset($GLOBALS['CORE_THEME']['colors']['header']) && strlen($GLOBALS['CORE_THEME']['colors']['header']) > 1){
			$STRING .= "#core_menu_wrapper .row, #wlt_smalldevicemenubar a.b1 { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['header'])."; border:0px; }";
		 	 
			 
			$STRING .= " #core_middle_column .panel-default>.panel-heading { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar'])."; }";
			$STRING .= "\n";
			 
	 	 		 
		}	
		
		// THIS ONLY HAPPENS WHEN WE USE THE PRE-DEFINED COLORS
		// SO WE COULD USE THIS TO HARD CODE ADDITONAL STYLING CHANEGS
		if(isset($_POST['shownewcode']) && $_POST['shownewcode'] == "save" && isset($GLOBALS['CORE_THEME']['colors']['header']) && strlen($GLOBALS['CORE_THEME']['colors']['header']) > 1){

		$STRING .= "#core_header_navigation .row { background:transparent; }";		
		}	 
		
return $c.$STRING;
}
add_action('hook_styles_code_filter','_ct_new_styles');
?>