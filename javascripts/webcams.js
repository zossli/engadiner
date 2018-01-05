

//Refresh der Webcam Bilder
var intervalIDWebcam;
function refreshWebcams(){
	var isMobile = false; //initiate as false
	// device detection
	if( /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		isMobile = true;
	}
    

	if(!isMobile)
	{
	    $("img.webcam").each(function () {
	        $(this).attr("src", $(this).attr("realurl") + "&timestamp=" + new Date().getTime());
	    });
    }
    else{
	    if($(".section.active").attr("data-anchor")=="webcams")
	    {
		    if($(".slide.active").attr("webcam"))
		    {
			$("img.webcam").each(function () {
				if($(this).attr("alt")==$(".slide.active").attr("webcam"))
				{
					$(this).attr("src", $(this).attr("realurl") + "&timestamp=" + new Date().getTime());

				}
	    	});
	    	}
	    }

    }
}

$(document).ready(
    function()
    {
        intervalIDWebcam = setInterval(refreshWebcams, 60000);
    }
);