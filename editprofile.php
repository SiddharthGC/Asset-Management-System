<?php
session_start();
if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
}
include 'Connect.php';
include 'Alert.php';
$conn = connectDB("assetdb"); 
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

header('Cache-Control: no cache'); //no cache
session_cache_limiter('must-revalidate');

$email= $_SESSION["Email"];
$sql = "SELECT name,password FROM user WHERE email='$email'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
<title>Edit Profile</title>
<link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />
<style>
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
.centeralign
{
	text-align: center;
	
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
   table.design
 {
	  border-spacing: 30px 20px; 
	    text-wrap:none;
   white-space:nowrap;
 }
 
  .button {

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
 background:#081b26;
 }
 
 .drop1{
	 background-color: #e5e5e5;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
height: 30px;
outline: none;
padding: 0px 10px;
width:300px;
-webkit-appearance:none;
 }
  </style>
</head>
<body>
<div>
<div  align="left"> 
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; position:relative; margin-left:5.45% ; margin-top:-0.58% "></a>
</div> 
<div class="centeralign" > 
 <h1>Edit Profile</h1>
</div>
<form method="post"  action = "editprofile.php">
 <div style="margin-top:-2%" >
        <table class="design" align="center">
            <tbody>
			<?php foreach ($result as $row) : ?>
                <tr>
                    <td><label  style="font-size:23px; float:left" >Name</label></td>
                    <td><input class="box" style="float:left" type="text" name ="name"  value="<?php echo $row["name"];?>" onclick="enableSubmit1()" ></td>
                </tr>
			   
			<?php endforeach;?>
	        </tbody>
        </table>
</div>
<div align="center" style=" white-space:nowrap">
  <input type="submit" class="btn waves-effect waves-light" name="submit1" id="submit1" value="submit" disabled>
</div> 
</form>
</div>
<div class="centeralign"  style=" white-space:nowrap" >
 <h1>Change password</h1>
</div>
<form method="post" action = "editprofile.php">
 <div align="center" style="margin-top:-2% ; margin-right:6%" >
        <table class="design"  align="center" >
            <tbody>
                <tr>
                    <td><label style="font-size:23px; float:left" >Old Password </label></td>
                    <td><input class="box" type="password"  placeholder="Old Password" name="oldPassword" id="oldPassword" onclick="enableSubmit()" style="position:relative ;"></td>
                </tr>
                <tr>
                 <td><label style="font-size:23px;float:left ">New Password </label></td>
                 <td><input class="box"  type="password"  placeholder="New Password" name="newPassword" id="newPassword" onclick="enableSubmit()" style="position:relative ;"></td>
                </tr>
			    <tr>
                 <td> <label style="font-size:23px;float:left">Confirm New Password </label></td>
                 <td><input  class="box" type="password"  placeholder="Confirm Password" name="confirmPassword" onclick="enableSubmit()" style="position:relative ;"></td>
                </tr>
			</tbody>
        </table>
</div>
<div align="center" style=" white-space:nowrap"  >
  <input type="submit" name="submit" class="btn waves-effect waves-light" id="submit" value="submit" disabled>
</div> 
</form>
</body>
</html>
<script type="text/javascript" src="Alert.js"></script>
 <script>
 function enableSubmit1()
 {
	//var button = document.getElementById('submit1');
    submit1.disabled = false;
 }
 </script>
  <script>
 function enableSubmit()
 {
		submit.disabled = false;
 }
 </script>
<?php
if(isset($_POST['submit'])){
$oldpassword= $_POST['oldPassword'];
$newpassword = $_POST['newPassword'];
$confirmpassword= $_POST['confirmPassword'];

$select_sql = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn, $select_sql);
if($result)
{
$row = mysqli_fetch_row($result);
$dbretrivedpassword =base64_decode($row[password]);

$secret_key = "helloworldabcdef";
$iv ="psg tech asset management system";//mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);

$decrypted_password = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $dbretrivedpassword, MCRYPT_MODE_CBC, $iv);
$decrypteddbpassword = rtrim($decrypted_password,"\0");
if ($decrypteddbpassword <> $oldpassword) 
{ 
 echo '<script>alertifyalert("Your old password is not right. Please do check it otherwise you cannot update your password!!!","editprofile.php")</script>';
  
}
elseif (!preg_match("((?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!^&*@#$%_]))",$newpassword)||strlen($newpassword)<6||strlen($newpassword)>12)
	{
		echo '<script>alertifyalert("Password must contain atleast 1 uppercase,lowercase,special charater(!^&*@#$%) and a number.Length must be between 6 to 12 characters","editprofile.php")</script>'; 
	}
elseif ($newpassword <> $confirmpassword) 
    { 
       echo '<script>alertifyalert("Your passwords do not match.","editprofile.php")</script>';
	}
	else{
        $encrypted_password = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $newpassword, MCRYPT_MODE_CBC, $iv);
        $encrypted_password = base64_encode($encrypted_password);
	 if(strlen($encrypted_password)<100)
	 {		 
     $update_sql="UPDATE user SET password='$encrypted_password' WHERE email='$email'";
	 $result=mysqli_query($conn,$update_sql );
	 if($result)
	 {
		  echo '<script>alertifyalert("Password changed successfully","profile.php")</script>';
		  //echo "<meta http-equiv=\"refresh\" content=\"0;URL=editprofile.php\">";	
	 }
	 else
	 {
		  echo '<script>alertifyalert("Password cannot be changed now. Try later!!!","editprofile.php")</script>';
	 }
	 }
	 else
	 {
		  echo '<script>alertifyalert("Password is too long. Try shorter passwords!!!","editprofile.php")</script>';
	 }
    }
}
else
{
	echo '<script>alertifyalert("Cannot update your password now.Try Later!!!","editprofile.php")</script>';
}
}
if(isset($_POST['submit1']))
{
	$name = $_POST['name'];
	$update_sql = "UPDATE user SET Name ='$name' WHERE email='$email'";
    $result = mysqli_query($conn,$update_sql);
	if($result)
	{
		echo '<script>alertifyalert("Profile updated successfully","profile.php")</script>';
	}
	else
	{
		echo '<script>alertifyalert("Cannot update your profile now.Try Later!!!","editprofile.php")</script>';
	}
	}		
    
mysqli_close($conn);
?>
