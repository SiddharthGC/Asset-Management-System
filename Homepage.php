<?php
session_start();

include 'Connect.php';
include 'NotificationNumber.php';
include 'Filter.php';

$_SESSION["assetid"]=null;            // To know which asset is being selected. This will be used in assetinfo page and edit assetinfo page

//Redirect to index page if not logged in
if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
} 
if(isset($_POST['viewsummary']))  // To view the summary of user's assets
{
	$_SESSION['summarytype']="1";  // Summary type '1' refers to summary of own assets. 2 - refers to summary of department. 3 - Summary of college.
	header('Location:http://localhost/Asset/viewsummary.php');
}
$email = $_SESSION["Email"]; //Get the user who has logged in
$conn = connectDB("assetsdb");   // Create connection to DB
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
$departmenttag = getdepartmenttag($conn,$email);
$sql = "SELECT * FROM assets WHERE assetID like '$departmenttag%' order by name ";
$assetinforesult = mysqli_query($conn, $sql);
$noofrowsofassets = mysqli_num_rows($assetinforesult);
?>

<!doctype html>
<html>
<head>
	<title>Home</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/header_buttons.css"/>
        <link rel="stylesheet" type="text/css" href="css/button_hover_logout.css"/>
        <link href="css/main.css" rel="stylesheet">
		<link href="css/demo.css" rel="stylesheet">
        <!--<link href="css/style.css" rel="stylesheet" type="text/css">-->
                <link rel="stylesheet" type="text/css" href="css/demo1.css" />
		<!-- common styles -->
		<link rel="stylesheet" type="text/css" href="css/dialog.css" />
		<!-- individual effect -->
		<link rel="stylesheet" type="text/css" href="css/dialog-cathy.css" />
        <link rel="stylesheet" type="text/css" href="css/notification.css" />
		<link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />
		<link rel="stylesheet" type="text/css" href="css/randombutton.css" />
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
color: PURPLE;
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
 
 .cd-top {
  display: inline-block;
  height: 40px;
  width: 40px;
  position: fixed;
  bottom: 40px;
  right: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
  /* image replacement properties */
  overflow: hidden;
  text-indent: 100%;
  white-space: nowrap;
  background: rgba(232, 98, 86, 0.8) url(../img/cd-top-arrow.svg) no-repeat center 50%;
  visibility: hidden;
  opacity: 0;
  -webkit-transition: opacity .3s 0s, visibility 0s .3s;
  -moz-transition: opacity .3s 0s, visibility 0s .3s;
  transition: opacity .3s 0s, visibility 0s .3s;
}
.cd-top.cd-is-visible, .cd-top.cd-fade-out, .no-touch .cd-top:hover {
  -webkit-transition: opacity .3s 0s, visibility 0s 0s;
  -moz-transition: opacity .3s 0s, visibility 0s 0s;
  transition: opacity .3s 0s, visibility 0s 0s;
}
.cd-top.cd-is-visible {
  /* the button becomes visible */
  visibility: visible;
  opacity: 1;
}
.cd-top.cd-fade-out {
  /* if the user keeps scrolling down, the button is out of focus and becomes less visible */
  opacity: .5;
}
.no-touch .cd-top:hover {
  background-color: #e86256;
  opacity: 1;
}
@media only screen and (min-width: 768px) {
  .cd-top {
    right: 20px;
    bottom: 20px;
  }
}
@media only screen and (min-width: 1024px) {
  .cd-top {
    height: 60px;
    width: 60px;
    right: 30px;
    bottom: 30px;
  }
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

<script src="js/something.js"></script>

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
//Script for logout
function Logout()
{
	
		location.href = "Logout.php";
	
}
</script>
 <!-- Script to enable or disable Waive ownership or make obsolete button. The state of button toggles when a valid selection is made in the checkbox--> 
 <script src="js/checkbox.js"></script>
    <script type="text/javascript">
        $(function () {
            $('.chk1').change(function () {
                if ($(this).is(":checked")) {
                    $('#delete').removeAttr('disabled');
                }
                else {
                    var isChecked = false;
                    $('.chk1').each(function () {
                        if ($(this).is(":checked")) {
                            $('#delete').removeAttr('disabled');
                            isChecked = true;
                        }
                    });
                    if (!isChecked) {
                        $('#delete').attr('disabled', 'disabled');
                    }
                }
 
 
            })
        });
</script>
<script src="js/modernizr.custom1.js"></script>
<script src="js/classie.js"></script>
<script src="js/dialogFx.js"></script>
</head>
<body>
<div align="left">
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; position:relative; margin-left:6% "></a><br><br><br><br> </div> 
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
                    <?php if($user=="Asset Manager") { ?><a href="searchassets.php"><font color="white">Search Assets</font></a><?php } elseif($user!="staff") { ?><a href="searchassets.php"><font color="white">Transfer Assets</font></a><?php } else { ?><a href="searchassets.php"><font color="white">View Available Assets</font></a><?php } ?>			
					<a href="<?php echo $moveto ?>" style="display :<?php echo $display ?>"><font color="white">My Control</font></a>                 
				</nav>
			</section>
</div>	
<div style="position:relative ; margin-top:1%; margin-left:10%">
<form id = "summaryform" action="homepage.php" method="post"> </form>
<label style="font-size:30px"><font color="White"><b>My Assets</b></font></label>	
<input form="summaryform" class="button" type="submit" name="viewsummary" id="viewsummary" value = "View My Assets Summary" style="margin-left:48%"/>
</div>
<!-- Two forms used in the page movetoassetinfoform - pass information to assetinfo page, deleteform - to delete the the assets -->
<form id = "movetoassetinfoform" action="assetinfo.php" method="post">	</form>
<form id = "deleteform" action="homepage.php" method="post"> </form>
<?php if($noofrowsofassets>0) //If the result has atleast one row, then the table will be displayed.
{?> 							
<div  class="button-wrap" align="center" >
<?php if ($buttondisplay == "Waive Ownership")
	    { ?>
            <button id="delete" data-dialog="somedialog" class="btn waves-effect waves-light" disabled>Waive Ownership</button>
            <?php
		}
?>
</div>
<div id="TableCodePreview" class="PreviewTable" align="center" style="position:relative; width:80% ; margin-top:2% ; margin-left:auto ; margin-right:auto ; table-layout:fixed">
<table style="white-space:normal;">
<thead>
                <tr> 
                    <th style="width: 20px"><label>#</label></th>
                    <th style="width: 120px"><label>Asset id</label></th>
                    <th style="width: 330px;"><label><center>Asset Name</center></label></th>
                    <th style="width: 100px"><label>Status</label></th>
                </tr>
            </thead>
<tbody>
<?php foreach ($assetinforesult as $row) : ?>
<tr>
<td><input form="deleteform" class="chk1" name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row['assetID']; ?>">
</td>
<td>	
<!-- Display each and every entry in a single row	 -->
<input form="movetoassetinfoform" type="submit" name="Viewassetinfo" class="tablesubmit"  id="viewassetinfo" value="<?php echo $row['assetID']; ?>" > 
</td>
<td><?php echo  $row["name"]  ?></td>
<td><?php echo  $row["status"]  ?></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
</div>
<div  class="button-wrap" align="center" style=" margin-top:1.5%" >
<?php if ($buttondisplay == "Waive Ownership")
	    { ?>
            <button id="delete" data-dialog="somedialog" class="btn waves-effect waves-light" disabled>Waive Ownership</button>
            <?php
		}
?>

</div>
<br>
<br>
<?php }
else
{
	?>
	<div align=center>
	<br>
	<br>
	<?php
	echo "You do not have any assets under your ownership";
	?>
	</div>
	<?php
}
?>
<div id="somedialog" class="dialog">
   <div class="dialog__overlay">
   </div>
   <div class="dialog__content" align="center">
   <?php if ($buttondisplay == "Waive Ownership")
	{ ?>
    <h2><strong>Are you sure you want to waive ownership ? </strong></h2>
	<br>
    <?php
	}
	?>
    <input form="deleteform" class="btn waves-effect waves-light" type="submit" name="Delete" style=" margin-right:15% ;" value="Yes"></input> 
    <button  class="btn waves-effect waves-light"  data-dialog-close style=" margin-right:6%;">Close</button>   
    </div>
	</div>                 
<script>
	(function() {
		var dlgtrigger = document.querySelector( '[data-dialog]' ),
		somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog' ) ),
		dlg = new DialogFx( somedialog );
		dlgtrigger.addEventListener( 'click', dlg.toggle.bind(dlg) );
	})();
</script>

<script type="text/javascript" src="js/backtotop.js"></script>
<script type="text/javascript" src="js/backtotop1.js"></script>

</body>
</html>
<?php
if(isset($_POST['Delete'])){
include 'Headmail.php';
include 'Alert.php';

$checkbox = $_POST['checkbox'];          //To  know which are all the items to be deleted[Waive ownership or make obsolete]
$splitemail1 = explode('.',$emailexplode[1]);
$email = $_SESSION["$Email"];
$departmenttag = getdepartmenttag($conn,$email);          //Get the department of the user
//$additionaldepartments = array();       // Array containing Special departments

$deletioncompleteflag = false;
$unavailableassets = "";
	$unavailableassetsflag = false;
	$count = 0;
// If, other users, they will be waiving ownership on the assets.
if($user!="Asset Manager")
{
	mysqli_autocommit($conn,FALSE);
    foreach($checkbox as $del_id)
	{
		$halved = substr($del_id,2,8);
		$newtag = "OB";
		$newid = $newtag.$halved;
	    $sql = "UPDATE assets set assetID='$newid' WHERE assetID='$del_id'"; //Waiving ownership - refers to changing the ownership from current user to department office
	    $result = mysqli_query($conn,$sql); 
		if(!$result)
		{
			 $deletioncompleteflag = false;
			 break;
		}
        else
		{
			$count++;
			$deletioncompleteflag = true;
        }	
    }
	if($deletioncompleteflag)
	{
		//Sending Notification to asset manager when ownership is waived
		date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('Y-m-d/H:i:s');
		$notificationnumber = generateNotificationNumber($conn);
		$message = "Staff with mail id ".$email." has waived the ownership on his asset(s)";
		$status = "submitted";
		$notificationtype = "3";
		$destinationemail = "pbk@asset.psgtech.ac.in";
		$notificationssql = "INSERT into notifications VALUES ('$notificationnumber','$destinationemail','$message','$status','$notificationtype','$timestamp')";
		$result = mysqli_query($conn,$notificationssql);
	    if($result)
		{
			mysqli_commit($conn);
			if(!$unavailableassetsflag)
			{
			   echo '<script> alertifyalert("You have successfully waived the ownership over the asset(s)","Homepage.php")</script>';
			}
		    else if($count>0)
			{
				 echo '<script> alertifyalert("You have successfully waived the ownership over the asset(s). But some of the assets are unavailable so you cannot waive ownership on those assets right now. Try later","Homepage.php")</script>';
			}
			else
			{
				echo '<script> alertifyalert("You cannot waive ownership of the asset that is unavailable.Try Later)",)</script>';
			}
		}
		else
		{
			echo '<script> alertifyalert("Problem with waiving the ownership over the asset.Try Later!!!"); </script>';
			
		}	
	}
	else
	{
		echo '<script> alertifyalert("Problem with waiving the ownership over the asset.Try Later!!!"); </script>';
	}
	mysqli_close($conn);
}

//echo "<meta http-equiv=\"refresh\" content=\"0;URL=homepage.php\">";
}
?>
