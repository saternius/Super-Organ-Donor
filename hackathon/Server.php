<?php
class Server{

    public function __construct($db){
        $this->db = $db;
    }
    
    public function createNewZombie($killer,$lat,$long){
    	 //lets create a new zombie
    	 $ip = $_SERVER['REMOTE_ADDR'];
    	 $people_with_this_ip = $this->db->query("SELECT * FROM Zomb WHERE IP_ADDRESS = '$ip'");
    	 //we might have to get rid of this temporarally from time to time to test
    	 

    	 
    	 if($people_with_this_ip->num_rows>0){
    	 	$people_with_this_ip = $people_with_this_ip->fetch_assoc();
    	 	return $people_with_this_ip['ID'];
    	 }else{
    	 
    	 $date = date("F j, Y, g:i a");
    	 
    	 
    	   $location = $lat.",".$long;
    	   $works = $this->db->query("INSERT INTO Zomb Values('','$ip','','$date','0','0','','$location','$killer','','','')");
    	   $id_of_inserted = $this->db->insert_id;
    	   
    	  // $location = "[\"".$id_of_inserted."\",".$lat.",".$long."]";
    	   //echo $location."<br>";
    	   $works4 = $this->db->query("SELECT * FROM LongAndLat WHERE ID = '1337'");
    	   $works4 = $works4->fetch_assoc();
    	   $LongAndLats = $works4['LONG_AND_LAT'];
    	  // echo $LongAndLats."<br>";
    	   $newLongAndLat = substr($LongAndLats, 0, -1);
    	   $newLongAndLat.=",".$location;
    	  // echo $newLongAndLat."<br>";
    	   $time = time();
    	   $works5 = $this->db->query("UPDATE LongAndLat SET LAST_KILLED='$time',LONG_AND_LAT='$newLongAndLat' WHERE ID = '1337'");
    	   
    	   
    	 //lets get the kills of the killer
    	   $parent_zombie = $this->db->query("SELECT * FROM Zomb WHERE ID = '$killer'");
       	   $parent_zombie = $parent_zombie->fetch_assoc();
       	   $kills = $parent_zombie['KILLS'];
       	   $kills++;
       	   $victims = $parent_zombie['VICTIMS'];
       	   $victims.=",".$id_of_inserted;
       	   
	   $parentLnL = $parent_zombie['LONG_AND_LATS'];
	   $newpLongAndLat = substr($parentLnL, 0, -1);
    	   $newpLongAndLat.=",".$location;
       	   $works2 = $this->db->query("UPDATE Zomb SET KILLS='$kills', VICTIMS='$victims', LAST_KILLED='$time', LONG_AND_LATS='$newpLongAndLat' WHERE ID = '$killer'");
   	  
    	 
    	 
	    	 if($works){
	    	 	return $id_of_inserted;
	    	 }else{
	    	 	return "FAILURE";
	    	 }
    	 }
    }
    public function assignName($zombie_index,$name){
    	$zombie_curName = $this->db->query("SELECT * FROM Zomb WHERE ID = '$zombie_index'");
       	$zombie_curName = $zombie_curName->fetch_assoc();
       	$curName = $zombie_curName['ALT_NAME'];
       	if(strlen($curName)!=0){
       		return "NAME ALREADY ASSIGNED";
       	}
       	   
   	$works = $this->db->query("UPDATE Zomb SET ALT_NAME='$name' WHERE ID = '$zombie_index'");
   	if($works){
   		return "SUCCESS";
   	}else{
   		return "FAILURE";
   	}
    }
    
    
    
    public function getKillerName($yourID){
   	$killy = $this->db->query("SELECT * FROM Zomb WHERE ID = '$yourID'");
       	$killy = $killy->fetch_assoc();
       	$killer = $killy['KILLED_BY'];
       	
       	$killy = $this->db->query("SELECT * FROM Zomb WHERE ID = '$killer'");
       	$killy = $killy->fetch_assoc();
       	return $killy['ALT_NAME'];
    
    }
    
    public function hasName($yourID){
   	$killy = $this->db->query("SELECT * FROM Zomb WHERE ID = '$yourID'");
       	$killy = $killy->fetch_assoc();
       	return $killy['ALT_NAME'];
    
    }
    
    public function numZombies(){
    	$numZombs = $this->db->query("SELECT * FROM Zomb");
    	return $numZombs->num_rows;
    }

    public function lastKilled(){
    	 $works4 = $this->db->query("SELECT * FROM LongAndLat WHERE ID = '1337'");
    	 $works4 = $works4->fetch_assoc();
    	 return $works4['LAST_KILLED'];
    }
    
     public function longAndLats(){
    	 $works4 = $this->db->query("SELECT * FROM LongAndLat WHERE ID = '1337'");
    	 $works4 = $works4->fetch_assoc();
    	 return $works4['LONG_AND_LAT'];
    }
    
     public function focusZombie($zombie){
     	$this->zomb = $this->db->query("SELECT * FROM Zomb WHERE ID = '$zombie'");
       	$this->zomb = $this->zomb->fetch_assoc();
     }
    
     public function kills(){
       	return $this->zomb['KILLS'];
    }
    
     public function zombLastKilled(){
       	return $this->zomb['LAST_KILLED'];
    }
    
     public function zombLongAndLats(){
       	return $this->zomb['LONG_AND_LATS'];
    }
    public function proxyKills(){
       	return $this->zomb['PROXY_KILLS'];
    }
    public function zombProxyLnL(){
       	return $this->zomb['LONG_LATS_PROXY'];
    }
    public function zombName(){
       	return $this->zomb['ALT_NAME'];
    }
    
    
    
    public function calculateProxies(){
    	$time = time();
    	if($time%86400 == 0){
	    	$q = $this->db->query("SELECT * FROM Zomb");
	       	while($r = $q->fetch_assoc()){
	       		$thisID = $r["ID"];
	       		$victims = $r["VICTIMS"];
	       		$victims = substr($victims, 1);
	       		$victims = split(",",$victims);
	       		$num_victims = sizeof($victims);
	       		$killProxy = 0;
	       		$proxLL="";
	       		for($i=0; $i<$num_victims; $i++){
	       			if(strlen($victims[$i])!=0){
	       				//this is the victim
	       				$this->focusZombie($victims[$i]);
	       				$killProxy+=$this->kills();
	       				$proxLL.=$this->zombLongAndLats();
	       			}
	       		}
	       		//echo $proxLL."<br>";
	       		$this->db->query("UPDATE Zomb SET LONG_LATS_PROXY='$proxLL' WHERE ID = '$thisID'");
	       		$this->db->query("UPDATE Zomb SET PROXY_KILLS='$killProxy' WHERE ID = '$thisID'");
	       	}
       	}
   }
}
?>