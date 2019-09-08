<?php
session_start();
if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
} 
include 'Connect.php';
include 'Alert.php';
include 'Filter.php';
$email = $_SESSION["Email"]; 
$conn = connectDB("assetdb");

$getnotificationsql = "Select * from notifications where destinationEmail = '$email' AND status = 'Submitted' order by timeOfNotification desc";
$notificationresult = mysqli_query($conn,$getnotificationsql);

$notificationssql = "Select count(*) as count from notifications where destinationEmail='$email'";
$result = mysqli_query($conn,$notificationssql);
if($result)
{
	$row = mysqli_fetch_row($result);
	$countofnotifications = $row[0];
}

$user = getUserType($conn,$email);

//Display Mycontrol Tab to Principal,HOD and office users. and set moveto variable to appropriate page
if($user == "HOD" || $user=="Asset Manager" ||$user =="Principal")
{
	$display = "visible";
	if($user == "HOD")
	{
		$moveto = "hodmycontrol1.php";  //Hod will have hodmycontrol page
		$buttondisplay = "Waive Ownership";
	}
	elseif($user == "Asset Manager")
	{
		$moveto = "deptprincipalmycontrol.php";      //Dept office user will have departmentmycontrol page
        $buttondisplay = NULL;		
	}
	elseif($user == "Principal")
	{
		$moveto = "principalmycontrol.php"; //Principal will have principalmycontrol page
		$buttondisplay = "Waive Ownership";
	}
}
else{
	$display = "none"; // if normal user the tab will not be displayed
}

function GetBetween($var1="",$var2="",$pool)
{
$temp1 = strpos($pool,$var1)+strlen($var1);
$result = substr($pool,$temp1,strlen($pool));
$dd=strpos($result,$var2);
if($dd == 0)
{
	$dd = strlen($result);
}
return substr($result,0,$dd);
}
?>
<!doctype html>
<html>
<head>
        <title>Notifications</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/header_buttons.css"/>
        <link rel="stylesheet" type="text/css" href="css/button_hover_logout.css"/>
        <link href="css/main.css" rel="stylesheet">
		<link href="css/demo.css" rel="stylesheet">
        <!--<link href="css/style.css" rel="stylesheet" type="text/css">-->
        <link href="css/style1.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/demo1.css" />
		<!-- common styles -->
		<link rel="stylesheet" type="text/css" href="css/dialog.css" />
		<!-- individual effect -->
		<link rel="stylesheet" type="text/css" href="css/dialog-cathy.css" />
		        <link rel="stylesheet" type="text/css" href="css/notification.css" />

<meta charset="utf-8">

<style type="text/css">

@font-face {
	font-weight: normal;
	font-style:normal;
	font-family:'Raleway';
	src:url(font/Raleway/Arvo-Regular.ttf)format('truetype');
}

*{font-family:Raleway;}

body {
	background:url(PurLEvz.jpg) no-repeat center center fixed;
	-webkit-background-size: cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	height:100%;
	width:100%;

}

body::-webkit-scrollbar{
	display:none;
}

.tablesubmit{
background-color:transparent;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #2200CC;
cursor: pointer;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size:16px;
height: 50px;	
text-transform: uppercase;
width: auto;
-webkit-appearance:none;
}
.submit{
 cursor:pointer;
 border-width:0px;
 border-style:solid;
 border-color:#000000;
 -webkit-border-radius: 9px;
 -moz-border-radius: 9px;
 border-radius: 9px;
 text-align:center;
 width:10%;
 height:40px;
 padding-top:undefinedpx;
 padding-bottom:undefinedpx;
 font-size:19px;
 font-family:arial;
 color:#ffffff;
 background:#1253ec;
 text-shadow: 2px 2px 0px #000000;
 display:inline-block;
 }
 
 form select {
background-color: #e5e5e5;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
outline: none;
padding: 0px 10px;
width:190px ;
 height:40px;
-webkit-appearance:none;
}

.drop1 {
background-color: #e5e5e5;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
outline: none;
padding: 0px 10px;
width:190px ;
 height:40px;
-webkit-appearance:none;
}

.Box1{
background-color: #e5e5e5;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 100%;
height: 50px;
outline: none;
width: 270px;
-webkitappearance:none;
padding-left:1%;
-webkit-appearance:none;
}
@import url(http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100);

body {
  background-color: #3e94ec;
  font-family: "Roboto", helvetica, arial, sans-serif;
  font-size: 16px;
  font-weight: 400;
  text-rendering: optimizeLegibility;
}

div.table-title {
   display: block;
  margin: auto;
  max-width: 600px;
  padding:5px;
  width: 100%;
}

.table-title h3 {
   color: #fafafa;
   font-size: 30px;
   font-weight: 400;
   font-style:normal;
   font-family: "Roboto", helvetica, arial, sans-serif;
   text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
   text-transform:uppercase;
}


/*** Table Styles **/

.table-fill {
  background: white;
  border-radius:3px;
  border-collapse: collapse;
  height: 320px;
  margin: auto;
  max-width: 600px;
  padding:5px;
  width: 100%;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  animation: float 5s infinite;
}
 
th {
  color:#D5DDE5;;
  background:BLACK;
  border-bottom:4px solid #9ea7af;
  font-size:23px;
  font-weight: 100;
  padding:24px;
  text-align:left;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  vertical-align:middle;
}

th:first-child {
  border-top-left-radius:3px;
}
 
th:last-child {
  border-top-right-radius:3px;
  border-right:none;
}
  
tr {
  border-top: 1px solid #C1C3D1;
  border-bottom-: 1px solid #C1C3D1;
  color:#666B85;
  font-size:16px;
  font-weight:normal;
  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
}
 
tr:hover td {
  background:#4E5066;
  color:#FFFFFF;
  border-top: 1px solid #22262e;
  border-bottom: 1px solid #22262e;
}
 
tr:first-child {
  border-top:none;
}

tr:last-child {
  border-bottom:none;
}
 
tr:nth-child(odd) td {
  background:#AAAAAA;
}
 
tr:nth-child(odd):hover td {
  background:#4E5066;
}

tr:last-child td:first-child {
  border-bottom-left-radius:3px;
}
 
tr:last-child td:last-child {
  border-bottom-right-radius:3px;
}
 
td {
  background:#FFFFFF;
  padding:20px;
  text-align:left;
  vertical-align:middle;
  font-weight:300;
  font-size:18px;
  text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
  border-right: 1px solid #C1C3D1;
}

td:last-child {
  border-right: 0px;
}

th.text-left {
  text-align: left;
}

th.text-center {
  text-align: center;
}

th.text-right {
  text-align: right;
}

td.text-left {
  text-align: left;
}

td.text-center {
  text-align: center;
}

td.text-right {
  text-align: right;
}
.PreviewTable table tbody tr td{
 vertical-align:middle;
 height:39px;
 text-align:center;
 font-weight:bold;
 color:#000000;
 font-family:Times New Roman;
 font-size:18px;
 border-width:0px 0px 1px 0px;
</style>
</head>

<script>
function Logout()
{
	
		location.href = "Logout.php";
	
}
</script>
<script>
function manageNotifications(choicemade,primarykey,email)
{
	var choice = choicemade;
	var notificationnumber = primarykey;
	//alert(notificationnumber);
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        
        }
	var requestedemail = email;
	requestedemail = encodeURIComponent(requestedemail);
	//alert(requestedemail+choice);
	xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
	xmlhttp.open("GET","UpdateNotifications.php?choice="+choice+"&notificationnumber="+notificationnumber+"&requestedemail="+requestedemail,true);
    xmlhttp.send();
}
</script>
<body>
<div align="left">
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; position:relative; margin-left:6% "></a><br><br><br><br>
</div>
<ul class="menu" style="margin-top:-55px; margin-left:60%; position:""; ">
    <li
	<!-- Notifications button -->
    	<a href="notifications.php">
    		Notifications
    		<span class="bubble"><?php echo $countofnotifications ?></span>
    	</a>
    </li>
</ul>
<!--Drop down on the side to display following information -->
<div class="click-nav" style="position:relative; margin-top:-35px ; margin-left:75% ;">
			<ul class="no-js">
				<li>
					<a class="clicker"><img src="img/i-1.png" alt="Icon">Profile</a>
					<ul>
						<li><a href="profile.php"><img src="img/i-2.png" alt="Icon">View Profile</a></li>
						<li><a href="help.php"><img src="img/i-5.png" alt="Icon">Help</a></li>
						<li><a onClick="Logout()"><img src="img/i-6.png" alt="Icon">Sign out</a></li>
					</ul>
				</li>
			</ul>
</div>
	
<!-- Main tabs or links to other pages -->	
<div style="height:42.8px ; background-color:#505963; white-space:nowrap ; margin-top:-75px"> 
         <section class="color-7">
				<nav class="cl-effect-21">
					<a href="homepage.php"><font color="white">Home</font></a>
                    <?php if($user=="Asset Manager") { ?><?php if($user=="Asset Manager") { ?><?php if($user=="Asset Manager") { ?><a href="searchassets.php"><font color="white">Search Assets</font></a><?php } elseif($user!="staff") { ?><a href="searchassets.php"><font color="white">Transfer Assets</font></a><?php } else { ?><a href="searchassets.php"><font color="white">View Available Assets</font></a><?php } ?><?php } elseif($user!="staff") { ?><a href="searchassets.php"><font color="white">Transfer Assets</font></a><?php } else { ?><a href="searchassets.php"><font color="white">View Available Assets</font></a><?php } ?><?php } elseif($user!="staff") { ?><a href="searchassets.php"><font color="white">Transfer Assets</font></a><?php } else { ?><a href="searchassets.php"><font color="white">View Available Assets</font></a><?php } ?>
										
					<a href="<?php echo $moveto ?>" style="display :<?php echo $display ?>"><font color="white">My Control</font></a>                 
				</nav>
			</section>
</div>	
<?php
if(mysqli_num_rows($notificationresult)>0)
{?>
<form method = "post" action="notifications.php" id = "changestatusform">
<div id="TableCodePreview" class="PreviewTable" align="center" style="position:relative; width:80% ; margin-top:2% ; margin-left:auto ; margin-right:auto ; table-layout:fixed">

<table>
<thead>
                <tr>  
				    <th><label>Time</label></th>
                    <th><label>Message</label></th>
                    <th><label>Status</label></th>
                </tr>
            </thead>
<tbody>
<?php foreach ($notificationresult as $row) : 
//$key = $row['DestinationEmail']."/".$row['NotificationType']."/".$row['TimeOfNotification'];
$notificationnumber = $row['notificationNumber'];
?>
<tr>	
<td><?php echo  $row["timeOfNotification"]?></td>
<td><?php echo  $row["message"]?></td>
<td>
<?php
if ($row['type'] == "1")
{
    $requestedemail = GetBetween("[","]",$row['message']);
?>
<input type="button" name = "accept" value = "Accept" onClick = "manageNotifications('Accept','<?php echo $notificationnumber ?>','<?php echo $requestedemail?>')">/
<input type="button" name = "decline" value = "Decline" onClick = "manageNotifications('Decline','<?php echo $notificationnumber ?>','<?php echo $requestedemail?>')">
<?php }
elseif($row['type'] == "12")
{
  $requestedemail = GetBetween("[","]",$row['message']);  	
?>
 <input type="button" name = "accept" value = "acceptit" onClick = "manageNotifications('acceptit','<?php echo $notificationnumber ?>','<?php echo $requestedemail?>')">/
<input type="button" name = "decline" value = "declineit" onClick = "manageNotifications('declineit','<?php echo $notificationnumber ?>','<?php echo $requestedemail?>')">

<?php
}
elseif($row['type']=='10')
{
	$splitmessage = explode(" ",$row['message']);
	$requestedemail = $splitmessage[4];
?>
<input type="button" name = "accept" value = "Reset" onClick = "manageNotifications('Reset','<?php echo $notificationnumber ?>','<?php echo $requestedemail?>')">
<?php	
} 
else
{?> 
<input type="button" name = "delete" value = "Delete" onClick="manageNotifications('Delete','<?php echo $notificationnumber ?>')">
<?php } ?>
</td>
</tr>
<?php endforeach ?>
</tbody>
</table>
</div>
<?php
}
else
{
	echo " You don't have recent notifications";
}
?>
<div id="txtHint" style="margin-left:-11%; margin-right:auto; margin-top:3%"></div>
<?php

?>
</body>
<script type="text/javascript" src="js/backtotop.js"></script>
<script type="text/javascript" src="js/backtotop1.js"></script>
</html>