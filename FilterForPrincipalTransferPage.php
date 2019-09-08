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
</style>
</head>
<body>
<?php
include 'Connect.php';
include 'Alert.php';
$con = connectDB("assetsdb");
if (!$con) {
    echo '<script>alertifyalert("Assets cannot be transferred now due to database connection problems. Try later!!!")</script>';
}
//initialise the values sent from the Principal transfer page(principalmycontrol page)
$assetname = $_GET['assetname'];
$departmentname = $_GET['secondfiltername'];

$sql = NULL;
$d=NULL;

if($assetname === "All" || $assetname === "By Items")
{
	$assetname = "%";   //If no assetname or all is selected
}

if($departmentname === "All" || $departmentname === "By Department")
{
	$d = "SELECT Email FROM userinfo";  //Select all emails
}
else{
	$d="SELECT Email FROM userinfo t1,departmentinfo t2 WHERE t2.DepartmentName = '$departmentname' AND t1.DepartmentID=t2.DepartmentID"; // Select emails of users under the chosen department
}
$assetname = str_replace(" ","",$assetname);
$sql = "SELECT * FROM assetcurrentinfo WHERE replace(replace(AssetName,'\t',''),' ','') like '$assetname' AND (Email in ($d)) AND Status = 'Available' order by AssetName";
$result = mysqli_query($con,$sql);
$noofrowsofassets = mysqli_num_rows($result);
?>
<?php  
if($noofrowsofassets>0)
{	
?>
<div id="TableCodePreview" class="PreviewTable" >
<table>
<thead>
                <tr> 
                    <td><label>#</label></td>
                    <td><label>Asset Id</label></td>
                    <td><label>Asset Name</label></td> 
                    <td><label>Email</label></td>   
                   <td><label>Status</label></td>
                </tr>
            </thead>
<tbody>

<?php
foreach ($result as $row) : ?>
<tr>
<td><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row['AssetID']; ?>" onClick = "EnableSubmit(this)" ></td>
<td><?php echo  $row["AssetID"]  ?></td>
<td><?php echo  $row["AssetName"]  ?></td>
<td><?php echo  $row["Email"]  ?></td>
<td><?php echo  $row["Status"]  ?></td>
</tr>
<?php endforeach;
} 
else
{
	echo "No assets found for this selection. Please try different combination of selection!!!";
}
mysqli_close($con);?>
</body>
</html>