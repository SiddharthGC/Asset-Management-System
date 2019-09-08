<?php

session_start();
if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
}
include 'Connect.php';
include 'Alert.php';
include 'Filter.php';
include 'NotificationNumber.php';
$conn = connectDB("assetdb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$email = $_SESSION["Email"];
$user = getUserType($conn,$email);
if($_SESSION["id"]==null)
$_SESSION["id"]= $_POST['requestinfo'];
$assetid=$_SESSION["id"];
$sql = "SELECT assetID,name,status,configuration FROM assets WHERE assetID='$assetid'";
$result = mysqli_query($conn, $sql);

$assetinformation = mysqli_fetch_row($result);
//foreach ($result as $row) {
$a=$assetinformation[1];
//echo $a;
//}
?>


<!DOCTYPE html>
<html>

<head>
<title>Request</title>
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />


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
.submit {

 cursor:pointer;
 border-width:0px;
 border-style:solid;
 border-color:#190ca2;
 -webkit-border-radius: 6px;
 -moz-border-radius: 6px;
 border-radius: 6px;
 text-align:center;
 width:100px;
 height:37px;
 padding-top:undefinedpx;
 padding-bottom:undefinedpx;
 font-size:15px;
 font-family:arial;
 color:#ffffff;
 background:#0b368c;
 display:inline-block;
 }.PreviewButton:hover{
 background:#e85b4c;
 }:none;

.selectbox { 
   background-color: #e5e5e5;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
height: 30px;
outline: none;
padding: 0px 10px;
width: 320px;
-webkit-appearance:none;
  }  
.centeralign
{
	text-align: center;
}

.labeldesign
 {
font-size:25px; 

 }
 
 table.s
 {
	  border-spacing: 60px 20px; 
	    text-wrap:none;
   white-space:nowrap;
 }
 

.Box1 { 
   background-color: #e5e5e5;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
height: 30px;
outline: none;
padding: 0px 10px;
width: 300px;
-webkit-appearance:none;
  } 
 .selectbox { 
   background-color: #e5e5e5;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
height: 30px;
outline: none;
padding: 0px 10px;
width: 320px;
-webkit-appearance:none;
  }  

.centeralign
{
	text-align: center;
}


 </style>
 
 <script type='text/javascript' src='./jquery.js'></script>
<script type="text/javascript" src="Alert.js"></script>
 </head>

<body>
<div  align="left">
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; margin-left:5.4%; margin-top:-0.58%" ></a>		    
</div>


 <div class="centeralign" >

 <h1><?php if($user!="staff") { ?>Request Asset<?php } else { ?>Asset Information<?php } ?></h1>
  </div>
  
  <form method = "post" action = "request.php">
 <div id="TableCodePreview"   align="center" style="margin-top:-2%" >
        <table class="s">
            <thead>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><label class="labeldesign">Asset Name</label></td>
                    <td><label class="labeldesign">:&nbsp; <?php echo $assetinformation[1] ;?></label></td>
                </tr>
                <tr>
                    <td><label class="labeldesign">Asset ID</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo $assetinformation[0]; ?> </label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Status </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $assetinformation[2];?></label></td>
                </tr>
				
				<tr>
                    <td><label class="labeldesign">Configuration </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $assetinformation[3];?></label></td>
                </tr>
            </tbody>
        </table>
         <?php if($user!="staff") { ?><input type="submit" class="btn waves-effect waves-light" name="Request" value="Request"><?php } ?>
    </div>
	</form>
		
<?php
	
		
		if(isset($_POST["Request"]))
		{	
	        $email = $_SESSION["Email"];
			$getdnotag = "Select Dno,Tag from department where HodEmail='$email'";
			$getdnotagresult = mysqli_query($conn,$getdnotag);
			foreach($getdnotagresult as $dnotag) :
			$dtag = $dnotag['Tag'];
			$dno = $dnotag['Dno'];
			endforeach;
			$transactionsql= "INSERT into assettransfer VALUES ('$assetinformation[0]','$email','$dtag','$dno')";
			$result = mysqli_query($conn,$transactionsql);
			if($result)
			{
				date_default_timezone_set('Asia/Kolkata');
				$timestamp = date('Y-m-d/H:i:s');
				$notificationnumber = generateNotificationNumber($conn);
				$heademail = "pbk@asset.psgtech.ac.in";
				$message = "User with mailid [".$email."] has requested the asset ".$assetinformation[0]." for transfer.";
				$status = "submitted";
				$notificationtype = "12";
				$notificationssql = "INSERT into notifications VALUES ('$notificationnumber','$heademail','$message','$status','$notificationtype','$timestamp')";
				$postit = mysqli_query($conn,$notificationssql);
				if($postit)
				{
					mysqli_commit($conn);
					echo '<script>alertifyalert("Request for asset submitted successfully","Homepage.php")</script>';
				}
				else
				{
					echo '<script>alertifyalert("Problem in updating notification","request.php")</script>';
				}
				
			}
			else
			{
				echo '<script>alertifyalert("Problem in submitting asset request","request.php")</script>';
			}
		} 
mysqli_close($conn);

?>

<br>
<br>
</body>
</html>
