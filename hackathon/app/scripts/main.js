//$( "#taggedText" ).css("top", "50px");

var killerNum = 0;
var myNum = 1;
var myName;
var killerName;
var url = document.URL;
var myLat;
var myLong;
var totalKilled = 0;

var x = 1;
while(!isNaN(parseInt(url.charAt(url.length-1)))) {
	killerNum+=parseInt(url.charAt(url.length-1))*x;
	url = url.substring(0,url.length-1);
	x*=10;
}

myLat = codehelper_ip.CityLatitude;
myLat = myLat + (Math.random()-.5)/5;

myLong = codehelper_ip.CityLongitude;
myLong = myLong + (Math.random()-.5)/5;


/*var call_to = "http://smart-ip.net/geoip-json?callback=?";

$.getJSON(call_to, function(data){
   alert(data.host);
});*/


$.getJSON('../../hackathon/zombie.php?killer='+killerNum + "&lat=" + myLat + "&long=" + myLong, function(data) {
    console.log(data);
    myNum = data.yourID;
    myName = data.hasName;
    killerName = data.killerName;
    setupText();
});

$.getJSON('../../hackathon/numKills.php?', function(data) {
    	totalKilled = data.numZombies;
    	setupText2();	
});

function setupText2(){
	$("#totalKilled").html("" + totalKilled);
}


function setupText(){
	if(killerName){
		$('#KillerNamed').html('Zombie #' + killerNum + ' AKA ' + killerName + ' HAS EATEN YOUR BRAINS');
	} else {
		$('#KillerNamed').html('Zombie #' + killerNum + ' AKA ' + " Jake the Ripper" + ' HAS EATEN YOUR BRAINS');
	}

	$('#myLink').html("http://myrighttoplay.com/hackathon/?"+myNum);
	$("#myProgress").html("http://myrighttoplay.com/hackathon/progress?"+myNum);
	$("#myProgress").attr("href", "http://myrighttoplay.com/hackathon/progress?"+myNum);
	//$("#myLink").attr("href", "http://myrighttoplay.com/hackathon/?" +myNum);

	if(myName != ""){
		$('#YouNamed').html("Welcome to the winning team " + myName + ". You are Zombie #" + myNum + ".");
		$('#taggedName').css("visibility", "hidden");
	}else{
		$("#YouNamed").html("Welcome to the winning team zombie #" + myNum + " or better yet...");
	}
}


$('#taggedName').keypress(function(e) {
	if(e.which == 13) {
		myName = $("#taggedName" ).val();
		$('#YouNamed').html("Welcome to the winning team " + myName + ". You are Zombie #" + myNum + ".");
		$('#taggedName').css("visibility", "hidden");
	
		$.getJSON('../../hackathon/changeName.php?zombie='+myNum +'&name='+myName, function(data) {	
		});
		$('html, body').animate({scrollTop:$('#stuff').position().top}, 'slow');

	}
});