<?php require_once('header.php'); ?>
<?php session_start(); ?>

<?php if (!isset($_SESSION['authenticated'])) {
	require_once('login.php');
} else {
	require_once('body.php');
 } ?>
<?php require_once('footer.php'); ?>
