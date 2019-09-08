<?php
include 'Connect.php';
include 'Alert.php';
$conn = connectDB("assetdb");

$choice = $_GET['choice'];
$notificationnumber = $_GET['notificationnumber'];

//Accepting a new user, authorising a new user.
if ($choice === "Accept")
{
	mysqli_autocommit($conn,false);
	$requestedemail = $_GET['requestedemail'];
	$insertsql = "insert into user(ID,name,email,password,Dno,Dname,UserType) select * from userwait where email = '$requestedemail'"; //approve new user
	$r1 = mysqli_query($conn,$insertsql);
	$deletetuserinfosql = "Delete from userwait where email='$requestedemail'"; //delete the user account entry in tuserinfo
	$r2 = mysqli_query ($conn,$deletetuserinfosql);
	$deletenotificationsql = "Delete from notifications where notificationNumber = '$notificationnumber'"; //delete the  notification
	$r3 = mysqli_query($conn,$deletenotificationsql);
	if($r1 && $r2 &&$r3)
	{
		/*$to = $requestedemail;
		$subject = "account verified";
		$message = "Greetings! you have been accepted into the asset management system by your HOD. You can now sign in with your email id. Your password is the letter a . You can change the password later through edit profile. Thanks for joining!";
		$headers = "From: assetmanagementpsgtech@gmail.com";
		if(mail($to,$subject,$message,$headers))*/
			mysqli_commit($conn);
			echo '<script>alertifyalert("You have added a new user to the system")</script>';
		/*else
		{
			echo '<script>alertifyalert("The acceptance for new user account was not updated. Try Later!!!")</script>';
		}*/
	}	
	else
	{
		echo '<script>alertifyalert("The acceptance for new user account cannot be updated. Try Later!!!")</script>';
	}
}
elseif($choice==='Decline')     //In case if HOD/Dean feels the submitted new user account is illegal user,he can decline it
{
	mysqli_autocommit($conn,false);
	$requestedemail = $_GET['requestedemail'];
	$deletetuserinfosql = "Delete from userwait where Email='$requestedemail'";  // delete the entry in tuserinfo
	$r1 = mysqli_query ($conn,$deletetuserinfosql);
	$deletenotificationsql = "Delete from notifications where notificationNumber = '$notificationnumber'"; // delete the notification
	$r2 = mysqli_query($conn,$deletenotificationsql);
	if($r1 && $r2)
	{
		mysqli_commit($conn);
		echo '<script>alertifyalert("You have not added a new user to the system")</script>';
	}
	else
	{
		echo '<script>alertifyalert("The acceptance for new user account cannot be updated. Try Later!!!")</script>';
	}
}
elseif($choice==='acceptit')
{
	mysqli_autocommit($conn,false);
	$requestedemail = $_GET['requestedemail'];
	$gettagsql = "select assetID,departmentTag from assettransfer where requestEmail='$requestedemail'";
	$gettag = mysqli_query($conn,$gettagsql);
	foreach($gettag as $tag) :
	$oldid = $tag['assetID'];
	$dtag = $tag['departmentTag'];
	endforeach;
	$halved = substr($oldid,3,8);
	$newid = $dtag.$halved;
	$update = "update assets set assetID='$newid' where assetID='$oldid'";
	$result = mysqli_query($conn,$update);
	if($result)
	{
		$clearnoti = "Delete from notifications where notificationNumber = '$notificationnumber'";
		$result2 = mysqli_query($conn,$clearnoti);
		if($result2)
		{
			$deleteold = "Delete from assettransfer where assetID = '$oldid'";
			$result3 = mysqli_query($conn,$deleteold);
			if($result3)
			{
				mysqli_commit($conn);
				echo '<script>alertifyalert("You accepted the request")</script>';
			}
			else
			{
				echo '<script>alertifyalert("The acceptance of the request could not be completed. Try Later!!!")</script>';
			}
		}
		else
		{
			echo '<script>alertifyalert("The acceptance of the request was not completed. Try Later!!!")</script>';
		}
	}
	else
	{
		echo '<script>alertifyalert("The acceptance of the request failed. Try Later!!!")</script>';
	}
}
elseif($choice==='rejectit')
{
	mysqli_autocommit($conn,false);
	$requestedemail = $_GET['requestedemail'];
	$gettagsql = "select assetID from assettransfer where requestEmail='$requestedemail'";
	$gettag = mysqli_query($conn,$gettagsql);
	foreach($gettag as $tag) :
	$oldid=$tag['$assetID'];
	endforeach;
	$clearnoti = "Delete from notifications where notificationNumber = '$notificationnumber'";
	$result2 = mysqli_query($conn,$clearnoti);
	$deleteold = "Delete from assettransfer where assetID = '$oldid'";
	$result3 = mysqli_query($conn,$deleteold);
	if($result2 && $result3)
	{
		mysqli_commit($conn);
		echo '<script>alertifyalert("You accepted the request")</script>';
	}
	else
	{
		echo '<script>alertifyalert("The acceptance of the request could not be completed. Try Later!!!")</script>';
	}
}
elseif($choice==='Reset')  // Resetting the password
{
	mysqli_autocommit($conn,false);
	$requestedemail= $_GET['requestedemail'];
	
	$password = 'a';  // Resetting the password to 'a'
	$secret_key = "helloworldabcdef";
    $iv ="psg tech asset management system";//mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
	$encrypted_password = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $password, MCRYPT_MODE_CBC, $iv);
    $encrypted_password = base64_encode($encrypted_password);
	
	$updatepasswordsql = "Update user set password = '$encrypted_password' where email = '$requestedemail'"; // update password
	$updateresult = mysqli_query($conn,$updatepasswordsql);
	$deletenotificationsql = "Delete from notifications where notificationNumber = '$notificationnumber'"; // Delete notification
	$r1 = mysqli_query($conn,$deletenotificationsql);
	if($updateresult && r1)
	{
		mysqli_commit($conn);
		echo '<script>alertifyalert("You have reset the password of requested user")</script>';
	}
	else
	{
		echo '<script>alertifyalert("Sorry you cannot reset the password of requested user now. Try later....")</script>';
	}
}
else  //  Delete notification
{
	mysqli_autocommit($conn,false);
	$deletenotificationsql = "Delete from notifications where notificationNumber = '$notificationnumber'";
	$r1 = mysqli_query($conn,$deletenotificationsql);
	if($r1)
	{
		mysqli_commit($conn);
		echo '<script>alertifyalert("You have added a new user to the system")</script>';
	}
	else
	{
		echo '<script>alertifyalert("The acceptance for new user account cannot be updated. Try Later!!!")</script>';
	}
}
echo "<meta http-equiv=\"refresh\" content=\"0;URL=notifications.php\">";
?>
