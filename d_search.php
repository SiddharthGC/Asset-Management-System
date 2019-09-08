<!doctype html>
<html>
<head>
		<title>Search Assets</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/header_buttons.css"/>
        <link rel="stylesheet" type="text/css" href="css/button_hover_logout.css"/>
        <link href="css/main.css" rel="stylesheet">
		<link href="css/demo.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet" type="text/css">
                <link rel="stylesheet" type="text/css" href="css/notification.css" />
     
        
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
</style>
</head>

<?php
session_start();

//If the user has not logged in redirects to index page

$_SESSION["id"]=null;
$email = "dept@cse.psgtech.ac.in";
$uemail = $email;

include 'Connect.php';
include 'Filter.php';
include 'Alert.php';


$emailexplode = explode("@",$email);    //--------------------------------------------------------------------------
$user = $emailexplode[0];

//$display = "none";
if($user == "hod" || $user=="dept" ||$user =="principal" || $user =="dean")
{
	$display = "visible";
	if($user == "hod" || $user == "dean")
	{
		$moveto = "hodmycontrol1.php";
	}
	elseif($user == "dept")
	{
		if($email == "dept@psg.psgtech.ac.in")
		{
			$moveto = "deptprincipalmycontrol.php";      //Dept office user will have departmentmycontrol page 	
		}
		else
		{
			$moveto = "addasset.php";      //Dept office user will have departmentmycontrol page 
		}
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

//Get the values to display in drop-down list
$assets = listAssets($conn,"");
$departments = listDepartments($conn);
$staffs =  listStaffs($conn); //$mySweetJSONString = json_encode($myAssocPHPArray);
foreach($staffs as $staff)
{
	$name = $staff['Name'];
	$employeeid = $staff['EmployeeID'];
	$email = $staff['Email'];
	$departmentid = $staff['DepartmentID'];
	$employees[] = array('name'=> $name,'employeeid'=> $employeeid,'email'=> $email,'departmentid'=> $departmentid);
}
$staffsjson = json_encode($employees);
//echo $staffsjson;
?>
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
	var assetid = document.getElementById("assetname");
	var assetname = assetid.options[assetid.selectedIndex].text;
    var departmentid = document.getElementById("departmentname").value;
	var staffemail = document.getElementById("staffname").value; 
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
        xmlhttp.open("GET","FilterForSearchAssetsPage.php?assetname="+assetname+"&departmentid="+departmentid+"&staffemail="+staffemail,true);
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
<div style=" margin-left:16%; margin-top:1% ;">
<label style="font-size:23px">Search:</label>
<?php 
//If the user is hod or principal then then have additional privilege of advanced search
if(preg_match('/^hod/',$email)||preg_match('/^dean/',$email)|| $email== "principal@psg.psgtech.ac.in")
{
	?>
	<form method="post" action="http://localhost/Asset/knowassets.php" style="margin-top:-2% ; margin-left:69%">
    <button type="submit">Advanced Search</button>
    </form>
    <?php
}
?>

</div>
<div style="position:relative ; margin-top:1% ; margin-left:16% ; margin-right:7.5% ; white-space:nowrap">
<!--Dropdownlist to choose asset name-->
<select id = "assetname" name="items" style="width:190px ; height:40px">
  <option value=""disabled selected style='display:none'>By Items</option>
  <option value="All">All</option>
  <?php foreach($assets as $asset): ?>
  <option value="<?php $asset['AssetName'] ?>"><?php echo $asset['AssetName'] ?></option>
  <?php endforeach ?>
</select>
<!--Dropdownlist to choose department name-->
<select id = "departmentname" name="department" onchange= "filterstaff(this)" style="width:190px ; height:40px ; margin-left:10%">
  <option value="All"disabled selected style='display:none'>By Department</option>
  <option value="All">All</option>
  <?php foreach($departments as $department): ?>
  <option value="<?php echo $department['DepartmentID'] ?>"><?php echo $department['DepartmentName'] ?></option>
  <?php endforeach ?>
</select>
<!--Dropdownlist to choose staff name-->
<select id = "staffname" name="staff" style="width:190px ; height:40px ; margin-left:10%">
 </select>
 <input type = "button" name= "go" id= "go" value ="Go" style="margin-left:2%" onClick="filterRecords()"/>
<div id="txtHint" style="margin-left:-11%; margin-top:3% ; margin-right:auto;"></div>
</div>	
									
<script>
		(function(){

			[].slice.call( document.querySelectorAll( '.tabs' ) ).forEach( function( el ) {
					new CBPFWTabs( el );
			});

		})();
</script>
<script type="text/javascript" src="js/backtotop.js"></script>
<script type="text/javascript" src="js/backtotop1.js"></script>        
<br>
<br>
</body>
</html>