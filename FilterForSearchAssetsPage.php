<?php
session_start();
$email=$_SESSION['Email'];

include 'Connect.php';
include 'Alert.php';
$con = connectDB("assetdb");
//Establishing connection
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
$_SESSION["id1"]=null;

$assetname = $_GET['assetname'];
$departmentid = $_GET['departmentid'];

$sql = NULL;
$d=NULL;
$n=NULL;

if($assetname === "All" || $assetname === "By Items")  // if no  particular assetname is selected
{
	$assetname = "%";
}

if($departmentid === "All"||$departmentid === "")     // if no  particular department is selected
{
	$departmentid = "%";
}


$assetname = str_replace(" ","",$assetname);
//echo $assetname;

$sql = "SELECT assetID,name,Dname,status FROM assets WHERE name like '$assetname' AND Dno like '$departmentid' AND status = 'Available' order by name" ; 

$result = mysqli_query($con,$sql);
?>

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
  background:BLACK;
  border-bottom:4px solid #9ea7af;
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
  background:#AAAAAA;
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
.PreviewTable table tbody tr td{
 vertical-align:middle;
 height:39px;
 text-align:center;
 font-weight:bold;
 color:#000000;
 font-family:Times New Roman;
 font-size:18px;
 border-width:0px 0px 1px 0px;
</style>
</head>

<body>
<!-- Display the results in table -->
<?php
if($result && mysqli_num_rows($result)>0)
{ ?>
<form id = "movetorequestform" action="request.php" method="post">	</form>
<div id="TableCodePreview" class="PreviewTable"  style="width:100% ; ">
<table style="width: 100%; white-space:normal;
              table-layout: fixed;">
<thead>
                <tr> 
                    
                   <th style="width: 120px"><label>Asset id</label></th>
                    <th style="width: 200px;"><label>Asset Name</label></th> 
                    <th><label>Department</label></th>
                   <th style="width: 100px"><label>Status</label></th>
                </tr>
            </thead>
<tbody>
<?php
foreach ($result as $row) : ?>
<tr>
<td><input form="movetorequestform" type="submit" name="requestinfo" class="tablesubmit" value="<?php echo $row['assetID']; ?>" > </td>
<td style="width:100px; word-wrap:break-word;"><?php echo  $row["name"]  ?></td>
<td><?php echo  $row["Dname"]  ?></td>
<td><?php echo  $row["status"]  ?></td>
</tr>
<?php endforeach ; 
}
else
{
	echo "Sorry no assets found for your selection. Please try different combination!";
}
mysqli_close($con);?>
</table>
</div>
</body>
</html>