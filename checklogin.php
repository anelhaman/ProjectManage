<?php  
require_once 'autoload.php';


$username = $_POST['username'];
$password = $_POST['password'];

$user->login($username,$password);
header("Location: index.php");
exit(); 
?>