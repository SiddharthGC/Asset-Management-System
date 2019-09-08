<?php
session_start();
include 'Connect.php';
include 'Alert.php';
include 'Filter.php';
include 'NotificationNumber.php';


if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
} 

$email = $_SESSION["Email"]; //Get the user who has logged in

$conn = connectDB("assetDB");
//$email = "hod_cse@mail.com";
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
	$buttondisplay = NULL;
}
$getmydeptsql = "select Dno from user where email='$email'";
$getmydept = mysqli_query($conn,$getmydeptsql);
foreach($getmydept as $dept) :
$dno = $dept['Dno'];
endforeach;
$staffsql = "select * from user where Dno='$dno' AND email not like '$email'";
$staffs = mysqli_query($conn,$staffsql);   // for delete user and transfer
?>

<!doctype html>
<html>
<head>
		<title>HOD/Dean MyControl</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/header_buttons.css"/>
        <link rel="stylesheet" type="text/css" href="css/button_hover_logout.css"/>
        <link href="css/main.css" rel="stylesheet">
		<link href="css/demo.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/style1.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/notification.css" />
		<link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />
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
  background:GREY;
  border-bottom:4px solid #9ea7af;
  border-right: 1px solid #343a45;
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
  background:#EBEBEB;
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

</style>

<script>
		$(function() {
			// Clickable Dropdown
			$('.click-nav > ul').toggleClass('no-js js');
			$('.click-nav .js ul').hide();
			$('.click-nav .js').click(function(e) {
				$('.click-nav .js ul').slideToggle(200);
				$('.clicker').toggleClass('active');
				e.stopPropagation();
			});
			$(document).click(function() {
				if ($('.click-nav .js ul').is(':visible')) {
					$('.click-nav .js ul', this).slideUp();
					$('.clicker').removeClass('active');
				}
			});
		});
</script>
<script>
function Logout()
{
	
		location.href = "Logout.php";

}
 //To enable delete user button after the user is chosen
function EnableDeleteUser()
{
	//alert("hello");
	var staffname1 = document.getElementById("staffname1").value;
	if(staffname!="")
	{
		var deleteuser = document.getElementById("deleteuser");
		deleteuser.disabled = false;
	}
} 
</script>

<script src="js/checkbox.js"></script>
    <script type="text/javascript">
        $(function () {    // To enable the assign ownership button once the asset and the user are chosen
            $('.chk1').change(function () {
                if ($(this).is(":checked")) {
					//alert("hello");
                    $('#AssignOwnership').removeAttr('disabled');
                }
                else {
                    var isChecked = false;
                    $('.chk1').each(function () {
                        if ($(this).is(":checked")) {
                            $('#AssignOwnership').removeAttr('disabled');
                            isChecked = true;
                        }
                    });
                    if (!isChecked) {
                        $('#AssignOwnership').attr('disabled', 'disabled');
                    }
                }
                if(document.getElementById("staffname").value=="")
					{
						document.getElementById("AssignOwnership").disabled = true;
					}
 
            })
        });
    </script>
<script type="text/javascript" src="Alert.js"></script>
<script src="js/tabs_old.js"></script>
<script src="js/modernizr17.js"></script>
<script src="js/tabsonline.js"></script>
<script src="js/index17.js"></script>
 <script>
function filterRecords() {	 // Function that sends information to filter for transfer asset page to display the assets.
	var assetid = document.getElementById("assetname");
	var assetname = assetid.options[assetid.selectedIndex].text;
    var staffemail = document.getElementById("staffname3").value;
	    if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","FilterForTransferPage.php?assetname="+assetname+"&staffemail="+staffemail,true);
        xmlhttp.send();
    
}
</script>
</head>
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
  
<div class="container" style="margin-top:3%">
	<ul class="tabs">
		<li class="tab-link current" data-tab="tab-2">Delete User</li>
	</ul>
<!-- Tab for delete user -->  
<div id="tab-2" class="tab-content current">
<div align="center" style="margin-top:2%">
  <form method="post" action = "hodmycontrol1.php">
  <label>Choose User:</label>
        <select id = "staffname1"  class="drop1" name="delstaff" style="width:190px ; height:40px ;">
  <option value=""disabled selected style="display : none">Staff</option>
  <?php foreach($staffs as $staff): 
  ?>
  <option value="<?php echo $staff['email'] ?>"><?php echo $staff['name']."-".$staff['ID'] ?></option>
  <?php 
  endforeach ?>
 </select>
 <br>
  <br>
  <input type='submit' class="btn waves-effect waves-light" name = 'deleteuser' id="deleteuser">
 </form>
 </div>
</div>

<?php

if(isset($_POST['deleteuser']))
{
	$useremail= $_POST['delstaff'];
	//echo $useremail;
	mysqli_autocommit($conn,false);
	// Deletion 
		$removeusersql = "DELETE from user where email = '$useremail'";
	    $userremoved= mysqli_query($conn,$removeusersql);
		if($userremoved)
		{
			mysqli_commit($conn);
			echo "<script>alertifyalert('The user is sucessfully deleted','hodmycontrol1.php')</script>";
		}
		else 
		{
			echo "<script>alertifyalert('Problem occurred in user deletion!!!')</script>";
		}
}

?>
<script type="text/javascript" src="js/backtotop.js"></script>
<script type="text/javascript" src="js/backtotop1.js"></script>
