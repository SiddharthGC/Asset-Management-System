<?php
session_start();
if($_SESSION["Email"] == null)
{
	header('Location:http://localhost/Asset/index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
<title>View Asset Information</title>
<style type="text/css">



@font-face {
	font-weight: normal;
	font-style:normal;
	font-family:'Arvo';
	src:url(font/Arvo/Arvo-Regular.ttf)format('truetype');
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
.submit {
 cursor:pointer;
 border-width:0px;
 border-style:solid;
 border-color:#190ca2;
 -webkit-border-radius: 6px;
 -moz-border-radius: 6px;
 border-radius: 6px;
 text-align:center;
 width:130px;
 height:37px;
 padding-top:undefinedpx;
 padding-bottom:undefinedpx;
 font-size:15px;
 font-family:arial;
 color:#ffffff;
 background:#0b368c;
 display:inline-block;
 font-family:'Raleway';

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

.labeldesign
 {
font-size:25px; 

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
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; position:relative; margin-left:5.45% ; margin-top:-0.58% " title="Home"></a>

</div>

<?php
//------------------------------------
include 'Connect.php';
include 'Alert.php';
include 'Filter.php';
// Create connection
$conn = connectDB("assetdb");
//-----------------------------------
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

header('Cache-Control: no cache'); //no cache
session_cache_limiter('must-revalidate');

if($_SESSION["assetid"]==null)      //If the session id is null then assign the value for it
{
$_SESSION["assetid"]= $_POST['Viewassetinfo'];
}
$assetid=$_SESSION["assetid"];
$departmentTag = substr($assetid,0,2);
//selecting data from assetinfo amd assetcurrentinfo tables to display the asset information
$select_asset_sql = "SELECT t1.AssetID,t1.name,t1.supplier,t1.configuration,t1.cost,t1.lastService,
t1.nextServiceDue,t1.status,t1.dateOfPurchase,t2.Dno,t2.Dname FROM assets t1,department t2 WHERE t1.AssetID='$assetid' and t2.Tag='$departmentTag'";
$result = mysqli_query($conn, $select_asset_sql);

?>

 <div class="centeralign">
 <h1>Asset Information </h1>
  </div>
   <form action="editassetinfo.php" method="post" style="margin-top:-2%">
   <?php foreach($result as $row) : ?>
 <div id="TableCodePreview"   align="center" >
        <table class="design" align="center" style="table-layout:fixed" >
            <tbody >
                <tr>
                    <td><label class="labeldesign">Name</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo wordwrap($row["name"],23,"<br>&nbsp;\n",TRUE) ;?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Asset ID</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo $row["AssetID"]; ?> </label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Status </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["status"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Supplier Name</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo wordwrap($row["supplier"],23,"<br>&nbsp;\n",TRUE);?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Configuration </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo wordwrap($row["configuration"],23,"<br>&nbsp\n",TRUE);?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Cost Per Unit </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["cost"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Date of Purchase </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["dateOfPurchase"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Last Service </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["lastService"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Next Service Due  </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["nextServiceDue"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Department ID</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo wordwrap($row["Dno"],23,"<br>&nbsp;\n",TRUE);?></label></td>
                </tr>
                <tr>
                    <td><label class="labeldesign">Department name</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo wordwrap($row["Dname"],23,"<br>&nbsp;\n",TRUE);?></label></td>
                </tr>
            </tbody>
        </table>
    </div>			
<?php endforeach;
?>
<center><div>
<p>
<?php
  $email = $_SESSION["Email"];
  $user = getUserType($conn,$email); 
  if($user =="Asset Manager") { 
?>
<td><input type="submit" class="btn waves-effect waves-light" name="Editassetinfo"  value="Edit information" ></td>
<?php
 } 
 mysqli_close($conn);
?>
</p>
</div></center>
</form>
</body>
</html>
