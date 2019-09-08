<!-- Profile view page
Author : Siddharth G.C
Last modified : 3/5/17 10:00 P.M-->


<!DOCTYPE html>
<html>
<head>
<title>View Profile</title>
<style>
.centeralign
{
	text-align: center;
	
}
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

}

 .labeldesign
 {
font-size:28px; 

 }
 
 table.design
 {
	  border-spacing: 60px 20px; 
	    text-wrap:none;
   white-space:nowrap;
 }
 #panel
{
     height: 200px;
     width: 200px;
     background: #E88C37;
     float: left;
     display: none;
     font-size: xx-large;
} 
</style>

<?php
session_start();
if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
}
?>
<link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />
</head>
<body>
<div  align="left"> 
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; position:relative; margin-left:5.45% ; margin-top:-0.58% " title="Home"></a>
</div>
<?php
include 'Connect.php';
include 'Alert.php';

 
// Create connection
$conn = connectDB("assetdb");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
header('Cache-Control: no cache'); //no cache

    session_cache_limiter('must-revalidate');
$email=$_SESSION["Email"];
//selecting profile details 
$selectProfileSql = "SELECT t1.name,t1.ID,t1.email,t1.Dno,t1.UserType,t1.Dname from user t1 WHERE t1.email='$email'";
 
$Result = mysqli_query($conn, $selectProfileSql);?>


 <div class="centeralign" >
 
 <h1>Profile Information </h1> 
  </div>
<?php foreach($Result as $row) : ?>
  <div   align="center" style="font-size:21px ; margin-left:12%">
        <table class="design">
            <thead>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><label class="labeldesign">Name</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo $row["name"];?></label></td>
                </tr>
<tr>
                    <td><label class="labeldesign">Employee ID</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo $row["ID"];?></label></td>
                </tr>
                <tr>
                    <td><label class="labeldesign">E-mail ID</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo $row["email"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">DepartmentID </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo $row["Dno"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Department </label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo $row["Dname"];?></label></td>
                </tr>
				<tr>
                    <td><label class="labeldesign">Designation</label></td>
                    <td><label class="labeldesign">:&nbsp;<?php echo $row["UserType"];?></label></td>
                </tr>
            </tbody>
        </table>
    </div>
					
	 <?php endforeach;

?>

<?php 
	mysqli_close($conn); //Close database connection
?>
<form action="editprofile.php" method="post">	
<div class="centeralign">
<p>
<td><input type="submit" class="btn waves-effect waves-light" style=" margin: 0 auto " name="editprofile" value="Edit profile" ></td>
</p>
</div>
</form>
</body>
