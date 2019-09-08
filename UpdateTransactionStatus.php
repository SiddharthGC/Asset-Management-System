<?php
session_start();
include 'Connect.php';
include 'NotificationNumber.php';
include 'Alert.php';

$conn = connectDB("assetsdb");

$choice = $_GET['choice'];
$txid = $_GET['txid'];

if($choice==="Accept")
{
	mysqli_autocommit($conn,false);
	$txidarray = explode("/",$txid);
	$assetid=$txidarray[2];
	echo $assetid;
	$assetstatussql = "Select Status from assetcurrentinfo where AssetID='$assetid'";
	$result = mysqli_query($conn,$assetstatussql);
	$row = mysqli_fetch_row($result);
	$assetstatus = $row[0];
	echo $assetstatus;
	if($assetstatus=="Available")
	{
	$sql = "UPDATE transactioninfo SET TransactionStatus='Request Accepted' WHERE TXID = '$txid'";
	$result = mysqli_query($conn,$sql);
	if($result)
	{
	    $updateassetstatussql = "UPDATE assetcurrentinfo set Status='Unavailable' where AssetID ='$assetid'";
		$r = mysqli_query($conn,$updateassetstatussql);
		if($r)
		{
			mysqli_commit($conn);
			echo '<script>alertifyalert("You have accepted the request","Activities.php")</script>';
		}
		else
		{
			echo '<script>alertifyalert("Problem in accepting the request")</script>';
		}
	}
	else
	{
		echo '<script>alertifyalert("Problem in accepting the request")</script>';
	}
	}
	else
	{
       echo '<script>alertifyalert("You cannot accept this request. The asset is not available right now. Check it!!!!")</script>';		
	}
}
else if($choice==="Lend")
{
	echo "Inside Lend";
	$sql = "UPDATE transactioninfo SET TransactionStatus='Lent' WHERE TXID = '$txid'";
	$result = mysqli_query($conn,$sql);
	if($result)
	{
		echo '<script>alertifyalert("Status Updated","Activities.php")</script>';
	}
	else
	{
		echo '<script>alertifyalert("Status cannot be Updated")</script>';
	}
}
else if($choice==="Returned")
{
	echo  "Inside returned";
	mysqli_autocommit($conn,false);
	$sql = "UPDATE transactioninfo SET TransactionStatus='Transaction Complete' WHERE TXID = '$txid'";
	$result = mysqli_query($conn,$sql);
	if($result)
	{
		$assetid  = "Select AssetID from transactioninfo where TXID = '$txid'";
	    $updateassetstatussql = "UPDATE assetcurrentinfo set Status='Available' where AssetID in($assetid)";
		$r = mysqli_query($conn,$updateassetstatussql);
		if($r)
		{
			$deletenotificationssql = "DELETE from notificationsinfo where Message like '%$txid%'";
			$deletenotificationsresult = mysqli_query($conn,$deletenotificationssql);
			if($deletenotificationsresult)
			{
				mysqli_commit($conn);
			    echo '<script>alertifyalert("Status Updated")</script>';
			}
			else
			{
				echo '<script>alertifyalert("Status cannot be Updated")</script>';
			}
			
		}
		else
		{
			echo '<script>alertifyalert("Status cannot be Updated")</script>';
		}
	}
	else
	{
		echo '<script>alertifyalert("Status cannot be Updated")</script>';
	}
}
else if($choice === "Decline")
{
	mysqli_autocommit($conn,false);
	        $remarks = $_GET['remarks'];
			$requestdenialsql = "UPDATE transactioninfo SET Remarks = '$remarks',TransactionStatus=\"Declined\" WHERE TXID = '$txid'";
			$result = mysqli_query($conn,$requestdenialsql);
			if($result)
			{
				date_default_timezone_set('Asia/Kolkata');
                $timestamp = date('Y-m-d/H:i:s');
				$destinationsql = "Select SenderEmail,AssetID from transactioninfo where TXID = '$txid'";
				$destinationresult = mysqli_query($conn,$destinationsql);
				if($destinationresult)
				{
				$row = mysqli_fetch_row($destinationresult);
				$notificationnumber = generateNotificationNumber($conn);
				$destinationemail = $row[0];
		        $message = "Your request for asset ".$row[1]." has been declined by ".$_SESSION['Email']." by stating that ".$remarks;
		        $status = "submitted";
		        $notificationtype = "8";
		        $notificationssql = "INSERT into notificationsinfo VALUES ('$notificationnumber','$destinationemail','$message','$status','$notificationtype','$timestamp')";
	            $r = mysqli_query($conn,$notificationssql);
				if($r)
				{
					mysqli_commit($conn);
					echo '<script>alertifyalert("You have declined the request")</script>';
				}
				else
				{
				    echo '<script>alertifyalert("Your denial of request is not updated properly. Please try later!!!")</script>';
				}
				}
				else
				{
					echo '<script>alertifyalert("Your denial of request is not updated properly. Please try later!!!")</script>';
				}
			}
			else
			{
				echo '<script>alertifyalert("Your denial of request is not updated properly. Please try later!!!")</script>';
			}
}
echo "<meta http-equiv=\"refresh\" content=\"0;URL=Activities.php\">";
?>