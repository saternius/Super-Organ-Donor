var killerNum = 0;
var url = document.URL;
var x = 1;
while(!isNaN(parseInt(url.charAt(url.length-1)))) {
	killerNum+=parseInt(url.charAt(url.length-1))*x;
	url = url.substring(0,url.length-1);
	x*=10;
}


var numKilled = 50;
var zombieName = "BRUNY";
var numKilledProxy = 10;
var longAndlats;
var proxyLnL;
var lastKill;

$.getJSON('../../hackathon/getZombInfo.php?zombie='+killerNum, function(data) {
	zombieName = data.name;
    	numKilled = data.kills;
    	numKilledProxy = data.proxyKills;
    	longAndLats = data.longAndLats;
    	proxyLnL = data.proxyLnL;
    	lastKill = data.lastKilled;
    	setupText();
});



function setupText(){
	for(var i = 0; i<numKilled; i++){
		$('#zombieDiv').append('<img src="../images/ZombieIcon.png">');
	}
	for(var i = 0; i<numKilledProxy; i++){
		$('#proxyZombieDiv').append('<img src="../images/ZombieIcon.png">');
	}
	
	$('#zombieNum').html("Zombie #"+killerNum);
	$('#zombieNamed').html("aka: "+zombieName);
	$('#numZombiesMade').html("Number of Zombies made: " + numKilled);
	$('#numZombiesMadeProxy').html("Number of Zombies your zombies made: " + numKilledProxy);
}