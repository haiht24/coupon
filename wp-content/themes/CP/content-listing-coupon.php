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

<?php global $CORE, $post; 

ob_start(); ?>

<div class="itemdata itemid<?php echo $post->ID; ?> <?php hook_item_class(); ?>" <?php echo $CORE->ITEMSCOPE('itemtype'); ?>>

	<div class="thumbnail">
	 
			<div class="col-md-2 hidden-sm hidden-xs hidden_grid"> 
            
            [IMAGE]
            
            <div class="clearfix"></div>
  
           [RATING style=10]
            
            </div>

			<div class="col-md-10 col-sm-12 col-xs-12">

    			<div class="wrap">    
    	
        			<div class="col-md-8 col-sm-12 col-xs-12">
        
                        <h3>[TITLE]</h3>
                    
                        <p><?php if(!isset($GLOBALS['flag-single'])){ ?>[EXCERPT size=100]<?php } ?></p>
                        
                        [STORE text="<?php echo $CORE->_e(array('coupons','36')); ?> "]
                    
                    </div>
        
                    <div class="col-md-4 col-sm-12 col-xs-12">
                   [CBUTTON]
                    </div>
        
        			<div class="clearfix"></div>
                    
                     <?php if(isset($GLOBALS['flag-single'])){ ?><hr /> [CONTENT] [GOOGLEMAP] <div class="clearfix"></div> <?php } ?>
                     
				</div>
             
   
    		<div class="wrap_extra hidden_grid">
            
            	<div class="pull-right hidden-xs hidden-sm"> <i class="fa fa-comment"></i> [COMMENT_COUNT] <?php echo $CORE->_e(array('single','37')); ?>   <i class='fa fa-star'></i> [FAVS]</div>  
                
                <i class='fa fa-clock-o'></i> [COUPON_END text="<?php echo $CORE->_e(array('coupons','37')); ?> "]
                
            </div>
        
 
	</div>
 <div class="clearfix"></div>
	</div>
 
</div>
 
<?php 
$SavedContent = ob_get_clean(); 

echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_content_listing($SavedContent))); ?>  