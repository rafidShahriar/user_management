<?php
include_once '../vendor/autoload.php';
use App\registration\Registration;

$obj = new Registration();
$obj->ready($_POST);
$obj->validation();
$obj->store();
?>