//$(document).ready(function () {
//    //attach a jQuery live event to the button
//    $('#getdata-button').on('click', function () {
//        $.getJSON('http://localhost:8888/86/app/prediction.php?latitude=42.355375699999996&longitude=-71.149031&direction=outbound', function (data) {
//            //alert(data); //uncomment this for debug
//            //alert (data.item1+" "+data.item2+" "+data.item3); //further debug
//            $('#showdata').html("<p>stop name=" + data.stop_name + " stop id=" + data.stop_id + " minutes=" + data.prediction[0]['pre_away'] + "</p>");
//        });
//    });
//});

$(document).ready(function () {
    //attach a jQuery live event to the button
    $('#getdata-button').on('click', function () {
        $.ajax({
            type: "GET",
            url: 'app/prediction.php?latitude=42.355375699999996&longitude=-71.149031&direction=outbound',
            async: true,
            dataType: "json",
            success: function (data) {
                $('#showdata').html("<p>stop name=" + data.stop_name + " stop id=" + data.stop_id + " minutes=" + data.prediction[0]['pre_away'] + "</p>");
            }
        });
    });
});
var direction = 'outbound';

//setInterval(
//        function ()
//        {
//            $.ajax({
//                type: "GET",
//                url: 'app/prediction.php?latitude=42.355375699999996&longitude=-71.149031&direction='+ direction,
//                async: true,
//                dataType: "json",
//                success: function (data) {
//                    $('#showdata').html("<p>stop name=" + data.stop_name + " stop id=" + data.stop_id + " minutes=" + data.prediction[0]['pre_away'] + "</p>");
//                }
//            });
//        }, 15000);
setTimeout(
        function ()
        {
            $.ajax({
                type: "GET",
                url: 'app/prediction.php?latitude=42.355375699999996&longitude=-71.149031&direction=' + direction,
                async: true,
                dataType: "json",
                success: function (data) {
                    $('#showdata').html("<p>stop name=" + data.stop_name + " stop id=" + data.stop_id + " minutes=" + data.prediction[0]['pre_away'] + "</p>");
                }
            });
        }, 9000);

(function pollServerForNewMail() {
    $.getJSON('/poll_newmail.php', function (response) {
        if (response.newMail) {
            alert(
                    "You have received a letter, good sir. " +
                    "I will have a quick lie-down and be on my way shortly."
                    );
        }
        setTimeout(pollServerForMail, 1000);
    });
}());
