<?php

class core_coupons extends white_label_themes {

/* =============================================================================
	  MOBILE ADJUSTMENTS
	========================================================================== */
	
	function mobile_header(){ ?>
    <style>
    .home h4 { margin:0px; padding:0px; margin-left:-10px; margin-right:-10px; line-height:50px; border-top:1px solid #ccc; margin-top:30px; padding-left:20px; background:#fff; }
    .storelist { background:#fff; margin-left:-10px; margin-right:-10px; margin-bottom:-20px; border-top:1px solid #ddd;  }
    .storelist li { border-bottom:1px solid #ddd; padding-top:5px; padding-bottom:5px; font-size:14px; line-height:40px; }
    .storelist i { margin-top:12px; color:#ddd;   }
    .storelist .col-xs-2 { padding:0px; }
    .storelist .col-xs-2 img { margin-left:2px; margin-top:10px; }
	.wlt_thumbs_style1 { margin:0px !important; padding:0px;  }
	.wlt_thumbs_style1 .btn { padding:0px; margin-right:10px; background:none; color:#999; font-weight:bold; font-size:12px; }
	.wlt_thumbs_style1 .btn i { color:#999; font-size:12px; }
	.searchblock .wlt_shortcode_code:before { content: "\e032"; padding-right:5px; font-family: 'Glyphicons Halflings'; font-size:7px; }
	</style>
    <?php }
	function mobile_footer(){ } 	
	function mobilesearchcontent(){ $GLOBALS['CUSTOMMOBILECONTENT'] = true; global $post; ?>
	<div style="padding:15px;">
	<h2 style="font-weight:bold;"><a href="<?php echo home_url(); ?>/out/<?php echo $post->ID; ?>/link/">[TITLE-NOLINK]</a></h2>
    [code]
	[EXCERPT size=60]
	</div>
	<div style="background:#eee; height:30px; padding:5px; font-size:11px; text-transform:uppercase; color:#999; font-weight:bold; ">
	<div class="row">
	 
    <div class="col-md-4 col-xs-5" style="font-size:10px;">[RATING style=2] </div> 
	<div class="col-md-8 col-xs-7 text-right" style="font-size:10px;">Ends: [COUPON_END small=1] </div> 
	</div>     
	</div>
	<?php }
	
	function hook_mobile_content_homepage($c){  global $wpdb, $CORE;	
	 
	if($GLOBALS['CORE_THEME']['mobileweb_homesetup'] != '4'){  return $c; }	
	ob_start();
	?>
    
    <a href="<?php echo home_url(); ?>/" id="logo1"><?php echo $GLOBALS['CORE_THEME']['mobileweb_logo']; ?></a>
    <div class="clearfix"></div>
    
    <h4><?php echo $CORE->_e(array('coupons','38')); ?></h4>
    <div class="storelist">
    <ul>
    <?php 
    
    $args = array(
                  'taxonomy'     => 'store',
                  'orderby'      => 'count',
                  'order'		=> 'desc',
                  'show_count'   => 0,
                  'pad_counts'   => 1,
                  'hierarchical' => 0,
                  'title_li'     => '',
                  'hide_empty'   => 0,
                 
    );
    $categories = get_categories($args);  $nc = 1;		
    foreach ($categories as $category) {
    
     
    // hide none parents
    if($category->parent != 0){ continue; } 
             
        $LINK 	= get_term_link($category->slug, 'store');
        $NAME 	= $category->name;			 
                
        if(isset($category->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_'.$category->term_id]) ){
        $IMG = $GLOBALS['CORE_THEME']['category_icon_'.$category->term_id];
        }
                
        if($IMG == ""){ $IMG = "http://placehold.it/245x100"; }
        $DESC 	= $category->category_description;
         
    ?>
    <li>
    
        <a href="<?php echo $LINK; ?>" class="clearfix" style="position:relative"> 
            <div class="col-md-2 col-xs-2">
             <?php if(strlen($IMG) > 1){ ?><img src="<?php echo $IMG; ?>" alt="cat" class="img-responsive" /><?php } ?>
            </div>
            <div class="col-md-10 col-xs-10">
             <i class="glyphicon glyphicon-chevron-right pull-right"></i>
            <?php echo $NAME; ?> (<?php echo $category->count; ?>)
            </div>				 
        </a>
     
    </li>       
    <?php $i++; } ?>
    </ul>
    </div>
    <?php 
	
	return  ob_get_clean();
	}


	function hook_admin_1_tab1_mobile_homelist(){ global $wpdb; $core_admin_values = get_option("core_admin_values"); 
	?>
	<option <?php selected( $core_admin_values['mobileweb_homesetup'], "4" );  ?> value="4">Popular Stores</option>
	<?php
	}
	
	function core_coupons(){ global $wpdb;	
  	
		if(is_admin()){
		
		add_action('hook_admin_1_tab1_tablist', array($this, '_new_admin_tab'  ) ); 
		add_action('hook_admin_1_tab1_newsubtab', array($this, 'wlt_coupon_field_menu'  ) ); 	
		add_action('hook_admin_2_tags_search', array($this,'wlt_coupon_new_tags') );	  
		}
		
		// MOBILE FUNCTIONS
		add_action('hook_admin_1_tab1_mobile_homelist', array($this, 'hook_admin_1_tab1_mobile_homelist') );
		add_action('hook_mobile_header', array($this, 'mobile_header' ) );
		add_action('hook_mobile_footer', array($this, 'mobile_footer' ) );
		add_action('hook_mobile_content_output', array($this, 'mobilesearchcontent' ), 1 );
		add_action('hook_mobile_content_homepage', array($this, 'hook_mobile_content_homepage' ) );
		
		// ADD HIDE EXPIRED OPTIONS
		//add_action('hook_gallerypage_results_btngroup', array($this, '_btngroup' ) );

		
		// HOOK ALL CUSTOM QUERIES TO REMOVE EXPIIRED COUPONS FROM DISPLAY
	 	add_action('hook_custom_queries',  array($this, '_hook_custom_query' ) );
	 
		// ADD HOOK INTO CUSTOM SEARCH FOR STORE ID
		add_action('hook_wlt_core_search', array($this, '_customsearch' ));
		// NEW TAXONOMIES
		if(strlen(get_option('premiumpress_storeslug')) > 1){ $store_slug_name = get_option('premiumpress_storeslug'); }else{ $store_slug_name = 'store'; }
		register_taxonomy( 'store', THEME_TAXONOMY.'_type', array( 'hierarchical' => true, 'labels' => array('name' => 'Stores') , 'query_var' => true, 'rewrite' => true, 'rewrite' => array('slug' => $store_slug_name) ) );  
		// FOOTER JAVASCRIPT
		add_action('wp_footer', array($this, '_new_js' ));
		// HOOK SUBMISSION PAGE AND ADD IN CORE FIELDS
		if(get_option('coupon_defaults') != '1'){	 
	 	add_action('hook_add_fieldlist',  array($this, '_hook_customfields' ) );
		add_action('hook_custom_fields_filter', array($this, '_remove_oldfields') );
		add_action('hook_fieldlist_0', array($this, '_blankfields' ) );
		}
		// ADD COUPON IMAGE FALLBACK 
		add_action('hook_fallback_image_display', array($this, 'wlt_coupon_fallback_image_tostore'  ));
		// REGISTER COUPON WIDGETS
		register_widget( 'core_widgets_stores' );
		register_widget( 'core_widgets_store_description' );
		// COUPON ACTIVATED SHORTCODES	
		add_shortcode( 'STORES', array($this,'wlt_shortcode_stores') );
		add_shortcode( 'STORE', array($this,'wlt_shortcode_store') );
		add_shortcode( 'COUPON', array($this,'wlt_shortcode_coupon') );
		add_shortcode( 'COUPON_START', array($this,'wlt_shortcode_coupon_starts') );
		add_shortcode( 'COUPON_END', array($this,'wlt_shortcode_coupon_ends') );
		add_shortcode( 'CBUTTON', array($this,'wlt_shortcode_coupon_button') );
		// LOAD UP WINDOW FOR COUPON CODE
		if(isset($_GET['cpop']) && is_numeric($_GET['cpop']) ){	
			die($this->cpop($_GET['cpop']));
		}	
		// CUSTOM STORE SLUG
		add_action('admin_footer', array($this, 'custom_permalinks') );
		
		// CHECK IF ITS EXPIRED
		add_action('hook_content_listing_class', array($this, '_hook_content_listing_class') );
	}
 
	function _btngroup($c){ global $CORE; 
	
	echo $c;
	?>
	 
	<span class="hidexpiredop btn btn-default btn-sm "> <input type="checkbox" value="1" class="pull-left" style="margin-right:5px;" id="wlt_hide_expired"> <?php echo $CORE->_e(array('coupons','33')); ?></span> 
	<script>
	jQuery(document).ready(function(){ 
		jQuery('#wlt_hide_expired').on( "click", function() { 
			if (this.checked) {
			jQuery('.expired').hide();		
			}else{
			jQuery('.expired').show();
			} 
		});
		//jQuery('.expired').hide();
	});
	</script> 
	<?php  }
	
	function _hook_content_listing_class($c){ global $post; 
		
		// CHECK IF ITS EXPIRED
		$date = get_post_meta($post->ID,'expiry_date',true);
		if($date != "" && strtotime($date) < strtotime(current_time( 'mysql' )) ) {
		$c .= " expired";
		}		
		return $c;	
	}
	function _customsearch(){	
	
		if(isset($GLOBALS['CORE_THEME']['hide_expired']) && $GLOBALS['CORE_THEME']['hide_expired'] == '1' && $GLOBALS['CORE_THEME']['coupon_defaults'] != 1){	
			$GLOBALS['custom'][] = array(
					'key' => 'expiry_date',
					'value' => current_time( 'mysql' ),
					'compare' => '>',
					'orderby' => 'date'									 
			);	
		}
	
		if(isset($_GET['storeid']) && is_numeric($_GET['storeid']) ){
			// ADD ON TAXONOMY QUERY FOR STORE
			$GLOBALS['taxonomies'][] = array(
					'taxonomy' => 'store',
					'field' => 'term_id',
					'terms' => array( $_GET['storeid'] ),
					'operator'=> 'IN'						
			);
		}	
	}
	function _hook_custom_query($c){
	return $c;
	if(isset($GLOBALS['CORE_THEME']['hide_expired']) && $GLOBALS['CORE_THEME']['hide_expired'] == '1' && $GLOBALS['CORE_THEME']['coupon_defaults'] != 1){	
	$args = array(
			'post_type' => THEME_TAXONOMY."_type",
			'meta_query' => array(
				array(
					'key' => 'expiry_date',
					'value' => current_time( 'mysql' ),
					'compare' => '>',
					'type' => 'date'
				),
			),
		);
	// MERGE VALUES
	$c = array_merge($c,$args);
	}
	return $c;
	}
	
	// ADD IN CORE FIELDS TO THE ADMIN
	function _blankfields($c){ global $CORE;
	
	$coupon_fields = array (
		"tab4" => array("tab" => true, "title" => "Coupon Theme Extras" ),
		
		"coupon_type" => array("label" => "Coupon Type", "values" => array("1" => "Website Coupon", "2" => "Printable Coupon",  "3" => "Offer") ), 	 
		"printable" => array("label" => "Printable", "values" =>array("0"=>"no", "1"=>"yes" ) ), 
		
		"code" => array("label" => "Coupon Code", ), 
		"link" => array("label" => "Affiliate Link", "desc" => "This is the link the user will be taken too."), 
		"start_date" => array("label" => "Coupon Start Date", "desc" => "Format: 2013-09-12 05:18:06", "dateitem" => true   ), 
		"expiry_date" => array("label" => "Coupon Expiry Date", "desc" => "Format: 2013-09-12 05:18:06", "dateitem" => true  ), 
		
		
	);
	 
	return array_merge($c,$coupon_fields);
	}
	function custom_permalinks(){ global $pagenow;
	
		if($pagenow == "options-permalink.php" ){ 
		
		
		$default_perm = get_option('premiumpress_storeslug');
		if($default_perm == ""){
		$default_perm = 'store';
		}
	  
			echo "<script> 
			jQuery(document).ready(function(){
				jQuery('table.permalink-structure').prepend( '<tr><th><label><input type=\"hidden\" name=\"submitted\" value=\"yes\">Coupon Store Slug</label></th><td> <input name=\"adminArray[premiumpress_storeslug]\" type=\"text\" value=\"".$default_perm."\" class=\"regular-text code\"><p><p>IMPORTANT. This option will let you change the slug display name from /store/ to your chosen value however doing so will change all of your existing store permalinks.</p></td></tr>' );
			});
			</script>";		
		
		}
	}
	function _remove_oldfields($c){
	if(!is_array($c)){ return $c; }
	
	$removeme = array('code','printable','link','start_date','expiry_date');
	foreach($c as $k=>$v){
		if(in_array($v['key'],$removeme)){ unset($c[$k]); }	
	}
	
	return $c;
	}
	function _hook_customfields($c){ global $CORE;
	
		$o = 50;
		
		$c[$o]['title'] 	= $CORE->_e(array('coupons','8'));
		$c[$o]['name'] 		= "coupon_type";
		$c[$o]['type'] 		= "select";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['listvalues'] 	= array("1" => $CORE->_e(array('coupons','9')), "2" => $CORE->_e(array('coupons','10')),  "3" => $CORE->_e(array('coupons','11')));
		$c[$o]['help'] 		= "<script>jQuery('#form_coupon_type').change(function(e) { if(jQuery('#form_coupon_type').val() == '2'){ jQuery('#form_printable').val('yes'); jQuery('#form-row-rapper-code').hide(); } else if(jQuery('#form_coupon_type').val() == '3'){ jQuery('#form-row-rapper-code').hide(); } else { jQuery('#form-row-rapper-code').show(); jQuery('#form_printable').val('no');  } }); </script> ";
		$o++;
		
		$c[$o]['title'] 	= "";
		$c[$o]['name'] 		= "printable";
		$c[$o]['type'] 		= "hidden";
		$c[$o]['values'] 	= "no";
		$c[$o]['class'] 	= "form-control";
		$o++;		
		
		$c[$o]['title'] 	= $CORE->_e(array('coupons','12'));
		$c[$o]['name'] 		= "code";
		$c[$o]['type'] 		= "text";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['help'] 		= $CORE->_e(array('coupons','13'));
		$c[$o]['required'] 	= false;
		$o++;
		
		$c[$o]['title'] 	= $CORE->_e(array('coupons','14'));
		$c[$o]['name'] 		= "link";
		$c[$o]['type'] 		= "text";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['help'] 		= $CORE->_e(array('coupons','15'));
		$c[$o]['defaultvalue'] 	= "http://";
		$o++;
		
		$c[$o]['title'] 	= $CORE->_e(array('coupons','16'));
		$c[$o]['name'] 		= "start_date";
		$c[$o]['type'] 		= "date";
		$c[$o]['class'] 	= "form-control";
 		 
		$o++;
		
		$c[$o]['title'] 	= $CORE->_e(array('coupons','17'));
		$c[$o]['name'] 		= "expiry_date";
		$c[$o]['type'] 		= "date";
		$c[$o]['class'] 	= "form-control";
 		
				
		return $c;
	}	

	function _new_admin_tab(){	
	echo '<li><a href="#coupontab" data-toggle="tab"><span class="sh6">Coupon Settings</span></a></li>';
	}
	// FOOTER JS FOR COUPON POP-UP
	function _new_js(){?>
    <script src="<?php echo get_bloginfo('template_url'); ?>/framework/js/jquery.zclip.js" type="text/javascript"></script>	
	<script type="application/javascript">    
    var windowSizeArray = [ "width=200,height=200",  "width=300,height=400,scrollbars=yes" ];                                        
        jQuery(".cbtn").click(function (e) {   	  
          var url = "<?php echo get_home_url(); ?>/?cpop="+jQuery(this).attr('title');
          var windowName = "popUp";//$(this).attr("name");
          var windowSize = windowSizeArray[1];
          window.open(url, windowName, windowSize);
		  window.location.href = jQuery(this).attr('href');
		  e.preventDefault();
        });		
    </script>	
	<?php }
	// POP-UP PAGE CODE
	function cpop($id){ global $CORE; 
	if(!function_exists('get_the_post_thumbnail')){
	require getcwd() . "/wp-includes/post-thumbnail-template.php";
	}	 
	// INCLUDE LANGUAGE
	$CORE->Language();
	/*** get post content ***/
	$post = get_post($id); 
	$code = get_post_meta($post->ID,$GLOBALS['CORE_THEME']['coupon']['code_key'],true);		
	/*** update view counter ***/
	update_post_meta($post->ID,'hits',get_post_meta($post->ID,'hits',true)+1);
	/*** get image ***/
	$image = hook_image_display(get_the_post_thumbnail($post->ID, 'thumbnail', array('class'=> "wlt_thumbnail")));	 		
	if($image == ""){$image = hook_fallback_image_display($CORE->FALLBACK_IMAGE($post->ID)); }	
	 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!--[if lte IE 8 ]><html lang="en" class="ie ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="ie"><![endif]-->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

    <title><?php echo $post->post_title; ?></title>
    <meta name="robots" content="noindex"/>
    <meta name="author" content="www.premiumpress.com">
    <style>
	body { background:#efefef; font-family:Arial, Helvetica, sans-serif; font-size:14px; }
	.wlt_thumbnail { float:right; max-width:100px; max-height:60px; }
	.alert-success {color: #468847;background-color: #dff0d8;border-color: #d6e9c6;}
	.alert {padding: 8px 35px 8px 14px;margin-bottom: 20px;text-shadow: 0 1px 0 rgba(255,255,255,0.5);background-color: #fcf8e3;border: 1px solid #fbeed5;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
	</style>
    </head>
    <body>   
    <div style="padding:20px; border-radius:20px;background:#fff;">
    <div style=""><?php echo $image; ?></div>
    <b style="line-height:30px;"><?php echo esc_html($post->post_title); ?></b>
    <div style="clear:both;"></div>
    <?php if($code != "" && !is_array($code)){ ?>
    <div style="font-size:10px;"><?php echo $CORE->_e(array('coupons','19')); ?></div>    
    <p style="color:orange; font-size:18px; text-align:center;padding:10px; border:1px dashed #ddd;"><?php echo $code; ?></p>  
    <?php }else{ ?>
    <hr />
    <p style="font-size:11px; text-align:center;"><?php echo $CORE->_e(array('coupons','20')); ?></p>
    <?php } ?>  
    </div>
    
    <?php echo stripslashes(do_shortcode(get_option('coupon_popup_custom'))); ?>
    
    <?php if($GLOBALS['CORE_THEME']['coupon_popup_newsletter'] != '0'){ ?>
    <div style="padding:20px; border-radius:20px;background:#fff; margin-top:30px;padding-top:10px;">
    <p><?php echo $CORE->_e(array('coupons','21')); ?></p>
    <form class="form-search" id="mailinglist-form" name="mailinglist-form" method="post" onSubmit="IsEmailMailinglist();return false;">
          <input type="text" class="input-medium" name="wlt_mailme" id="wlt_mailme" placeholder="example@hotmail.com">
          <button type="submit" class="btn"><?php echo $CORE->_e(array('coupons','22')); ?></button>
        </form>
    </div>   
    <script src="<?php echo get_bloginfo('template_url'); ?>/framework/js/core.ajax.js" type="text/javascript"></script>

      <script type="application/javascript">
		function IsEmailMailinglist(){
		var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
			var de4 	= document.getElementById("wlt_mailme");
			if(de4.value == ''){
			alert('<?php echo $CORE->_e(array('coupons','23')); ?>');
			de4.style.border = 'thin solid red';
			de4.focus();
			return false;
			}
			if( !pattern.test( de4.value ) ) {	
			alert('<?php echo $CORE->_e(array('coupons','23')); ?>');
			de4.style.border = 'thin solid blue';
			de4.focus();
			return false;
			}
			WLTMailingList('<?php echo str_replace("http://","",get_home_url()); ?>', this.wlt_mailme.value, 'mailinglist-form');
		}		
		 </script>
        <?php } ?>
          
    </body>
    </html>	
	<?php }
	
	function wlt_shortcode_coupon_button( $atts, $content = null  ){
	
		global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = 'text';
		
		extract( shortcode_atts( array('class' => '' ), $atts ) );
		 
		$can_print = get_post_meta($post->ID,"printable",true);	
		$coupon_type = get_post_meta($post->ID,"coupon_type",true);	
		if($coupon_type == 2){ $can_print = "yes"; }
	
		if($can_print == "yes" || $can_print == 1){
		
			$pl = get_permalink($post->ID);		 
			if(substr($pl,-1) != "/"){ $print_link = $pl."&print=true&amp;pid=".$post->ID; }else{ $print_link = $pl."/?print=true&amp;pid=".$post->ID; }
		
			return "<a href='".$print_link."' title='".$post->ID."' target='_blank' rel='nofollow' class='btn btn-success pbtn'>".$CORE->_e(array('button','23'))."</a>";
	
		}else{
		
			// CHECK IT HAS A COUPON
			$has_code 		= get_post_meta($post->ID,"code",true);	
			$coupon_style 	= $GLOBALS['CORE_THEME']['coupon_style'];
			
			switch($coupon_style){
				
				case "1": { // CLICK TO REVEAL
				
					if($has_code == ""){
				
					return "<div class='clicktoreveal green' id='".$post->ID."_clicktoreveal'>
					<div class='overlay none'> ".$CORE->_e(array('coupons','34'))." </div>
					 
					</div>
					
					<script>
					jQuery('#".$post->ID."_clicktoreveal').on( \"click\", function() {					 
					window.open(  '".get_home_url()."/out/".$post->ID."/".$GLOBALS['CORE_THEME']['coupon']['code_link']."/',  '_blank' );					});
					
					</script>
					";
					}else{
					
					 	return "<div class='clicktoreveal green' id='".$post->ID."_clicktoreveal'>
						<div class='overlay'> ".$CORE->_e(array('coupons','35'))."</div>
						<div class='code'>".$has_code."</div>
						</div>
						
						<script>
						jQuery('#".$post->ID."_clicktoreveal').on( \"click\", function() {						
						jQuery('#".$post->ID."_clicktoreveal .overlay').hide();
						jQuery('#".$post->ID."_clicktoreveal .code').css('text-align','center');						
						window.open(  '".get_home_url()."/out/".$post->ID."/".$GLOBALS['CORE_THEME']['coupon']['code_link']."/',  '_blank' );
						});						
						</script>
						";
					
					}
				
				} break;
				
				
				case "3": { // CLICK TO COPY
				
				return do_shortcode('[COUPON]');
				
				} break;
				
				default: { // CLICK TO OPEN
				
				if($has_code != ""){
				return "<a href='".get_home_url()."/out/".$post->ID."/".$GLOBALS['CORE_THEME']['coupon']['code_link']."/' title='".$post->ID."' rel='nofollow' class='btn btn-primary cbtn col-xs-12 ".$class."'  target='_blank'>".$CORE->_e(array('button','34'))."</a>";
				}else{
				return "<a href='".get_home_url()."/out/".$post->ID."/".$GLOBALS['CORE_THEME']['coupon']['code_link']."/' title='".$post->ID."' rel='nofollow' class='btn btn-primary cbtr col-xs-12 ".$class."' target='_blank'>".$CORE->_e(array('button','40'))."</a>";
				}
				
				} break;
			
			}
	 
			
		
		}
	}
	function wlt_shortcode_stores( $atts, $content = null ) {
	
			global $userdata, $CORE, $post, $shortcode_tags; 
		
			extract( shortcode_atts( array('icon' => "yes", 'limit' => 100, 'perrow' => 4  ), $atts ) );
			 
			return do_shortcode('[TAXONOMY name=store icon='.$icon.' limit='.$limit.' perrow='.$perrow.']');
	}	
	function wlt_shortcode_store( $atts, $content = null ) {
	
			global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = 'text';
		
			extract( shortcode_atts( array('text' => $default_options  ), $atts ) );
			 
			$store = "";
			$store_list = get_the_terms($post->ID, "store" );
			if(is_array($store_list)){
				foreach($store_list as $st){
					$store .= "<span class='wlt_shortcode_store'><a href='".get_term_link($st->slug, "store")."'>".esc_attr($text)."".$st->name."</a></span>";
				}	
			return $store;
			}
	}
	function wlt_shortcode_coupon( $atts, $content = null ) {
	
			global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = '';
		
			extract( shortcode_atts( array('text' => $default_options  ), $atts ) );
		  	
			// CHECK WE HAVE A COUPON CODE
			if(!isset($GLOBALS['CORE_THEME']['coupon']['code_key']) || $GLOBALS['CORE_THEME']['coupon']['code_key'] == ""){ return $c; }	
			// GET VALUE
			$code = get_post_meta($post->ID,$GLOBALS['CORE_THEME']['coupon']['code_key'],true);	
		 	$link = get_post_meta($post->ID,$GLOBALS['CORE_THEME']['coupon']['code_link'],true);	
		 
			// BUILD OUTPUT FOR MOBILE
			if($GLOBALS['CORE_THEME']['responsive'] == 1 && $code != "" ){ 
			$STRING .='<div class="coupon_wrapper visible-xs coupon_code">
			<a href="'.$link.'" rel="nofollow">'.$code.'</a>
			</div>';
			}
			// BUILD OUTPUT FOR DESKTOP	
			if($code != "" && strlen($code) > 1){
			$STRING .='<div class="coupon_outter_wrapper visible-lg"><span class="coupon_wrapper_text">'.esc_attr($text).'</span><span class="coupon_wrapper "> 
		<a id="coupon_code_feat_'.$post->ID.'" class="coupon_code"  data-toggle="tooltip" title="'.$CORE->_e(array('coupons','24')).'"><i class="fa fa-scissors"></i> '.$code.'</a>
			</span></div>';			 
								
			$STRING .= "<script language='javascript' type='text/javascript'>
			 jQuery(document).ready(function(){";
			 
			 if(!defined('IS_MOBILEVIEW')){
			 $STRING .= "jQuery('#coupon_code_feat_".$post->ID."').tooltip();";
			 }
			 
				$STRING .= "jQuery('#coupon_code_feat_".$post->ID."').zclip({				
					path:'".FRAMREWORK_URI."js/ZeroClipboard.swf',
					copy:jQuery('#coupon_code_feat_".$post->ID."').text(),
					afterCopy:function(){
						window.open(  '".get_home_url()."/out/".$post->ID."/".$GLOBALS['CORE_THEME']['coupon']['code_link']."/',  '_blank' );
					}	
				}); 
				 
			});
			
			jQuery('#wlt_search_tab2').on( 'click', function() {
			
				jQuery('#coupon_code_feat_".$post->ID."').zclip('remove');  
				setTimeout(function(){ 				
					jQuery('#coupon_code_feat_".$post->ID."').zclip({				
						path:'".FRAMREWORK_URI."js/ZeroClipboard.swf',
						copy:jQuery('#coupon_code_feat_".$post->ID."').text(),
						afterCopy:function(){
							window.open(  '".get_home_url()."/out/".$post->ID."/".$GLOBALS['CORE_THEME']['coupon']['code_link']."/',  '_blank' );
						}	
					}); 				
				
				}, 1000);
				
			});
			 
			
			</script>"; /**/
			
			}elseif(strlen($link) > 1){			
				$STRING .= '<a href="'.$link.'" target="_blank" class="btn" rel="nofollow">'.$CORE->_e(array('button','12')).'</a>';
			}
			
	  return $STRING; 
	
	}
	function wlt_shortcode_coupon_starts( $atts, $content = null ) {
	
			global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = 'text';
		
			extract( shortcode_atts( array('text' => $default_options  ), $atts ) );
			$options = explode("|",esc_attr($type));
			// GET VALUE
			$date = get_post_meta($post->ID,'start_date',true);
			// ADD IN END DTATE IF NONE IS SET
			if($date == ""){ $STRING = "recently"; }else{  $STRING = esc_attr($text)."".hook_date($date); }
			// RETURN VALUE
			return "<span class='wlt_shortcodes_start_date'>".$STRING."</span>"; 
	}
	 function wlt_shortcode_coupon_ends( $atts, $content = null ) {
	
			global $userdata, $wpdb, $CORE, $post, $shortcode_tags; $STRING = ""; 
		
			extract( shortcode_atts( array('text' => "", 'id' => '', 'small' => false  ), $atts ) );
			 
			$id = esc_attr($id);
			// WHICH ID TO USE
			if($id != "" && is_numeric($id)){ $ThisId = $id; }else{ $ThisId = $post->ID; }
			// GET VALUE
			$date = get_post_meta($ThisId,'expiry_date',true);
			if($date == ""){
			$date = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE post_id =('".$ThisId."') AND meta_key=('expiry_date') LIMIT 1" );
			}			
			// ADD IN END DTATE IF NONE IS SET
			if($date == ""){ $STRING = $CORE->_e(array('add','59')); }else{	
					
				// CHECK IF ITS EXPIRED			 
				if(strtotime(date("Y-m-d H:i:s", strtotime($date) ) ) < strtotime(current_time( 'mysql' )) ) {
				
				$STRING = "".$CORE->_e(array('coupons','18'));
				
				}else{
				
					if($small){
					
					$STRING = $date; 
					
					}else{
				
					// ADJUST THE TEXT AND REMOVE IT IF ITS ALREADY EXPIRED
					if(isset($GLOBALS['flag-single'])){ unset($GLOBALS['flag-single']); $canSetSingle=true; }
					$vv = $CORE->TimeDiff($date);					
					 
					if(strpos($vv,"ago") === false){
					$STRING = esc_attr($text)."".$CORE->TimeDiff($date); 
					}else{
					$STRING = $CORE->TimeDiff($date); 
					}
					if(isset($canSetSingle)){ $GLOBALS['flag-single'] = 1; }	
					
					}			
				}
			}
			// RETURN VALUE
			return "<span class='wlt_shortcodes_expiry_date'>".$STRING."</span>";  
	} 
	 
	// ADD A NEW coupon SHROTCODE
	function wlt_coupon_new_tags(){
		echo "<br />[CBUTTON] - Displays The Get Coupon Button";
	echo "<br />[COUPON] - Displays The Coupon";
	echo "<br/>[COUPON_START] - Shows the start date of the coupon";
	echo "<br/>[COUPON_END] - Shows the expiry of the coupon";
	echo "<br/>[STORE] - Shows the coupon store";
	}
	
	 
	//1. HOOK INTO THE ADMIN MENU TO CREATE A NEW TAB
	function wlt_coupon_field_menu(){  global $wpdb, $CORE; $core_admin_values = get_option("core_admin_values");  ?>
	
	<div class="tab-pane fade in" id="coupontab">
    
    <div class="heading1">Coupon Field Mapping</div>
    
    <div class="row-fluid">
    <div class="span6"> 
	
	<div class="form-row control-group row-fluid ">
	
		<label class="control-label"><b>Coupon Field Mapping</b></label>
	
		<small>Select the custom field which will be used to store coupon codes.</small>
					
		<select data-placeholder="Choose a value..." class="chzn-select" name="admin_values[coupon][code_key]">
		<option value=""></option>
		<?php
			echo $CORE->CUSTOMFIELDLIST(esc_attr( $core_admin_values['coupon']['code_key'] ) );
		?> 
		</select>
				   
	 </div> 
	
    </div><div class="span6"> 
	
	<div class="form-row control-group row-fluid ">
	
		<label class="control-label"><b>Coupon Link Field Mapping</b></label>
	
		<small>Select the custom field which will be used to store coupon button links.</small>
					
		<select data-placeholder="Choose a value..." class="chzn-select" name="admin_values[coupon][code_link]">
		<option value=""></option>
		<?php
			echo $CORE->CUSTOMFIELDLIST(esc_attr( $core_admin_values['coupon']['code_link'] ) );
		?> 
		</select>
				   
	 </div> 
     </div></div>
     
     <div class="heading1">Coupon Pop-up Window</div>
     
     
      <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn on if you want the newsletter form to be displayed at the bottom of your coupon pop-up window." data-placement="top">Display Newsletter Form</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="0" onChange="document.getElementById('coupon_popup_newsletter').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="1" onChange="document.getElementById('coupon_popup_newsletter').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['coupon_popup_newsletter'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="coupon_popup_newsletter" name="admin_values[coupon_popup_newsletter]" 
                             value="<?php echo $core_admin_values['coupon_popup_newsletter']; ?>">
            </div>       
            
            <div class="form-row control-group row-fluid">
            
                <label class="control-label">Custom HTML/Shortcodes</label>   
                <div class="controls">    
                <textarea class="row-fluid" style="height:100px; font-size:11px;" name="adminArray[coupon_popup_custom]"><?php echo stripslashes(get_option('coupon_popup_custom')); ?></textarea>    	 
                </div>
            </div> 
            
            
            <div class="heading1">Coupon Settings</div>
     
            
                  <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn on if you want to remove the hardcoded coupon fields." data-placement="top">Disable Default Fields</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="0" onChange="document.getElementById('coupon_defaults').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="1" onChange="document.getElementById('coupon_defaults').value='1'">
                                  </label>
                                  <div class="toggle <?php if(get_option('coupon_defaults') == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="coupon_defaults" name="adminArray[coupon_defaults]" 
                             value="<?php echo get_option('coupon_defaults'); ?>">
            </div>  
            
            
            
            
	<div class="form-row control-group row-fluid ">
	
		<label class="control-label span6"><b>Coupon Button Type</b></label>
	
		 <div class="span6">	
		<select data-placeholder="Choose a value..." class="chzn-select" name="admin_values[coupon_style]">
		<option value="1" <?php if($core_admin_values['coupon_style'] == '1'){ echo "selected=selected"; } ?>>Click to reveal</option>
		<option value="2" <?php if($core_admin_values['coupon_style'] == '2'){ echo "selected=selected"; } ?>>Click to open</option>
		 <option value="3" <?php if($core_admin_values['coupon_style'] == '3'){ echo "selected=selected"; } ?>>Click to copy</option>
		</select>
        </div>
				   
	 </div> 
            
            
            
            
     
    </div>
	<?php	
	}
	
	
	// ADD IN HOOK FOR FALLBACK IMAGE
	function wlt_coupon_fallback_image_tostore($c){ global $post;	
	// GET ID FROM NO-IMAGE STRING
	$b = explode('no-image-',$c);
	$b1 = explode('"',$b[1]);
	
	if(!is_numeric($b1[0])){ return $c; } 
	$terms = wp_get_post_terms( $b1[0], 'store', array("fields" => "all") ); 
	// CHECK IF THE STORE ASSIGNED HAS AN ICON
	 
	if(isset($terms[0]->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_'.$terms[0]->term_id]) ){
	$merchant_logo = $GLOBALS['CORE_THEME']['category_icon_'.$terms[0]->term_id];
	return "<img src='".$merchant_logo."' alt='merchant' class='wlt_thumbnail storelogo' />";
	}
	 
	return $c;
	}
 	
	
} // END CLASS FILE

















/* =============================================================================
	  STORE WIDGET CLASS
	========================================================================== */
class core_widgets_store_description extends WP_Widget {

    function core_widgets_store_description() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widgets_store_description',
			'description' => 'This widget will show the store description content when viewing a store.'
		);
		parent::__construct( 'core_widgets_store_description', __( '[WLT-COUPON] Store Description' ), $opts );
		
    }

    function form($instance) {
	
	global $wpdb, $CORE;
	
 		$defaults = array(
			'title'		=> 'Store Description',		
		);		
		$instance = wp_parse_args( $instance, $defaults );  
	
	 ?>
     This widget will only show when viewing a store list of coupons.
 	   <?php
 
	echo $out;
 
    }

	function update( $new, $old ){	
	
		$clean = $old;		
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';	
 		return $clean;
	}

    function widget($args, $instance) {

		global $CORE, $wp_query, $post; $STRING = ""; $COUNTER = 2; @extract($args); $core_admin_values = get_option("core_admin_values"); 
		
		if(isset($GLOBALS['flag-single'])){
	 
		$cl = wp_get_post_terms($post->ID, 'store', array("fields" => "all"));
		if(empty($cl)){ return; }
		$category = $cl[0];		
		}else{
		$category = $wp_query->get_queried_object();
		}
  
		if($category->taxonomy == "store" && strlen($category->description) > 2){
		 
			echo "<div class='core_widgets_".$category->taxonomy."_description'>".$before_widget.$before_title.$category->name.$after_title; 
				
			echo $category->description;
						
			echo $after_widget." <div class='clearfix'></div></div>";
		 
		 }
 
 
    }

}
class core_widgets_stores extends WP_Widget {

    function core_widgets_stores() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widgets_stores',
			'description' => __( 'Display Stores.' )
		);
		parent::__construct( 'core_widgets_stores', __( '[WLT-COUPON] Store List' ), $opts );
		
    }

    function form($instance) {
	
	global $wpdb, $CORE;
	
 		$defaults = array(
			'title'		=> 'Website Stores',		
		);		
		$instance = wp_parse_args( $instance, $defaults );  
	
	 ?>
     
 	<p><b>Title</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
  
   <p><br /><b>Select Stores to Display</b> (Hold Shift+Ctrl to select multiple)</p>  
      <select id="<?php echo $this->get_field_id( 'storeID' ); ?>" name="<?php echo $this->get_field_name( 'storeID' ); ?>[]" multiple="multiple" style="width:100%; height:150px;">
      <?php echo $CORE->categorylist(array($instance['storeID'],false,0,"store")); ?>
    </select> 
  
     <?php
	 
    $out = '<br /><br /><p class="inline"> <input id="' . $this->get_field_id('parentonly') . '" name="' . $this->get_field_name('parentonly') . '" type="checkbox" ' . checked(isset($instance['parentonly'])? $instance['parentonly']: 0, true, false) . ' />';
	$out .= ' &nbsp;&nbsp; <label for="' . $this->get_field_id('parentonly') . '">Show Store Image </label></p>';
	echo $out;
 
    }

	function update( $new, $old ){	
	
		$clean = $old;		
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';	
		$clean['parentonly'] = isset( $new['parentonly'] ) ? '1' : '0';	
		$clean['storeID'] = $new['storeID'];
		return $clean;
	}

    function widget($args, $instance) {

		global $CORE; $STRING = ""; $COUNTER = 2; @extract($args); $core_admin_values = get_option("core_admin_values"); if(!is_array($instance['storeID'])){ $instance['storeID'] = array(); } 
		
  
 			echo "<div class='core_widgets_stores_list'>".$before_widget.$before_title.$instance['title']."</div>"; 
	
			$categories = get_categories(array('taxonomy' => "store",'hide_empty'=> 0,'hierarchical'=> 0,'use_desc_for_title'=> 1,'pad_counts'=> 1, "orderby" => "count", "order"=>"desc")); 
  			foreach ($categories as $category) {
			
			if(!in_array($category->term_id, $instance['storeID'])){ continue; }
			
				// DISPLAY ICONS
				if($instance['parentonly']){
					
						if(isset($core_admin_values['category_icon_'.$category->term_id]) && strlen($core_admin_values['category_icon_'.$category->term_id]) > 5){
						$image = $core_admin_values['category_icon_'.$category->term_id];			
						}else{
						$image = FRAMREWORK_URI.'img/img_fallback.jpg';
						}
						
						$link = get_term_link($category->slug, 'store');
						echo "
						<div class='storediv col-md-6 text-center'>
						<a href='".$link."'><img src='".$image."' alt='".$category->name."' class='wlt_thumbnail' /></a>
						<div class='clearfix'></div>
					 
						<strong><a href='".$link."'>".$category->name."</a></strong>
						<p>".$category->count." ".$CORE->_e(array('coupons','31'))."</p>
						 
						</div>	
						";				 
						
				}else{
					echo '<a class="list" href="'.get_term_link($category->slug, 'store').'"><span>'.$category->name.'</span></a>'; 
				}
		 
			
			}
			
			echo $after_widget;  
 
    }

}

?>