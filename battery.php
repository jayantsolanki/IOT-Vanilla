<?php
//include 'iotdb.php';
/*
*Project: eYSIP_2015_IoT-Connected-valves-for-irrigation-of-greenhouse
*Team members: Jayant Solanki, Kevin D'Souza
*File name: battery.php
*Author: Jayant Solanki
*Runs continously in cli mode ,
*subscribing to esp/battery for getting battery status from esp modules
*/
require(__DIR__ . '/spMQTT.class.php');

$mqtt = new spMQTT('tcp://10.129.28.181:1883/');

spMQTTDebug::Enable();

//$mqtt->setAuth('sskaje', '123123');
$mqtt->setKeepalive(3600);
$connected = $mqtt->connect();
if (!$connected) {
    die("Not connected\n");
}


$topics['esp/battery'] = 1;
//$topics['esp/valve/state'] = 1;

$mqtt->subscribe($topics);

#$mqtt->unsubscribe(array_keys($topics));

$mqtt->loop('default_subscribe_callback');



/**
 * @param spMQTT $mqtt
 * @param string $topic
 * @param string $message
 */
function default_subscribe_callback($mqtt, $topic, $com) {
    printf("Message received: Topic=%s, Message=%s\n</br>", $topic, $com);
	//entering macids into database
	$dbhost  = 'localhost';    //bottleneck for me,, included file cant work
	$dbname  = 'IOT'; 
	$dbuser  = 'root';    
	$dbpass  = 'jayant123';    
	$macid   =substr($com,0,17);
	$batstatus = substr($com,17);
	mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname) or die(mysql_error());
	$query = "UPDATE devices SET devices.status ='1', devices.battery='$batstatus' WHERE macid='$macid'";
	echo $query;
	if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
		echo "UPDATE failed: $query<br/>".mysql_error()."<br/><br/>";
	else
	echo "</br>Device battery status updated";//marked online and battery marked
mysql_close();
	//$mqtt->close(); //same with this line
	//$mqtt->unsubscribe($topics); //adding this line helped in removing the infinite wait
	
}


