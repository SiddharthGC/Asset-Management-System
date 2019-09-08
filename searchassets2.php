
<?php

session_start();

//If the user has not logged in redirects to index page
if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
}

$_SESSION["id"]=null;
$email = $_SESSION["Email"];
$uemail = $email;
//Get the values from searchassets
$name = $_POST['items'];
$dno = $_POST['department'];

include 'Connect.php';
include 'Filter.php';
include 'Alert.php';
// Create connection
$conn = connectDB("assetdb");
// Check connection

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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



$notificationssql = "Select count(*) as count from notifications where destinationEmail='$email'";
$result = mysqli_query($conn,$notificationssql);
if($result)
{
	$row = mysqli_fetch_row($result);
	$countofnotifications = $row[0];
}

?>
<!doctype html>
<html>
<head>
		<title>Search Assets</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/header_buttons.css"/>
        <link rel="stylesheet" type="text/css" href="css/button_hover_logout.css"/>
        <link href="css/main.css" rel="stylesheet">
		<link href="css/demo.css" rel="stylesheet">
        <!--<link href="css/style.css" rel="stylesheet" type="text/css">-->
        <link rel="stylesheet" type="text/css" href="css/notification.css" />
		<link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />
		<link rel="stylesheet" type="text/css" href="css/randombutton.css" />
     
        
<meta charset="utf-8">
<style type="text/css">
.scroll-top-wrapper {
    position: relative;
	opacity: 0;
	visibility: hidden;
	overflow: hidden;
	text-align: center;
	z-index: 99999999;
    background-color: #777777;
	color: #eeeeee;
	width:100px;
	height: 48px;
	float:right;
	line-height: 48px;
	margin-right: 1.5%;
	padding-top: 2px;
	border-top-left-radius: 10px;
	border-top-right-radius: 10px;
	border-bottom-right-radius: 10px;
	border-bottom-left-radius: 10px;
	-webkit-transition: all 0.5s ease-in-out;
	-moz-transition: all 0.5s ease-in-out;
	-ms-transition: all 0.5s ease-in-out;
	-o-transition: all 0.5s ease-in-out;
	transition: all 0.5s ease-in-out;
}
.scroll-top-wrapper:hover {
	background-color: #888888;
}
.scroll-top-wrapper.show {
    visibility:visible;
    cursor:pointer;
	opacity: 1.0;
}

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
 
 form fieldset input[type="text"], select {
background-color: #e5e5e5;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
height: 50px;
outline: none;
padding: 0px 10px;
width: 350px;
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
 
$(function(){
 
	$(document).on( 'scroll', function(){
 
		if ($(window).scrollTop() > 100) {
			$('.scroll-top-wrapper').addClass('show');
		} else {
			$('.scroll-top-wrapper').removeClass('show');
		}
	});
 
	$('.scroll-top-wrapper').on('click', scrollToTop);
});
 
//To scroll to the top of the page 
function scrollToTop() {
	verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
	element = $('body');
	offset = element.offset();
	offsetTop = offset.top;
	$('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
}
</script>
<script>
function filterstaff(selected)
{
	//alert("hello");
	//alert(selected.value);
	var useremail = "<?php echo $uemail; ?>";
	//alert(useremail);
	var staffs = <?php echo $staffsjson ?>;
	var staffslength = staffs.length;
	var filteredstaffs=[];
	var sel = document.getElementById('staffname');
	sel.innerHTML = "";
	var opt = document.createElement('option');
			opt.innerHTML = "By Staff";
            opt.value = "";
            sel.appendChild(opt);
	if(document.getElementById("departmentname").value != "All")
	{
	for (var i=0;i<staffslength;i++)
	{
		if(staffs[i].departmentid == selected.value && staffs[i].email != useremail)
		{
			var opt = document.createElement('option');
			opt.innerHTML = staffs[i].name+"-"+staffs[i].employeeid;
            opt.value = staffs[i].email;
            sel.appendChild(opt);
		}
	}
	}
	else
	{
    for (var j=0;j<staffslength;j++)
	{
			var opt = document.createElement('option');
			opt.innerHTML = staffs[j].name+"-"+staffs[j].employeeid;
            opt.value = staffs[j].email;
            sel.appendChild(opt);
	}
	}
	//alert(sel.length);
}
</script>
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
    function filterRecords() { 
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
        xmlhttp.open("GET","FilterForSearchAssetsPage.php?assetname="+assetname+"&departmentid="+departmentid,true);
        xmlhttp.send();
    
}
</script>
<script>
function Logout()
{
		location.href = "Logout.php";
}
</script>
<script src="js/modernizr.custom.js"></script>
<body onload="filterstaff(this)">
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
<!--changed function name -->
<?php if($user=="Asset Manager") {
	
if($name=="All")
{
	if($dno=="All")
	{
		$sql = "SELECT assetID,name,status FROM assets where assetID not like 'OB%'"; 
	}
	else
	{
		$gettagsql = "Select Tag from department where Dno='$dno'";
		$gettag = mysqli_query($conn,$gettagsql);
		foreach($gettag as $tag) :
		$depttag = $tag['Tag'];
		endforeach;
		$sql = "SELECT assetID,name,status FROM assets where assetID like '$depttag%'"; 
	}
}
else
{
	if($dno=="All")
	{
		$sql = "SELECT assetID,name,status FROM assets where assetID not like 'OB%' and name='$name'"; 
	}
	else
	{
		$gettagsql = "Select Tag from department where Dno='$dno'";
		$gettag = mysqli_query($conn,$gettagsql);
		foreach($gettag as $tag) :
		$depttag = $tag['Tag'];
		endforeach;
		$sql = "SELECT assetID,name,status FROM assets where assetID like '$depttag' and name='$name'"; 
	}
}
 $result = mysqli_query($conn,$sql);
 if($result && mysqli_num_rows($result)>0)
{ ?>
  <form id = "movetoassetinfoform" action="assetinfo.php" method="post">	
<div id="TableCodePreview" class="PreviewTable" style="position:relative; width:80% ; margin-top:2% ; margin-left:auto ; margin-right:auto ; table-layout:fixed">
<table style="width: 100%; white-space:normal;
              table-layout: fixed;">
<thead>
                <tr> 
                    
                   <th style="width: 120px"><label><center>Asset id</center></label></th>
                    <th style="width: 200px;"><label><center>Asset Name</center></label></th> 
                   <th style="width: 100px"><label><center>Status</center></label></th>
                </tr>
            </thead>
<tbody>
<?php
foreach ($result as $row) : ?>
<tr>
<td><input form="movetoassetinfoform" type="submit" name="Viewassetinfo" class="tablesubmit" value="<?php echo $row['assetID']; ?>" > </td>
<td style="width:100px; word-wrap:break-word;"><?php echo  $row["name"]  ?></td>
<td><?php echo  $row["status"]  ?></td>
</tr>
<?php endforeach ; 
}
else
{
	echo "Sorry no assets found for your selection. Please try different combination!";
}
}
mysqli_close($conn);?>
</body>
</html>									
<script>
		(function(){

			[].slice.call( document.querySelectorAll( '.tabs' ) ).forEach( function( el ) {
					new CBPFWTabs( el );
			});

		})();
</script>
<script type="text/javascript" src="js/backtotop.js"></script>
<script type="text/javascript" src="js/backtotop1.js"></script>        
