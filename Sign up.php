<?php
include  'Connect.php';
include 'Filter.php';
include 'NotificationNumber.php';
include 'Headmail.php';
include 'Alert.php';
//Establish a connection
$conn = connectDB('assetdb');

//List all Departments
$departmentlist = "SELECT Dname,Dno from department where Dno not in('A','B') order by Dname";
$department = mysqli_query($conn,$departmentlist); 
?>
<html>
<head>
<title>Sign Up</title>
<meta charset="utf-8">
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
a { text-decoration: none; }
h1 { font-size: 1em; }


/* ---------- LOGIN ---------- */
#signup {
line-height:3;
}
form fieldset input[type="text"], input[type="password"] , select {
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
-webkit-appearance:none;
}
form fieldset input[type="submit"] {
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
width:95%;
}
.selectdisabledstyle
{
	color:#f8f8f8;
}
</style>
</head>
<script type="text/javascript" src="Alert.js"></script>
<body>
<!--logo for PSG College of Technology -->
<div  align="left">
<img src="Banner logo.png" style="width:65% ; margin-left:5.4%; margin-top:-0.58%" >		    
</div>
<div id="signup" style=" margin:0 auto ; width:350px">
 <h1><strong>Signup</strong></h1>
 <!-- Form Details -->
<form action="Sign up.php" method="post" style="margin-top:-4%">
<fieldset style="text-align:center">
<p><input name="Name" type="text"  placeholder="Name" title="Enter name without special characters"></p>
<p><input name="EmpID" type="text"  placeholder="Employee ID" title="Enter Employee ID"></p>
<p><input name="Email" title="Enter College email ID" type="text"  placeholder="E-mail"></p>
<select name="Department">
  <option style="display:none" value="" disabled selected>Department</option>
  <?php foreach($department as $row) :?>
  <option value="<?php echo $row['Dno']; ?>"><?php echo $row['Dname']; ?></option>
   <?php endforeach ?>
</select>
<p> </p>
<p><input type="submit" name="CreateAccount" value="Create Account"></p>
</fieldset>
</form>
</div>
</body>
</html>
<?php
//When Create Account button is clicked, this gets called 
if(isset($_POST['CreateAccount']))
{
    $name= $_POST['Name'];
    $email = $_POST['Email'];
    $empid =$_POST['EmpID'];
    $departmentid =$_POST['Department'];
    $getdeptname = "select Dname from department where Dno = '$departmentid'";	
	$getdeptnameresult = mysqli_query($conn,$getdeptname);
	foreach($getdeptnameresult as $depname) : 
	$dname = $depname['Dname'];
	endforeach;
    $validation_result =  ValidateForm(); //Validate the information
	if($validation_result ==="true")
    {
		 $insertionresult=InsertRecord($name,$email,$empid,$departmentid,$conn,$dname); //Insert Record
         if($insertionresult==="true")
         {
			 echo '<script>alertifyalert("Request for new account submitted successfully.You need to wait for your Head\'s approval to access the system","index.php")</script>';
            //header('Location:http://localhost//Asset//index.php');
         }
         else
         {
			 echo "<script>alertifyalert('$insertionresult','Sign up.php')</script>";
         }
    }
    else
    {
		echo "<script>alertifyalert('$validation_result','Sign up.php')</script>"; 
    }
}

// Validate the form information
function ValidateForm()
{

global $name,$username,$email,$conn,$empid;

//No special characters are allowed in Name
if (!preg_match("/^[a-zA-Z ]*$/",$name)||strlen($name)>30) 
    {
       return "Only letters and white space allowed in Name and it should not be more than 30 characters"; 
    }
		
// Check for mail id	
/*if (!preg_match("/^[_a-z0-9-]+@[a-z0-9-]+(\.psgtech.ac.in)$/",$email) || strlen($email)>30) 
    {
       return "Enter a valid email id"; 
    }
*/
$sql = "Select * from user where email='$email'"; 
$result = mysqli_query($conn,$sql); //9659521637

if($result->num_rows != 0)  // Check whether user already exists
{
    return "Email ID already exists";
} 
	
	if(!isset($_POST['Department']))
	{
		return "Choose Department";
	}

	return "true";
}

//Inserts the record
function InsertRecord($name,$email,$empid,$departmentid,$conn,$dname)
{

global $usertype;
mysqli_autocommit($conn,FALSE);
$sql = "SELECT * FROM   userwait WHERE  email ='$email'";
$result = mysqli_query($conn,$sql);
$usertype = "staff";
$password = "wmmrNXJsDJMf9DkZyyava9i/FdVXpn53WBK+lyxoMDg=";         //a
if($result->num_rows == 0) // check whether the user has already submitted the request for new account
{
 $sql = "INSERT INTO userwait(ID,name,email,password,Dno,Dname,UserType) VALUES('$empid','$name','$email','$password','$departmentid','$dname','$usertype')";
 $insertresult = mysqli_query($conn,$sql);
if($insertresult)
{
	// Send notification for the respective head for the approval of new account
	date_default_timezone_set('Asia/Kolkata');
    $timestamp = date('Y-m-d/H:i:s');
	$notificationnumber = generateNotificationNumber($conn);
	$gethodemail = "Select HodEmail from department where Dname='$dname'";
	$hodemail = mysqli_query($conn,$gethodemail);
	foreach($hodemail as $getty) :
	$heademail = $getty['HodEmail'];
	endforeach;
	$message = $name." with mailid [".$email."] has requested for authorisation of new AMS account";
	$status = "submitted";
	$notificationtype = "1";
	$notificationssql = "INSERT into notifications VALUES ('$notificationnumber','$heademail','$message','$status','$notificationtype','$timestamp')";
	
	if(mysqli_query($conn,$notificationssql))
	{
		mysqli_commit($conn);
		$conn->close();
	    return "true";
	}
	else
	{
		$conn->close();
        return "Failure/Request for new account not submitted properly. Try again later";
	}
}
else
{
	$conn->close();
return "Failure/Request for new account not submitted properly. Try again later";
}
}
else
{
	$conn->close();
	return "Failure/You have already submitted request for new account";
}
}

?>
