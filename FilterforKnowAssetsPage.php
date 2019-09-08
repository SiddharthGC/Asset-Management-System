<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}

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
</style>
</head>
<?php
session_start();
include 'Connect.php';
include 'Alert.php';
$conn = connectDB("assetsdb");
if (!$conn) {
    echo '<script>alertifyalert("Assets cannot be transferred now due to database connection problems. Try later!!!")</script>';
}
$email=$_SESSION['Email'];

//intialising the values of variables that are sent from knowassetspage
$assetname = $_GET['assetname'];
$from = $_GET ['from'];
$to = $_GET ['to'];
$minvalue = $_GET['minvalue'];
$maxvalue = $_GET['maxvalue'];
$suppliername = $_GET['suppliername'];
$resulttype= $_GET['resulttype'];
$staffmail = null;

if($email == "principal@psg.psgtech.ac.in")  //if principal he will choose the department he wants to see. 
{
	$departmentid = $_GET['departmentid'];
	if($departmentid == "" || $departmentid == "All")
	{
		$departmentid = "%";
	}
}
else    //if hod or dean he can choose the staff of his department who he wants to see
{
	$staffmail = $_GET['staffname'];
	if($staffmail == "" || $staffmail == "All")
	{
		$staffmail = "%";         // if no particular staff is selected
	}
	$departmentid = "Select DepartmentID from userinfo where Email = '$email'";
	
}

if($assetname == "By Items" || $assetname == "All")
{
	$assetname = "%";           // if no particular assetname is selected
}
if($from == "By Year" || $from == "All")
{
	$from = "%";           //if no particular year is selected
}
if($to == "By Year" || $to == "All")
{
	$to = "%";           //if no particular year is selected
}
if($minvalue == "")
{
	$minvalue = 0;     //if no particular min value is selected, initialsing it to  0.
}
if($maxvalue == "")
{
	$maxvalue = 1000000000;     //if no particular min value is selected, initialsing it to  this value.
}
if($suppliername == "By Supplier" || $suppliername == "All")
{
	$suppliername = "%";       //if no particular year is selected
}
$assetname = str_replace(" ","",$assetname);
if($resulttype=="2")  //Result type 2 displays all the assets.
{
if($email == "principal@psg.psgtech.ac.in")
{
	$summarysql = "Select t1.AssetID,t2.AssetName from assetinfo t1,assetcurrentinfo t2, userinfo t3 where t1.AssetID=t2.AssetID AND replace(replace(t2.AssetName,'\t',''),' ','') like '$assetname' AND t3.DepartmentID like '$departmentid' AND t3.Email = t2.Email AND t1.DateOfPurchase BETWEEN '$from' AND '$to' AND t1.CostPerUnit >= $minvalue AND t1.CostPerUnit <= $maxvalue AND t1.SupplierName like '$suppliername' order by t2.AssetName";
}
else
{
	$summarysql = "Select t1.AssetID,t2.AssetName from assetinfo t1,assetcurrentinfo t2, userinfo t3 where t1.AssetID=t2.AssetID AND replace(replace(t2.AssetName,'\t',''),' ','') like '$assetname' AND t3.DepartmentID in ($departmentid) AND t2.Email like '$staffmail' AND t3.Email = t2.Email AND t1.DateOfPurchase BETWEEN '$from' AND '$to' AND t1.CostPerUnit >= $minvalue AND t1.CostPerUnit <= $maxvalue AND t1.SupplierName like '$suppliername' order by t2.AssetName";
}
$summaryresult = mysqli_query($conn,$summarysql);
if(mysqli_num_rows($summaryresult)>0)
{
?>
<form id = "movetoassetinfoform" action="advancedassetinfo.php" method="post">	</form>
<div id="TableCodePreview" class="PreviewTable"  style="width:100% ; table-layout:fixed">
<table style="white-space:normal;
              table-layout: fixed;">
<thead>
      <tr>    
            <td><label>Asset id</label></td>
			<td><label>Asset Name</label></td> 
      </tr>
</thead>
<tbody>
<?php
foreach ($summaryresult as $row) : ?>
<tr>

<td><input form="movetoassetinfoform" type="submit" name="Viewassetinfo" class="tablesubmit"  id="viewassetinfo" value="<?php echo $row['AssetID']; ?>" > </td>
<td><?php echo  $row["AssetName"]  ?></td>
</tr>
<?php endforeach ; 
}
else
{
	?>
	<div align=center>
	<br>
	<br>
	<?php
	echo "Sorry no assets found for your selection. Please try different combination";
	?>
	</div>
	<?php
}
}
else   // if the result type is not  2 then it will display only the count of assets 
{
	if($email == "principal@psg.psgtech.ac.in")
    {
	    $summarysql = "Select t2.AssetName,count(*) as count from assetinfo t1,assetcurrentinfo t2, userinfo t3 where t1.AssetID=t2.AssetID AND replace(replace(t2.AssetName,'\t',''),' ','') like '$assetname' AND t3.DepartmentID like '$departmentid' AND t3.Email = t2.Email AND t1.DateOfPurchase BETWEEN '$from' AND '$to' AND t1.CostPerUnit >= $minvalue AND t1.CostPerUnit <= $maxvalue AND t1.SupplierName like '$suppliername' group by t2.AssetName";
    }
    else
    {
	    $summarysql = "Select t2.AssetName,count(*) as count from assetinfo t1,assetcurrentinfo t2, userinfo t3 where t1.AssetID=t2.AssetID AND replace(replace(t2.AssetName,'\t',''),' ','') like '$assetname' AND t3.DepartmentID in ($departmentid) AND t2.Email like '$staffmail' AND t3.Email = t2.Email AND t1.DateOfPurchase BETWEEN '$from' AND '$to' AND t1.CostPerUnit >= $minvalue AND t1.CostPerUnit <= $maxvalue AND t1.SupplierName like '$suppliername' group by t2.AssetName";
    }
    $summaryresult = mysqli_query($conn,$summarysql);
    if(mysqli_num_rows($summaryresult)>0)
{
?>
<div id="TableCodePreview" class="PreviewTable"  style="width:100% ; table-layout:fixed">
<table style="white-space:normal;
              table-layout: fixed;">
<thead>
      <tr>    
            <td><label>Asset Name</label></td>
			<td><label>Count</label></td> 
      </tr>
</thead>
<tbody>
<?php
foreach ($summaryresult as $row) : ?>
<tr>
<td><?php echo $row['AssetName']; ?></td>
<td><?php echo  $row["count"]  ?></td>
</tr>
<?php endforeach ; 
}
else
{
	?>
	<div align=center>
	<br>
	<br>
	<?php
	echo "Sorry no assets found for your selection. Please try different combination";
	?>
	</div>
	<?php
}
}
mysqli_close($conn);
?>
</body>
</html>
