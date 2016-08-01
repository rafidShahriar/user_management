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
<?php $obj->validationMessage('reg_failed');?>
	<fieldset>
		<legend>User Registration Form</legend>
		<form action="store.php" method="post">
			<table>
				<tr>
					<td><label>Username:</label></td>
					<td><input type="text" name="username" value="<?php $obj->validationMessage('val_username'); ?>" maxlength="12" /></td>
					<td><?php $obj->validationMessage('uniq_name'); $obj->validationMessage('username_length'); $obj->validationMessage('name_req'); ?></td>
				</tr>
				<tr>
					<td><label>Password:</label></td>
					<td><input type="password" name="pass" maxlength="12" /></td>
					<td><?php $obj->validationMessage('pass_req'); $obj->validationMessage('pass_length'); ?></td>
				</tr>
				<tr>
					<td><label>Retype Password:</label></td>
					<td><input type="password" name="repass" maxlength="12" /></td>
					<td><?php  $obj->validationMessage('pass_match'); $obj->validationMessage('repass_req');?></td>
				</tr>
				<tr>
					<td><label>Email:</label></td>
					<td><input type="text" name="email" value="<?php $obj->validationMessage('val_email'); ?>" \></td>
					<td><?php $obj->validationMessage('email_valid'); $obj->validationMessage('email_uniq'); $obj->validationMessage('email_req');?></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="reset" value="Reset">&nbsp;<input type="submit" value="Submit"></td>
				</tr>
			</table>
		</form>
	</fieldset>
</body>
</html>