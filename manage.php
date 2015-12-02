<?php 
/*
*Project: eYSIP_2015_IoT-Connected-valves-for-irrigation-of-greenhouse
*Team members: Jayant Solanki, Kevin D'Souza
*File name: manage.php
*Author: Jayant Solanki
*user interface for managing devices
*/
include_once 'iotdb.php';?>
<?php
date_default_timezone_set('Asia/Kolkata');//setting IST
//echo "Time is ".date('Hi');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Devices</title>
<?php include 'favicon.php';?>
</head>
<?php include_once 'css.php'; ?>
<script type='text/javascript'>
/*
 *
 * Function Name: addsen()
 * Input: -
 * Output: adds sensor in sensors table
 * Logic: It is a AJAX call
 * Example Call: addsen()
 *
 */
function addsen()
{

if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function()
  {
	if (xmlhttp.readyState==3 && xmlhttp.status==200)
	  {
	  document.getElementById("sensors").innerHTML="Adding...";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("sensors").innerHTML=xmlhttp.responseText;
    }
  }
var sensor = document.getElementById("sensor").value;
xmlhttp.open('GET','managedev.php?sensor='+sensor,true);
//alert("Hello! I am an alert box!!");
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: addgrp()
 * Input: -
 * Output: adds group in groups table
 * Logic: It is a AJAX call
 * Example Call: addgrp()
 *
 */
function addgrp()
{

if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function()
  {
	if (xmlhttp.readyState==3 && xmlhttp.status==200)
	  {
	  document.getElementById("groups").innerHTML="Adding...";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("groups").innerHTML=xmlhttp.responseText;
    }
  }
var group = document.getElementById("group").value;
xmlhttp.open('GET','managedev.php?q='+group,true);
//alert("Hello! I am an alert box!!");
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: edit()
 * Input: -macid, for stroing mac id of esp modules
 * Output: updates device table with group name, device name and sensor type
 * Logic: It is a AJAX call
 * Example Call: edit()
 *
 */
function edit(macid)
{

if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function()
  {
	if (xmlhttp.readyState==3 && xmlhttp.status==200)
	  {
	  document.getElementById(macid).innerHTML="loading...";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(macid).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','managedev.php?edit='+macid,true);
//alert(macid);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: update(macid)
 * Input: -macid, for stroing mac id of esp modules
 * Output: updates device table with group name, device name and sensor type
 * Logic: It is a AJAX call
 * Example Call: update(12-1A-34-54-DC-AA)
 *
 */
function update(macid)
{
var sentyp=document.getElementById("sensoradd").value;
var gid=document.getElementById("groupadd").value;
var dname=document.getElementById("dname").value;
//alert(macid);
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function()
  {
	if (xmlhttp.readyState==3 && xmlhttp.status==200)
	  {
	  document.getElementById(macid).innerHTML="loading...";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(macid).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','managedev.php?update='+macid+'&gid='+gid+'&dname='+dname+'&sentyp='+sentyp,true);
//alert(macid);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: del(str)
 * Input: -str, for stroing group id
 * Output: deletes the group
 * Logic: It is a AJAX call
 * Example Call: del(12-1A-34-54-DC-AA)
 *
 */
function del(str)
{

if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function()
  {
	if (xmlhttp.readyState==3 && xmlhttp.status==200)
	  {
	  document.getElementById("groups").innerHTML="deleting...";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("groups").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','managedev.php?del='+str,true);
//alert(macid);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: dels(str)
 * Input: -str, for stroing sensor id
 * Output: deletes the sensor
 * Logic: It is a AJAX call
 * Example Call: dels(12-1A-34-54-DC-AA)
 *
 */
function dels(str)
{

if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function()
  {
	if (xmlhttp.readyState==3 && xmlhttp.status==200)
	  {
	  document.getElementById("sensors").innerHTML="deleting...";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("sensors").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','managedev.php?dels='+str,true);
//alert(macid);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
function ddel(macid)
{

if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function()
  {
	if (xmlhttp.readyState==3 && xmlhttp.status==200)
	  {
	  document.getElementById("items").innerHTML="deleting...";
	  
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("items").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','managedev.php?ddel='+macid,true);
//alert(macid);
xmlhttp.send();
}
</script>
<noscript>
Your browser doesnt support javascript</noscript>
<body >
<div id="layout">
<?php include_once "navigation.php";?>

<div  id="main">
<div class="header" ><a href='index.php'>
      <h1>IOT Based Valve control</h1></a>
      <h2>Manage Devices</h2>
    </div>
    <div class="content">
<pre>
<span><b>Add Sensor :</b></span>
<input type='text' id='sensor' name='sensor'/>

<button id='button' type='button' onclick='addsen();' value='add'>Add</button>

</pre>
<div id='sensors'>

<?php
mysql_select_db($dbname) or die(mysql_error());
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

 ?>  
</div>
</br>
<pre>
<span><b>Add Group :</b></span>
<input type='text' id='group' name='group'/>

<button id='button' type='button' onclick='addgrp();' value='add'>Add</button>

</pre>
<div id='groups'>

<?php
mysql_select_db($dbname) or die(mysql_error());
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

 ?>  
</div>

<div id='items'>

<?php
mysql_select_db($dbname) or die(mysql_error());
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

 ?>  
</div>
     </div><!-- end of content div -->
<?php
include_once "app.php";?>
    </div><!-- end of main div -->
</div><!-- end of layout -->
   
<div class="push"></div>

<div class='container footer'>
<?php //include_once "footer.php";?></div>
<script src="js/ui.js"></script>
</body>
</html>
