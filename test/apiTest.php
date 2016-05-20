<?php
require_once('/../api/api.php');
class apiTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * login success assert
	 */
	public function testLogin(){
		$loginData = array(
			'username'=>'sayem',
		    'password'=>'test',
		);
		$api = new api\api();
		$response = $api->login($loginData);
		$this->assertEquals('success',$response);
	}

	/**
	 * registration success test
	 */
	public function testRegistration(){
		$loginData = array(
			'username'=>'test',
			'password'=>'test',
		);
		$api = new api\api();
		$response = $api->login($loginData);
		$this->assertEquals('success',$response);
	}
}
?>