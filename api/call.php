<?php
/**
 * all relevent call ar calls from here and javascript allways
 * calls this file
 */
require_once('../autoloader.php');
use api\api;

$api = new api();

if (isset($_GET['login']) && ($_GET['login'] == 'true')) {
	$data = getRegLoginData();
	$api->login($data);
}

if (isset($_GET['registration']) && ($_GET['registration'] == 'true')) {
	$data = getRegLoginData();
	$api->registration($data);
}

if (isset($_GET['logout']) && ($_GET['logout'] == 'true')) {
	session_start();
	unset($_SESSION["authenticated"]);
}
if (isset($_GET['createtask']) && ($_GET['createtask'] == 'true')) {
	$taskName = mysql_real_escape_string($_POST['taskname']);
	$api->createTask($taskName);
}
if (isset($_GET['deleteTask']) && ($_GET['deleteTask'] == 'true')) {
	$taskId = mysql_real_escape_string($_POST['taskId']);
	$api->deleteTask($taskId);
}
if (isset($_GET['updateMark']) && ($_GET['updateMark'] == 'true')) {
	$taskId = mysql_real_escape_string($_POST['taskId']);
	$status = mysql_real_escape_string($_POST['status']);
	$api->updateMark($taskId,$status);
}
if (isset($_GET['commentDelete']) && ($_GET['commentDelete'] == 'true')) {
	$commentId = mysql_real_escape_string($_POST['commentId']);
	$api->deleteComment($commentId);
}

if (isset($_GET['loadtask']) && ($_GET['loadtask'] == 'true')) {
	$api->getAllTasks();
}
if (isset($_GET['createComment']) && ($_GET['createComment'] == 'true')) {
	$commentData = array(
		'comment' =>  mysql_real_escape_string($_POST['comment']),
		'task_id' =>  mysql_real_escape_string($_POST['taskId'])
	);
	$api->createComment($commentData);
}

function getRegLoginData()
{
	$data = array(
		'username' => mysql_real_escape_string( $_POST['username']),
		'password' =>  mysql_real_escape_string($_POST['pass'])
	);
	return $data;
}
