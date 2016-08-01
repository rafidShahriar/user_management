<?php
include_once '../vendor/autoload.php';
use App\registration\Registration;

$obj = new Registration();
$obj->validationMessage('error');
?>