<!-- Generate notification number
Author : Siddharth G.C
Last modified : 2/5/17 8:15 P.M-->

<?php 
function generateNotificationNumber($conn)        //Function to generate notification number
{
	$notificationNumberSql = "SELECT t1.notificationNumber+1 AS Missing FROM notifications AS t1 LEFT JOIN notifications AS t2 ON t1.notificationNumber+1 = t2.notificationNumber WHERE t2.notificationNumber IS NULL ORDER BY t1.notificationNumber LIMIT 1";
	$notificationNumberResult = mysqli_query($conn,$notificationNumberSql); //Executes SQL query
	if($notificationNumberResult)
	{
		$row = mysqli_fetch_row($notificationNumberResult);
	    if($row[0]=="")
		{
			return 1;      //Returns 1 when it is the first notification in the table
		}
		else
		{
			return $row[0]; //Returns the notification number
		}
	}
}
?>