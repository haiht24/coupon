<?php
/* 
* Theme: PREMIUMPRESS CORE FRAMEWORK FILE
* Url: www.premiumpress.com
* Author: Mark Fail
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
?>

<?php global $post, $CORE;

 
ob_start();
?>
<a name="toplisting"></a>

<div class="wlt_search_results row list_style">

	<?php get_template_part( 'content', 'listing-coupon' ); ?> 

</div>

[COMMENTS]

<hr />

<h4><?php echo $CORE->_e(array('single','0')); ?></h4>

<hr />

[RELATED]

<?php $SavedContent = ob_get_clean(); 
echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_content_single_listing($SavedContent)));

?>