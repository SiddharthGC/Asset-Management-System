<?php
session_start();
include 'Connect.php';
include 'Filter.php';
include 'Alert.php';  

if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
}

$_SESSION["id"]=null;
$useremail = $_SESSION["Email"];

$emailexplode = explode("@",$useremail);
$user = $emailexplode[0];

//$display = "none";
if($user == "hod" || $user=="dept" ||$user =="principal" || $user =="dean")
{
	$display = "visible";
	if($user == "hod" || $user =="dean")
	{
		$moveto = "hodmycontrol1.php";
	}
	elseif($user == "dept")
	{
		if($useremail == "dept@psg.psgtech.ac.in")
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

$declinedid = null;
$conn = connectDB("assetsdb");

$sentsql = "SELECT t1.TXID,t1.AssetID,t1.TransactionStatus,t1.StartDate,t1.Remarks,t2.AssetName,t3.Name FROM transactioninfo t1,assetcurrentinfo t2, userinfo t3  WHERE t1.SenderEmail='$useremail' AND t1.AssetID=t2.AssetID AND t2.Email=t3.Email AND t1.TransactionStatus <> 'Transaction Complete' AND t1.TransactionStatus <> 'Declined'";
$sentresult = mysqli_query($conn,$sentsql);

$receivedsql = "SELECT t1.TXID,t1.AssetID,t1.TransactionStatus,t1.StartDate,t2.AssetName,t3.Name FROM transactioninfo t1,assetcurrentinfo t2, userinfo t3 WHERE t1.AssetID=t2.AssetID AND t2.Email='$useremail' AND t1.SenderEmail=t3.Email AND t1.TransactionStatus <> 'Transaction Complete' AND t1.TransactionStatus <> 'Declined'";
$receivedresult = mysqli_query($conn,$receivedsql);

$noofrowsinsentrequests = mysqli_num_rows($sentresult);
$noofrowsinreceivedrequests = mysqli_num_rows($receivedresult);
$notificationssql = "Select count(*) as count from notificationsinfo where DestinationEmail='$useremail'";
$result = mysqli_query($conn,$notificationssql);
if($result)
{
	$row = mysqli_fetch_row($result);
	$countofnotifications = $row[0];
}

//Function decides the button content to be displayed
function decideButton($status)
{
	global $conn;
	$button1display = NULL;
	if($status ==="Requested")
{
	$button1display = "Accept";
}
elseif($status==="Request Accepted")
{
	$button1display = "Lend";
}
elseif($status === "Lent")
{
	$button1display = "Returned";
}
else
{
	return $status;
}

return $button1display;	
}

//On the sent activities tab, this function helps to decide on the status of the sent request
function decideStatus($status,$remarks)
{
	if($status=="Lent")
	{
		return "Received";
	}
	elseif($status=="Declined")
	{
		return $status.$remarks;
	}
	else
	{
		return $status;
	}
}
?>
<!doctype html>
<html>
<head>
		<title>Activities</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/header_buttons.css"/>
        <link rel="stylesheet" type="text/css" href="css/button_hover_logout.css"/>
        <link href="css/main.css" rel="stylesheet">
		<link href="css/demo.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/style1.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/demo1.css" />
		<!-- common styles -->
		<link rel="stylesheet" type="text/css" href="css/dialog.css" />
		<!-- individual effect -->
		<link rel="stylesheet" type="text/css" href="css/dialog-cathy.css" />
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

<script src="js/modernizr.custom1.js"></script>
<script src="js/classie.js"></script>
<script src="js/dialogFx.js"></script>
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
		<li class="tab-link current" data-tab="tab-1">Sent</li>
		<li class="tab-link" data-tab="tab-2">Received</li>
	</ul>
	 <!-- Tab for sent requests -->
	<div id="tab-1" class="tab-content current" >
   <?php 
	if($noofrowsinsentrequests>0){?>
      <div class="PreviewTable tabpage" style="table-layout:fixed">
  	   <table>
            <thead>
                <tr>
                    <td><label>TransactionID</label></td>
                    <td><label>Requested Asset id</label></td>
                    <td><label>Asset Name</label></td>
                    <td><label>Requested to</label></td>
                   <td><label>Status</label></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sentresult as $row) : 
                $sentsidestatus = decideStatus($row['TransactionStatus'],$row['Remarks']); 
				?>
                <tr> 
                  <td><?php echo  $row["TXID"]  ?></td>
                  <td><?php echo  $row["AssetID"]  ?></td>
                  <td><?php echo  $row["AssetName"]  ?></td>
                  <td><?php  echo  $row["Name"]." on ".$row['StartDate']  ?></td>
                 <td><?php echo  $sentsidestatus ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
     </div>
	 <?php
	}
	else
	{
		echo "You have not sent any requests for assets recently"; 
	}
	?>
    </div>
 
 <!-- Tab for received requests -->
  <div id="tab-2" class="tab-content">
  <?php
	if($noofrowsinreceivedrequests>0)
	{?>
    <div class="PreviewTable tabpage" style="table-layout:fixed">
  	   <table>
            <thead>
                <tr>
                    <td><label>TransactionID</label></td>
                    <td><label>Requested Asset id</label></td>
                    <td><label>Asset Name</label></td>
                    <td><label>Request from</label></td>
                   <td><label>Status</label></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receivedresult as $row) : 
                $buttondisplay = decideButton($row['TransactionStatus']); ?>
                <tr> 
                  <td><?php echo  $row["TXID"]  ?></td>
                  <td><?php echo  $row["AssetID"]  ?></td>
                  <td><?php echo  $row["AssetName"]  ?></td>
                  <td><?php echo  $row["Name"]." on ".$row['StartDate']  ?></td>
                  <?php
                  if($row['TransactionStatus']==='Requested')
                  { 
			          $tid = $row['TXID'];
                  ?>
                 <td><input type="button" value="Accept" style="width:70px" onClick="updateStatus('Accept','<?php echo $tid ?>')"> /
                <input type="button" value="Decline" data-dialog="somedialog" class="trigger">
                <div id="somedialog" class="dialog">
				<div class="dialog__overlay"></div>
			     <div class="dialog__content" align="center">
				 <h2><strong>Remarks</strong></h2>
				 <form method="post" action = "Activities.php">
                 <textarea  id="text1"  rows="5" maxlength="200" style="resize:none ; width:68%"></textarea>	
				 </form>
                 <br></br>
                 <button  class="btn waves-effect waves-light" data-dialog-close onClick="updateStatus('Decline','<?php echo $tid ?>')" style=" margin-right:6%;">Reply</button>   
				 </div>
				</div>
                 </td>
                 <?php } 
                 else
                 {
                 ?>
                 <td><input type="button" value=<?php echo $buttondisplay ?> onClick="updateStatus('<?php echo $buttondisplay ?>','<?php echo $row['TXID'] ?>')"></td>
                 <?php } ?>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
	<div id="txtHint" style="margin-left:-11%; margin-top:3% ; margin-right:auto;"></div>
	<?php
	}
	else
	{
		echo "You have not received any requests for assets recently";
	}
	?>
 </div>
</div>  
</body>
<script type="text/javascript" src="js/backtotop.js"></script>
<script type="text/javascript" src="js/backtotop1.js"></script>
</html>
<script>
//Script for updating status. This script sends info to the update transaction status page
function updateStatus(choicemade,tid)
{
	var choice = choicemade;
	var txid = tid;
	var remarks = ""; 
	if(choice=="Decline")
	{
		var remarks = document.getElementById("text1").value;
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
        xmlhttp.open("GET","UpdateTransactionStatus.php?choice="+choice+"&txid="+txid+"&remarks="+remarks,true);
        xmlhttp.send();
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
function Logout()
{
	location.href = "Logout.php";
}
</script>
<script src="js/tabs_old.js"></script>
<script src="js/modernizr17.js"></script>
<script src="js/tabsonline.js"></script>
<script src="js/index17.js"></script>.
<script type="text/javascript" src="js/pop_up.js"></script>

<script>
			(function() {
				var dlgtrigger = document.querySelector( '[data-dialog]' ),
					somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog' ) ),
					dlg = new DialogFx( somedialog );
				dlgtrigger.addEventListener( 'click', dlg.toggle.bind(dlg) );
			})();
</script>

