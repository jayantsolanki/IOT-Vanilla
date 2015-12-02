<?php 
/*
*Project: eYSIP_2015_IoT-Connected-valves-for-irrigation-of-greenhouse
*Team members: Jayant Solanki, Kevin D'Souza
*File name: devdis.php
*Author: Jayant Solanki
*It is for displaying devices information
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
<title>New Device Discovery</title>
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
  document.getElementById('dev').innerHTML='';
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
	  document.getElementById('dev').innerHTML="<span class='push-5'><img src='images/ajax.gif'/></span>";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById('dev').innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','dd.php?grp='+grp,true);
//alert(grp);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: checkbat(bat)
 * Input: bat, stores group id
 * Output: checks for battery status of sensors under group id
 * Logic: It is a AJAX call
 * Example Call: checkbat(34)
 *
 */
function checkbat(bat)
{
if (bat=='')
  {
  document.getElementById('dev').innerHTML='';
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
	  document.getElementById('dev').innerHTML="<span class='push-5'><img src='images/ajax.gif'/></span>";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById('dev').innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','dd.php?bat='+bat,true);
//alert(grp);
xmlhttp.send();
}
</script>
<noscript>
Your browser doesnt support javascript</noscript>
<body >
<div id="layout">
<?php include_once "navigation.php";?>
<div class="header"><a href='index.php'>
      <h1>IOT Based Valve control</h1></a>
      <h2>Registered Devices</h2>
    </div>
    <div class="content">

<b>Select group</b> <select name='groups' id='groups' onchange='showgrp(this.value)'>
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
<div id='dev'>

</div>
  </div><!-- end of content div -->
<?php
include_once "app.php";?>
    </div><!-- end of main div -->
    <?php
include_once "app.php";?>
</div><!-- end of layout -->
<div class="push"></div>

<?php //include_once "footer.php";?></div>
<script src="js/ui.js"></script>
</body>
</html>
