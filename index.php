<?php
	include "config/config.php";
	$site = new SiteCreator();



?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="apple-touch-icon" href="/icon.png" />
	<title>Engadiner - dev</title>

	<meta name="author" content="Reto Zoss" />
	<meta name="description" content="Zum Verfolgen von Langläufern " />
	<meta name="keywords"  content="Engadin Skimarathon,Engadiner,Zuoz,St. Moritz,Langlauf" />
	<meta name="Resource-type" content="Document" />


	<link rel="stylesheet" type="text/css" href="/styles/jquery.fullPage.css" />
	<link rel="stylesheet" type="text/css" href="/styles/styles.css" />


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    <!--
    NEEDED JS
    -->
    <?php
        echo $site->neededJS();
    ?>

    <script src="/javascripts/jquery.fullPage.js"></script>


</head>
<body>


<ul id="menu">
    <?php
        echo $site->getMenu();
    ?>
</ul>

<div id="fullpage">

    <?php

        echo $site->getFullpage();

    ?>

</div>
<script type="text/javascript">
	var hideLegend = false;
    var hideOthers = false;
    var theChoosenOne ="";

    function enableFullPagejs(){
        $('#fullpage').fullpage({
            sectionsColor: ['white', '#4BBFC3', '#7BAABE', '#1bbc9b', '#ccddff'],
            <?php echo $site->getAnchors(); ?>
            menu: '#menu',
            continuousVertical: true,
            continuousHoricontal: true,
	})
		$.fn.fullpage.setAllowScrolling(false);
		;

    }
    function reloadFullpage () {
        temp = $(".section.active");
        temp1 = $(".slide.active");
        $.fn.fullpage.destroy('all');
        temp.addClass("active");
        temp1.addClass("active");
        enableFullPagejs();
    };


    $(document).ready(function() {
		enableFullPagejs();
		
				
		$("#legendonoff").attr("y",$("#svg-span").height()-8);  
		$("#reglegendonoff").attr("y",$("#svg-span").height()-25);  
		      
        $(".mapclick").on("click", function(){
	        hideOthers = !hideOthers;
            theChoosenOne = $(this);
            hideTheElements(theChoosenOne);

        });
        $(".personLivetimeClicker").on("click", function (){
	        
        })
        $(".legendclick").on("click", function(){
	        hideLegend = !hideLegend;
	        $(".legend").each(function(){
		        if(hideLegend) {
                    
                        $(this).css('display', 'none');
                    
                }
                else{
                    $(this).css('display', '');
					hideTheElements()
                }
		        });
	    
	    });

	});
	function hideTheElements()
	{
		$(".mapclick").each(function(){
                if(hideOthers) {
                    if ($(this).attr("uuid") === theChoosenOne.attr("uuid")) {
                        $(this).css('display', '');
                    }
                    else {
                        $(this).css('opacity', '0.2');
                    }
                }
                else{
                    $(this).css('opacity', '1');
                }

            }
            );
	}

</script>
</body>
</html>