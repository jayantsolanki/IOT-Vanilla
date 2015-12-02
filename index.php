<?php 
/*
*Project: eYSIP_2015_IoT-Connected-valves-for-irrigation-of-greenhouse
*Team members: Jayant Solanki, Kevin D'Souza
*File name: index.php
*Author: Jayant Solanki
*This is the homepage of the website, which will basically show the maunal control options
*for different sensors
*/
include_once 'iotdb.php';
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1); //for suppressing errors and notices
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Homepage-Valve Control</title>
<?php include 'favicon.php';?>
</head>
<?php include_once 'css.php'; ?>

<script type='text/javascript'>
/*
 *
 * Function Name: showgrp(grp)
 * Input: grp, stores group id
 * Output: returns the sensors under the group id
 * Logic: It is a AJAX call
 * Example Call: showgrp(34)
 *
 */
function showgrp(grp)
{
if (grp=='')
  {
  document.getElementById('controls').innerHTML='';
  return;
  } 
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
	  document.getElementById('controls').innerHTML="<span class='push-5'><img src='images/ajax.gif'/></span>";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById('controls').innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','control.php?grp='+grp,true);
//alert(grp);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: update(str)
 * Input: str, stores group id, duration, stores the time in minutes
 * Output: send ON/OFF signal to the esp
 * Logic: It is a AJAX call
 * Example Call: update(12-14-AA-54-76-BB)
 *
 */
function update(str)
{
var duration=document.getElementById('duration').value;
//alert(duration);
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
	  document.getElementById(str).innerHTML="Switching ....";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(str).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','com.php?q='+str+'&duration='+duration,true);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: updateall(str)
 * Input: str, stores 0/1, duration, stores the time in minutes, gid, stores group id
 * Output: send ON/OFF signal to all esp of one group
 * Logic: It is a AJAX call
 * Example Call: updateall(1)
 *
 */
function updateall(str)
{
var gid=document.getElementById('groups').value;
var duration=document.getElementById('duration').value;

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
	  var items = document.getElementsByClassName('item');
	  for (var i = 0; i < items.length; ++i) 
		{
    			var item = items[i];  
    			item.innerHTML = "Switching....";
    		}
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var items = document.getElementsByClassName('item');
	for (var i = 0; i < items.length; ++i) 
		{
    			var item = items[i];  
    			item.innerHTML = xmlhttp.responseText;
    		}
	
   

    }
  }
xmlhttp.open('GET','com.php?q='+str+'&gid='+gid+'&duration='+duration,true);
xmlhttp.send();
}
</script>

<noscript>
Your browser doesnt support javascript</noscript>
</head>

<body >
<div id="layout">
<?php include_once "navigation.php";?>

<div  id="main">
<div class="header" ><a style'text-decoration: none;' href='index.php'>
      <h1>IOT Based Valve control</h1></a>
      <h2>Valve Controls</h2>
    </div>
    <div class="content">

<b>Select group </b><select name='groups' id='groups' onchange='showgrp(this.value)'>
<option selected="true" disabled='disabled'>Choose</option>
<?php 
mysql_select_db($dbname) or die(mysql_error());
$query="SELECT * FROM groups"; //displaying groups
$results=mysql_query($query);
if (mysql_num_rows($results) > 0) 
	{		
		while($row=mysql_fetch_assoc($results)) 
		{	//$id=$row['id'];
			$group=$row['name'];
			$id=$row['id'];
			echo " <option value='$id'>$group</option>";
		}
	}
?>
</select>&nbsp; &nbsp;</br></br>
<div id='controls'>

</div>

    </div><!-- end of content div -->
<div class='footer'>
<?php
include_once "app.php";?></div>
    </div><!-- end of main div -->
    
</div><!-- end of layout -->
<div class="push"></div>


<script src="js/ui.js"></script>
</body>
</html>
