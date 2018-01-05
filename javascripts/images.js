
var intervalIDLImages;
var lastImageId = 0;
function reloadImages() {
    $.ajax({
            type: "POST",
            url: "/scripts/imagehandler.php",
            dataType: "xml",
            data: {isValidated: varisValidated, received_id: lastImageId}
        }
    ).done(function (xml) {
        $(xml).find('images').each(function () {
            $(this).find("image").each(function () {
                var xmlfrom = $(this).find("from").text();
                var xmlmessage = $(this).find("description").text();
                var xmltime = $(this).find("time").text();
                var xmlId = $(this).find("id").text();
                $(".fotostream").prepend('<div class="slide"><img class="fotostream" src="http://engadin.zoss.li/scripts/showimage.php?img_id='+xmlId+'&isValidated='+varisValidated+'"  title="" /> </div>');
                lastImageId = xmlId;
                reloadFullpage()
            });
        });
    });
}

$(document).ready(
    function () {
        intervalIDLImages = setInterval(reloadImages, 30000);
        reloadImages();
    }
);


