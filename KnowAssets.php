<?php

session_start();
header('Cache-Control: no cache'); //no cache
session_cache_limiter('must-revalidate');

if($_SESSION['Email']==null)
{
	header('Location:http://localhost/Asset/index.php');
}
if(!(preg_match('/^hod/',$_SESSION['Email'])||preg_match('/^dean/',$_SESSION['Email'])|| $_SESSION['Email']== "principal@psg.psgtech.ac.in"))
{
	header('Location:http://localhost/Asset/logout.php');
}
$email = $_SESSION['Email'];   

?>
<!doctype html>
<html>
<head>
        <title>View Assets</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/header_buttons.css"/>
        <link rel="stylesheet" type="text/css" href="css/button_hover_logout.css"/>
        <link href="css/main.css" rel="stylesheet">
		<link href="css/demo.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="css/notification.css" />
        <link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />
        
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
 
 form fieldset , select {
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

.input {
background-color: #e5e5e5;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 100%;
height: 40px;
outline: none;
width:178px;
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


<script src="js/modernizr.custom.js"></script>
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
		function changeDateFormat(date){
					var date1split = date.split("/");
	                var finaldate = date1split[2]+"-"+date1split[0]+"-"+date1split[1] ;
	                return finaldate;
				}
		function filterRecords(resulttype) {
			var email="<?php echo $email; ?>";
			var chk = "principal@psg.psgtech.ac.in";
			if(email == chk)
			{
				var departmentid = document.getElementById("departmentname").value;
			}
			else
			{
				var staffid = document.getElementById("staffname"); 
                var staffname = staffid.options[staffid.selectedIndex].value;
			}
	var assetid = document.getElementById("assetname");
	var assetname = assetid.options[assetid.selectedIndex].text;
	var supplierid = document.getElementById("suppliername");
	var suppliername = supplierid.options[supplierid.selectedIndex].text;
	suppliername = encodeURIComponent(suppliername);
	var minvalue = document.getElementById("minvalue").value;
	var maxvalue = document.getElementById("maxvalue").value;
	var pattern =new RegExp('^[0-9]*$');
	var minvalueresult = false;
	var maxvalueresult = false;
	minvalueresult = pattern.test(minvalue);
	maxvalueresult = pattern.test(maxvalue);
	if(minvalueresult&&maxvalueresult)
	{
	var from =document.getElementById("datepicker").value;
	if(from == "")
	{
		from = "0000-00-00";
	}
	else
	{
	    from = changeDateFormat(from);
	}
	var to = document.getElementById("datepicker1").value;
	if(to == "")
	{
		to = "2200-12-31";
	}
	else
	{
	    to = changeDateFormat(to);
	}
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
           xmlhttp.open("GET","FilterforKnowAssetsPage.php?assetname="+assetname+"&departmentid="+departmentid+"&staffname="+staffname+"&suppliername="+suppliername+"&minvalue="+minvalue+"&maxvalue="+maxvalue+"&from="+from+"&to="+to+"&resulttype="+resulttype,true);
     xmlhttp.send();
	}
    else
	{
		alertifyalert("Enter the values for min value and max value properly without punctuation(s) E.g:50000","Knowassets.php");
	}
}
</script>
<script>
function Logout()
{

		location.href = "Logout.php";
	
}
</script>
</head>
<body>
<?php
//------------------------

include 'Connect.php';
include 'Alert.php';
include 'Filter.php';


$_SESSION["id"]=null;


$emailexplode = explode("@",$email);
$user = $emailexplode[0];

if($user == "hod" || $user=="dept" ||$user =="principal" || $user == "dean")
{
	$display = "visible";
	if($user == "hod" || $user == "dean")
	{
		$moveto = "hodmycontrol1.php";
	}
	elseif($user == "dept")
	{
		$moveto = "addasset.php";
	}
	else
	{
		$moveto = "principalmycontrol.php";
	}
}
else{
	$display = "none";
}


// Create connection
$conn = connectDB("assetsdb");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$notificationssql = "Select count(*) as count from notificationsinfo where DestinationEmail='$email'";
$result = mysqli_query($conn,$notificationssql);
if($result)
{
	$row = mysqli_fetch_row($result);
	$countofnotifications = $row[0];
}
//--------------------------------
//Get the values to display in drop-down list
$assets = listAssets($conn,$email);
$departments = listDepartments($conn);
$staffs =  listStaff($conn,$email);
$suppliers = listSuppliers($conn,$email);
?>
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
<div style="height:42.8px ; background-color:#FFF9F9; white-space:nowrap ; margin-top:-75px"> 
         <section class="color-7">
				<nav class="cl-effect-21">
					<a href="homepage.php">Home</a>
					<a href="searchassets.php">Search Assets</a>
					<a href="Activities.php">Activities</a>					
					<a href="<?php echo $moveto ?>" style="display :<?php echo $display ?>">My Control</a>                 
				</nav>
			</section>
</div>
<!--changed function name -->
<div style=" margin-left:16%; margin-top:1%">
<label style="font-size:23px">Search:</label>
</div>
<div style="position:relative ; margin-top:1% ; margin-left:16% ; margin-right:7.5% ; white-space:nowrap">
<!--Dropdownlist to choose asset name-->
<select id = "assetname" name="items" style="width:190px ; height:40px">
  <option value=""disabled selected style='display:none'>By Items</option>
  <option value="All">All</option>
  <?php foreach($assets as $asset): ?>
  <option value="<?php echo $asset['AssetName'] ?>"><?php echo $asset['AssetName'] ?></option>
  <?php endforeach ?>
</select>
<!--Dropdownlist to choose department name-->
<?php 
if($email == "principal@psg.psgtech.ac.in")       // To be replaced with original id
{ ?>
<select id = "departmentname" name="department" style="width:190px ; height:40px ; margin-left:10%">
  <option value=""disabled selected style='display:none'>By Department</option>
  <option value="All">All</option>
  <?php foreach($departments as $department): ?>
  <option value="<?php echo $department['DepartmentID'] ?>"><?php echo $department['DepartmentName'] ?></option>
  <?php endforeach ?>
</select>
<?php 
}
else
{ 
?>
<!--Dropdownlist to choose staff name-->
<select id = "staffname" name="staff" style="width:190px ; height:40px ; margin-left:10%">
  <option value=""disabled selected style='display:none'>By Staff</option>
  <option value="All">All</option>
  <?php foreach($staffs as $staff): ?>
  <option value="<?php echo $staff['Email'] ?>"><?php echo $staff['Name'] ?></option>
  <?php endforeach ?>
 </select>
<?php } ?>
<!--Dropdownlist to choose supplier name-->
<select id = "suppliername" name="supplier" style="width:190px ; height:40px ; margin-left:10%">
  <option value=""disabled selected style='display:none'>By Supplier</option>
  <option value="All">All</option>
  <?php foreach($suppliers as $supplier): ?>
  <option value="<?php echo $supplier['SupplierName'] ?>"><?php echo $supplier['SupplierName'] ?></option>
  <?php endforeach ?>
</select>
<!-- Price Range -->
<div style="margin-top:1%">
<label style="font-size:23px">Price Range:</label>

<p><input class="input" id="minvalue" type="text" style=" margin-top:1%" title="Enter minimum product price" placeholder="Minimum Price">
<input class="input" id="maxvalue" type="text"  style=" margin-left:10% ; margin-top:1%"  title="Enter maximum product price"placeholder="Maximum Price"></p>
</div>

<!-- Specifying Period  -->
<div style="margin-top:1%">
<label style="font-size:23px">Period:</label>

<p><input  class="input" name="datepicker" id="datepicker" type="text"  style=" margin-top:1%" placeholder="Start Date">
<input  class="input" name="datepicker1" id="datepicker1" type="text" style=" margin-left:10% ; margin-top:1%"  placeholder="End Date"></p>
</div>
<br>
<input type="button" class="btn waves-effect waves-light" name = "displayassets" id="displayassets" Value = "Display Assets" onClick="filterRecords('2')"/>
<input type="button" class="btn waves-effect waves-light" name = "displaysummary" id="displaysummary" style="margin-left:10%" Value = "Display Summary" onClick="filterRecords('3')"/>

<div id="txtHint" style="margin-left:-11%; margin-right:auto; margin-top:3%"></div>
</div>
<br>
<br>
<br>
<br>
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
 
function scrollToTop() {
	verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
	element = $('body');
	offset = element.offset();
	offsetTop = offset.top;
	$('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
}
</script>
<script  src="js/datepicker1.js"></script>   
  <script src="js/datepicker2.js"></script>
  <script>
    $(document).ready(
  
 
  function () {
    $( "#datepicker" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
    </script>
      <script>
    $(document).ready(
  
 
  function () {
    $( "#datepicker1" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
  }

);
    </script>
