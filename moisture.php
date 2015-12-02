<?php
/*
*Project: eYSIP_2015_IoT-Connected-valves-for-irrigation-of-greenhouse
*Team members: Jayant Solanki, Kevin D'Souza
*File name: moisture.php
*Author: Jayant Solanki
*Runs continously in cli mode ,
*subscribing to esp topic for getting moisture status from esp modules
*/
//include 'iotdb.php';
require(__DIR__ . '/spMQTT.class.php');

$mqtt = new spMQTT('tcp://127.0.0.1:1883/');

spMQTTDebug::Enable();

//$mqtt->setAuth('sskaje', '123123');
$mqtt->setKeepalive(3600);
$connected = $mqtt->connect();
if (!$connected) {
    die("Not connected\n");
}


$topics['esp/moisture'] = 1;
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
 * Output: updates the moisture status to the corresponding macid in device table
 * each msg has macid, which will enable the script to identify the device from which the msg came
 * Logic: msg format is 'macid+moisturestatus'
 * 
 *
 */
function default_subscribe_callback($mqtt, $topic, $com) {
    printf("Message received: Topic=%s, Message=%s\n</br>", $topic, $com);
	//entering macids into database
	$dbhost  = 'localhost';    //bottleneck for me,, included file cant work
	$dbname  = 'IOT'; 
	$dbuser  = 'root';    
	$dbpass  = 'jayant123';    
	$macid   =substr($com,0,17);
	$moval = substr($com,17);
	mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname) or die(mysql_error());
	$query = "UPDATE devices SET status ='1', action='$moval' WHERE macid='$macid'";
	echo $query;
	if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
		echo "UPDATE failed: $query<br/>".mysql_error()."<br/><br/>";
	else
	echo "</br>Moisture status updated";//marked online and battery marked
mysql_close();
	//$mqtt->close(); //same with this line
	//$mqtt->unsubscribe($topics); //adding this line helped in removing the infinite wait
	
}


