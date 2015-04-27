/*
 * Problem: Application needs interectivity and pull in data from api to be displayed 
 * When page loads, application gets location of user.
 * It defaults to one direction and starts displaying predictions
 * When users clicks the direction button, the button changes label accordingly 
 * and app starts to display appropriate predictions.
 * 
 * We need a default direction: it will be outbound. Todo: decide according to location what direction is more appropriate.
 */
//Hiding the error message
$('#error').hide();
//Getting the direction button element
var dButton = $('button');
//Creating the bus icon to be appended later
var icon = "<i class='mdi-maps-directions-bus left'></i>";
//Get MBTA data
function getBusData(latitude, longitude, direction) {
    $.ajax({
        type: "GET",
        url: 'app/prediction.php?latitude=' + latitude + '&longitude=' + longitude + '&direction=' + direction,
        async: true,
        dataType: "json",
        success: function (data) {
            //$('#showdata').html("<p>stop name=" + data.stop_name + " stop id=" + data.stop_id + " minutes=" + data.prediction[0]['pre_away'] + " time=" + data.prediction[0]['pre_dt'] + "</p>");
            $('.bus-stop').text(data.stop_name);
            $('.eta').text(data.prediction[0]['pre_away']);
            $('.time').text(data.prediction[0]['pre_dt']);
        }
    });
}
//Setting geolocation options
var geoLocationOptions = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};
//In case of geolocation error
function error(err) {
    $('.progress').hide();
    $('#error').show();
    console.log('ERROR(' + err.code + '): ' + err.message);
    //$('#error').show();
}
//Get current position
function successPosition(currentPosition) {
    var direction = 'outbound';
    $('.progress').hide();
    var crd = currentPosition.coords;
    console.log('Your current position is:');
    console.log('Latitude : ' + crd.latitude);
    console.log('Longitude: ' + crd.longitude);
    console.log('More or less ' + crd.accuracy + ' meters.');
    console.log('Direction: ' + direction);
    getBusData(crd.latitude, crd.longitude, direction);
}
;
//Two different functions for the same click event. I will have to bind one function for changing button text and another for getting the data.
//Function for changing button text
var buttonChangeDirection = function () {
    var direction = dButton.attr('name');
    if (direction === 'outbound') {
        direction = 'inbound';
        dButton.attr('name', direction);
        dButton.text("To Cleveland Circle");
        dButton.append(icon);
        //console.log('this is the dbutton being clicked with an anonimus function ' + direction);
    } else if (direction === 'inbound') {
        direction = 'outbound';
        dButton.attr('name', direction);
        dButton.text("To Sullivan Station");
        dButton.append(icon);
        //console.log('this is the dbutton being clicked with an anonimus function ' + direction);
    }
    console.log(direction);
};
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successPosition, error, geoLocationOptions);
} else {
    $('.progress').hide();
    $('#error').show();
}

dButton.click(buttonChangeDirection);
