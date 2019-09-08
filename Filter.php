<?php
/*function filterAssetInfo($conn,$table,$attribute)
{
	
	if($table== "assetinfo")
	{
		$sql = "SELECT DISTINCT AssetName FROM $table";
	}
	else
	{
	$senderemail = "praveen23.em@gmail.com";
	$sender ="head"; //dummy
	if($sender!="head"||$sender!="dean")
	{
	   $sql = "SELECT DISTINCT $attribute FROM $table";
	}
	else
	{ 
		
	}
	}
	$result = mysqli_query($conn,$sql);
	return $result;
}*/

//To list the departments 
/*function listDepartment($conn,$table,$attribute)
{
	$sql ="Select  $attribute,DepartmentName from $table"; 
	$result = mysqli_query($conn,$sql);
	return $result;
}*/

//To list Staff of the the department of sender email
function listStaff($conn,$senderemail)
{
	$department ="Select DepartmentID FROM userinfo WHERE Email = '$senderemail'";
	$sql = "Select Name,EmployeeID,Email from userinfo WHERE DepartmentID in ($department) order by Name";
	$result = mysqli_query($conn,$sql);
	return $result;
}

function giveDepartmentStringID($conn,$email)
{
	$deptsql = "Select t1.DepartmentStringID from departmentidinfo t1,userinfo t2 where t2.Email='$email' AND t1.DepartmentID=t2.DepartmentID";
		$r = mysqli_query($conn,$deptsql);
		$row = mysqli_fetch_row($r);
		$deptstringid = $row[0];
		return $deptstringid;
}


//To List Assets
function listAssets($conn,$email)
{
	$deptstringid = "%";
	if($email!="" && $email!="principal@psg.psgtech.ac.in")
	{
		$deptstringid = giveDepartmentStringID($conn,$email);
		//echo $deptstringid;
	}
	$sql = "SELECT DISTINCT AssetName from assetcurrentinfo where AssetID like '$deptstringid%' order by AssetName";
	$result = mysqli_query($conn,$sql);
	return $result;
}

//To list Departments
function listDepartments($conn)
{
	$sql = "SELECT Dname,Dno from department order by Dname";
	$result = mysqli_query($conn,$sql);
	return $result;
}

//To list all staffs
function listStaffs($conn)
{
	$sql = "SELECT Name,EmployeeID,Email,DepartmentID from userinfo order by Name";
	$result = mysqli_query($conn,$sql);
	return $result;
}


function listValues($conn,$table,$attribute)
{
	$sql=NULL;
	if($table==="assetcurrentinfo")
	{
		$sql="SELECT DISTINCT $attribute from $table";
	}
	elseif($table==="userinfo")
	{
	   $sql = "Select Name,EmployeeID from $table";	
	}
	else
	{
		$sql= "SELECT $attribute from $table";
	}
	$result = mysqli_query($conn,$sql);
	return $result;
}

//To list all the suppliers
function listSuppliers($conn,$email)
{
	$deptstringid = "%";
	if($email!="" && $email!="principal@psg.psgtech.ac.in")
	{
		$deptstringid = giveDepartmentStringID($conn,$email);
		//echo $deptstringid;
	}
	$suppliersql = "Select Distinct SupplierName from assetinfo where AssetID like '$deptstringid%'";
	$supplierresult = mysqli_query($conn,$suppliersql);
	return $supplierresult;
}

function isAssetAvailable($conn,$assetid)
{
	$statussql = "Select status from assets where assetID = '$assetid'";
	$r = mysqli_query($conn,$statussql);
	$row = mysqli_fetch_row($r);
	$t = $row[0];
	$t = rtrim($t,"\0");
    if($t==="Available")
	{
		return true;
	}
    else
	{
		return false;
	}		
}

function getUserType($conn,$email)
{
	$getusertype = "Select UserType from user where email ='$email'";
	$getusertyperesult = mysqli_query($conn,$getusertype);
	foreach($getusertyperesult as $type) :
	$user = $type['UserType'];
	endforeach;
	return $user;
}
function getdepartmenttag($conn,$email)
{
	$getdname = "Select Dname from user where email ='$email'";
	$getdnameresult = mysqli_query($conn,$getdname);
	foreach($getdnameresult as $type) :
	$dname = $type['Dname'];
	endforeach;
	$gettag = "select Tag from department where Dname='$dname'";
	$gettagresult = mysqli_query($conn,$gettag);
	foreach($gettagresult as $tags) :
	$dtag = $tags['Tag'];
	endforeach;
	return $dtag;
}
?>