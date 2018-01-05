
var maloja = Array(774168.00, 142000.00);
var pontresina = Array(787245.00, 154034.00);
var diffMalojaPontresinaPixel = Array(1077,112);
var rectLength = 0;
var intervalIDLocation;



function draw(elem, latitude, longitude, name, time){
    var point = $('#circle_' + elem);

    if (point.length)
    {
        posit = getScreenPoint(latitude, longitude);
        point.attr("cx", posit[0]);
        point.attr("cy", posit[1]);
        $('#legend_text_' + elem).html(name + " " + time);
        nlength = ($('#legend_text_' + elem).width() + 24);
        if (nlength > rectLength)
        {
            $("#rectangle").attr("width", nlength + "px");
            rectLength = nlength;
        }
    }

}
function getScreenPoint(lat, long)
{

    var diffMalojaPontresina = Array(pontresina[0]-maloja[0],pontresina[1]-maloja[1]);
    var rotationkarte = Math.atan(diffMalojaPontresina[1]/diffMalojaPontresina[0])*180/Math.PI;
    var rotationkarteabbildung =  Math.atan(diffMalojaPontresinaPixel[1]/diffMalojaPontresinaPixel[0])*180/Math.PI;
    var rotation = rotationkarte+rotationkarteabbildung;
    var diffMalojaPontresina = matrixRotation(diffMalojaPontresina[1],diffMalojaPontresina[0],rotation);
    var skalierung = diffMalojaPontresinaPixel[0]/diffMalojaPontresina[0];


    var pointy = WGStoCHx(lat, long);
    var pointx = WGStoCHy(lat, long); //ACHTUNG Koordinaten System x-y vertauscht....

    pointx = pointx-maloja[0];
    pointy = pointy-maloja[1];

    var point = matrixRotation(pointx, pointy, rotation);

    skalierung = skalierung/(2160/$("#svg-span").width());

    point = Array(point[0] * skalierung, point[1] * -skalierung);


    point[0] = point[0]+(149/(2160/$("#svg-span").width())); //Verschiebung von Maloja...
    point[1] = point[1]+(180/(2160/$("#svg-span").width()));

    return point;

}

function matrixRotation(x, y, winkel)
{
    var a = Array();
    a[0] = x;
    a[1] = y;
    winkel = arguments[2];
    var b = Array();

    b[0] = (a[0] * Math.cos(winkel * (Math.PI / 180))) + (a[1] * Math.sin(winkel * (Math.PI / 180)));
    b[1] = (-a[0] * Math.sin(winkel * (Math.PI / 180))) + (a[1] * Math.cos(winkel * (Math.PI / 180)));
    return b;
}

function getNormalTime(unix_timestamp) {
    // create a new javascript Date object based on the timestamp
// multiplied by 1000 so that the argument is in milliseconds, not seconds
    var date = new Date(unix_timestamp * 1000);
// hours part from the timestamp
    var hours = date.getHours();
// minutes part from the timestamp
    var minutes = "0" + date.getMinutes();
// seconds part from the timestamp
    var seconds = "0" + date.getSeconds();
// day part from the timestamp
    var day = date.getDate();
// month part from the timestamp
    var month = date.getMonth() + 1;
// seconds part from the timestamp
    var year = date.getFullYear();

// will display time in 10:30:23 format
    var formattedTime = hours + ':' + minutes.substr(minutes.length - 2) + ':' + seconds.substr(seconds.length - 2) + ' Uhr am ' + day + '.' + month + '.' + year;
    return formattedTime;
}


function retrieveNewLocations(){
    $.ajax({
            url: "/scripts/locationhandler.php",
            dataType: "xml"
        }

    ).always(function (xml){
        $(xml).find('competitors').each(function(){
            $(this).find("competitor").each(function(){
                var unique = $(this).find("unique").text();
                var latitude = $(this).find("latitude").text();
                var longitude = $(this).find("longitude").text();
                var name = $(this).find("name").text();
                var time = $(this).find("time").text();
                draw(unique,latitude,longitude,name,time);
            });
        });
    });
}

$(document).ready(
    function()
    {
        intervalIDLocation = setInterval(retrieveNewLocations, 5000);
        retrieveNewLocations();
    }
);


