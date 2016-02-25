 

// GOOGLE PLUS    
function plusone_download(plusone) {
	if (plusone.state == "on") {
		wlt_download_file('google');
	}
}
 
// PIN INTEREST
jQuery('#pin-container').click(function () {
        wlt_download_file('pin');
});
 
// DOWNLOAD FILE
function wlt_download_file(network){

	jQuery.ajax({
		type: 'POST',
		url: siteurl + "" + Math.round(Math.random()*1000),
		data: 'action=download&fileid=' + fileid + '&network=' + network + '&',
		success: function(resp) {
			// REFRESH PAGE AND SHOW DOWNLOAD
			if(resp == "ok"){
				location.reload();				
			}				 
		},
		error: function() {
				 
				alert('Unable to complete the request.');
				 
		} //end error
	}); // end ajax
}