<?php

add_action('hook_new_install','_newinstall');
function _newinstall(){ global $CORE, $wpdb;

define('RESET_THEME_TAXONOMY','coupon');
$GLOBALS['theme_defaults']['coupon'] = array('code_link' => 'link', 'code_key' => 'code');

// CONTENT LAYOUT / SINGLE LAYOUT
$GLOBALS['theme_defaults']['content_layout'] = "listing-coupon";
$GLOBALS['theme_defaults']['single_layout'] = "listing-coupon";

// SET HEADER
$GLOBALS['theme_defaults']['layout_header'] = 1;
// SET MENU
$GLOBALS['theme_defaults']['layout_menu'] = 2;
// 4. DEFAULT TEMPLATE DATA
$GLOBALS['theme_defaults']['template'] 		= "template_coupon_theme";
// RATING
$GLOBALS['theme_defaults']['rating_type'] = "3a";
 
 
		// ADD IN CUSTOM WIDGET BLOCK
$GLOBALS['theme_defaults']['widgetobject']["text"]["0"] = array(
			"fullw" => "yes",
			"text" =>  "
			<img src='".get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/icon1.png' class='right mainimg hidden-xs' alt='img' />
			<div style='padding-left:15px;padding-right:15px;'>			 
			<h1>Welcome to our coupon website!</h1>
			<h2>Great savings all year round!</h2>
			<h4>We provide a collection of the latest coupon and offers helping you make great savings online.</h4>
			<p>Below are a collection of our most popular stores;</p>
			</div>		
			<div class='clearfix'></div>	
			[STORES limit=12 perrow=6 icon=yes]"		
		); 
$GLOBALS['theme_defaults']['widgetobject']["recentlisting"]["1"] 	= array(
		"style" => "list",
		"title" => "Latest Coupons", 
		"fullw" => "no",
);
$GLOBALS['theme_defaults']['homepage'] 		= array("widgetblock1" => "text_0,recentlisting_1");


$GLOBALS['theme_defaults']['layout_columns'] 	= array('style' => 'fixed',  '2columns' => '0', 'homepage' => 1, 'search' => 1, 'single' => 1, 'page' => 1);
 

$GLOBALS['theme_defaults']['itemcode'] 		= "<div class='frame1'>[IMAGE link=0] <div class='desc'>[STORE text='more from ']</div> </div>
<h1>[TITLE-NOLINK]</h1>
<div class='hidden_details'>
<i class='fa fa-clock-o'></i> Expires in [COUPON_END]
<hr>
 [EXCERPT]</div> 
<div class='clearfix'></div>
<div class='highlight' >
<div class='col-md-4 hidden-sm hidden-xs'>
<div class='row'> [RATING] </div>
</div>
<div class='col-md-5 hidden-sm hidden-xs'>
<i class='fa fa-check-square-o'></i> used [hits] times   <i class='fa fa-comments'></i> [COMMENT_AJAX]
</div>
<div class='col-md-3 col-sm-3'>[CBUTTON]</div>
<div class='clearfix'></div></div>"; 

update_option('wlt_reset_itemcode', $GLOBALS['theme_defaults']['itemcode']);

$GLOBALS['theme_defaults']['listingcode']	= '<div class="block"><div class="block-title"><h1><span>[TITLE]</span></h1></div><div class="block-content"><div class="couponcontent">[IMAGE]<div class="caption"><h1>[TITLE]</h1><i class="fa fa-clock-o"></i> Expires in [COUPON_END]<hr /><div class="details"><div class="hidden_details">[CONTENT] [FIELDS] [GOOGLEMAP] </div>[CBUTTON]</div></div></div></div></div>[COMMENTS][RELATED]';

update_option('wlt_reset_listingcode', $GLOBALS['theme_defaults']['listingcode']);
 


// 5. REINSTALL THE SAMPLE DATA CATEGORIES 
$new_cat_array = array("Coupons","Printable Coupons","Offers","Other"); 
$saved_cats_array = array();
foreach($new_cat_array as $cat){
	if ( is_term( $cat , RESET_THEME_TAXONOMY ) ){
	$term = get_term_by('slug', $cat, RESET_THEME_TAXONOMY);
	$saved_cats_array[] = $term->term_id;
	}else{
	$cat_id = wp_insert_term($cat, RESET_THEME_TAXONOMY, array('cat_name' => $cat ));
		if(!is_object($cat_id) && isset($cat_id['term_id'])){
		$saved_cats_array[] = $cat_id['term_id'];
		}else{
		$saved_cats_array[] = $cat_id->term_id;
		}	
	}	
}
// 6. INSTALL THE SAMPLE DATA LISTINGS
$posts_array = array(
"1" => array("name" =>"Example Coupon 1","price" => "100", "tagline"=> "this is an example tag line", "url" => "http://google.com", "code" => "3543JH3JK45HJK35"),
"2" => array("name" =>"Example Coupon 2","price" => "130", "tagline"=> "this is an example tag line", "url" => "http://bing.com", "code" => "234SDFS2232"),
"3" => array("name" =>"Example Coupon 3","price" => "150", "tagline"=> "this is an example tag line", "url" => "http://yahoo.com", "code" => "FFFSDA23424"),
"4" => array("name" =>"Example Coupon 4","price" => "160", "tagline"=> "this is an example tag line", "url" => "http://lycos.com", "code" => "FDGD3242"),
"5" => array("name" =>"Example Coupon 5","price" => "150", "tagline"=> "this is an example tag line", "url" => "http://dogpile", "code" => "SDFSDF5433"),
"6" => array("name" =>"Example Coupon 6","price" => "170", "tagline"=> "this is an example tag line", "url" => "http://ask.com", "code" => "JHGJG54654"),
"7" => array("name" =>"Example Coupon 7","price" => "200", "tagline"=> "this is an example tag line", "url" => "http://mahalo.com", "code" => "DDD2111"),
"8" => array("name" =>"Example Coupon 8","price" => "300", "tagline"=> "this is an example tag line", "url" => "http://webopedia.com", "code" => "5464FFDF"),
"9" => array("name" =>"Example Coupon 9","price" => "500", "tagline"=> "this is an example tag line", "url" => "http://clusty.com", "code" => "AD343443")

);

foreach($posts_array as $np){
 
	$my_post = array();
	$my_post['post_title'] 		= $np['name'];
	$my_post['post_content'] 	= "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Someone famous <cite title='Source Title'>Source Title</cite></small>
</blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><dl class='dl-horizontal'>
				<dt>Description lists</dt>
				<dd>A description list is perfect for defining terms.</dd>
				<dt>Euismod</dt>
				<dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
				<dd>Donec id elit non mi porta gravida at eget metus.</dd>
				<dt>Malesuada porta</dt>
				<dd>Etiam porta sem malesuada magna mollis euismod.</dd>
				<dt>Felis euismod semper eget lacinia</dt>
				<dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</dd>
			  </dl>";
	$my_post['post_type'] 		= RESET_THEME_TAXONOMY."_type";
	$my_post['post_status'] 	= "publish";
	$my_post['post_category'] 	= "";
	$my_post['tags_input'] 		= "";
	$POSTID 					= wp_insert_post( $my_post );	
	add_post_meta($POSTID, "tagline", $np['tagline']);
	add_post_meta($POSTID, "link", $np['url']);
	add_post_meta($POSTID, "code", $np['code']);
	add_post_meta($POSTID, "start_date", date("Y-m-d H:i:s"));
	add_post_meta($POSTID, "expiry_date",  date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +7 days")));
	//add_post_meta($POSTID, "price", $np['price']);
	// UPDATE CAT LIST
	wp_set_post_terms( $POSTID, $saved_cats_array, RESET_THEME_TAXONOMY );		
} 
 
} 

?>