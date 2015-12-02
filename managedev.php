
<?php
/*
*Project: eYSIP_2015_IoT-Connected-valves-for-irrigation-of-greenhouse
*Team members: Jayant Solanki, Kevin D'Souza
*File name: managedev.php
*Author: Jayant Solanki
*It is called in AJAX mode, performing administrator work for the user i.e., adding removing
* sensors, groups, editing devices, alotting them groups and type of sensor
*/
include 'iotdb.php';
$q=$_GET["q"]; //q is the group name received
$macid=$_GET['edit'];
$id=$_GET['id'];
$update=$_GET['update'];
$gid=$_GET['gid'];
$del=$_GET['del'];
$dels=$_GET['dels'];
$ddel=$_GET['ddel'];
$dname=$_GET['dname'];
$sensor=$_GET['sensor'];
$sentyp=$_GET['sentyp'];
if($q!=null)
{
	
	mysql_select_db($dbname) or die(mysql_error());
	$query="SELECT * FROM groups where"."(name='$q')";
	$results=mysql_query($query);
	if (mysql_num_rows($results) > 0) 
	{
	echo "<span class='error'>Enter Unique group name</span>";
	}
	else
	{
		$query="INSERT into groups VALUES(DEFAULT,'$q')";
		
		if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
			echo "INSERT failed: $query".mysql_error()."<br/>";
		else
			echo "</br><span class='success'><b>'$q' added</b></span></br>";
		
	}	
	

	$query="SELECT * FROM groups"; //displaying groups
	$results=mysql_query($query);
	if (mysql_num_rows($results) > 0) 
	{	$i=1;
		echo "</br></br><h2>Groups available</h2>";		
		while($row=mysql_fetch_assoc($results)) 
		{	//$id=$row['id'];
			$group=$row['name'];
		
		
			echo "<span style='color:#3B5998;font-weight:normal;'><b>".$i.".</b>&nbsp; &nbsp; <b>$group </b>&nbsp; &nbsp;<a href="."javascript:del('$group')".">delete</a></span><hr>";
			$i++;
		
		
		}
	}
	else
	{
		echo "</br><div class='notice'><b>No groups created yet.</b></div>";
	}
	

}
if($sensor!=null)
{
	
	mysql_select_db($dbname) or die(mysql_error());
	$query="SELECT * FROM sensors where"."(name='$sensor')";
	$results=mysql_query($query);
	if (mysql_num_rows($results) > 0) 
	{
	echo "<span class='error'>Enter Unique sensor name</span>";
	}
	else
	{
		$query="INSERT into sensors VALUES(DEFAULT,'$sensor')";
		
		if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
			echo "INSERT failed: $query".mysql_error()."<br/>";
		else
			echo "</br><span class='success'><b>'$sensor' added</b></span></br>";
		
	}	
	

	$query="SELECT * FROM sensors"; //displaying groups
	$results=mysql_query($query);
	if (mysql_num_rows($results) > 0) 
	{	$i=1;
		echo "</br></br><h2>Sensors available</h2>";		
		while($row=mysql_fetch_assoc($results)) 
		{	//$id=$row['id'];
			$sensor=$row['name'];
		
		
			echo "<span style='color:#3B5998;font-weight:normal;'><b>".$i.".</b>&nbsp; &nbsp; <b>$sensor </b>&nbsp; &nbsp;<a href="."javascript:dels('$sensor')".">delete</a></span><hr>";
			$i++;
		
		
		}
	}
	else
	{
		echo "</br><div class='notice'><b>No Sensors added yet.</b></div>";
	}
	

}
if($macid!=null)//update group and sensor type for selected deviceS
{

echo "<span id='$macid' style='color:#3B5998;font-weight:normal;'>&nbsp;<b>Allot group and sensor type</b>  </br><b>&nbsp; &nbsp;</b><input type='text' name='dname' id='dname'> <b>Name </b></br><b>MAC id:</b> $macid &nbsp; &nbsp; ".groups()."&nbsp;".sensors()."<button id='$macid' type='button' onclick="."update('$macid')".">Update</button></span><hr>";

}

if($update!=null)//perform the updation task
{
	
	mysql_select_db($dbname) or die(mysql_error());
	$query="SELECT name FROM groups WHERE id='$gid'";
	$grps=mysql_query($query);
	$grp=mysql_fetch_assoc($grps);
	$name=$grp['name'];
	if($name=='')
		$name="<span style='color: #0088FF;'><b>New Device Found</b></span>";
	$query = "UPDATE devices SET devices.group = '$gid', devices.status='1', devices.name='$dname', devices.type='$sentyp' WHERE devices.macid = '$update'"; //updating item with group id
				
	if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
		echo "UPDATE failed: $query<br/>".mysql_error()."<br/><br/>";
	echo " <span id='$update' style='color:#3B5998;font-weight:normal;'><b></b><b>MAC id:</b> $update &nbsp; &nbsp;<b>Group:</b> $name&nbsp; &nbsp; <a href="."javascript:edit('$update')".">edit</a></span>";
	
	
}

if($del!=null)//perform deletion task for group
{
	
	$query = "DELETE FROM groups WHERE name='$del'";

	if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
	echo "INSERT failed: $query<br/><div class='error'>".mysql_error()."</div><br/><br/>";
	$query="SELECT * FROM groups"; //displaying groups
	$results=mysql_query($query);
	if (mysql_num_rows($results) > 0) 
	{	$i=1;
		echo "</br></br><h2>Groups available</h2>";		
		while($row=mysql_fetch_assoc($results)) 
		{	//$id=$row['id'];
			$group=$row['name'];
		
		
			echo "<span style='color:#3B5998;font-weight:normal;'><b>".$i.".</b>&nbsp; &nbsp; <b>$group </b>&nbsp; &nbsp;<a href="."javascript:del('$group')".">delete</a><hr>";
			$i++;
		
		
		}
	}
	else
	{
		echo "</br><div class='notice'><b>No groups created yet.</b></div>";
	}
	
	
}
if($dels!=null) //for deleting selected sensor type
{
	
	$query = "DELETE FROM sensors WHERE name='$dels'";

	if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
	echo "INSERT failed: $query<br/><div class='error'>".mysql_error()."</div><br/><br/>";
	$query="SELECT * FROM sensors"; //displaying groups
	$results=mysql_query($query);
	if (mysql_num_rows($results) > 0) 
	{	$i=1;
		echo "</br></br><h2>Sensors available</h2>";		
		while($row=mysql_fetch_assoc($results)) 
		{	//$id=$row['id'];
			$sensor=$row['name'];
		
		
			echo "<span style='color:#3B5998;font-weight:normal;'><b>".$i.".</b>&nbsp; &nbsp; <b>$sensor </b>&nbsp; &nbsp;<a href="."javascript:dels('$sensor')".">delete</a><hr>";
			$i++;
		
		
		}
	}
	else
	{
		echo "</br><div class='notice'><b>No Sensor added yet.</b></div>";
	}
	
	
}
if($ddel!=null) //for deleting selected device
{
	
	$query = "DELETE FROM devices WHERE devices.macid='$ddel'";
	if(!mysql_query($query,mysql_connect($dbhost, $dbuser, $dbpass)))
	echo "INSERT failed: $query<br/><div class='error'>".mysql_error()."</div><br/><br/>";

	$query="SELECT * FROM devices"; //displaying groups
	$results=mysql_query($query);
	if (mysql_num_rows($results) > 0) 
	{	$i=1;
		echo "</br></br><h2>Items available</h2>";		
		while($row=mysql_fetch_assoc($results)) 
		{	$macid=$row['macid'];
			$group=$row['group'];
			//$group=$row['name'];
			$query="SELECT name FROM groups WHERE id='$group'";
			$grps=mysql_query($query);
			$grp=mysql_fetch_assoc($grps);
			$name=$grp['name'];
			if($name=='')
			 	$name="<span style='color: #0088FF;'><b>New Device Found</b></span>";
			echo "".$i.". <span id='$macid' style='color:#3B5998;font-weight:normal;'><b></b><b>MAC id:</b> $macid &nbsp; &nbsp;<b>Group:</b> $name &nbsp; &nbsp;<a href="."javascript:edit('$macid')".">edit</a>&nbsp; &nbsp;<a href="."javascript:ddel('$macid')".">Delete</a></span><hr>";
			$i++;
			
			
		}
	}
	else
	{
		echo "</br><div class='notice'><b>No devices added yet.</b></div>";
	}
	
	
}
 /*
 *
 * Function Name: groups()
 * Input: -
 * Output: displays the selection menu for group
 * 
 *
 */

function groups()
{
$dbname='IOT';
mysql_select_db($dbname) or die(mysql_error());
$query="SELECT * FROM groups"; //displaying groups
$results=mysql_query($query);
echo "<select id='groupadd'>";	
if (mysql_num_rows($results) > 0) 
	{
	echo "<option selected='true' disabled='disabled'>Choose</option>";
	while($row=mysql_fetch_assoc($results)) 
		{	//$id=$row['id'];
			$group=$row['name'];
			$id=$row['id'];
		
			echo "<option value='$id'>$group </option>";
			$i++;
		
		
		}
	}
else
	{
		echo "<option value=''>Create a group first </option>";
	}
echo "</select>";

}
 /*
 *
 * Function Name: sensors()
 * Input: -
 * Output: displays the selection menu for group
 * 
 *
 */
function sensors()
{
$dbname='IOT';
mysql_select_db($dbname) or die(mysql_error());
$query="SELECT * FROM sensors"; //displaying groups
$results=mysql_query($query);
echo "<select id='sensoradd'>";	
if (mysql_num_rows($results) > 0) 
	{
	echo "<option selected='true' disabled='disabled'>Choose</option>";
	while($row=mysql_fetch_assoc($results)) 
		{	//$id=$row['id'];
			$name=$row['name'];
			$id=$row['id'];
		
			echo "<option value='$id'>$name </option>";
			$i++;
		
		
		}
	}
else
	{
		echo "<option value=''>Add a sensor first </option>";
	}
echo "</select>";

}

?>

