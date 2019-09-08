<!doctype html>
<html>
<head>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/header_buttons.css"/>
        <link rel="stylesheet" type="text/css" href="css/button_hover_logout.css"/>
        <link href="css/main.css" rel="stylesheet">
		<link href="css/demo.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/datepicker.css" />
                <link rel="stylesheet" type="text/css" href="css/notification.css" />
     
        
<meta charset="utf-8">
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
	margin-right: 1.5%;
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
 
 form fieldset , select {
background-color: #e5e5e5;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 16px;
height: 50px;
outline: none;
padding: 0px 10px;
width: 350px;
-webkit-appearance:none;

}


.input {
background-color: #e5e5e5;
border: none;
border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
color: #5a5656;
font-family: 'Open Sans', Arial, Helvetica, sans-serif;
font-size: 100%;
height: 40px;
outline: none;
width:178px;
-webkitappearance:none;
padding-left:1%;
-webkit-appearance:none;
}
</style>
<?php
session_start();
if($_SESSION['Email']==null)
{
	header('Location:http://localhost/Asset/index.php');
}
if(!(preg_match('/^hod/',$_SESSION['Email'])||preg_match('/^dean/',$_SESSION['Email'])|| $_SESSION['Email']== "principal_psg@mail.com"))
{
	header('Location:http://localhost/Asset/logout.php');
}
$email = $_SESSION['Email'];   //$_SESSION["Email"];
?>
<!--
<script src="js/modernizr.custom.js"></script>
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
		function changeDateFormat( date)
				{
				//	alert (date);
					var date1split = date.split("/");
	 var finaldate = date1split[2]+"-"+date1split[0]+"-"+date1split[1] ;
	return finaldate;
				}		
				
				
				
		function filterRecords(resulttype) {
			//alert ("hello");
			var email="<?php echo $email; ?>";
			//alert(email);
			var chk = "principal_psg@mail.com";
			if(email == chk)
			{
				//alert("true");
				var departmentid = document.getElementById("departmentname");
	            var departmentname = departmentid.options[departmentid.selectedIndex].text;
	            departmentname = encodeURIComponent(departmentname);
			}
			else
			{
				//alert("false");
				var staffid = document.getElementById("staffname"); 
                var staffname = staffid.options[staffid.selectedIndex].value;
			}
	var assetid = document.getElementById("assetname");
	var assetname = assetid.options[assetid.selectedIndex].text;
	var supplierid = document.getElementById("suppliername");
	var suppliername = supplierid.options[supplierid.selectedIndex].text;
	suppliername = encodeURIComponent(suppliername);
	//var minvalueid = document.getElementById("minvalue");
	var minvalue = document.getElementById("minvalue").value;
	//var maxvalueid = document.getElementById("maxvalue");
	var maxvalue = document.getElementById("maxvalue").value;
	//var fromyearid = document.getElementById("fromyear");
	var from =document.getElementById("datepicker").value;
	if(from == "")
	{
		from = "0000-00-00";
	}
	else
	{
	    from = changeDateFormat(from);
	}
	var to = document.getElementById("datepicker1").value;
	if(to == "")
	{
		to = "2200-12-31";
	}
	else
	{
	    to = changeDateFormat(to);
	}
	//alert(from+"-"+to);
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
           xmlhttp.open("GET","FilterforKnowAssetsPage.php?assetname="+assetname+"&departmentname="+departmentname+"&staffname="+staffname+"&suppliername="+suppliername+"&minvalue="+minvalue+"&maxvalue="+maxvalue+"&from="+from+"&to="+to+"&resulttype="+resulttype,true);
     xmlhttp.send();
    
}
</script>-->
<script>
function Logout()
{

		location.href = "Logout.php";
	
}
</script>
<script src="js/checkbox.js"></script>
    <script type="text/javascript">
        $(function () {
            $('.chk1').change(function () {
                if ($(this).is(":checked")) {
                    $('#Delete').removeAttr('disabled');
                }
                else {
                    var isChecked = false;
                    $('.chk1').each(function () {
                        if ($(this).is(":checked")) {
                            $('#Delete').removeAttr('disabled');
                            isChecked = true;
                        }
                    });
                    if (!isChecked) {
                        $('#Delete').attr('disabled', 'disabled');
                    }
                }
 
 
            })
        });
    </script>
</head>
<?php
include 'Connect.php';
include 'Alert.php';
$conn = connectDB("obsoletedb");
$obsoleteinfosql = "Select * from obsoleteassetinfo";
$obsoleteinforesult = mysqli_query($conn,$obsoleteinfosql);
if(isset($_POST['Delete']))
{
	echo "Hello";
	mysqli_autocommit($conn,false);
	$checkbox = $_POST['checkbox'];
	$flag= false;
	foreach($checkbox as $obsoleteassetid)
	{
		$deleteobsoleteassetsql = "Delete from obsoleteassetinfo where ObsoleteAssetID='$obsoleteassetid'";
		$deleteobsoleteassetresult = mysqli_query($conn,$deleteobsoleteassetsql);
		if($deleteobsoleteassetresult)
		{
			$flag=true;
		}
		else
		{
			$flag = false;
		}
	}
	if($flag)
	{
		mysqli_commit($conn);
	    echo '<script>alertifyalert("Obsolete assets are cleared successfully");</script>';
	}
	else
	{
		echo '<script>alertifyalert("Sorry assets cannot be cleared successfully. Try later!!!");</script>';
	}
}

?>
<body>
<form id = "deleteform" action="clearobsoletedb.php" method="post"> </form>
<div id="TableCodePreview" class="PreviewTable" align="center" style="position:relative; width:80% ; margin-top:2% ; margin-left:auto ; margin-right:auto ; table-layout:fixed">

<table>
<thead>
                <tr> 
                    <td><label>#</label></td>
                    <td><label>Obsolete Asset ID</label></td>
                    <td><label>Department Name</label></td>
                    <td><label>Reason</label></td>
                </tr>
            </thead>
<tbody>
<?php foreach ($obsoleteinforesult as $row) : ?>
<tr>
<td onClick = "EnableDeleteButton()"><input form="deleteform" class="chk1" name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row['ObsoleteAssetID']; ?>">
</td>
<td style="width:25%"><?php echo $row['ObsoleteAssetID'];?></td>
<td><?php echo  $row["DepartmentName"]  ?></td>
<td><?php echo  $row["Reason"]  ?></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
</div>
<input form = "deleteform" type="submit" value = "Delete" name = "Delete" id="Delete" disabled>
</body>
<?php
?>
</html>

<?php
?>