<!-- Edit asset information page
Author : Siddharth G.C
Last modified : 4/5/17 9:19 P.M-->

<?php
session_start();
include 'Connect.php';
include 'Alert.php';
if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
}
$conn = connectDB("assetdb");
// Check connection
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}
header('Cache-Control: no cache'); //no cache
session_cache_limiter('must-revalidate');

$assetid= $_SESSION['assetid'];
$sql = "SELECT t1.assetID,t1.status,t1.configuration,t1.lastService,t1.nextServiceDue FROM assets t1 WHERE t1.assetID='$assetid'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<script type='text/javascript' src='./jquery.js'></script>
<script type="text/javascript" src="Alert.js"></script>
<head>
<title>Edit Asset Information</title>
<link rel="stylesheet" href="css/datepicker1.css" />

<style type="text/css">


fieldset {
	border-color:transparent;}

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

 .button {
 cursor:pointer;
 border-width:0px;
 border-style:solid;
 border-color:#000000;
 -webkit-border-radius: 4px;
 -moz-border-radius: 4px;
 border-radius: 4px;
 text-align:center;
 width:8%;
 height:40px;
 padding-top:undefinedpx;
 padding-bottom:undefinedpx;
 font-size:auto;
 font-family:arial;
 color:#ffffff;
 background:#102a9a;
 display:inline-block;
 }.PreviewButton:hover{
 background:#081b26;
 }

.box { 
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
width: 300px;
-webkit-appearance:none;
  }  

.centeralign
{
	text-align: center;
}
 table.design
 {
	  border-spacing: 60px 20px; 
	    text-wrap:none;
   white-space:nowrap;
 }
</style>
<link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />
</head>
<body>
<div  align="left"> 
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; position:relative; margin-left:5.45% ; margin-top:-0.58% "></a>
</div>
<div class="centeralign" >  
<h1> Asset Details </h1>
</div>
 <br></br>
<form method="post"  style="position:relative ; top:-35px">
 <div align="center" style="margin-top:-2%" >
        <table class="design">
            <tbody>
			<?php foreach ($result as $row) : ?>
                <tr>
                 <td><label  style="font-size:23px ; position:relative ; " >Asset ID </label>   </td>
                 <td><label style="font-size:23px ; position:relative ; "><?php echo $row["assetID"] ; ?> </td>
                </tr>
			    <tr>
                 <td><label  style="font-size:23px;">Status</label></td>
                  <td><select  class="selectbox" style="position:relative ; " name="Status" onchange = "enableSubmit()">
                        <option value="<?php echo $row['status'] ?>" selected="selected"><?php echo $row['status'] ?></option>
                        <option value="Available">Available</option>
						 <option value="In Use">In Use</option>
                        <option value="In service">In service</option>
                      </select> 
				  </td>
                </tr>
				<tr>
                 <td><label  style="font-size:23px;" >Configuration </label></td>
                 <td><input class="box"  type="text" name ="Configuration" title="Enter Asset Configuration"  value="<?php echo  $row["configuration"];?>" onclick = "enableSubmit()" style="position:relative ;"></td>
                </tr>
				<tr>
                 <td><label  style="font-size:23px;">Last Service </label></td>
                 <td><input type="text" class="box" name = "datepicker1" id="datepicker1"  value="<?php echo  $row["lastService"];?>" onclick = "enableSubmit()"/></td>
                </tr>
				<tr>
                 <td><label  style="font-size:23px;" >Next Service Due </label></td>
                 <td><input type="text" class="box" name = "datepicker" id="datepicker" value="<?php echo  $row["nextServiceDue"];?>" onclick = "enableSubmit()"/></td>
                </tr>
                <?php endforeach;?> 
		    </tbody>
        </table>	
</div>
<br></br><br></br><br></br>
 <div align="center" style=" white-space:nowrap position:relative"  >
  <input type="submit"  class="btn waves-effect waves-light" name="submit" id="submit" value="submit" disabled>
 </div>   
 </form>
 </body>
</html>
 <script>
 function enableSubmit()
 {
	 submit.disabled=false;
 }
 </script>
 <script  src="js/datepicker1.js"></script>   
  <script src="js/datepicker2.js"></script>
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
<?php
if(isset($_POST['submit']))
{
	$dateOfPurchaseSql = "SELECT dateOfPurchase from assets where assetID= '$assetid'";
	$dateOfPurchaseResult = mysqli_query($conn,$dateOfPurchaseSql);
	$row = mysqli_fetch_row($dateOfPurchaseResult);
	$dateOfPurchase = $row[0];
	$dop = strtotime($dateOfPurchase);
	$currentDate = date('Y-m-d');
	$curr = strtotime($currentDate);
    $lastServiceDate = changeDateFormat($_POST['datepicker1']);
    $lsd =  strtotime($lastServiceDate);
	$diff = $lsd-$dop;
    $n = $diff/(24*60*60); // last service must be latest when compared to date of purchase. 
	$diff = $curr - $lsd;
	$n2 = $diff /(24*60*60); // last service should not be in future
	$nextServiceDate = changeDateFormat($_POST['datepicker']);
	$nsd = strtotime($nextServiceDate);
	$diff = $nsd - $lsd ;
	$n1 = $diff/(24*60*60); //Next service should be latest compared to last service
	$diff = $nsd - $curr;
	$n3 = $diff /(24*60*60); // next service date should not be in past
    if($n>=0 && $n1>=0 && $n2>=0 && $n3>0)
	{
	$status=$_POST['Status'];
	$config=$_POST['Configuration'];
	$lastService= $lastServiceDate;  //Last service
	$nextService=$nextServiceDate;    //Next service
	mysqli_autocommit($conn,FALSE);
		
	if(isset($_POST['Remarks']))
	{
		$remarks = $_POST['Remarks'];
		//updating asset table according the value specified by the user.if no value is specified by the user for a particular column then old values will be written back to the table
    $update_sql = "UPDATE assets SET status='$status' WHERE assetID='$assetid'";
    $result = mysqli_query($conn,$update_sql);
	}
    else	
	{
		//updating asset table according the value specified by the user.if no value is specified by the user for a particular column then old values will be written back to the table
    $update_sql = "UPDATE assets SET status='$status' WHERE assetID='$assetid'";
    $result = mysqli_query($conn,$update_sql);
	}
    if($result)
	{
		//updating asset table according the value specified by the user.if no value is specified by the user for a particular column then old values will be written back to the table
        $update_sql = "UPDATE assets SET configuration='$config',lastService='$lastService',nextServiceDue='$nextService' WHERE assetID='$assetid'";
        $result1 = mysqli_query($conn,$update_sql);
		if($result1)
		{
			mysqli_commit($conn);
            echo '<script>alertifyalert("Asset information updated successfully","assetinfo.php")</script>';
		}
        else{
			echo '<script>alertifyalert("Asset information cannot be updated","editassetinfo.php")</script>';
		}
	}
	else{
		echo '<script>alertifyalert("Asset information cannot be updated","editassetinfo.php")</script>';
	}
}
	else{
		echo '<script>alertifyalert("It seems you have chosen wrong dates","editassetinfo.php")</script>';
	}
}
?>
 <?php 
 function changeDateFormat($date)
{
	if(strpos ($date,'/' ))
	{
		$date1Split = explode("/",$date);
	$finalDate = $date1Split[2]."-".$date1Split[0]."-".$date1Split[1] ;
	return $finalDate;
	}
	else{
		return $date;
		}	
}

mysqli_close($conn);
?>


