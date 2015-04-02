var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};

function success(pos) {
    var crd = pos.coords;
    //var latitude = position.coords.latitude;
    //var longitude = position.coords.longitude;
    alert('Latitude : ' + crd.latitude + ' Longitude: ' + crd.longitude);
    console.log('Your current position is:');
    console.log('Latitude : ' + crd.latitude);
    console.log('Longitude: ' + crd.longitude);
    console.log('More or less ' + crd.accuracy + ' meters.');
}
;

function error(err) {
    alert('ERROR(' + err.code + '): ' + err.message);
    console.warn('ERROR(' + err.code + '): ' + err.message);
}
;

navigator.geolocation.getCurrentPosition(success, error, options);
