<?php

class core_download extends white_label_themes {

	function core_download(){ global $wpdb;	
	
 	// CHECK FOR ACTIONS
	add_action('init', array($this, '_actions' ) );
	
	// WP HEAD
	add_action('wp_head', array($this, '_CORE_SHARECODE') );
  	
	// ADD FOOTER MODALS
	add_action('wp_footer', array($this, '_js')); 
 	
	// SHORTCODES	
	add_shortcode( 'DOWNLOADS', array($this,'wlt_shortcode_downloads') );
	add_shortcode( 'SPECS', array($this,'wlt_shortcode_specs') );
  
	// ADD FIELDS TO THE ADMIN
	add_action('hook_fieldlist_0', array($this, '_hook_adminfields' ) );
	
	 // HOOK ADMIN FOR ADMIN FIELDS
	 add_action('hook_admin_1_tab1_subtab1_bottom', array($this,'_terms') );

	 // HOOK SUBMISSION PAGE AND ADD IN CORE FIELDS
	 add_action('hook_add_fieldlist',  array($this, '_hook_customfields' ) );
	 
	 //FILTER PRICE
	 add_filter('hook_price', array($this, 'newprice' ) );
	 
	 // ADD IN EXTRAS
	 add_filter('hook_add_form_post_save_extra', array($this, 'defaultops' ) );
 
    }
	
	function defaultops($id){	global $CORE, $wpdb;
	 
		$ff = $GLOBALS['CORE_THEME']['dl_theme_default_ops'];
		if(!is_array($ff)){ $ff = array(); }
		
		update_post_meta($id, 'download_ops', $ff);	
	 	
	}
	
	function newprice($p){ global $CORE;
		if($p == $GLOBALS['CORE_THEME']['currency']['symbol']."0"){
		return $CORE->_e(array('button','19'));
		}
		return $p;
	}
	
	function _hook_customfields($c){ global $CORE;
	
		$o = 50;
		
		$c[$o]['title'] 	= $CORE->_e(array('checkout','2'));
		$c[$o]['name'] 		= "price";
		$c[$o]['type'] 		= "price";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "0";	
		$o++;
		
		$c[$o]['title'] 	= $CORE->_e(array('software','10'));
		$c[$o]['name'] 		= "download_path";
		$c[$o]['type'] 		= "text";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "http://";	
		$o++;
		
		$c[$o]['title'] 	= $CORE->_e(array('software','9'));
		$c[$o]['name'] 		= "url";
		$c[$o]['type'] 		= "text";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "http://";	
		$o++;	
		
		$c[$o]['title'] 	= $CORE->_e(array('software','3'));
		$c[$o]['name'] 		= "dl_version";
		$c[$o]['type'] 		= "text";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "0";	
		$o++;
		
		$c[$o]['title'] 	= $CORE->_e(array('software','2'));
		$c[$o]['name'] 		= "dl_filesize";
		$c[$o]['type'] 		= "text";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "10";	
		$o++;
		
		$c[$o]['title'] 	= $CORE->_e(array('software','1'));
		$c[$o]['name'] 		= "dl_license";
		$c[$o]['listvalues'] 	= array("freeware" => "Freeware", "shareware" => "Shareware", "adware" => "Adware", "demo" => "Demo", "commercial" => "Commercial", "data" => "Data Only" );
		$c[$o]['type'] 		= "select";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "0";	
		$o++;
		
		$c[$o]['title'] 	= $CORE->_e(array('software','5'));
		$c[$o]['name'] 		= "dl_system";
		$c[$o]['type'] 		= "text";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "0";	
		$o++;		
		
		$c[$o]['title'] 	= $CORE->_e(array('software','8'));
		$c[$o]['name'] 		= "dl_released";
		$c[$o]['type'] 		= "date";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['required'] 	= true;	
  
		$o++;	 
		
		return $c;
	}
	
	function _terms(){  global $CORE; $core_admin_values = get_option("core_admin_values");   
	
	$gg = array("pay" => "Paid Download", "google" => "Google Plus", "twitter" => "Twitter", "facebook" => "Facebook", "linkedin" => "LinkedIn", "pininterest" => "Pin Interest", );
	
	$ff = $core_admin_values['dl_theme_default_ops'];
	if(!is_array($ff)){ $ff = array(); }
	?>
	
	<div class="heading1">Default Download Options</div> 
    
    <div class="span6">
        <div class="form-row control-group row-fluid">
        <label class="control-label span4">Facebook APP ID</label>
  
        <div class="controls span7">
            <input type="text" name="admin_values[dl_theme_facebookid]" class="row-fluid" value="<?php echo $core_admin_values['dl_theme_facebookid']; ?>">
        </div>
    	</div>
    </div>
    
    <div class="clearfix"></div>
    
    <p>You need to create and enable a new Facebook API before you can use the facebook share option. <a href="https://developers.facebook.com/" target="_blank">Go here</a> and create a new app in the top menu.
    
    <p><b style="font-size:18px;">Default Download Options</b></p>
    <p>This will setup the default download options for newly added listings.</p>
    
    <select multiple="multiple" class="row-fluid" style="height:150px;" name="admin_values[dl_theme_default_ops][]">
    <?php foreach($gg as $k => $n){
	
	if(in_array($k,$ff)){ $ex = "selected=selected"; }else{ $ex = ""; } 
	 ?>
    <option value="<?php echo $k; ?>" <?php echo $ex; ?>><?php echo $n; ?></option>
    <?php } ?>
    </select>
   
   
   
   <?php }
	
	// ADD IN CORE FIELDS TO THE ADMIN
	function _hook_adminfields($c){ global $CORE;
	
		$CORE->Language();
		
		// DATA
		$fields = array(
		
		"tab4" 				=> array("tab" => true, "title" => "Download Theme Extras" ),		
		
		"price" 			=> array("label" => "Price" ),
		"download_path" 	=> array("label" => "Download Path (Server)" ),
 		"download_ops" 		=> array("label" => "Download Options", "multi" => 1, "values" => array("pay" => "Paid Download", "google" => "Google Plus", "twitter" => "Twitter", "facebook" => "Facebook", "linkedin" => "LinkedIn", "pininterest" => "Pin Interest", ) ),
		"dl_released"	=> array("label" => "Date Released", "date" => true ),
		"dl_version"	=> array("label" => "Version" ),
		"dl_filesize"	=> array("label" => "File Size (MB)" ),
		"dl_license" 		=> array("label" => "License Type", "values" => array("freeware" => "Freeware", "shareware" => "Shareware", "adware" => "Adware", "demo" => "Demo", "commercial" => "Commercial", "data" => "Data Only", ) ),
		"dl_system"	=> array("label" => "Operating System" ),
		
		
		"url" 				=> array("label" => "Website Link" ),
		
		
		);
 
	 
	return array_merge($c,$fields);
	}
	
	// FUNCTION TO GET THE COUNTER FOR THE PAGE VIA THE NETWORK
	function getNetworkCount($network, $url){
	
		switch($network){
		
			//case "linkedin": { $sql = "http://www.linkedin.com/countserv/count/share?url=".$url."&format=json"; } break;
			
			//case "facebook": { $sql = "http://api.facebook.com/restserver.php?method=links.getStats&urls=".$url."&format=json"; } break;

			
			default: { return false; }
		}
		 	
		// GET RESULT
		$response = wp_remote_get( $sql );
		
		// CHECK RESPONSE
		if( !is_wp_error( $response ) ) {
				$result = json_decode($response['body']);
				 //print_r($result);
				 // SWITCH AND GET COUNT
				 switch($network){
				 	case "linkedin": { return $result->count; } break;
					case "facebook": { return $result[0]->like_count; } break;
				 }	
				
		} else {
			return false;
		}
	
	
	}
	
	
	// DOWNLOAD SHORTCODE
	function _CORE_SHARECODE(){  global $wpdb, $userdata, $CORE, $post; $STRING = "";
 	
	//if(is_single()){ return; }
	
		$services = array(
		
			"google" => array( 
				"title" => "Google Plus",
				"js"	=> "https://apis.google.com/js/plusone.js",
				"code" => ' <g:plusone size="medium" annotation="inline" callback="plusone_download" href="[url]"></g:plusone>',
				"custom" => true,
				
				),
			
			"twitter" => array( 
				"title" => "Twitter",
				"js"	=> "https://platform.twitter.com/widgets.js",
				"code" => '<script>twttr.ready(function(a){a.events.bind("tweet",function(b){wlt_download_file(\'twitter\');});});</script>
				<a href="https://twitter.com/share" class="twitter-share-button" data-via="" data-text="" data-url="[url]" data-count="horizontal">Tweet</a>',
				"custom" => true,				
				),
			 
				// app id 
				"facebook" => array( 
				"title" => "Facebook",
				"js"	=> "",
				"code" => '<div id="fb-root"></div>
				<script>
				window.fbAsyncInit = function() {
					FB.init({
						appId: \''.$GLOBALS['CORE_THEME']['dl_theme_facebookid'].'\'
					});
					FB.Event.subscribe(\'edge.create\', function(response) {
						alert(\'You liked the URL: \' + response);
						wlt_download_file(\'facebook\');
					});
				};
				(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id; //js.async = true;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='.$GLOBALS['CORE_THEME']['dl_theme_facebookid'].'";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, \'script\', \'facebook-jssdk\'));
				
				</script>
				<div class="fb-like" data-href="[url]" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false" data-stream="true" data-header="true"></div>'
				),
				
				"linkedin" => array( 
				"title" => "Linked in",
				"js"	=> "",
				"code" => '<div id="linkin-share"><script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script><script type="IN/Share" data-url="[url]" data-counter="right" data-onSuccess="wlt_linkedin_callback"></script><script type="text/javascript">function wlt_linkedin_callback() { wlt_download_file(\'linkedin\'); }</script></div> ',
			 
				  
				),
				
				"pininterest" => array( 
				"title" => "Pin Interest",
				"js"	=> "",
				"code" => '<span id="pin-container"><a data-pin-config="beside" href="http://pinterest.com/pin/create/button/?url=[your_url]&media=[your_image]&description=[your_desc]" data-pin-do="buttonPin" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a></span>' 
				
				),				
				
				
		);
		
		// GET DOWNLOAD OPTIONS
		$download_ops = get_post_meta($post->ID,'download_ops',true);		 
		if(!is_array($download_ops)){ $download_ops = array(); }
		
		// GET PRICE
		$price = get_post_meta($post->ID,'price',true);	
		
		// GET THE URL 
		$url = get_post_meta($post->ID,'url',true);
		if($url == ""){ $url = get_permalink($post->ID); } 
		
		foreach($services as $k => $service){  if(!in_array($k, $download_ops)){ continue; }	
		 
		// DEFAULTS
		$SHARECOUNT = "";
		
		// CUSTOM FOR SOME SCRIPTS WITH CALLBACK SUCH AS GOOGLE
		if(!isset($service['custom'])){
		
			// GET SHARE COUNT
			$SHARECOUNT = $this->getNetworkCount($k,$url);
			
			// SET FLAG
			$canDownload = false;
			
			// CHECK IF THERE IS A SESSION SET ALREADY
			if(isset($_SESSION['wlt_download_'.$k.'_'.$post->ID]) && is_array($_SESSION['wlt_download_'.$k.'_'.$post->ID]) ){
			
				 //echo "<br>ID: ".$post->ID." (".$k.") // count: ".$SHARECOUNT." // saved count: ".$_SESSION['wlt_download_'.$k.'_'.$post->ID]['count']."<br>";
				 //echo "time checked: ".$_SESSION['wlt_download_'.$k.'_'.$post->ID]['date']." // time now: ".date('Y-m-d H:i:s', strtotime('-10 minutes'));
				 
				// COMPARE COUNT TO SEE IF ITS CHANGED
				if( ( $SHARECOUNT > $_SESSION['wlt_download_'.$k.'_'.$post->ID]['count'] ) && ( strtotime($_SESSION['wlt_download_'.$k.'_'.$post->ID]['date']) >= strtotime( date('Y-m-d H:i:s', strtotime('-10 minutes')) ) ) ){			
				 //echo "here with ".$k;
				 
				// SET COOKIE
				setcookie("wlt_download_".$post->ID."-".$k, true);
				
				// DISABLE RESET
				$canDownload = true;
				}
			
			}
			
			// RESET SESSION
			if(!$canDownload){
			$_SESSION['wlt_download_'.$k.'_'.$post->ID]  = array("date" => date('Y-m-d H:i:s'), "count" => $SHARECOUNT);
			}
		}
		 		
		
		// CHECK FOR EXISTING COOKIE
		if( isset($_COOKIE["wlt_download_".$post->ID."-".$k]) || $canDownload ){ 
			
			$downloadbtn = '<form method="post" action="'.home_url().'/index.php" target="_blank" style="margin:0px;">
			<input type="hidden" name="pid" value="'.$post->ID.'" />
			<input type="hidden" name="free" value="1" />
			<input type="hidden" name="purchased" value="1" />
			<input type="hidden" name="downloadproduct" value="1" />';
			$downloadbtn .= "<button type='submit' class='btn btn-primary'>".$CORE->_e(array('checkout','18'))."</button>";
			$downloadbtn .= '</form>'; 
			
			$SHOWTHISCODE = $CORE->_e(array('software','7'));
		
		}else{ 
		
			$SHOWTHISCODE = str_replace("[url]",$url, $service['code']);
			
			$downloadbtn = '<button class="btn inactive" onclick="alert(\'Please share first.\');">'.$CORE->_e(array('checkout','18')).'</button>';
		
		} 

		
		if(strlen($service['js']) > 1){ $STRING .= '<script type="text/javascript" src="'.$service['js'].'"></script>'; } 
        
        $STRING .= '<div class="wlt_downloadbox '.$k.'"> 
		
		<div class="title">
		'.$service['title'].'
		</div>
		
        <div class="content">
		
			<div class="col-md-7">
			
			'.$SHOWTHISCODE.' 
			
			</div>
			
			<div class="col-md-5">
			
			'.$downloadbtn.'
			
			</div>
			
			<div class="clearfix"></div>
 		
        </div> </div>';
		 
		}// end loop
		
		
		// ADD ON EXTRA SETUP FOR PAID DOWNLOADS
		if(in_array("pay", $download_ops) ){
		
		// CHECK IF USER HAS PAID ALREADY
		$paidme = get_user_meta($userdata->ID, $post->ID.'-paid',true);
		if($paidme == "yes"){ $canDownloadPay = true; }else{ $canDownloadPay = false; }
		
		
				// CHECK FOR EXISTING COOKIE
		if($canDownloadPay || $price  == 0){ 
			
			$downloadbtn = '<form method="post" action="'.home_url().'/index.php" target="_blank" style="margin:0px;">
			<input type="hidden" name="pid" value="'.$post->ID.'" />
			<input type="hidden" name="free" value="1" />
			<input type="hidden" name="purchased" value="1" />
			<input type="hidden" name="downloadproduct" value="1" />';
			$downloadbtn .= "<button type='submit' class='btn btn-primary'>".$CORE->_e(array('checkout','18'))."</button>";
			$downloadbtn .= '</form>'; 
		
		}else{ 
		
			$downloadbtn = '<button href="#myPaymentOptions1" role="button" type="button" class="btn inactive" data-toggle="modal">'.$CORE->_e(array('checkout','18')).'</button> ';
		
		} 
		
		
        $STRING .= '<div class="wlt_downloadbox pay"> 
		
		<div class="title">'.$CORE->_e(array('software','6')).'</div>
		
        <div class="content">
		
			
			<div class="col-md-7">
			
			'.hook_price($price).'
			
			</div>
			
			<div class="col-md-5">
			
			'.$downloadbtn.'
			
			</div>
			
			<div class="clearfix"></div>
 		
        </div> </div>';
		
		if(!$canDownloadPay &&  $price > 0){
		
		$STRING .= '<!-- Modal -->
		<div id="myPaymentOptions1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog"><div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h4 class="modal-title">'.$CORE->_e(array('single','13')).' ('.hook_price($price).')</h4>
		  </div>
		  <div class="modal-body">'.$this->PAYMENTS($price, "DL-".$post->ID."-".$userdata->ID, $post->post_title, $post->ID, $subscription = false).'</div>
		  <div class="modal-footer">
		  '.$this->admin_test_checkout().'
		  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">'.$CORE->_e(array('single','14')).'</button></div></div>
		  </div></div>
		<!-- End Modal -->';
		}
		
		
		}		
		
		$GLOBALS['CORESHARECODE'] = $STRING;
	
	}
	
	function wlt_shortcode_specs($atts, $content = null){ global $post, $CORE;
	
	$l = get_post_meta($post->ID,'dl_license',true);
	$v = get_post_meta($post->ID,'dl_version',true);
	$fs = get_post_meta($post->ID,'dl_filesize',true);
	$d = get_post_meta($post->ID,'dl_released',true);
	$s = get_post_meta($post->ID,'dl_system',true);
	
	$STRING =  '<table class="table downloadDetails">
			<tbody>';
			
	if(strlen($l) > 0){
	$STRING .= '<tr>
						<th>'.$CORE->_e(array('software','1')).'</th>
						<td>'.$l.'</td>
					</tr>';	
	}
	if(strlen($fs) > 0){
	$STRING .= '<tr>
						<th>'.$CORE->_e(array('software','2')).'</th>
						<td>'.$fs.' MB</td>
					</tr>';	
	}
	
	if(strlen($v) > 0){
	$STRING .= '<tr>
						<th>'.$CORE->_e(array('software','3')).'</th>
						<td>'.$v.'</td>
					</tr>';	
	}
	
	if(strlen($d) > 0){
	$STRING .= '<tr>
						<th>'.$CORE->_e(array('software','4')).'</th>
						<td>'.hook_date($d).'</td>
					</tr>';	
	}
	
	if(strlen($s) > 0){
	$STRING .= '<tr>
						<th>'.$CORE->_e(array('software','5')).'</th>
						<td>'.$s.'</td>
					</tr>';	
	}
	
	$STRING .= '</tbody></table>';	
	
	return $STRING;
	}
	
	// DOWNLOAD SHORTCODE
	function wlt_shortcode_downloads($atts, $content = null){ 
 		 
		 return "".$GLOBALS['CORESHARECODE'];
 
	
	} 
	
	function _actions(){ global $userdata, $CORE;
 		
 		 if(isset($_POST['action']) && $_POST['action'] != ""){
			
			switch($_POST['action']){
			
				case "download": {
				
				// VALIDATION
				if(!is_numeric($_POST['fileid'])){ return; }
			 
				// SET COOKIE
				setcookie("wlt_download_".$_POST['fileid']."-".strip_tags($_POST['network']), true);
				
				// DIE OK FOR JAVASCRIPT
				die("ok");
				
				} break;		
			}// end switch		 
		}// end action
	 
		// FILE DOWNLOAD
		if(isset($_POST['downloadproduct']) && isset($_POST['pid']) && is_numeric($_POST['pid']) ){		 
		 
			// UPDATE DOWNLOAD COUNTER
			update_post_meta($_POST['pid'], 'download_count', get_post_meta($_POST['pid'], 'download_count',true)+1);
			
			// START DOWNLOAD
			$file = get_post_meta($_POST['pid'], 'download_path',true);
			
			// CHECK IF ITS IT HTTP LINK
			if(substr($file,0,4) == "http"){			
			header("location:".$file);
			die();			
			}
			 
			// ASSUME THE USER HAS LINKED TO THE FILE
			if(strpos($file,get_home_url()) !== false){			
				$b = explode("/wp-content/",THEME_PATH);		
				$file = str_replace(get_home_url(),$b[0],$file);			
			}
			ini_set('memory_limit','256M');	
			if(file_exists($file)) {
						header('Content-Description: File Transfer');
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename='.basename($file));
						header('Content-Transfer-Encoding: binary');
						header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						readfile($file);
						exit;
			}else{
			die("<h1>Download Error</h1><p>The file your looking for has been moved or deleted. Please contact the website owner.</p>");
			}		
		}
	 
	}
	
	
	function _js(){ global $post, $userdata;
	?>
    <script>var siteurl = "<?php echo home_url(); ?>/index.php";</script>
    <script>var fileid = "<?php echo $post->ID; ?>";</script>
    <script type="text/javascript" src="<?php echo CORE_THEME_PATH_JS; ?>wlt_downloadapi.js"></script>
    <?php	
	}

}
?>