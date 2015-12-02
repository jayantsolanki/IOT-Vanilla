<?php 
/*
*Project: eYSIP_2015_IoT-Connected-valves-for-irrigation-of-greenhouse
*Team members: Jayant Solanki, Kevin D'Souza
*File name: time.php
*Author: Jayant Solanki
*display options to user for time scheduling
*options are, period, duration and frequency
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
<title>Schedule</title>
<?php include 'favicon.php';?>
</head>

<?php include_once 'css.php'; ?>
<script type='text/javascript' src='script/jquery-1.9.1.min.js'></script>
<script type='text/javascript'>
$(document).ready(function () {
  $('.choose').hide();
  $('#grps').change(function () {
    $('.choose').show();
    
  })
});
</script>
<script type='text/javascript'>
$(document).ready(function () {
  $('.time').hide();
  //$('#period').show();
  $('#time').change(function () {
    $('.time').hide();
    $('#'+$(this).val()).show();
  })
});
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: del(str)
 * Input: str, task id, for deletion
 * Output: deletes the selected task
 * Logic: It is a AJAX call
 * Example Call: del(12)
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
	  document.getElementById(str).innerHTML="Switching ....";
	  }
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("display").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','timetasker.php?del='+str,true);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: period()
 * Input: -
 * Output: updates tasks table with start and stop time for a group, in period format
 * Logic: It is a AJAX call
 * Example Call: period()
 *
 */
function period()
{
var grp=document.getElementById("grps").value;
var starth=document.getElementById("starth").value;
var startm=document.getElementById("startm").value;
var stoph=document.getElementById("stoph").value;
var stopm=document.getElementById("stopm").value;
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
    document.getElementById("display").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','timetasker.php?grp='+grp+'&starth='+starth+'&startm='+startm+'&stoph='+stoph+'&stopm='+stopm,true);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: duration()
 * Input: -
 * Output: updates tasks table with start and stop time for a group, in duration format
 * Logic: It is a AJAX call
 * Example Call: duration()
 *
 */
function duration()
{
var grp=document.getElementById("grps").value;
var starth=document.getElementById("dstarth").value;
var startm=document.getElementById("dstartm").value;
var duration=document.getElementById("dduration").value;

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
    document.getElementById("display").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','timetasker.php?grp='+grp+'&starth='+starth+'&startm='+startm+'&duration='+duration,true);
xmlhttp.send();
}
</script>
<script type='text/javascript'>
/*
 *
 * Function Name: frequency()
 * Input: -
 * Output: updates tasks table with start and stop time for a group, in frequency format
 * Logic: It is a AJAX call
 * Example Call: frequency()
 *
 */
function frequency()
{
var grp=document.getElementById("grps").value;
var starth=document.getElementById("fstarth").value;
var duration=document.getElementById("fduration").value;
var repeath=document.getElementById("repeath").value;

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
    document.getElementById("display").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open('GET','timetasker.php?grp='+grp+'&starth='+starth+'&repeath='+repeath+'&duration='+duration,true);
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
      <h2>Add Schedule</h2>
    </div>

    <div class="content">

<b>Choose Group</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select id="grps">
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

</select>
<div class='choose'>
<b>Type of Schedule</b>&nbsp;&nbsp;&nbsp;<select id="time">
<option selected="true" disabled='disabled'>Choose</option>
  <option value="period">Period</option>
  <option value="duration">Duration</option>
  <option value="frequency">Frequency</option>
</select>
<div id='period' class="time">
<pre>
</br>
<span style='color:#3B5998;font-weight:normal;'>Start time:(hhmm)</span>

<?php
echo "Hrs:<select id='starth' name='starth'>";
$i=0; 
while($i<=24)
{
echo "<option value='$i'>$i</option>";
$i++;
} 
echo "</select>";
echo " Mins:<select id='startm' name='startm'>";
$j=0; 
while($j<=60)
{
echo "<option value='$j'>$j</option>";
$j=$j+5;
} 
echo "</select>";
?>

</br><span style='color:#3B5998;font-weight:normal;
    '>Stop time:(hhmm)</span></br>
<?php
echo "Hrs:<select id='stoph' name='stoph'>";
$i=0; 
while($i<=24)
{
echo "<option value='$i'>$i</option>";
$i++;
} 
echo "</select>";
echo " Mins:<select id='stopm' name='stopm'>";
$j=0; 
while($j<=60)
{
echo "<option value='$j'>$j</option>";
$j=$j+5;
} 
echo "</select>";
?>
</br>
<input type='submit' name='submit' onclick='period()' value='Submit' />
</pre>
</div>
<div id='duration' class="time">
<pre>


<span style='color:#3B5998;font-weight:normal;'>Start time:(hhmm)</span></br>
<?php
echo "Hrs:<select id='dstarth' name='starth'>";
$i=0; 
while($i<=24)
{
echo "<option value='$i'>$i</option>";
$i++;
} 
echo "</select>";
echo " Mins:<select id='dstartm' name='startm'>";
$j=0; 
while($j<=60)
{
echo "<option value='$j'>$j</option>";
$j=$j+5;
} 
echo "</select>";
?>
</br></br><span style='color:#3B5998;font-weight:normal;'>Duration:(mm)</span></br>
<?php

echo "Mins:<select id='dduration' name='duration'>";
$j=5; 
while($j<=60)
{
echo "<option value='$j'>$j</option>";
$j=$j+5;
} 
echo "</select>";
?>
</br>
<input type='submit' name='submit' onclick='duration()' value='Submit' />

</pre>
</div>
<div id='frequency' class="time">
<pre>


<span style='color:#3B5998;font-weight:normal;'>Start time:(hhmm)</span></br>
<?php
echo "Hrs:<select id='fstarth' name='starth'>";
$i=0; 
while($i<=24)
{
echo "<option value='$i'>$i</option>";
$i++;
} 
echo "</select>";
echo "</br></br><span style='color:#3B5998;font-weight:normal;'>Duration:(mm)</span></br>";
echo "Mins:<select id='fduration' name='duration'>";
$j=5; 
while($j<=60)
{
echo "<option value='$j'>$j</option>";
$j=$j+5;
} 
echo "</select>";

?>
</br></br><span style='color:#3B5998;font-weight:normal;'>Repeat after every :(hh)</span></br>
<?php

echo "Hrs:<select id='repeath' name='repeath'>";
$i=4; 
while($i<=12)
{
echo "<option value='$i'>$i</option>";
$i=$i+4;
} 
echo "</select>";
?>
</br>
<input type='submit' name='submit' onclick='frequency()' value='Submit' />

</pre>
</div>
</div>

<div id='display'>
<?php display();?>
</div>
  </div><!-- end of content div -->
<?php
include_once "app.php";?>
    </div><!-- end of main div -->
</div><!-- end of layout -->
   
<div class="push"></div>
<?php //include_once "footer.php";?></div>
<?php


/*
 *
 * Function Name: display()
 * Input: -
 * Output: display the scheduled tasks
 * Logic: fetches tasks from tasks table
 * 
 *
 */
function display()
{
	$dbname='IOT';
	mysql_select_db($dbname) or die(mysql_error());
	$query="SELECT * FROM tasks"; //displaying scheduled tasks
	$results=mysql_query($query);
	if (mysql_num_rows($results) > 0) 
	{	$i=1;
		echo "</br></br><h2>Scheduled Tasks</h2>";		
		while($row=mysql_fetch_assoc($results)) 
		{	$id=$row['id'];
			$start=$row['start'];
			$stop=$row['stop']; //online offline or new, 1, 0, 2
			$item=$row['item'];
			if($start>=2100 or $start<=300)
				$status="<span style='color:#FF0000;font-weight:bold;'>Shouldn't water plants during night</span>";
			else
				$status='';
			echo "<span style='color:#3B5998;font-weight:normal;'><b>Task ".$i."</b>&nbsp; &nbsp;<b>Item:</b> $item&nbsp; &nbsp; Start time : $start &nbsp; &nbsp; Stop time : $stop </span>&nbsp;<a href='javascript:del($id)'><b>DELETE</b></a> &nbsp; $status<hr>";
			$i++;
		
		
		}
	}
	else
	{
		echo "</br><div class='notice'><b>No Tasks scheduled yet.</b></div>";
	}

}
?>
<script src="js/ui.js"></script>
</body>
</html>
