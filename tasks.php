<?php
/*
*Project: eYSIP_2015_IoT-Connected-valves-for-irrigation-of-greenhouse
*Team members: Jayant Solanki, Kevin D'Souza
*File name: tasks.php
*Author: Jayant Solanki
*Runs continously in cli mode , executing the scheduled tasks based upon start and stop time
*
*/
include 'iotdb.php';
require(__DIR__ . '/spMQTT.class.php');
date_default_timezone_set('Asia/Kolkata');//setting IST
spMQTTDebug::Enable();



mysql_select_db($dbname) or die(mysql_error());
	
$query="SELECT * FROM tasks";
//echo $query;

$results=mysql_query($query);

if (mysql_num_rows($results) > 0) 
{
	   echo "</br>Executing tasks</br>";

	   while($row = mysql_fetch_assoc($results)) 
		{	
			$id=$row['id'];
			$start=$row['start'];
			$stop=$row['stop'];
			$action=$row['action'];
           	    	$currenttime=date('Hi');
			//echo $currenttime;
			if($start!=NULL)
			{
				
				if($currenttime>=$start and $currenttime<$stop and $action==1)
				{
					$task="SELECT * FROM devices"; //starting every valves,,// problem here why is it not selecting dvices from a particular group????
					$result=mysql_query($task);
						if (mysql_num_rows($result) > 0) 
						{
							while($rows = mysql_fetch_assoc($result))
							{
									$macid=$rows['macid'];			
									command($macid,$action);	//switch 
							
									//echo "Switch OFF"; //update button status
				
			
						   	    	
							}
						}
					$query = "UPDATE tasks SET action ='0' WHERE id='$id'";
					$action=0;//doing this because dont want to again fetch from table
					//setting start NUll so that it wont check
					echo "</br>".$query;
					if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
						echo "INSERT failed: $query<br/>".mysql_error()."<br/><br/>";
					else
						echo "</br>Task upadated to stop</br>";
					$query="UPDATE devices SET action='1'"; //this is for updating running status off devices,//problem here
					echo "</br>".$query;
					if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
						echo "INSERT failed: $query<br/>".mysql_error()."<br/><br/>";
					
					
				}
				
			}
			if($stop!=NULL)
			{
				if($currenttime==0000)
						$currenttime=2400; //2400 is same as 1200am or 0000
						
				
				if($currenttime>=$stop and $action==0)
				{
					$task="SELECT * FROM devices"; //stopping every valves
					$result=mysql_query($query);
						if (mysql_num_rows($result) > 0) 
						{
							while($rows = mysql_fetch_assoc($results))
							{
									$macid=$rows['macid'];			
									command($macid,$action);	//switch 
							
									//echo "Switch ON"; //update button status
				
			
						   	    	
							}
						}
					$query = "UPDATE tasks SET action ='1' WHERE id='$id'"; //resetting to 1 for next day execution
					echo $query;
					if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
						echo "INSERT failed: $query<br/>".mysql_error()."<br/><br/>";
					else
						echo "</br>Task upadated for next day</br>";
					$query="UPDATE devices SET action='0'"; //this is for updating running status off devices
					echo "</br>".$query;
					if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
						echo "INSERT failed: $query<br/>".mysql_error()."<br/><br/>";
				}
				
			}
    		}
echo "Done executing";
}
else
{
echo "No scheduled tasks exist";
}
 /*
 *
 * Function Name: command($macid,$action)
 * Input: $ macid for macid, and $action for defining 0/1 for OFF/ON commands
 * Output: publish ON/OFF commands to esp device.
 * each msg has macid, which will enable the script to generate a macid based topic(esp/macid)
 * Logic: msg format is 0, 1, 2, for OFF, ON and battery status.
 * 
 *
 */
function command($macid,$action) //for sending mqtt commands
{
//$mqtt->setAuth('sskaje', '123123');
$mqtt = new spMQTT('tcp://127.0.0.1:1883/');
$connected = $mqtt->connect();
if (!$connected) {
    die(" Mosca MQTT Server is Offline\n");
}

$mqtt->ping();

$msg = str_repeat($action, 1);

//echo "</br>esp/valve/".$macid;
$mqtt->publish('esp/valve/'.$macid, $msg, 0, 1, 0, 1);
echo "</br>Success";
}




