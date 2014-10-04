var image = '../images/skull.png';
var proxImage = '../images/skullProx.png';
var map;

/*
 var locations = [
      [-33.890542, 151.274856],
      [-33.923036, 151.259052],
      [-34.028249, 151.157507],
      [-33.80010128657071, 151.28747820854187],
      [-33.950198, 151.259302]
    ];
*/

var locations = [];

var killerNum = 0;
var url = document.URL;
var x = 1;
while(!isNaN(parseInt(url.charAt(url.length-1)))) {
	killerNum+=parseInt(url.charAt(url.length-1))*x;
	url = url.substring(0,url.length-1);
	x*=10;
}


function loadMap(){    
	$.getJSON('../../hackathon/getZombInfo.php?zombie='+killerNum, function(data) {
    		var locString = data.longAndLats;
    		var proxyString = data.proxyLnL;
    		
    		getLocArray(locString);
    		for (var p = 0; p < locations.length; p++) {  
      			marker = new google.maps.Marker({
        			position: new google.maps.LatLng(locations[p][0], locations[p][1]),
        			map: map,
        			icon: image
      			});
      			marker.setMap(map);
      		}
      		
      		locations=[];
      		getLocArray(proxyString);
    		for (var p = 0; p < locations.length; p++) {  
      			marker = new google.maps.Marker({
        			position: new google.maps.LatLng(locations[p][0], locations[p][1]),
        			map: map,
        			icon: proxImage
      			});
      			marker.setMap(map);
      		}
      		
      		
      		
      		
	});
}

function getLocArray(locStr){
	locStr = locStr.substring(1,locStr.length);
	var tempArray = locStr.split(",");
	for(var i = 0; i<Math.floor(tempArray.length/2); i++){
		var temp = [parseFloat(tempArray[2*i]) ,parseFloat(tempArray[2*i+1])];
		locations.push(temp);
	}
};



function initialize() {
	loadMap();
	var mapOptions = {
		center: { lat: 39.5, lng: -98.5},
		zoom: 4,
		styles: myStyles
	};
	map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
		
		for (i = 0; i < locations.length; i++) {  
      			marker = new google.maps.Marker({
        			position: new google.maps.LatLng(locations[i][0], locations[i][1]),
        			map: map,
        			icon: image
      			});
      		google.maps.event.addListener(marker, 'click', (function(marker, i) {
        	return function() {
          		infowindow.setContent(locations[i][0]);
          		infowindow.open(map, marker);
        	}
      		})(marker, i));
      		}
	
	var marker, i;
	
		
}

   google.maps.event.addDomListener(window, 'load', initialize);

var myStyles = [
    {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#333739"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#2ecc71"
            }
        ]
    },
    {
        "featureType": "poi",
        "stylers": [
            {
                "color": "#2ecc71"
            },
            {
                "lightness": -7
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#2ecc71"
            },
            {
                "lightness": -28
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#2ecc71"
            },
            {
                "visibility": "on"
            },
            {
                "lightness": -15
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#2ecc71"
            },
            {
                "lightness": -18
            }
        ]
    },
    {
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#2ecc71"
            },
            {
                "lightness": -34
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#333739"
            },
            {
                "weight": 0.8
            }
        ]
    },
    {
        "featureType": "poi.park",
        "stylers": [
            {
                "color": "#2ecc71"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#333739"
            },
            {
                "weight": 0.3
            },
            {
                "lightness": 10
            }
        ]
    }
];