<?php
session_start();
if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
} 
include 'Connect.php';
include 'Alert.php';
include  'NotificationNumber.php';
include 'Filter.php';

$conn = connectDB("assetdb");
$email = $_SESSION["Email"];
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
$assettypessql = "SELECT * FROM assettype ";
$assettypesresult=mysqli_query($conn,$assettypessql);


//$con = connectDB("assetsdb");
$obsoleteinfosql = "Select * from assets where assetID like 'OB%'";
$obsoleteinforesult = mysqli_query($conn,$obsoleteinfosql);
?>

<!doctype html>
<html>
<head>
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
        <link rel="stylesheet" href="css/datepicker.css" />
		<link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />
        
<script type='text/javascript' src='jquery.js'></script>
<script type="text/javascript" src="Alert.js"></script>

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
	margin-right:2%;
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
width:289px ;
 height:50px;
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
padding-left:2%;
-webkit-appearance:none;
}

</style>
</head>
<script src="js/tabs_old.js"></script>
<script src="js/tabsonline.js"></script>
<script src="js/index17.js"></script>
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

<script src="js/modernizr.custom1.js"></script>
<script src="js/classie.js"></script>
<script src="js/dialogFx.js"></script>
</head>
<script type="text/javascript" src="Alert.js"></script>
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
		<li class="tab-link current" data-tab="tab-1"><b>Add Asset</b></li>
		<li class="tab-link" data-tab="tab-2"><b>Delete Assets</b></li>
		<li class="tab-link" data-tab="tab-3"><b>Assign Ownership</b></li>
	</ul>

	<div id="tab-1" class="tab-content current" >
     <div align="center">
    <form action="deptprincipalmycontrol.php" method="post" >
<fieldset style="text-align:center ; border-color:transparent">

<p><select name="AssetName" class="drop1" id = "ExistingAssetName" style="margin-top:1%" onchange='showNewAssetNameBox(this.value)'>
  <option style="display:none" value="" disabled selected>Asset Name</option>
  <?php
  foreach($assettypesresult as $row) :?>
  <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
   <?php endforeach ?>
   <option value ="other">Other</option>
</select></p>

<p align="center"><input type="text"  class="Box1" name="AssetName1" placeholder = "New Asset Name" onkeyup = "EnableAddAsset()" id="AssetName" style='display: none; margin-top:1.4%' /></p>
<br>
<p>
<input type="text" class="Box1" name = "datepicker" id="datepicker" placeholder="Date of Purchase" onChange="EnableAddAsset()" ></p>
<br>
<p><input name="SupplierName" class="Box1" type="text"  placeholder="Supplier Name"></p>
<br>
<p><input name="Configuration" type="text" class="Box1"  placeholder="Configuration"></p>
<br>
<p><input name="CostPerUnit" type="text" class="Box1"  placeholder="Cost Per Unit" id ="CostPerUnit" onclick = "EnableAddAsset()"></p>
<br>
<p><input name="NumberOfUnits" type="text" class="Box1"  placeholder="Quantity" id ="NumberOfUnits" onclick = "EnableAddAsset()"></p>
<br>
<input type="submit" name="addasset" id = "addasset" class="btn waves-effect waves-light" value="Add asset" disabled>
</fieldset>
</form>
</div>
</div>

<div id="tab-2" class="tab-content"> <form id = "deleteform" action="deptprincipalmycontrol.php" method="post"> </form>
<div id="TableCodePreview" class="PreviewTable" align="center" style="position:relative; width:95% ; margin-top:2% ; margin-left:auto ; margin-right:auto ; table-layout:fixed">

<table>
<thead>
                <tr> 
                    <td><label>#</label></td>
                    <td><label>Asset ID</label></td>
					<td><label>Asset Name</label></td>
                    <td><label>Department Name</label></td>
                </tr>
            </thead>
<tbody>
<?php foreach ($obsoleteinforesult as $row) : 
$deptstringid = substr($row['assetID'], 0, 2);
$deparmentnamesql = "Select Dname from department where  Tag = '$deptstringid'";
$assetname = $row['name'];
$result = mysqli_query($conn,$deparmentnamesql);
$r = mysqli_fetch_row($result);
$departmentname = $r[0];
?>
<tr>
<td><input form="deleteform" class="chk1" name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row['assetID']; ?>">
</td>
<td style="width:25%"><?php echo $row['assetID'];?></td>
<td><?php echo  $assetname  ?></td>
<td><?php echo  $departmentname  ?></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
</div>
<br>
<br>
<div align="center">
<input form = "deleteform" class="btn waves-effect waves-light" type="submit" value = "Delete" name = "Delete" id="Delete">
</div>
</div>
<div id="tab-3" class="tab-content">
<form method="post" action="deptprincipalmycontrol.php">
<div class="PreviewTable tabpage" align="center" style="position:relative; width:95% ; margin-top:2% ; margin-left:auto ; margin-right:auto ; table-layout:fixed  ">
<table >
<thead>
                <tr > 
                    <td><label>#</label></td>
                    <td><label>Asset ID</label></td>
                    <td><label>Asset Name</label></td>
                </tr>
            </thead>
<tbody >
<?php
 $getdeptinfo = "Select * from department where Dno not in ('A','B')";
 $deptinfo = mysqli_query($conn,$getdeptinfo);
 $getobassets = "Select assetID,name from assets where assetID like 'OB%'";
 $obassets = mysqli_query($conn,$getobassets);
 foreach ($obassets as $row) : ?>
<tr>
<td ><input class = "chk1" name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row['assetID']; ?>" >
</td>	
<td><?php echo $row['assetID']; ?></td>
<td><?php echo  $row["name"]  ?></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
</div>
<br>
<div align="center">
<select id = "departmentname" class="drop1 chk1" name="department" style="height:40px ; margin-left:1%" >
  <option value=""disabled selected style="display:none">To Department</option>
  <?php foreach($deptinfo as $dept): ?>
  <option value="<?php echo $dept['Tag'] ?>"><?php echo $dept['Dname']."-".$dept['Tag'] ?></option>
  <?php endforeach ?>
 </select>
<br>
<br>
<input name="AssignOwnership" type="submit" class="btn waves-effect waves-light" id="AssignOwnership" value="Assign Ownership" >
</div>
</form>	
</div>
</div> 
</body>
</html>
<script type="text/javascript">
function showNewAssetNameBox(val){
 var element=document.getElementById('AssetName');
 if(val=='other')
   element.style.display='block';
 else  
   element.style.display='none';
EnableAddAsset();
}
function EnableAddAsset()
{
	//alert("hello");
	var assetname = document.getElementById("ExistingAssetName").value;
	if(assetname == "other")
	{
	  assetname = document.getElementById("AssetName").value;
	}
	var dop = document.getElementById("datepicker").value;
	var CostPerUnit = document.getElementById("CostPerUnit").value;
	if(assetname!="" && dop!="" && CostPerUnit!="" )
	{
		var addassetbutton = document.getElementById("addasset");
		addassetbutton.disabled = false;
	}
}
</script>
<script>
function Logout()
{
	location.href = "Logout.php";
}
</script>
<?php
function generateAssetID($assetname,$useremail)
{
	global $conn;
	$departmentid = "Select Dno from user where  email ='$useremail'";
    //$assetname = "Printer";
    $departmentstringsql = "SELECT Tag from department where Dno in ($departmentid)";	
	$assetnamestringsql = "Select typeID from assettype where name ='$assetname'";
	
	$departmentstringresult = mysqli_query($conn,$departmentstringsql);
	$assetnamestringresult = mysqli_query($conn,$assetnamestringsql);
	
	$row1 = mysqli_fetch_row($departmentstringresult); 
	$row2 = mysqli_fetch_row($assetnamestringresult);
	
	$departmentstringid= $row1[0];
	$assetnamestringid = $row2[0];

	$extractnumber = "Select SUBSTR(assetID,7,4)as id from assets where assetID like'$departmentstringid$assetnamestringid%'";
	
	
	$missingnumbersql = "SELECT t1.id+1 AS Missing FROM ($extractnumber) AS t1 LEFT JOIN ($extractnumber) AS t2 ON t1.id+1 = t2.id WHERE t2.id IS NULL ORDER BY t1.id LIMIT 1";

	$missingnumberresult = mysqli_query($conn,$missingnumbersql);
	$row3 = mysqli_fetch_row($missingnumberresult);
	
	$assetnumber = str_pad($row3[0], 4, '0', STR_PAD_LEFT);
	if($assetnumber =="0000")
	{
		$assetnumber = "0001";
	}
	$assetid = $departmentstringid.$assetnamestringid.$assetnumber;
	return $assetid;
}
function generateAssetTypeID() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 4; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function checkExistingAssetName($assetname)
{
	global $conn;
	$sql = "SELECT name from assettype where name= '$assetname'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function addNewAssetType($assetname)
{
	global $conn;
	$isassetnameexist = checkExistingAssetName($assetname);
	if(!$isassetnameexist)
	{
		$assettypeidsql = "Select typeID from assettype";
	$assettypeidresult = mysqli_query($conn,$assettypeidsql);
	$newassettypeid = null;
	$assettypeids = array();
	foreach($assettypeidresult as $assettypeid)
	{
		array_push($assettypeids,$assettypeid['typeID']);
	}
	while(true)
	{
		$tassettypeid =  generateAssetTypeID();
		if (!in_array($tassettypeid, $assettypeids))
		{
			$newassettypeid = $tassettypeid;
			break;
		}
	}
	$insertnewassettypesql = "INSERT into assettype VALUES ('$assetname','$newassettypeid')";
	$insertnewassettyperesult = mysqli_query($conn,$insertnewassettypesql);
	if($insertnewassettyperesult)
	{
		
		return true;
	}
	else 
	{
		return false;
	}
	}
	else{
		return false;
	}
		
}
function changeDateFormat($date)
{
	$date1split = explode("/",$date);
	$finaldate = $date1split[2]."-".$date1split[0]."-".$date1split[1] ;
	return $finaldate;
}
function validateAssetDetails()
{
	global $AssetName,$SupplierName,$configuration;
	if(strlen($AssetName)>100)
	{
		return "AssetName cannot be more than 100 characters";
	}
	if(strlen($SupplierName)>100)
	{
		return "SupplierName cannot be more than 100 characters";
	}
	if(strlen($configuration)>200)
	{
		return "Configuration cannot be more than 200 characters";
	}
	return "true";
}
if(isset($_POST['addasset']))
{
   mysqli_autocommit($conn,FALSE);
   
   $DateOfPurchase=$_POST['datepicker'];
   $DateOfPurchase = changeDateFormat($DateOfPurchase);
  
			$dop = strtotime($DateOfPurchase);
            $current_date = date('Y-m-d');
            $cd =  strtotime($current_date);
			$diff = $dop-$cd;
   if($diff<=0)
   {   
   $cost = $_POST['CostPerUnit'];
	   if(!preg_match("/^[0-9]*$/",$cost))
	   {
		   $cost=-99999;
	   }
	   else
	   {
		   $cost = intval($cost);
	   }
	   $numberofunits = $_POST['NumberOfUnits']; 
	   if(!preg_match("/^[0-9]*$/",$numberofunits))
	   {
		   $numberofunits=-99999;
	   }
   if($cost >0 && $numberofunits>0)
   {
    if($_POST['AssetName'] == "other")
	{
		$AssetName= $_POST['AssetName1'];
		$assettypeavailable = addNewAssetType($AssetName);
	}
	else{
		 $AssetName= $_POST['AssetName'];
		 $assettypeavailable = true;
	}
	if($assettypeavailable)
	{
	$Email = "pbk@asset.psgtech.ac.in";
    $SupplierName= $_POST['SupplierName'];
    $Configuration = $_POST['Configuration']; 
    $validationresult = validateAssetDetails();	
	if($validationresult=="true")
	{	   
    $Status="Available";
	$flag = false;
	for($i=0;$i<$numberofunits;$i++)
	{
	$AssetID= generateAssetID($AssetName,$Email);
  //SupplierName, Configuration    '$SupplierName' $Configuration'
    $sql = " INSERT INTO assets(assetID,dateOfPurchase,supplier,configuration,cost,lastService,nextServiceDue,status,name) VALUES ('$AssetID','$DateOfPurchase','$SupplierName','$Configuration','$cost','$DateOfPurchase','$DateOfPurchase','$Status','$AssetName') " ;
    $result1 = mysqli_query($conn,$sql);
	if($result1)
	{
		$flag = true;
	}
	else
	{
		$flag = false;
	}
    if($flag)
    {
		
		date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('Y-m-d/H:i:s');
		$notificationnumber = generateNotificationNumber($conn);
		$destination1email = "pbk@asset.psgtech.ac.in";
		$message = "New asset with assetid ".$AssetID." has been added to the system";
		$status = "submitted";
		$notificationtype = "7";
		$notificationssql = "INSERT into notifications VALUES ('$notificationnumber','$destination1email','$message','$status','$notificationtype','$timestamp')";
	    $r1 = mysqli_query($conn,$notificationssql);
		$notificationnumber = generateNotificationNumber($conn);
		$destination2email = "principal@psg.psgtech.ac.in";
		$message = "New asset with assetid ".$AssetID." has been added to the system";
		$status = "submitted";
		$notificationtype = "7";
		$notificationssql = "INSERT into notifications VALUES ('$notificationnumber','$destination2email','$message','$status','$notificationtype','$timestamp')";
	    $r2 = mysqli_query($conn,$notificationssql);
		
		if(!($r1&&$r2))
		{
			echo '<script>alertifyalert("Problem in adding new asset")</script>';
		}
    }
	else
	{
		echo '<script>alertifyalert("Problem in adding a new asset")</script>';	
	}
	}
	if($r1&&$r2)
	{
	        mysqli_commit($conn);
		    echo '<script>alertifyalert("New Asset(s) added successfully")</script>';
	}
    }
	else
	{
		echo "<script> alertifyalert('$validationresult'); </script>";
	}
	}
	else
	{
		 echo '<script>alertifyalert("Problem in adding new asset type. Asset type might be already existing!!!")</script>';
	
	}
   }
   else
   {
	   	echo '<script>alertifyalert("Check whether cost is entered without any special characters or valid quantity is entered")</script>';
   }
   }
   else
   {
	   echo '<script>alertifyalert("Make proper date selection")</script>';
   }
}

if(isset($_POST['Delete']))
{
   if(isset($_POST['checkbox']))
   {
	mysqli_autocommit($conn,false);
	$checkbox = $_POST['checkbox'];
	$flag= false;
	$obsoleteassetidstring = "";
	foreach($checkbox as $obsoleteassetid)
	{
		$deleteobsoleteassetsql = "Delete from assets where assetID='$obsoleteassetid'";
		$deleteobsoleteassetresult = mysqli_query($conn,$deleteobsoleteassetsql);
		if($deleteobsoleteassetresult)
		{
			$flag=true;
			$obsoleteassetidstring = $obsoleteassetidstring.$obsoleteassetid." ";
		}
		else
		{
			$flag = false;
		}
	}
	date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('Y-m-d/H:i:s');
		$notificationnumber = generateNotificationNumber($conn);
		$destination2email = "principal@psg.psgtech.ac.in";
		$message = "Asset(s) with obsolete assetid ".$obsoleteassetidstring." has been deleted from the system";
		$status = "submitted";
		$notificationtype = "11";
		$notificationssql = "INSERT into notifications VALUES ('$notificationnumber','$destination2email','$message','$status','$notificationtype','$timestamp')";
	    $r2 = mysqli_query($conn,$notificationssql);
	if($flag)
	{
		if($r2)
		{
			mysqli_commit($conn);
			echo '<script>alertifyalert("Asset(s) deleted successfully","deptprincipalmycontrol.php");</script>';
		}
		else
		{
			echo '<script>alertifyalert("Sorry asset(s) could not be deleted. Try later");</script>';
		}
	}
	else
	{
		echo '<script>alertifyalert("Sorry asset(s) were not deleted. Try later");</script>';
	}
	}
	 else
	 {
		 echo '<script>alertifyalert("Select the assets and then choose delete");</script>';
	 }
}

if(isset($_POST['AssignOwnership']))
{
	if(isset($_POST['checkbox']))
   {
	$checkbox = $_POST['checkbox'];
	$flag = false;
	$assignedassetidstring = "";
	$depttag = $_POST['department'];
	foreach($checkbox as $asset)
	{
		$oldid = $asset;
		$halved = substr($oldid,3,8);
		$newid = $depttag.$halved;
		$updatesql = "Update assets set assetID = '$newid' where assetID = '$oldid'";
		$update = mysqli_query($conn,$updatesql);
		if($update)
		{
			$flag = true;
			$assignedassetidstring = $assignedassetidstring.$newid." ";
		}
		else
		{
			$flag = false;
		}
	}
	if($flag)
	{
		date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('Y-m-d/H:i:s');
		$notificationnumber = generateNotificationNumber($conn);
		$gethodemail = "Select HodEmail from department where Tag='$depttag'";
		$hodemail = mysqli_query($conn,$gethodemail);
		foreach($hodemail as $getty) :
		$destination2email = $getty['HodEmail'];
		endforeach;
		$message = "Asset(s) with assetid ".$assignedassetidstring." was added to your department";
		$status = "submitted";
		$notificationtype = "11";
		$notificationssql = "INSERT into notifications VALUES ('$notificationnumber','$destination2email','$message','$status','$notificationtype','$timestamp')";
	    $r2 = mysqli_query($conn,$notificationssql);
		if($r2)
		{
			mysqli_commit($conn);
			echo '<script>alertifyalert("Ownership transferred successfully","deptprincipalmycontrol.php");</script>';
		}
		else
		{
			echo '<script>alertifyalert("Sorry. the transfer of ownership failed. Try later");</script>';
		}
	}
	else
	{
		echo '<script>alertifyalert("Sorry ownership transfer failed. Try later");</script>';
	}
   }
   else
   {
	   echo '<script>alertifyalert("Select the assets and then choose Assign Ownership");</script>';
   }
}
?>
