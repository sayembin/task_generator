<?php
namespace TodoController;

require_once('../autoloader.php');

/**
 *
 * Class TodoController
 * @author Md.Sayem bin hasan <sayemdoc@gmail.com>
 */
class TodoController {
	/**
	 * redirect to login view if user is not logged in
	 */
	function __construct(){
       $settings = \Config\config::getConfig();
	   header( "Location: ".$settings['base_url']."/view".DIRECTORY_SEPARATOR."view.php",false );
	}
}

$controller = new TodoController();