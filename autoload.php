<?php
session_start();
// session_regenerate_id(true); // regenerated the session, delete the old one.
ob_start();
define('StTime', microtime(true));

date_default_timezone_set('Asia/Bangkok');
// error_reporting(E_ALL ^ E_NOTICE);
// error_reporting(0);

define("VERSION" 	,'1.0.1');

require_once 'config/config.php';
// require_once 'class/api.class.php';
require_once 'class/database.class.php';
require_once 'class/user.class.php';
require_once 'class/project.class.php';
require_once 'class/activity.class.php';
// require_once 'class/money.class.php';
// require_once 'class/log.class.php';

$wpdb = new Database; // DATABASE CONNECT...
$user = new User;

$user->sec_session_start();
$user_online = $user->loginChecking();
$user_id = $user->getId();

$project = new Project;
$activity = new Activity();
 ?>
 <link href="https://fonts.googleapis.com/css?family=Taviraj" rel="stylesheet">
