<?php

add_action('hook_new_install','_newinstall');
function _newinstall(){ global $CORE, $wpdb;

 
// 4. DEFAULT TEMPLATE DATA
$GLOBALS['theme_defaults']['template'] 		= "template_software_theme";
// SET HEADER
$GLOBALS['theme_defaults']['layout_header'] = 4;
// HOME PAGE
$GLOBALS['theme_defaults']['widgetobject']["slider1"][0] 	= array(
		"fullw" => "yes",
); 
$GLOBALS['theme_defaults']['home']['slider_item_1'] = get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template'].'/img/demo/slide.jpg';

$GLOBALS['theme_defaults']['widgetobject']["4columns"][1] 	= array(
		"title1" => "Featured Products",
		"fullw" => "yes",
		"col1" => "<div class='panel panel-default'>
            <div class='panel-heading'><h3>Box Headline</h3></div>
            <div class='panel-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
        <img src='".get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/b1.jpg' alt='&nbsp;' class='wltatt_id'>
            </div></div>",
		"col2" => "<div class='panel panel-default'>
            <div class='panel-heading'><h3>Box Headline</h3></div>
            <div class='panel-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
        <img src='".get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/b2.jpg' alt='&nbsp;' class='wltatt_id'>
            </div></div>",
		"col3" => "<div class='panel panel-default'>
            <div class='panel-heading'><h3>Box Headline</h3></div>
            <div class='panel-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
        <img src='".get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/b3.jpg' alt='&nbsp;' class='wltatt_id'>
            </div></div>",
		"col4" => "<div class='panel panel-default'>
            <div class='panel-heading'><h3>Box Headline</h3></div>
            <div class='panel-body'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
        <img src='".get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/b4.jpg' alt='&nbsp;' class='wltatt_id'>
            </div></div>",		
	
); 
$GLOBALS['theme_defaults']['widgetobject']["recentlisting"][2] 	= array(
		"title" => "Recently Added Software Titles",
		"query" => "",
		"tax" => "",
		"style" => "grid",
		"fullw" => "no",
		"pagenav" => "no",
		"perrow" => 4,
	
);

$GLOBALS['theme_defaults']['homepage'] 		= array("widgetblock1"=>"slider1_0,4columns_1,recentlisting_2");


$GLOBALS['theme_defaults']['display'] 			= array('default_gallery_style' => 'list');


$GLOBALS['theme_defaults']['layout_columns'] 	= array('style' => 'fixed',  '2columns' => '2', 'homepage' => 3, 'search' => 2, 'single' => 2, 'page' =>2, 'footer' => 4);

 
 $GLOBALS['theme_defaults']['itemcode'] 		= '<div class="hidden_details">[RATING]</div>[IMAGE]
<div class="caption">
<h2>[TITLE]</h2>
<p class="extrainfo">[hits] Views / [download_count] Downloads</p> 
<div class="excerpt">[EXCERPT] </div>           
<hr /> 
<div class="col-xs-4 col-sm-6 col-md-5">[price]</div>
<div class="col-xs-7 col-sm-6 col-md-7 btnbox"> [BUTTON] </div>
</div>';
update_option('wlt_reset_itemcode', $GLOBALS['theme_defaults']['itemcode']);
 
$GLOBALS['theme_defaults']['listingcode']		= '<div class="block"><div class="block-content"><div class="pricetag">[price]</div><h1><span>[TITLE]</span></h1><hr /><div class="row well"><div class="col-md-5" >[IMAGES]</div><div class="col-md-7">[DOWNLOADS]</div><div class="clearfix"> </div>[SPECS]</div><div class="clearfix"></div><hr /><h4>{Description}</h4><hr />[CONTENT]<hr /><h4>Related Products</h4><hr />[RELATED carousel=true]</div></div>[COMMENTS box=true]'; 
update_option('wlt_reset_listingcode', $GLOBALS['theme_defaults']['listingcode']);


$GLOBALS['theme_defaults']['menucategoryicon'] = 1;


 
// 5. REINSTALL THE SAMPLE DATA CATEGORIES 
$new_cat_array = array(
"Audio &amp; Multimedia" => array("Audio Encoders/Decoders","Audio File Players","Audio File Recorders","CD Burners","CD Players","Multimedia Creation Tools","Music Composers","Rippers &amp; Converters","Other"),
"Business" => array("Accounting &amp; Finance","Calculators &amp; Converters","Databases &amp; Tools","Helpdesk &amp; Remote PC","Inventory &amp; Barcoding","Investment Tools","Math &amp; Scientific Tools","Office Suites &amp; Tools","Other"),
"Communications" => array("Chat &amp; Instant Messaging","E-Mail Clients","E-Mail List Management","Newsgroup Clients","Web/Video Cams","Pager Tools","Telephony","Other Comms Tools"),
"Desktop" => array("Clocks &amp; Alarms","Cursors &amp; Fonts","Icons","Screen Savers","Themes &amp; Wallpaper","Other"),
"Development" => array("Active X","Basic, VB, VB DotNet","C / C++ / C#","Compilers &amp; Interpreters","Components &amp; Libraries","Debugging","Delphi","Help Tools","Install &amp; Setup"),
"Education" => array("Computer","Dictionaries","Geography","Kids","Languages","Mathematics","Reference Tools","Teaching &amp; Training Tools","Other"),
"Games &amp; Entertainment" => array("Action","Adventure &amp; Roleplay","Arcade","Board","Card","Casino &amp; Gambling","Kids","Online Gaming","Strategy &amp; War Games","Other"),
"Graphic Apps" => array("Animation Tools","CAD","Converters &amp; Optimizers","Editors","Font Tools","Gallery &amp; Cataloging Tools","Icon Tools","Screen Capture","Other"),
"Home &amp; Hobby" => array("Astrology/Biorhythms/Mystic","Astronomy","Cataloging","Food &amp; Drink","Genealogy","Health &amp; Nutrition","Personal Finance","Personal Interes","Other"),
"Network &amp; Internet" => array("Ad Blockers","Browser Tools","Browsers","Download Managers","File Sharing/Peer to Peer","FTP Clients","Network Monitoring","Remote Computing","Other"),
"Security &amp; Privacy" => array("Access Control","Anti-Spam &amp; Anti-Spy Tools","Anti-Virus Tools","Covert Surveillance","Encryption Tools","Password Managers","Other"),
"Servers" => array("Firewall &amp; Proxy Servers","FTP Servers","Mail Servers","News Servers","Telnet Servers","Web Servers","Other Server Applications"),
"System Utilities" => array("Automation Tools","Backup &amp; Restore","Benchmarking","Clipboard Tools","File &amp; Disk Management","File Compression","Launchers &amp; Task Managers","Printer","Other"),
"Web Development" => array("ASP &amp; PHP","E-Commerce","Flash Tools","HTML Tools","Java &amp; JavaScript","Log Analysers","Site Administration","Wizards &amp; Components","XML/CSS Tools","Other"),
);


$saved_cats_array = array(); $ff=1;
foreach($new_cat_array as $cat=>$catlist){
	if ( is_term( $cat , THEME_TAXONOMY ) ){	
		$term = get_term_by('slug', $cat, THEME_TAXONOMY);		 
		$nparent  = $term->term_id;
		$saved_cats_array[] = $term->term_id;	
	}else{
	
		$cat_id = wp_insert_term($cat, THEME_TAXONOMY, array('cat_name' => $cat ));
 
		if(!is_object($cat_id) && isset($cat_id['term_id'])){
		$saved_cats_array[] = $cat_id['term_id'];
		$nparent = $cat_id['term_id'];
		}else{
		$saved_cats_array[] = $cat_id->term_id;
		$nparent = $cat_id->term_id;
		}
		$ff++; 
	}
 	
	/* SUB CATS */
	if(is_array($catlist)){
		foreach($catlist as $newcat){
		wp_insert_term($newcat, THEME_TAXONOMY, array('cat_name' => $newcat,'parent' => $nparent));
		}	
	}
}
// 6. INSTALL THE SAMPLE DATA LISTINGS
$posts_array = array(
"1" => array("name" =>"Bitdefender Antivirus Plus 2014","price" => "29.95","version" => "1.7.5"),
"2" => array("name" =>"Kaspersky Anti-Virus","price" => "59.95","version" => "2.7.5"),
"3" => array("name" =>"AVG Anti-Virus","price" => "34.99","version" => "1.1.5"),
"4" => array("name" =>"Norton AntiVirus","price" => "39.99","version" => "3.7.5"),
"5" => array("name" =>"Trend Micro Titanium Antivirus","price" => "39.95","version" => "16.7.5"),
"6" => array("name" =>"eScan Anti-Virus","price" => "29.99","version" => "5.7.5"),
"7" => array("name" =>"Total Defense Anti-Virus","price" => "20.99","version" => "2.2.5"),
"8" => array("name" =>"Early Detection Center","price" => "30.99","version" => "8.7.5"),
"9" => array("name" =>"F-Secure Anti-Virus","price" => "39.99","version" => "2.7.5"),

);
$i=1;
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
	$my_post['post_type'] 		= THEME_TAXONOMY."_type";
	$my_post['post_status'] 	= "publish";
	$my_post['post_category'] 	= "";
	$my_post['tags_input'] 		= "";
	$POSTID 					= wp_insert_post( $my_post );	
	add_post_meta($POSTID, "image", get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template'].'/img/demo/'.$i.'.jpg');
	add_post_meta($POSTID, "price", $np['price']);
	add_post_meta($POSTID, "download_ops", array("pay","google","twitter","facebook","linkedin"));
	
	add_post_meta($POSTID, "dl_system", "Windows XP/Vista/7/8");
	add_post_meta($POSTID, "dl_filesize", "57.02");
	add_post_meta($POSTID, "dl_version", $np['version']);
	add_post_meta($POSTID, "dl_license", "commercial");
	add_post_meta($POSTID, "dl_released", date('Y-m-d H:i:s'));
	add_post_meta($POSTID, "download_path", get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template'].'/img/demo/example.zip');
	
	
	
	
	// UPDATE CAT LIST
	//wp_set_post_terms( $POSTID, $saved_cats_array, THEME_TAXONOMY );
	$i++;		
} 
 
} 

?>