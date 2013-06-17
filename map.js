try {
  $(function(){});
}catch (error) {
  console.error("Your javascript has an error: " + error);
}    
//$('#map-canvas').css()

var map;

function initialize() {
  var mapWidth = $(window).width();
  var mapOptions = {
    zoom: 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    width: mapWidth
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude,
                                       position.coords.accuracy);      
      $('#my_long').val(position.coords.longitude);
      $('#my_lat').val(position.coords.latitude);
      $('#my_accuracy').val(position.coords.accuracy);
      var info_message = 'Found You!<br/>Within an accuracy of ' + position.coords.accuracy + ' meters.';

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: info_message
      });

      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  }else{
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}

function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
}

function map_with_markers(){
  var my_long = $('#my_long').val();
  var my_lat = $('#my_lat').val();
  var latlng = new google.maps.LatLng(my_lat, my_long);

  var mapWidth = $(window).width();  
  var mapOptions = {
    zoom: 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: latlng,
    width: mapWidth
  };
  map = new google.maps.Map(document.getElementById('history_map'), mapOptions); 

  // Define Marker properties18
  var image = new google.maps.MarkerImage('images/Happy-64.png',
    // This marker is 129 pixels wide by 42 pixels tall.20
    new google.maps.Size(64, 64),
    // The origin for this image is 0,0.22
    new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 18,42.24
    new google.maps.Point(18, 64)
  );
  
  // Add Marker
  var marker1 = new google.maps.Marker({
    position: new google.maps.LatLng(my_lat, my_long),
      map: map,
      icon: image, // This path is the custom pin to be shown. Remove this line and the proceeding comma to use default pin
      position: latlng
  });
  // Add listener for a click on the pin
  google.maps.event.addListener(marker1, 'click', function() {
    infowindow1.open(map, marker1);
  });

  // Add information window
  var infowindow1 = new google.maps.InfoWindow({
    content:  createInfo('Colbys Happy Marker', ' Joy Joy:<a title="Check Out My Web" href="https://plus.google.com/u/0/102241244144248557838/posts/p/pub">My G Thang</a>')
  }); 

  // Create information window
  function createInfo(title, content) {
    return '<div class="infowindow"><strong>'+ title +'</strong>'+content+'</div>';
  }    
}

