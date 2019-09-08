<!DOCTYPE html>
<html>

<head>
<title>View Asset Information</title>
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
</head>
<?php
session_start();
if($_SESSION["Email"] == null)
{
	header('Location:http://localhost/Asset/index.php');
}
?>
<body>
<div  align="left"> 
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; position:relative; margin-left:5.45% ; margin-top:-0.58% "></a>

</div>

<?php
//------------------------------------
include 'Connect.php';
include 'Alert.php';
// Create connection
$conn = connectDB("assetsdb");
//-----------------------------------
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

header('Cache-Control: no cache'); //no cache
session_cache_limiter('must-revalidate');
$assetid=$_POST['Viewassetinfo'];
//selecting data from assetinfo amd assetcurrentinfo tables to display the asset information
$select_asset_sql = "SELECT t1.AssetID,t1.AssetName,t1.Email,t1.Location,t1.Status,t1.Remarks ,
t2.DateOfPurchase,t2.SupplierName,t2.DepartmentStockRegisterNumber,t2.Configuration,
t2.CostPerUnit,t2.LastService,t2.NextServiceDue FROM assetcurrentinfo t1,assetinfo t2 WHERE t1.AssetID='$assetid'AND t1.AssetID=t2.AssetID";
$result = mysqli_query($conn, $select_asset_sql);?>

 <div class="centeralign">
 <h1>Asset Information </h1>
  </div>
   
   <?php foreach ($result as $row) : ?>
 <div id="TableCodePreview"   align="center" >
        <table class="design" align="center" style="table-layout:fixed" >
            <tbody >
                <tr>
                    <td><label class="labeldesign">Name</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo wordwrap($row["AssetName"],23,"<br>&nbsp;\n",TRUE) ;?></label></td>
                </tr>
<tr>
                    <td><label class="labeldesign">Asset ID</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo $row["AssetID"]; ?> </label></td>
                </tr>
               
				<tr>
                    <td><label class="labeldesign">Location</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo wordwrap($row["Location"],23,"<br>&nbsp;\n",TRUE);?></label></td>
                </tr>

				<tr>
                    <td><label class="labeldesign">Status </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["Status"];?></label></td>
                </tr>
					<tr>
                    <td><label class="labeldesign">Stock Register Number</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["DepartmentStockRegisterNumber"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Date Of Purchase</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["DateOfPurchase"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Supplier Name</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo wordwrap($row["SupplierName"],23,"<br>&nbsp;\n",TRUE);?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Configuration </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo wordwrap($row["Configuration"],23,"<br>&nbsp\n",TRUE);?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Cost Per Unit </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["CostPerUnit"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Last Service </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["LastService"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Next Service Due  </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php  echo $row["NextServiceDue"];?></label></td>
                </tr>
				 <tr>
                    <td><label class="labeldesign">Remarks</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo wordwrap($row["Remarks"],20,"<br>&nbsp\n",TRUE) ;?></label></td>
                </tr>
            </tbody>
        </table>
    </div>			
<?php endforeach;
     mysqli_close($conn);
?>

<br>
<br>
</body>
</html>
