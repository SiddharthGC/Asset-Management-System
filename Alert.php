
<!-- include alertify.css -->
<link rel="stylesheet" href="css/alertify.css">

<!-- include boostrap theme  -->
<link rel="stylesheet" href="css/themes/bootstrap.css">

<!-- include alertify script -->
<script src="alertify.js"></script>

<script type="text/javascript">
//override defaults

alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";
</script>
<html>
<body>
</body>
</html>
<script>
function alertifyalert(msg,moveto)
{	
	if(moveto != null)
	{
		 alertify.alert('Message',msg).set({ onshow:null, onclose:function(){ window.location.assign(moveto);}} ); 
	}
	else 
	{
		 alertify.alert('Message',msg);
	}
}
</script>
<?php
/*$message =null; 
$moveto = null;
function produceAlert($msg,$mov)
{
	echo "hi";
	echo '<script>alertifyalert("hi")</script>';
}*/
?>