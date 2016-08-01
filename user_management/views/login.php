<?php
include_once '../vendor/autoload.php';
use App\registration\Registration;

$obj = new Registration();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<?php $obj->validationMessage('success'); ?>
	<fieldset>
		<legend>Login Form</legend>
		<form action="">
			<table>
				<tr>
					<td>Usernamae:</td>
					<td><input type="text" name="" id=""></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="" id=""></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Log In"></td>
				</tr>
			</table>
		</form>
	</fieldset>
</body>
</html>