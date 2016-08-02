<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h3>Thanks for registration</h3>
	<?php
	$to = "somebody@example.com";
	$subject = "My subject";
	$txt = "Hello world!";
	$headers = "From: webmaster@example.com" . "\r\n" .
	"CC: somebodyelse@example.com";

	mail($to,$subject,$txt,$headers);
	?>
	<a href="active.php?id=<?php echo $_GET['id'];?>">Click here...</a>for email verification and complete the registration.
</body>
</html>