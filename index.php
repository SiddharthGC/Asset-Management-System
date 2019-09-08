<?php
session_start();
//if already  logged in redirects to homepage
if(isset($_SESSION['Email']))
{
	header('Location:http://localhost/Asset/homepage.php');
}
	include 'Connect.php'; 
    $conn= connectDB("assetsdb"); 
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/demo1.css" />
	<!-- common styles -->
	<link rel="stylesheet" type="text/css" href="css/dialog.css" />
	<!-- individual effect -->
	<link rel="stylesheet" type="text/css" href="css/dialog-cathy.css" />
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
	font-family: 'Arvo', Arial, sans-serif;	
}


body::-webkit-scrollbar{
	display:none;
}

a 
{ text-decoration: none; }

h1 
{ 
font-size: 1em;
}

#login {
line-height:3;
}
.textbox {
background-color: #e5e5e5;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 100%;
height: 50px;
outline: none;
width: 95%;
-webkitappearance:none;
padding-left:5%;
}
.submit{
background-color: #008dde;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #f4f4f4;
cursor: pointer;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size:16px;
height: 50px;
-webkit-appearance:none;
width:100%;

}
.linkcolor {
color: WHITE;
}
</style>
</head>
<body>
<div  align="left"> 
<img src="Banner logo.png" style="width:65% ; position:relative; margin-left:5.45% ; margin-top:-0.58% ">
</div>
<div id="login" style=" margin:0 auto ; width:350px">
  <h1><strong> Welcome.</strong> Please login.</h1>
<form action="index.php" method="post">
<fieldset style="text-align:center">
<p><input style="position:relative" type="text" class="textbox" name ="Email" placeholder="Email" title="Enter College email ID" onBlur="if(this.value=='')this.value='Email'" onFocus="if(this.value=='Email')this.value='' "></p>
<p><input type="password" class="textbox" name="Password" placeholder="Password" onBlur="if(this.value=='')this.value='Password'" title="Enter Password" onFocus="if(this.value=='Password')this.value='' "></p>
<p>
<a class="linkcolor" style="font-size:15px; float:left; cursor:pointer" data-dialog="somedialog">Forgot Password?</a>             
<a class="linkcolor" style="font-size:15px ; float:right" href="http://localhost/Asset/Sign%20up.php">Create New Account</a> 
</p>
<p><input type="submit" class="submit" value="Login" name="Login"></p>
</fieldset>
</form>
</div>
 <div id="somedialog" class="dialog">
	<div class="dialog__overlay"></div>
		<div class="dialog__content">
			<h2>Enter Your E-mail ID</h2>
            <div>
			<form method = "post" action = "index.php">
             <input type="text" class="textbox" name ="EmailReset" placeholder="Email" title="Enter College email ID" style=" width:200px ; height:40px ; margin-top:1.5%">
             <br>
             <br>
			 <p>
             <input type="submit" name="Reset" id="Reset" value="Submit" class="popupbutton" style="margin-right:5%">
             <button class="action" style="margin-left:2%" data-dialog-close>Close</button></p>
			 </form>
			 </div>
			</div>
		</div>
	</body>
</html>
 

 
<script src="js/modernizr.custom1.js"></script>
<script src="js/classie.js"></script>
<script src="js/dialogFx.js"></script>
<script>
	(function() {var dlgtrigger = document.querySelector( '[data-dialog]' ),
	    somedialog = document.getElementById( dlgtrigger.getAttribute( 'data-dialog' ) ),
		dlg = new DialogFx( somedialog );
		dlgtrigger.addEventListener( 'click', dlg.toggle.bind(dlg) );
	})();
</script>
<?php
// Login Code
if(isset($_POST['Login']))
{                             
    if(!$conn){
     echo '<script>alertifyalert("Database Connection is not established. Try Later!!!")</script>';
    }
    else{
        $email = $_POST['Email'];
        $password= $_POST['Password'];
		$secret_key = "helloworldabcdef";
        $iv ="psg tech asset management system"; // mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
        
		$sql = "Select Password from userinfo where Email='$email'";
        $r = mysqli_query($conn,$sql);
		if($r -> num_rows > 0)
		{
        $row = mysqli_fetch_row($r);
		//echo $row[0];
		//echo '<br/>';
        $retrived_password =base64_decode($row[0]);
		//echo $retrived_password;
		//echo '<br/>';
		$decrypted_password = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $retrived_password, MCRYPT_MODE_CBC, $iv);
		$decrypted_password = rtrim($decrypted_password,"\0");
		//echo $decrypted_password;
		//echo '<br/>';
        if($password===$decrypted_password)
               {
                   $_SESSION["Email"] = $email;
                   header('Location:http://localhost/Asset/Homepage.php');
               }
               else{
				   include 'Alert.php';
                   echo '<script>alertifyalert("Enter Correct Password","index.php")</script>';
               }
		}
		else
		{
			include 'Alert.php';
			echo '<script>alertifyalert("No account has been created for this email")</script>';
		}   
    }
	$conn->close();
}
//Executes when forgot password is clicked
if(isset($_POST['Reset']))
{
	include 'NotificationNumber.php';
	include 'Headmail.php';
	include 'Alert.php';
	date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('Y-m-d/H:i:s');
		$notificationnumber = generateNotificationNumber($conn);
		$email = $_POST['EmailReset'];
		$checkvalidusersql = "Select * from user where Email = '$email'";
		$validuserresult = mysqli_query($conn,$checkvalidusersql);     // Sends a notification for the respective head for resetting password
		if(mysqli_num_rows($validuserresult)==1)
		{
		if(preg_match('/^hod/',$email)||preg_match('/^dean/',$email))  // If the user is a hod/dean ,notification will be sent to the principal
		{
			$destinationemail = "principal@psg.psgtech.ac.in";
		}
        elseif($email == "principal@psg.psgtech.ac.in") // If principal forgets the password ..
		{
			$destinationemail = "hod@cse.psgtech.ac.in"; //$destinationemail = ; // Add email id when principal wants to reset his password
		}		
		else //If any other user lost the password the notification will be sent to the the respective HOD or dean 
		{
			$destinationemail = formHeadEmail($email);
		}
		$message = "Staff with mail id ".$email." has forgotten the password.Please do reset it!!!";
		$status = "submitted";
		$notificationtype = "10";
		$notificationssql = "INSERT into notifications VALUES ('$notificationnumber','$destinationemail','$message','$status','$notificationtype','$timestamp')";
		if(mysqli_query($conn,$notificationssql))
		{
			echo '<script>alertifyalert("You have successfully submitted the request for resetting the password")</script>';
		}
		else
		{
			echo '<script>alertifyalert("Failure in submitting the request for reset password")</script>';
		}
		}
		else
		{
			echo '<script>alertifyalert("You are not a valid user")</script>';
		}
}
?>
<script>

var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var browserName  = navigator.appName;
var fullVersion  = ''+parseFloat(navigator.appVersion); 
var majorVersion = parseInt(navigator.appVersion,10);
var nameOffset,verOffset,ix;

// In Opera 15+, the true version is after "OPR/" 
if ((verOffset=nAgt.indexOf("OPR/"))!=-1) {
 browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+4);
}
// In older Opera, the true version is after "Opera" or after "Version"
else if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
 browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+6);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In MSIE, the true version is after "MSIE" in userAgent
else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
 browserName = "Microsoft Internet Explorer";
 fullVersion = nAgt.substring(verOffset+5);
}
// In Chrome, the true version is after "Chrome" 
else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
 browserName = "Chrome";
 fullVersion = nAgt.substring(verOffset+7);
}
// In Safari, the true version is after "Safari" or after "Version" 
else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
 browserName = "Safari";
 fullVersion = nAgt.substring(verOffset+7);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In Firefox, the true version is after "Firefox" 
else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
 browserName = "Firefox";
 fullVersion = nAgt.substring(verOffset+8);
}
// In most other browsers, "name/version" is at the end of userAgent 
else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < 
          (verOffset=nAgt.lastIndexOf('/')) ) 
{
 browserName = nAgt.substring(nameOffset,verOffset);
 fullVersion = nAgt.substring(verOffset+1);
 if (browserName.toLowerCase()==browserName.toUpperCase()) {
  browserName = navigator.appName;
 }
}
// trim the fullVersion string at semicolon/space if present
if ((ix=fullVersion.indexOf(";"))!=-1)
   fullVersion=fullVersion.substring(0,ix);
if ((ix=fullVersion.indexOf(" "))!=-1)
   fullVersion=fullVersion.substring(0,ix);

majorVersion = parseInt(''+fullVersion,10);
if (isNaN(majorVersion)) {
 fullVersion  = ''+parseFloat(navigator.appVersion); 
 majorVersion = parseInt(navigator.appVersion,10);
}


if (browserName != "Chrome")
{
	if(browserName == "Firefox")
	{
		
	}
	else
{
	window.location.assign("redirectpage.php");
}
}
</script>