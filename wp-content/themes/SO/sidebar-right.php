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

<?php global $CORE; ?>
<aside class="<?php $CORE->CSS("columns-right"); ?> <?php if(isset($GLOBALS['CORE_THEME']['mobileview']['sidebars']) && $GLOBALS['CORE_THEME']['mobileview']['sidebars'] == '1'){ }else{ ?>hidden-xs<?php } ?>" id="core_right_column">
     
	<?php hook_core_columns_right_top(); ?>
 
    <?php dynamic_sidebar('Right Column'); ?>
           
	<?php hook_core_columns_right_bottom(); ?>
         
</aside>