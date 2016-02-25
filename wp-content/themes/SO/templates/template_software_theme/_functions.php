<?php
// INCLUDE THE CORE CART TOOLS
define('WLT_DOWNLOADTHEME',true); 

// INCLUDE GOOGLE FONT
function gfont(){?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'><link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
<?php }
add_action('wp_head','gfont');


// MOVE TOP MENU
function blank(){return; }
add_action('hook_topmenu','blank');

function b2($c){
return $c.str_replace("nav nav-pills","newmenustyle6", str_replace("col-md-8","col-md-12",_design_topmenu()));
}
add_action('hook_header','b2');

function topnm(){ global $CORE, $userdata;
?>
<?php if(!$userdata->ID){ ?>
<div id="topbit" class="hidden-sm hidden-xs">

<form class="form-inline" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post" style="float:right;"> 
<input type="hidden" name="testcookie" value="1" /> 
<input type="hidden" name="rememberme" id="rememberme" value="forever" />  
<input type="hidden" name="redirect_to" value="<?php if(isset($_GET['redirect_to'])){  echo esc_attr($_GET['redirect_to']); }else{ echo $GLOBALS['CORE_THEME']['links']['myaccount']; } ?>" /> 

 
  <div class="form-group">
     
    <input type="text" class="form-control input-sm" name="log" placeholder="<?php echo $CORE->_e(array('login','10')); ?>">
  </div>
 
  <div class="form-group">
     
    <input type="password" class="form-control input-sm" name="pwd"  placeholder="<?php echo $CORE->_e(array('account','10')); ?>">
  </div>
  <input type="submit" name="wp-submit" class="btn btn-default input-sm" value="<?php echo $CORE->_e(array('head','5')); ?>">
 
</form> 

<div class="clearfix"></div>
</div>
<?php } ?>
<?php 

}
add_action('hook_wrapper_before','topnm');
?>