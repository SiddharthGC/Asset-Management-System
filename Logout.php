<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Logout</title>
</head>

<body>
<?php
session_start();
unset($_SESSION);
session_destroy();
header('Location:http://localhost/Asset/index.php');
?>
</body>
</html>