//problem: I need to diffirentiate button states when user clicks the direction button
//
//when user clicks direction button
//    it switches from light teal to dark teal
//    the other button switches from dark teal light teal
var direction = 'outbound';
$("#inbound").click(function () {
if ($(this).hasClass("teal lighten-2")) {
        $(this).removeClass("teal lighten-2");
        $(this).toggleClass("teal darken-1");
        $("#outbound").removeClass("teal darken-1");
        $("#outbound").toggleClass("teal lighten-2");
    }
    direction = 'inbound';
    //alert(direction);
});

$("#outbound").click(function () {
    if ($(this).hasClass("teal lighten-2")) {
        $(this).removeClass("teal lighten-2");
        $(this).toggleClass("teal darken-1");
        $("#inbound").removeClass("teal darken-1");
        $("#inbound").toggleClass("teal lighten-2");
    }
    direction = 'outbound';
    //alert(direction);
});


