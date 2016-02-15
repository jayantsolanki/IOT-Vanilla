<?php
/*
*Project: eYSIP_2015_IoT-Connected-valves-for-irrigation-of-greenhouse
*Team members: Jayant Solanki, Kevin D'Souza
*File name: subscribe.php
*Author: Jayant Solanki
*Runs continously in cli mode ,
*subscribing to esp topic for getting macid from esp modules and also adding new found device
*/
//include 'iotdb.php';
require(__DIR__ . '/spMQTT.class.php');


//$start_time = time(); //defining starting time
//ini_set('display_errors', 'Off'); //for suppressing errors and notices
//$start_time = time();
//echo $start_time;

$mqtt = new spMQTT('tcp://10.129.28.118:1883/');

spMQTTDebug::Enable();

//$mqtt->setAuth('sskaje', '123123');
$mqtt->setKeepalive(3600);
$connected = $mqtt->connect();
if (!$connected) {
    die("Not connected\n");
}


$topics['esp'] = 1;
//$topics['esp/valve/state'] = 1;

$mqtt->subscribe($topics);

#$mqtt->unsubscribe(array_keys($topics));

$mqtt->loop('default_subscribe_callback');



/**
 * @param spMQTT $mqtt
 * @param string $topic
 * @param string $message
 */
/*
 *
 * Function Name: default_subscribe_callback($mqtt, $topic, $com)
 * Input: $mqtt, fro sending mqtt connection, $topic, for sending topic, $com, for storing message
 * Output: updates the table with new macid, used for device discovery
 * Logic: msg format is 'macid'
 * 
 *
 */
function default_subscribe_callback($mqtt, $topic, $com) {
    printf("Message received: Topic=%s, Message=%s\n</br>", $topic, $com);
	//entering macids into database
	$dbhost  = 'localhost';    
	$dbname  = 'IOT'; 
	$dbuser  = 'root';    
	$dbpass  = 'jayant123';    

	mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	$query="SELECT * FROM devices where"."(macid='$com')";
	mysql_select_db($dbname) or die(mysql_error());
	$results=mysql_query($query);
	if (mysql_num_rows($results) > 0) 
	{
	  echo "</br>Match found</br>";
	$query = "UPDATE devices SET status ='1' WHERE macid='$com'";
	echo $query;
	if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
		echo "INSERT failed: $query<br/>".mysql_error()."<br/><br/>";
	else
	echo "</br>Device status updated";//marked online
	//mark the device online
	}
	else 
	{
	echo "</br>Match not found</br>";
	//inserting the new found device into the device folder
	$query="INSERT INTO devices VALUES". "(DEFAULT,NULL,'$com',NULL,2,1, DEFAULT,NULL,NULL)";
	if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
		echo "INSERT failed: $query<br/>".mysql_error()."<br/><br/>";
	else
	echo "New device added";
}
mysql_close();
	//$mqtt->close(); //same with this line
	//$mqtt->unsubscribe($topics); //adding this line helped in removing the infinite wait
	
}


