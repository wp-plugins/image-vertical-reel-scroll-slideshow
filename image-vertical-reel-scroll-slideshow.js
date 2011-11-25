/*
##########################################################################################################################
###### Project   : Image vertical reel scroll slideshow  															######
###### File Name : image-vertical-reel-scroll-slideshow.js                   										######
###### Purpose   : This javascript is to scroll the images.  														######
###### Created   : 24-june-2011                  																	######
###### Modified  : 24-june-2011                  																	######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                       									######
###### Link      : http://www.gopiplus.org/work/2011/05/30/wordpress-plugin-image-vertical-reel-scroll-slideshow/   ######
##########################################################################################################################
*/
	

function ivrss_scroll() {
	ivrss_obj.scrollTop = ivrss_obj.scrollTop + 1;
	ivrss_scrollPos++;
	if ((ivrss_scrollPos%ivrss_heightOfElm) == 0) {
		ivrss_numScrolls--;
		if (ivrss_numScrolls == 0) {
			ivrss_obj.scrollTop = '0';
			ivrss_content();
		} else {
			if (ivrss_scrollOn == 'true') {
				ivrss_content();
			}
		}
	} else {
		setTimeout("ivrss_scroll();", 10);
	}
}

var ivrss_Num = 0;
/*
Creates amount to show + 1 for the scrolling ability to work
scrollTop is set to top position after each creation
Otherwise the scrolling cannot happen
*/
function ivrss_content() {
	var tmp_vsrp = '';

	w_vsrp = ivrss_Num - parseInt(ivrss_numberOfElm);
	if (w_vsrp < 0) {
		w_vsrp = 0;
	} else {
		w_vsrp = w_vsrp%ivrss_array.length;
	}
	
	// Show amount of vsrru
	var elementsTmp_vsrp = parseInt(ivrss_numberOfElm) + 1;
	for (i_vsrp = 0; i_vsrp < elementsTmp_vsrp; i_vsrp++) {
		
		tmp_vsrp += ivrss_array[w_vsrp%ivrss_array.length];
		w_vsrp++;
	}

	ivrss_obj.innerHTML 	= tmp_vsrp;
	
	ivrss_Num 			= w_vsrp;
	ivrss_numScrolls 	= ivrss_array.length;
	ivrss_obj.scrollTop 	= '0';
	// start scrolling
	setTimeout("ivrss_scroll();", 2000);
}

