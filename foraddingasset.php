<html>
<head>
<link rel="stylesheet" href="css/datepicker.css" />
<script type='text/javascript' src='./jquery.js'></script>
<script type="text/javascript" src="Alert.js"></script>

      
<meta charset="utf-8">
<style type="text/css">

@font-face {
	font-weight: normal;
	font-style:normal;
	font-family:'Raleway';
	src:url(font/Raleway/Arvo-Regular.ttf)format('truetype');
}
body {
	background:url(PurLEvz.jpg) no-repeat center center fixed;
	-webkit-background-size: cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	height:100%;
	width:100%;
	 	font-weight: 400;
	font-family: 'Raleway', Arial, sans-serif;	
}

body::-webkit-scrollbar{
	display:none;
}
a { text-decoration: none; }
h1 { font-size: 1em; }


/* ---------- LOGIN ---------- */
#signup {
line-height:3;
}
form fieldset input[type="text"], input[type="password"] , select {
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
width: 95%;
-webkitappearance:none;
padding-left:5%;
-webkit-appearance:none;
}
form fieldset input[type="submit"] {
background-color: #008dde;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #f4f4f4;
cursor: pointer;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size:16px;
height: 50px;
-webkit-appearance:none;
width:95%;
}
.selectdisabledstyle
{
	color:#f8f8f8;
}
</style>
<?php
session_start();
include  'Connect.php';
include  'NotificationNumber.php';
include 'Alert.php';
include 'Filter.php';
$conn = connectDB("assetsdb");
$staffs = listStaffs($conn);
?>
</head>
<script type="text/javascript" src="Alert.js"></script>
<body>
<div  align="left">
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; margin-left:5.4%; margin-top:-0.58%" ></a>    
</div>
<div id="signup" style=" margin:0 auto ; width:350px">
 <h1><strong>Add asset</strong></h1>

<form action="foraddingasset.php" method="post" style="margin-top:-4%;">
<fieldset style="text-align:center">
<select name="staffname" id = "staffname" style="margin-top:5%">
  <option style="display:none" value="" disabled selected>Staff Name</option>
  <?php
  foreach($staffs as $row) :?>
  <option value="<?php echo $row['Email']; ?>"><?php echo $row['Name']; ?></option>
   <?php endforeach ?>
</select>

<select name="AssetName" id = "ExistingAssetName" style="margin-top:5%" onchange='showNewAssetNameBox(this.value)'>
  <option style="display:none" value="" disabled selected>Asset Name</option>
  <?php 
  $sql = "SELECT * FROM assettypeinfo ";
  $result=mysqli_query($conn,$sql);
  foreach($result as $row) :?>
  <option value="<?php echo $row['AssetName']; ?>"><?php echo $row['AssetName']; ?></option>
   <?php endforeach ?>
   <option value ="other">Other</option>
</select>
<p><input type="text" name="AssetName1" placeholder = "New Asset Name" onkeyup = "EnableAddAsset()" id="AssetName" style='display:none; margin-left:2.2%' /></p>

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
   
<p>
<input type="text" name = "datepicker" id="datepicker" placeholder="Date of Purchase" onChange="EnableAddAsset()" /></p>

<p><input name="SupplierName" type="text"  placeholder="Supplier Name"></p>
<p><input name="DepartmentStockRegisterNumber" type="text" placeholder="Department Stock Register Number"><p>
<p><input name="Configuration" type="text"  placeholder="Configuration"></p>
<p><input name="CostPerUnit" type="text"  placeholder="Cost Per Unit" id ="CostPerUnit" onkeyup = "EnableAddAsset()"></p>
<p><input name="NumberOfUnits" type="text"  placeholder="Quantity" id ="NumberOfUnits" onkeyup = "EnableAddAsset()"></p>
<p><input type="submit" name="addasset" id = "addasset" value="Add asset" disabled></p>
</fieldset>
</form>
</div>
</body>

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
</html>
<?php
function generateAssetID($assetname,$useremail)
{
	global $conn;
	//echo "inside generate assetid function";
	$departmentid = "Select DepartmentID from userinfo where  Email ='$useremail'";
    //$assetname = "Printer";
    $departmentstringsql = "SELECT DepartmentStringID from departmentidinfo where DepartmentID in ($departmentid)";	
	$assetnamestringsql = "Select AssetTypeID from assettypeinfo where AssetName ='$assetname'";
	
	$departmentstringresult = mysqli_query($conn,$departmentstringsql);
	$assetnamestringresult = mysqli_query($conn,$assetnamestringsql);
	
	$row1 = mysqli_fetch_row($departmentstringresult); 
	$row2 = mysqli_fetch_row($assetnamestringresult);
	
	$departmentstringid= $row1[0];
	$assetnamestringid = $row2[0];

	$extractnumber = "Select SUBSTR(AssetID,7,4)as id from assetinfo where AssetID like'$departmentstringid$assetnamestringid%'";
	
	//echo $extractnumber;
	
	$missingnumbersql = "SELECT t1.id+1 AS Missing FROM ($extractnumber) AS t1 LEFT JOIN ($extractnumber) AS t2 ON t1.id+1 = t2.id WHERE t2.id IS NULL ORDER BY t1.id LIMIT 1";

	$missingnumberresult = mysqli_query($conn,$missingnumbersql);
	$row3 = mysqli_fetch_row($missingnumberresult);
	
	//echo "h".$row3[0]."h";
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
	$sql = "SELECT AssetName from assettypeinfo where AssetName= '$assetname'";
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
		$assettypeidsql = "Select AssetTypeID from assettypeinfo";
	$assettypeidresult = mysqli_query($conn,$assettypeidsql);
	$newassettypeid = null;
	$assettypeids = array();
	foreach($assettypeidresult as $assettypeid)
	{
		array_push($assettypeids,$assettypeid['AssetTypeID']);
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
	$insertnewassettypesql = "INSERT into assettypeinfo VALUES ('$assetname','$newassettypeid')";
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
if(isset($_POST['addasset']))
{
   include 'Headmail.php';
   echo "inside isset";
   //generateAssetID();
   mysqli_autocommit($conn,FALSE);
   $DateOfPurchase=$_POST['datepicker'];
   $DateOfPurchase = changeDateFormat($DateOfPurchase);
   //echo $DateOfPurchase;
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
	   else
	   {
		   $numberofunits = intval($numberofunits);
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
    $SupplierName= $_POST['SupplierName'];
    $DepartmentStockRegisterNumber = $_POST['DepartmentStockRegisterNumber'];
    $Configuration = $_POST['Configuration'];  
	//$CostPerUnit = $_POST['CostPerUnit'];  
    $Email= $_POST['staffname'];   //"dept_cse@mail.com";
    $Status="Available";
	$numberofunits = $_POST['NumberOfUnits']; 
	$flag = false;
	for($i=0;$i<$numberofunits;$i++)
	{
	$AssetID= generateAssetID($AssetName,$Email);
    //echo $AssetID;
  //SupplierName, Configuration    '$SupplierName' $Configuration'
    $sql = " INSERT INTO assetinfo (AssetID,DateOfPurchase,SupplierName,DepartmentStockRegisterNumber,Configuration,CostPerUnit,LastService,NextServiceDue) VALUES ('$AssetID','$DateOfPurchase','$SupplierName','$DepartmentStockRegisterNumber','$Configuration','$cost','$DateOfPurchase','$DateOfPurchase') " ;
	//echo $sql;
    $result1 = mysqli_query($conn,$sql);
    $sql = " INSERT INTO assetcurrentinfo (AssetID,AssetName,Email,Status)VALUES('$AssetID','$AssetName','$Email','$Status') " ;
	//echo $sql;
    $result2 = mysqli_query($conn,$sql);
	if($result1&&$result2)
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
		$destination1email = formHeadEmail($Email);
		$message = "Asset with assetid ".$AssetID." has added to your Department";
		$status = "submitted";
		$notificationtype = "7";
		$notificationssql = "INSERT into notificationsinfo VALUES ('$notificationnumber','$destination1email','$message','$status','$notificationtype','$timestamp')";
	    $r1 = mysqli_query($conn,$notificationssql);
		
		$notificationnumber = generateNotificationNumber($conn);
		$destination2email = "principal@psg.psgtech.ac.in";
		$message = "Asset with assetid ".$AssetID." has added to ".strtoupper(substr($Email,5,3))." Department";
		$status = "submitted";
		$notificationtype = "7";
		$notificationssql = "INSERT into notificationsinfo VALUES ('$notificationnumber','$destination2email','$message','$status','$notificationtype','$timestamp')";
	    $r2 = mysqli_query($conn,$notificationssql);
		
		if($r1 && $r2)
		{
			mysqli_commit($conn);
			echo '<script> alertifyalert("New Asset added successfully"); </script>';
		}
		else
		{
			echo '<script> alertifyalert("Problem in adding new asset"); </script>';
		}
    }
	else
	{
		echo '<script> alertifyalert("Problem in adding new asset"); </script>';
	}
	}
	}
	else
	{
		echo '<script> alertifyalert("Asset type cannot be found or new asset type not added properly"); </script>';	
	}
   }
   else
   {
	   echo '<script> alertifyalert("Check whether cost is entered without any special characters or valid quantity is entered"); </script>';	
   }
   }
   else
   {
	   echo '<script>alertifyalert("Make proper date selection")</script>';
   }
}
?>
