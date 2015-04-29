//Declaring jquery representation of the direction button
var dButton = $('button');
//Creating the bus icon to be appended later
var icon = "<i class='mdi-maps-directions-bus left'></i>";
//creating the location icon to append later
var currentLocationIcon = "<i class='mdi-maps-my-location left'></i>";
//Creating global direction varible
var direction;
//Setting geolocation options
var geoLocationOptions = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};
//Get MBTA data using local api
function getBusData(latitude, longitude, direction) {
    $.ajax({
        type: "GET",
        url: 'app/prediction.php?latitude=' + latitude + '&longitude=' + longitude + '&direction=' + direction,
        async: true,
        dataType: "json",
        success: function (data) {
            $('.bus-stop').text(data.stop_name).append(currentLocationIcon);
            $('.eta').text(data.prediction[0]['pre_away']+' MIN');
            $('.time').text(data.prediction[0]['pre_dt']);
        }
    });
}
//In case of geolocation error
function error(err) {
    $('.progress').hide();
    $('#error').show();
    console.log('ERROR(' + err.code + '): ' + err.message);
}
//Success callback function for navigator.geolocation
function successPosition(currentPosition) {
    if (direction !== 'inbound') {
        direction = 'outbound';
    }
    $('.progress').hide();
    var crd = currentPosition.coords;
    console.log('Your current position is:');
    console.log('Latitude : ' + crd.latitude);
    console.log('Longitude: ' + crd.longitude);
    console.log('More or less ' + crd.accuracy + ' meters.');
    console.log('Direction: ' + direction);
    getBusData(crd.latitude, crd.longitude, direction);
    setInterval(
            function ()
            {
                getBusData(crd.latitude, crd.longitude, direction);
            }, 15000);
}
//Function for changing direction with the click of button
var buttonChangeDirection = function () {
    direction = dButton.attr('name');
    if (direction === 'outbound') {
        direction = 'inbound';
        dButton.attr('name', direction);
        dButton.text("To Cleveland Circle");
        dButton.append(icon);
        initGeolocation();
    } else if (direction === 'inbound') {
        direction = 'outbound';
        dButton.attr('name', direction);
        dButton.text("To Sullivan Station");
        dButton.append(icon);
        initGeolocation();
    }
};
//Getting current location
function initGeolocation() {
    $('.progress').show();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successPosition, error, geoLocationOptions);
    } else {
        $('.progress').hide();
        $('#error').show();
    }
}
//Hiding the error message
$('#error').hide();
//Initializing geolocation
initGeolocation();
//Changing directions
dButton.click(buttonChangeDirection);
