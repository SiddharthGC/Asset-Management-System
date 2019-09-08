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
session_start();
include 'Connect.php';
include 'Alert.php';

$assetname = $_GET['assetname'];
$staffemail = $_GET['staffemail'];


$conn = connectDB("assetsDB");

if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}

$sql = NULL;
echo "<br></br>";

$d=NULL;

$assettypeid = "%";
if($assetname === "All" || $assetname === "By Items")
{
	$assetname = "%";
}
else
{
	$assetname = rtrim($assetname,"\0");
}
if($staffemail === "All" || $staffemail === "")
{
	$staffemail = "%";
}

$t= $_SESSION['Email'];
$deptid = "Select DepartmentID from userinfo where Email = '$t'";
$deptstringidsql = "Select DepartmentStringID from departmentidinfo where DepartmentID in ($deptid)";
$result = mysqli_query($conn,$deptstringidsql);
$row = mysqli_fetch_row($result);
$deptstringid = $row[0];

$assetname = str_replace(" ","",$assetname);


$sql = "SELECT * FROM assetcurrentinfo WHERE replace(replace(AssetName,'\t',''),' ','') like '$assetname' AND Email like '$staffemail'  AND Status = 'Available' and AssetID like '$deptstringid%' order by AssetName";  // if only available things needs to be transferred give the condition as available

$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
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
<td><input class = "myCheckBox" name="checkbox1[]" type="checkbox" id="checkbox1[]" value="<?php echo $row['AssetID']; ?>"></td>
<td><?php echo  $row["AssetID"]  ?></td>
<td><?php echo  $row["AssetName"]  ?></td>
<td><?php echo  $row["Email"]  ?></td>
<td><?php echo  $row["Status"]  ?></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
</div>
<?php
}
else
{
	echo "Sorry no assets found for your selection. Please try different combination!";
}
mysqli_close($conn);?>

</body>
</html>