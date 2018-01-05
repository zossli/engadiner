
var intervalIDLMessages;
var lastMessageId = 0;
function reloadMessages() {
    $.ajax({
            type: "POST",
            url: "/scripts/messagehandler.php",
            dataType: "xml",
            data: {isValidated: varisValidated, received_id: lastMessageId}
        }
    ).done(function (xml) {
        console.log(xml);
        $(xml).find('messages').each(function () {
            $(this).find("message").each(function () {
                var xmlfrom = $(this).find("from").text();
                var xmlmessage = $(this).find("text").text();
                var xmltime = $(this).find("time").text();
                var xmlId = $(this).find("id").text();
                $("#messagestream").prepend('<fieldset>' +
                    '<legend>' + xmlfrom + ' am ' + xmltime + '</legend>'
                    + xmlmessage
                    + '</fieldset>');
                lastMessageId = xmlId;

                reloadFullpage();
            });
        });
    });
}

$(document).ready(
    function () {
        intervalIDLMessages = setInterval(reloadMessages, 30000);
        reloadMessages();
    }
);


