<?php
session_start();
include 'Connect.php';
include 'Filter.php';
include 'NotificationNumber.php';

if($_SESSION["Email"]==null)
{
	header('Location:http://localhost/Asset/index.php');
} 
if($_SESSION['Email']!= "principal@psg.psgtech.ac.in")
{
	header('Location:http://localhost/Asset/logout.php');
}
$conn = connectDB("assetdb");
$email=$_SESSION["Email"];

$notificationssql = "Select count(*) as count from notifications where destinationEmail='$email'";
$result = mysqli_query($conn,$notificationssql);
if($result)
{
	$row = mysqli_fetch_row($result);
	$countofnotifications = $row[0];
}
$user = getUserType($conn,$email);

//Display Mycontrol Tab to Principal,HOD and office users. and set moveto variable to appropriate page
if($user == "HOD" || $user=="Asset Manager" ||$user =="Principal")
{
	$display = "visible";
	if($user == "HOD")
	{
		$moveto = "hodmycontrol1.php";  //Hod will have hodmycontrol page
		$buttondisplay = "Waive Ownership";
	}
	elseif($user == "Asset Manager")
	{
		$moveto = "deptprincipalmycontrol.php";      //Dept office user will have departmentmycontrol page
        $buttondisplay = NULL;		
	}
	elseif($user == "Principal")
	{
		$moveto = "principalmycontrol.php"; //Principal will have principalmycontrol page
		$buttondisplay = "Waive Ownership";
	}
}
else{
	$display = "none"; // if normal user the tab will not be displayed
	$buttondisplay = NULL;
}
//For Tab - 2
$departments = listDepartments($conn);

?>
<!doctype html>
<html>
<head>
<title>Principal MyControl</title>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/header_buttons.css"/>
        <link rel="stylesheet" type="text/css" href="css/button_hover_logout.css"/>
        <link href="css/main.css" rel="stylesheet">
		<link href="css/demo.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/style1.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/notification.css" />
		<link rel="stylesheet" type="text/css" href="css/buttonwaves.css" />
<meta charset="utf-8">
<script type="text/javascript" src="Alert.js"></script>
<style type="text/css">


.scroll-top-wrapper {
    position: relative;
	opacity: 0;
	visibility: hidden;
	overflow: hidden;
	text-align: center;
	z-index: 99999999;
    background-color: #777777;
	color: #eeeeee;
	width:100px;
	height: 48px;
	float:right;
	line-height: 48px;
	margin-right:2%;
	padding-top: 2px;
	border-top-left-radius: 10px;
	border-top-right-radius: 10px;
	border-bottom-right-radius: 10px;
	border-bottom-left-radius: 10px;
	-webkit-transition: all 0.5s ease-in-out;
	-moz-transition: all 0.5s ease-in-out;
	-ms-transition: all 0.5s ease-in-out;
	-o-transition: all 0.5s ease-in-out;
	transition: all 0.5s ease-in-out;
}
.scroll-top-wrapper:hover {
	background-color: #888888;
}
.scroll-top-wrapper.show {
    visibility:visible;
    cursor:pointer;
	opacity: 1.0;
}

@font-face {
	font-weight: normal;
	font-style:normal;
	font-family:'Raleway';
	src:url(font/Raleway/Arvo-Regular.ttf)format('truetype');
}

*{font-family:Raleway;}

body {
	background:url(PurLEvz.jpg) no-repeat center center fixed;
	-webkit-background-size: cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	height:100%;
	width:100%;

}

body::-webkit-scrollbar{
	display:none;
}

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
.submit{
 cursor:pointer;
 border-width:0px;
 border-style:solid;
 border-color:#000000;
 -webkit-border-radius: 9px;
 -moz-border-radius: 9px;
 border-radius: 9px;
 text-align:center;
 width:10%;
 height:40px;
 padding-top:undefinedpx;
 padding-bottom:undefinedpx;
 font-size:19px;
 font-family:arial;
 color:#ffffff;
 background:#1253ec;
 text-shadow: 2px 2px 0px #000000;
 display:inline-block;
 }
 
 form select {
background-color: #e5e5e5;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
outline: none;
padding: 0px 10px;
width:190px ;
 height:40px;
-webkit-appearance:none;
}

.drop1 {
background-color: #e5e5e5;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
outline: none;
padding: 0px 10px;
width:190px ;
 height:40px;
-webkit-appearance:none;
}

.Box1{
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
width: 270px;
-webkitappearance:none;
padding-left:4%;
-webkit-appearance:none;
}

</style>
<script> 
$(function(){
 
	$(document).on( 'scroll', function(){
 
		if ($(window).scrollTop() > 100) {
			$('.scroll-top-wrapper').addClass('show');
		} else {
			$('.scroll-top-wrapper').removeClass('show');
		}
	});
 
	$('.scroll-top-wrapper').on('click', scrollToTop);
});
 
function scrollToTop() {
	verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
	element = $('body');
	offset = element.offset();
	offsetTop = offset.top;
	$('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
}
</script>
<script>
		$(function() {
			// Clickable Dropdown
			$('.click-nav > ul').toggleClass('no-js js');
			$('.click-nav .js ul').hide();
			$('.click-nav .js').click(function(e) {
				$('.click-nav .js ul').slideToggle(200);
				$('.clicker').toggleClass('active');
				e.stopPropagation();
			});
			$(document).click(function() {
				if ($('.click-nav .js ul').is(':visible')) {
					$('.click-nav .js ul', this).slideUp();
					$('.clicker').removeClass('active');
				}
			});
		});
</script>
<script>
function Logout()
{
	
		location.href = "Logout.php";
	
}
</script>
<!--scripts for tab 3 -->
    <script>
        function filterRecords() {
			//alert("hello");
	var assetid = document.getElementById("assetname");
	var assetname = assetid.options[assetid.selectedIndex].text;
    var secondfilterid = document.getElementById("secondfiltername");
	var secondfiltername = secondfilterid.options[secondfilterid.selectedIndex].text;
	secondfiltername = escape(secondfiltername);
	//alert(secondfiltername);
	    if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","FilterForPrincipalTransferPage.php?assetname="+assetname+"&secondfiltername="+secondfiltername,true);
        xmlhttp.send();
    
}
</script>
<script src="js/tabs_old.js"></script>
<script src="js/modernizr17.js"></script>
<script src="js/tabsonline.js"></script>
<script src="js/index17.js"></script>
</head>
<body>
<div align="left">
<a href="homepage.php"><img src="Banner logo.png" style="width:65% ; position:relative; margin-left:6% "></a><br><br><br><br>
</div>
<ul class="menu" style="margin-top:-55px; margin-left:60%; position:""; ">
    <li
	<!-- Notifications button -->
    	<a href="notifications.php">
    		Notifications
    		<span class="bubble"><?php echo $countofnotifications ?></span>
    	</a>
    </li>
</ul>
<!--Drop down on the side to display following information -->
<div class="click-nav" style="position:relative; margin-top:-35px ; margin-left:75% ;">
			<ul class="no-js">
				<li>
					<a class="clicker"><img src="img/i-1.png" alt="Icon">Profile</a>
					<ul>
						<li><a href="profile.php"><img src="img/i-2.png" alt="Icon">View Profile</a></li>
						<li><a href="help.php"><img src="img/i-5.png" alt="Icon">Help</a></li>
						<li><a onClick="Logout()"><img src="img/i-6.png" alt="Icon">Sign out</a></li>
					</ul>
				</li>
			</ul>
</div>
	
<div style="height:42.8px ; background-color:#505963; white-space:nowrap ; margin-top:-75px"> 
         <section class="color-7">
				<nav class="cl-effect-21">
					<a href="homepage.php"><font color="white">Home</font></a>
                    <?php if($user=="Asset Manager") { ?><?php if($user=="Asset Manager") { ?><?php if($user=="Asset Manager") { ?><a href="searchassets.php"><font color="white">Search Assets</font></a><?php } elseif($user!="staff") { ?><a href="searchassets.php"><font color="white">Transfer Assets</font></a><?php } else { ?><a href="searchassets.php"><font color="white">View Available Assets</font></a><?php } ?><?php } elseif($user!="staff") { ?><a href="searchassets.php"><font color="white">Transfer Assets</font></a><?php } else { ?><a href="searchassets.php"><font color="white">View Available Assets</font></a><?php } ?><?php } elseif($user!="staff") { ?><a href="searchassets.php"><font color="white">Transfer Assets</font></a><?php } else { ?><a href="searchassets.php"><font color="white">View Available Assets</font></a><?php } ?>
										
					<a href="<?php echo $moveto ?>" style="display :<?php echo $display ?>"><font color="white">My Control</font></a>                 
				</nav>
			</section>
</div>	
    <div class="container" style="margin-top:3%">
	<ul class="tabs">
		<li class="tab-link current" data-tab="tab-1"><font color="black"><b>Add Department</b></font></li>
		<li class="tab-link" data-tab="tab-2"><font color="black"><b>Delete Department</b></font></li>
		<li class="tab-link" data-tab="tab-3"><font color="black"><b>Appoint Asset Manager</b></font></li>
       <!-- <li class="tab-link" data-tab="tab-4">Delete User</li> -->
	</ul>
	<!-- Tab for Create a Department Account -->
<div id="tab-1" class="tab-content current">
<br>
<div align="center">
<fieldset style="margin-left:35% ; margin-right:40%; padding-left:2%; padding-right:2% ">
<legend>Add Department</legend>
<form method="post" action="principalmycontrol.php">
<br>
<p><input name="DeptID" class="Box1" type="text" title = "Department ID can have only number or alphabets and can be maximum of 3 in length"  placeholder="Department ID"></p>
<br>
<p><input name="DeptName" class="Box1" type="text" title = "Name should start with an alphabet and can have special characters such as \'space\',& and _"  placeholder="Department Name"></p>
<br>
<p><input name="DeptStringID" class="Box1" type="text"  title="Enter two uppercase alphabets" placeholder="Department tag"></p>
<br>
<br>
<p><label> HOD's Account </label></p>
<br>
<p><input name="Name" class="Box1" type="text"  title="Enter HOD/Dean name" placeholder="Name"></p>
<br>
<p><input name="EmailID" class="Box1" type="text"  title="Enter HOD/Dean email ID" placeholder="Email ID"></p>
<br>
<p><input name="CreateDepartment" type="submit" class="btn waves-effect waves-light" id="CreateDepartment" value="Create Department"></p>
</form>
</fieldset>
</div>
<br>
</div>
<!-- Tab for Deleting Department -->
<div id="tab-2" class="tab-content"> 
  <br>
  <br>
  <div align="center">
   <form method="post" action = 'principalmycontrol.php'>
    <p>
     <label>Choose Department:</label>
      <select id = "Department" name="Department" style="width:190px ; height:40px ;" onChange = "EnableDeleteDepartment()">
      <option value=""disabled selected style='display:none'>By Department</option>     
      <?php foreach($departments as $department): 
	  if(($department['Dno']!="A")&&($department['Dno']!="B"))
	  {?>
      <option value="<?php echo $department['Dno'] ?>"><?php echo $department['Dname'] ?></option>
      <?php 
	  }
	  endforeach ?>
      </select>
    </p>
    <br>
	<input type = "submit" name = "DeleteDepartment" class="btn waves-effect waves-light" id="DeleteDepartment" value="Delete Department" disabled>
    </form>
    </div>
</div>
<!-- Tab for creating asset manager Account -->
<div id="tab-3" class="tab-content">
<br>
<div align="center">
<fieldset style="margin-left:35% ; margin-right:40%; padding-left:2%; padding-right:2% ">
<legend> Account details </legend>
<form method="post" action="principalmycontrol.php">
<br>
<p><input name="name" class="Box1" type="text"  title="Enter Asset manager name" placeholder="Name"></p>
<br>
<p><input name="ID" class="Box1" type="text"  title="Enter Asset manager ID" placeholder="ID"></p>
<br>
<p><input name="EmailID" class="Box1" type="text"  title="Enter Asset manager email ID" placeholder="Email ID"></p>
<br>
<p><input name="CreateAccount" type="submit" class="btn waves-effect waves-light" id="CreateAccount" value="Create Account"></p>
</form>
</fieldset>
</div>
<br>
</div>

</div>
<br>
<br>
</body> 
<script type="text/javascript" src="js/backtotop.js"></script>
<script type="text/javascript" src="js/backtotop1.js"></script>
</html>
<script>
//for tab - 2
function EnableDeleteDepartment()
{
	var deletedepartment = document.getElementById('Department').value;
	if(deletedepartment != "")
	{
		var DeleteDepartment = document.getElementById("DeleteDepartment");
		DeleteDepartment.disabled = false;
	}
}
</script>
<?php
include 'Alert.php';
//Tab - 1
//Create Department
if(isset($_POST['CreateDepartment']))
{
	//Get the information
	$deptid=$_POST['DeptID'];
	$deptname = $_POST['DeptName'];
	$heademail = $_POST['EmailID'];
	$deptstringid  = $_POST['DeptStringID'];
	$deptstringid = strtoupper($deptstringid);
		
	mysqli_autocommit($conn,FALSE);
	//Check for duplicate Department ID
	$sql = "Select * from department where Dno='$deptid'"; 
    $result = mysqli_query($conn,$sql);
    if(!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9]*$/",$deptid)||strlen($deptid)>3||$result->num_rows != 0) 
    {
       echo  "<script>alertifyalert('Department ID already exists or department ID is invalid')</script>";
    }
	else
	{  // Validate department name
		if( !isset($_POST["DeptName"])||!preg_match("/^[a-zA-Z][a-zA-Z &_]*$/",$deptname)||strlen($deptname)>50)
		{
			echo '<script>alertifyalert(" Department Name should not be empty, it should start with an alphabet and can have special characters such as \'space\',& and _ or it should not be more than 50 characters")</script>';
		}
		else
		{
		$sql = "Select * from department where Tag='$deptstringid'"; 
        $result = mysqli_query($conn,$sql);
		
		if($result->num_rows != 0 || strlen($deptstringid)!=2|| !preg_match("/^[A-Z][A-Z]$/",$deptstringid))  //Check for duplicate department string ID and it should be exactly 2 characters
        {
          echo  "<script>alertifyalert('Department String ID already exists or length of department string id is not equal to 2 or the characters are not capital alphabets')</script>";
        }
		else
		{
		$sql = "Select * from user where email='$heademail'"; 
        $result = mysqli_query($conn,$sql);
        if($result->num_rows != 0 || !preg_match("/^[_a-z0-9-]+@[a-z0-9-]+(\.psgtech.ac.in)$/",$heademail) || strlen($heademail)>30) //check for duplicate email ID
        {
          echo  "<script>alertifyalert('Email id already exists or email id is not the college email id or email id is more than 30 characters')</script>";
        } 
		else
		{
			$insertdept = "Insert into department(Dno,Dname,HodEmail,Tag) values ('$deptid','$deptname','$heademail','$deptstringid')";
			$result1 = mysqli_query($conn,$insertdept);
			if($result1)
			{
			    $name = $_POST['Name'];
			    $id = '$deptstringid'."123";
				$usertype = "HOD";
			    $password = "wmmrNXJsDJMf9DkZyyava9i/FdVXpn53WBK+lyxoMDg=";
				$insertusersql = "INSERT into user (ID,name,email,password,Dno,Dname,UserType) VALUES ('$id','$name','$heademail','$password','$deptid','$deptname','$usertype')";
				$result = mysqli_query($conn,$insertusersql);
				if($result)
				{
					mysqli_commit($conn);
					echo  "<script>alertifyalert('Department created successfully','principalmycontrol.php')</script>";
				}
				else
				{
					echo  "<script>alertifyalert('Problem in creating Department. Try again Later!!!')</script>";
				}	
			}
			else
				{
					echo  "<script>alertifyalert('Problem in creating Department. Try Later!!!')</script>";
				}	
			
		}
		}
		}
	}
}

//Tab - 2
if(isset($_POST['DeleteDepartment']))
{
	$departmentid = $_POST['Department']; // Get department ID
	$gettag = "select Tag from department where Dno ='$departmentid'";
    $gettag1 = mysqli_query($conn,$gettag);
	foreach($gettag1 as $tag1) :
	$tag = $tag1['Tag'];
	endforeach;
	$getassetsql = "select assetID from assets where assetID like '$tag%'";
	$getasset = mysqli_query($conn,$getassetsql);
	foreach($getasset as $iter)
	{
		$del_id = $iter['assetID'];
		$halved = substr($del_id,2,8);
		$newtag = "OB";
		$newid = $newtag.$halved;
		$deleteassetsql = "update assets set assetID='$newid' where assetID='$del_id'";
		$deleteasset = mysqli_query($conn,$deleteassetsql);
		if($deleteasset)
		{
			$flagit = true;
		}
		else
		{
			$flagit = false;
		}
	}
	if($flagit)
	{
	$deleteusersql = "DELETE FROM user WHERE Dno = '$departmentid'";  // Delete users of that department
	$deleteuserresult = mysqli_query($conn,$deleteusersql);
	if($deleteuserresult)
	{
		$deletedepartmentsql = "DELETE FROM department WHERE Dno = '$departmentid'"; // Delete the department
		$deletedepartmentresult = mysqli_query($conn,$deletedepartmentsql);
		if($deletedepartmentresult)
		{
			mysqli_commit($conn);
			echo  "<script>alertifyalert('Department deleted successfully','principalmycontrol.php')</script>";
		}
		else
		{
                echo  "<script>alertifyalert('Problem with department deletion')</script>";
		}
	}
	else
	{
		echo  "<script>alertifyalert('Users not deleted properly')</script>"; 
	}
	}
	else
	{
		echo  "<script>alertifyalert('assets not deleted properly')</script>"; 
	}
}
	


//Tab - 3
if(isset($_POST['CreateAccount']))
{
	global $aid,$aname,$aemail,$apassword,$adname,$adno,$ausertype;
	//Get the information
	$aid=$_POST['ID'];
	$aname = $_POST['name'];
	$aemail = $_POST['EmailID'];
	$apassword = "wmmrNXJsDJMf9DkZyyava9i/FdVXpn53WBK+lyxoMDg=";    //Encrypted version of the password : 'a'
	$adname = "Asset Management";
	$adno = "B";
	$ausertype = "Asset Manager";
	mysqli_autocommit($conn,FALSE);
	$valid = ValidateForm($aname,$aemail,$conn);
    if($valid)
	{
		$sql = "insert into user(ID,name,email,password,Dno,Dname,UserType) values ('$aid','$aname','$aemail','$apassword','$adno','$adname','$ausertype')";
	    $result = mysqli_query($conn,$sql);
		if($result)
		{
		    mysqli_commit($conn);
			echo  "<script>alertifyalert('Account created successfully')</script>";
		}
		else
		{
			echo  "<script>alertifyalert('Problem in creating account. Try Again later')</script>";
		}
	}   
	else
	{
		echo  "<script>alertifyalert('Problem in creating account. $valid')</script>";
	}
	
}

function ValidateForm($aname,$aemail,$conn)
{
//No special characters are allowed in Name
if (!preg_match("/^[a-zA-Z ]*$/",$aname)||strlen($aname)>30) 
    {
       return "Only letters and white space allowed in Name and it should not be more than 30 characters"; 
    }	

$sql = "Select * from user where email='$aemail'"; 
$result = mysqli_query($conn,$sql); //9659521637

if($result->num_rows != 0)  // Check whether user already exists
{
    return "Email ID already exists";
} 	
	return "true";
}
?>

<!--Tab - 3
// Generate new asset ID for inter department transfer
function generateNewAssetID($departmentid,$assettypeid)
{
	global $conn;
	$departmentstringsql = "SELECT DepartmentStringID from departmentidinfo where DepartmentID in ($departmentid)";
	$departmentstringresult = mysqli_query($conn,$departmentstringsql);
	$row1 = mysqli_fetch_row($departmentstringresult);
	$departmentstringid= $row1[0];
	$extractnumber = "Select SUBSTR(AssetID,7,4)as id from assetinfo where AssetID like '$departmentstringid$assettypeid%'";
	
	$missingnumbersql = "SELECT t1.id+1 AS Missing FROM ($extractnumber) AS t1 LEFT JOIN ($extractnumber) AS t2 ON t1.id+1 = t2.id WHERE t2.id IS NULL ORDER BY t1.id LIMIT 1"; // Get missing number in the sequence of that asset type in that department

	$missingnumberresult = mysqli_query($conn,$missingnumbersql);
	$row3 = mysqli_fetch_row($missingnumberresult);
	
	$assetnumber = str_pad($row3[0], 4, '0', STR_PAD_LEFT);
	if($assetnumber =="0000")   // if the  sequence number returned is zero  make it as one
	{
		$assetnumber = "0001";
	}
	$assetid = $departmentstringid.$assettypeid.$assetnumber;
	return $assetid;
}
if(isset($_POST['Transfer']))
{
	    include 'Headmail.php';
		if(isset($_POST['checkbox']))
		{
		$checkbox = $_POST['checkbox'];
		if(isset($_POST['destination']))
		{
		$destinationdepartmentid = $_POST['destination'];
		echo $destinationdepartmentid;
		if($destinationdepartmentid != "" && $checkbox!=null)
		{
	    mysqli_autocommit($conn,FALSE);
		$newownersql = "Select Email from userinfo where DepartmentID='$destinationdepartmentid' AND Email like 'dept%'"; // New owner is the office user of destination department
		$newresult = mysqli_query($conn,$newownersql);
		$newowneremailinformation = mysqli_fetch_row($newresult);
		$newowneremail= $newowneremailinformation[0];
        echo $newowneremail;	
		$flag = false;
		date_default_timezone_set('Asia/Kolkata');
		$timestamp = date('Y-m-d/H:i:s');
        foreach($checkbox as $updateid){
			$newassetid = generateNewAssetID($destinationdepartmentid,substr($updateid,2,4)); // Since inter department transfer , there is a need to generate new asset id for that asset
			$oldownersql = "Select t1.Email,t2.DepartmentID from assetcurrentinfo t1,userinfo t2 where t1.AssetID = '$updateid' AND t1.Email=t2.Email";
			$oldownerresult = mysqli_query($conn,$oldownersql);
			$row = mysqli_fetch_row($oldownerresult);
			$oldownerdepartmentid = $row[1];
			if($destinationdepartmentid==$oldownerdepartmentid) // If the source and destination department are same.
			{
				$flag=false;
				break;
			}
			$oldowner = $row[0];  // get old owner
			$changeownersql = "Update assetcurrentinfo set Email = '$newowneremail' where AssetID= '$updateid'"; // update new owner
			$changeownerresult = mysqli_query($conn,$changeownersql);
			if($changeownerresult)
			{
				$transfersql = "UPDATE assetinfo set AssetID= '$newassetid' where AssetID = '$updateid'"; // update asset ID
			    $transferresult = mysqli_query($conn,$transfersql);	
				if($transferresult)
				{
			        $sql = "Insert into transferinfo(Source,SourceAssetID,Destination,DestinationAssetID,TransferredTime) VALUES ('$oldowner','$updateid','$newowneremail','$newassetid','$timestamp')"; // Make new entry in transfer info
					$r = mysqli_query($conn,$sql);
					if($r)
					{
						date_default_timezone_set('Asia/Kolkata');
                        $timestamp = date('Y-m-d/H:i:s');
						
						// Send notification to HOD/ Dean of source department
						$notificationnumber = generateNotificationNumber($conn);
						$destination1email = formHeadEmail($oldowner);
		                $message = "Your asset with asset ID ".$updateid." has been transferred to ".strtoupper(substr($newowneremail,5,3))." department";
		                $status = "submitted";
		                $notificationtype = "6";
		                $notificationssql = "INSERT into notificationsinfo VALUES ('$notificationnumber','$destination1email','$message','$status','$notificationtype','$timestamp')";
	                    $r1 = mysqli_query($conn,$notificationssql);
						echo "result1: ".$r1."<br/>";
						// Send notification to HOD/ Dean of destination department
						$notificationnumber = generateNotificationNumber($conn);
						$destination1email = formHeadEmail($newowneremail);
		                $message = "New asset with asset ID ".$newassetid." has been transferred from ".strtoupper(substr($oldowner,5,3))." department";
		                $status = "submitted";
		                $notificationtype = "6";
		                $notificationssql = "INSERT into notificationsinfo VALUES ('$notificationnumber','$destination1email','$message','$status','$notificationtype','$timestamp')";
	                    $r2 = mysqli_query($conn,$notificationssql);
						echo "result2: ".$r2."<br/>";
	                    if($r1 && $r2)
                        {
							$flag = true;
						}
                        else
						{
							$flag = false;
							//echo "1";
						}							
					}
					else
					{
						$flag = false;
						//echo "2";
					}
				}
				else{
					$flag = false;
					//echo "3";
				}	
			}
			else
			{
				$flag = false;
				//echo "4";
			}	
		}
		if($flag)
		{
			mysqli_commit($conn);
			echo "<script>alertifyalert('Assets transferred successfully','principalmycontrol.php')</script>";
		}
		else
		{
			echo "<script>alertifyalert('Problem occurred in transferring. Try Later!!!')</script>";
		}
		}
		}
		else
		{
			echo "<script>alertifyalert('Choose destination in transfer assets tab')</script>";		
		}
		}
		else
		{
			echo "<script>alertifyalert('Choose assets to be transferred in transfer assets tab')</script>";
		}
}-->


