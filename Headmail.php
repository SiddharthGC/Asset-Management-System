<?php
function formHeadEmail($email)
{
	$explodemail = explode("@",$email);
	$tdept = explode(".",$explodemail[1]);
	$dept = $tdept[0];
	$splarray = array("su","acad");
	if($email == "principal@psg.psgtech.ac.in" || $email == "dept@psg.psgtech.ac.in")
	{
		return "principal@psg.psgtech.ac.in";
	}
	elseif(!in_array($dept,$splarray))
	{
		return "hod@".$dept.".psgtech.ac.in";
	}
	else
	{
		return "dean@".$dept.".psgtech.ac.in";
	}
}
?>