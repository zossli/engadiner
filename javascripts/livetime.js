
var intervalIDLivetime;
function reloadlivetime(){
    $(".livetime").each(function(){
        $(this).attr("src",$(this).attr("realurl")+"&time="+new Date().getTime());
    })
}

$(document).ready(
    function()
    {
        intervalIDLivetime = setInterval(reloadlivetime, 30000);
        reloadlivetime();
    }
);


